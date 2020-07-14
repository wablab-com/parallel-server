<?php


namespace WabLab\ParallelServer;

use WabLab\ParallelServer\Contracts\Logger;
use WabLab\Tools\Contracts\DI;
use EventSslContext;
use EventBase;
use EventListener;
use EventBufferEvent;
use Event;
use Closure;

class ParallelServer
{
    /**
     * @var Stream[]
     */
    protected $streams = [];

    /**
     * @var ParallelServerOptions
     */
    protected $parallelServerOptions;

    /**
     * @var DI
     */
    private $dependencyInjector;

    /**
     * @var Logger
     */
    protected $logger;

    /**
     * @var EventSslContext
     */
    protected $sslContext;

    /**
     * @var EventListener
     */
    protected $listener;

    /**
     * @var EventBase
     */
    protected $eventBase;

    /**
     * @var Event
     */
    protected $gcEvent;

    /**
     * @var array
     */
    protected $gcActions = [];

    /**
     * @var Closure|null
     */
    protected $onConnectionEstablishedHandler;

    /**
     * @var Closure|null
     */
    protected $onReadHandler;

    public function __construct(ParallelServerOptions $parallelServerOptions, DI $dependencyInjector = null, Logger $logger = null)
    {
        $this->parallelServerOptions = $parallelServerOptions;
        if(!$dependencyInjector) {
            $this->dependencyInjector = new \WabLab\Tools\DI();
            $this->dependencyInjector->map(Logger::class, ConsoleLogger::class);
        }

        $this->logger = $logger ?? $this->dependencyInjector->make(Logger::class);
    }

    public function start()
    {
        $this->debug("Createing IPv4, stream, TCP socket");
        $this->eventBase = $this->initEventBase();
        $this->listener = $this->initListener($this->parallelServerOptions->getBind().':'.$this->parallelServerOptions->getPort());
        $this->gcEvent = $this->initGC();

        $this->logger->success("Listening {$this->parallelServerOptions->getBind()}:{$this->parallelServerOptions->getPort()}");
        $this->eventBase->dispatch();
    }

    public function acceptConnection(EventListener $listener = null, $fd = null, $remote = null)
    {

        $this->debug('Connection established');
        try {
            $stringAddress = $remote ? implode(':', $remote) : '';


            $eventBufferEvent = new EventBufferEvent($this->eventBase, $fd, EventBufferEvent::OPT_CLOSE_ON_FREE);
            $eventBufferEvent->setTimeouts($this->parallelServerOptions->getTimeout(), 0);
            $eventBufferEvent->setCallbacks([$this, "connectionRead"], [$this, 'connectionWrite'], [$this, 'connectionError'], $stringAddress);
            $eventBufferEvent->enable(Event::READ | Event::WRITE);

            $this->streams[$stringAddress] = $this->dependencyInjector->make(Stream::class, [
                'eventBufferEvent' => $eventBufferEvent,
                'parallelServerOptions' => $this->parallelServerOptions,
                'logger' => $this->logger,
                'remoteAddress' => $stringAddress
            ]);

            if(!empty($this->onConnectionEstablishedHandler)) {
                ($this->onConnectionEstablishedHandler)($stringAddress);
            }

            if(!$this->onReadHandler) {
                $this->logger->warning('No read handler assigned to connection "'.$stringAddress.'"');
                $this->streamCloseProcess($stringAddress);
            }

            if($this->streams[$stringAddress]->isClosed()) {
                $this->gcActions[] = [
                    'command' => 'close_connection',
                    'string_address' => $stringAddress,
                    'time' => time() + 1
                ];
            }

        } catch (\Throwable $exception) {
            $this->streamCloseProcess($stringAddress);
            $this->logger->error("[LINE: {$exception->getLine()}] ".$exception->getMessage());
        }
    }

    public function close()
    {
        $this->listener->disable();
        $this->eventBase->free();
        $this->eventBase->stop();
    }

    protected function initListener(string $socket): \EventListener
    {
        $listener = new EventListener(
            $this->eventBase,
            [$this, 'acceptConnection'],
            null,
            EventListener::OPT_CLOSE_ON_FREE | EventListener::OPT_REUSEABLE | EventListener::OPT_THREADSAFE,
            $this->parallelServerOptions->getConnectionsBacklog(),
            $socket
        );

        if(!$listener) {
            $this->logger->error("Couldn't create listener\n");
            exit(1);
        }

        $listener->setErrorCallback([$this, 'listenerErrorHandler']);
        return $listener;
    }

