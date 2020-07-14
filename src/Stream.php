<?php


namespace WabLab\ParallelServer;


use WabLab\ParallelServer\Contracts\Logger;

class Stream
{

    /**
     * @var bool
     */
    private $closedFlag = false;

    /**
     * @var ParallelServerOptions
     */
    private $parallelServerOptions;

    /**
     * @var Logger
     */
    private $logger;

    /**
     * @var \EventBufferEvent
     */
    private $eventBufferEvent;

    /**
     * @var string
     */
    private $remoteAddress;

    public function __construct(\EventBufferEvent $eventBufferEvent, ParallelServerOptions $parallelServerOptions, Logger $logger, string $remoteAddress)
    {
        $this->parallelServerOptions = $parallelServerOptions;
        $this->logger = $logger;
        $this->eventBufferEvent = $eventBufferEvent;
        $this->remoteAddress = $remoteAddress;
    }

    public function read($size = null)
    {
        $read = $this->eventBufferEvent->read($size ?? $this->parallelServerOptions->getMaxReadBlockLength());
        $this->debug("{$this->remoteAddress} >>> ".trim($read) );
        return $read;
    }

    public function write($content)
    {
        $this->debug("{$this->remoteAddress} <<< ".trim($content));
        $this->eventBufferEvent->write($content);
    }

    public function close()
    {
        $this->debug("{$this->remoteAddress} Connection flagged to be closed.");
        $this->closedFlag = true;
    }

    public function isClosed(): bool
    {
        return $this->closedFlag;
    }

    public function getEventBufferEvent(): \EventBufferEvent
    {
        return $this->eventBufferEvent;
    }

    protected function debug($message) {
        if($this->parallelServerOptions->getDebug()) {
            $this->logger->debug($message);
        }
    }
}