    protected function initEventBase(): EventBase
    {
        $base = new EventBase();
        if (!$base) {
            $this->logger->error("Couldn't open event base\n");
            exit(1);
        }
        return $base;
    }

    protected function initGC() {
        $gcEvent = Event::timer($this->eventBase, function(ParallelServer $server) {
            foreach($this->gcActions as $key => $gcAction) {
                unset($this->gcActions[$key]);
                if(!empty($gcAction['command']) && $gcAction['command'] == 'close_connection') {
                    $stringAddress = $gcAction['string_address'] ?? '';
                    $this->debug('GC Action '.$gcAction['command']. ' -  '.$stringAddress);
                    $this->streamCloseProcess($stringAddress);
                }
            }

            $server->gcEvent->addTimer(1);
        }, $this);
        $gcEvent->addTimer(1);
        return $gcEvent;
    }

    public function listenerErrorHandler()
    {
        $this->logger->error('Listener error ['.\EventUtil::getLastSocketErrno().'] '.\EventUtil::getLastSocketError());
        exit;
    }

    public function connectionRead(EventBufferEvent $eventBufferEvent = null, $stringAddress = '')
    {
        try {
            $stream = $this->getStreamByAddress($stringAddress);
            ($this->onReadHandler)($stringAddress);

            if($stream->isClosed()) {
                $this->gcActions[] = [
                    'command' => 'close_connection',
                    'string_address' => $stringAddress,
                    'time' => time() + 1
                ];
            }
        } catch (\Throwable $exception) {
            $this->streamCloseProcess($stringAddress);
            $this->logger->error("[LINE: {$exception->getLine()}] ".$exception->getMessage());
        }
    }

    public function connectionWrite(EventBufferEvent $eventBufferEvent = null, $stringAddress = '') {
        try {
            $stream = $this->getStreamByAddress($stringAddress);
            if($stream && $stream->isClosed()) {
                $this->streamCloseProcess($stringAddress);
            }
        } catch (\Throwable $exception) {
            $this->logger->error("[LINE: {$exception->getLine()}] ".$exception->getMessage());
        }
    }

    public function connectionError(EventBufferEvent $eventBufferEvent = null, $fd = null, $stringAddress = '')
    {
        try {
            $this->logger->error("[{$stringAddress}] Connection error [".\EventUtil::getLastSocketErrno().'] '.\EventUtil::getLastSocketError());
            $this->streamCloseProcess($stringAddress);
        } catch (\Throwable $exception) {
            $this->logger->error("[LINE: {$exception->getLine()}] ".$exception->getMessage());
        }
    }

    protected function streamCloseProcess($stringAddress)
    {
        if(isset($this->streams[$stringAddress])) {
            $stream = $this->streams[$stringAddress];
            unset($this->streams[$stringAddress]);
            try {
                $stream->getEventBufferEvent()->close();
            } catch (\Throwable $exception) {
                $this->logger->error("[LINE: {$exception->getLine()}] ".$exception->getMessage());
            }
        }
    }

    public function onConnectionEstablished(Closure $onConnectionEstablished)
    {
        $this->onConnectionEstablishedHandler = $onConnectionEstablished;
    }

    public function onRead(Closure $onRead) {
        $this->onReadHandler = $onRead;
    }

    public function getStreamByAddress($stringAddress = ''): ?Stream
    {
        if(isset($this->streams[$stringAddress])) {
            return $this->streams[$stringAddress];
        }
        return null;
    }

    public function logger(): Logger
    {
        return $this->logger;
    }

    protected function debug($message) {
        if($this->parallelServerOptions->getDebug()) {
            $this->logger->debug($message);
        }
    }

    /*
    protected function initSSLv3Context() : \EventSslContext {
        if(!$this->sslContext) {
            $this->sslContext = new EventSslContext(EventSslContext::SSLv3_SERVER_METHOD, [
                EventSslContext::OPT_LOCAL_CERT  => 'cert.pem',
                EventSslContext::OPT_LOCAL_PK    => 'privkey.pem',
                //EventSslContext::OPT_PASSPHRASE  => '',
                EventSslContext::OPT_VERIFY_PEER => false, // change to true with authentic cert
                EventSslContext::OPT_ALLOW_SELF_SIGNED => true // change to false with authentic cert
            ]);
        }
        return $this->sslContext;
    }*/

}