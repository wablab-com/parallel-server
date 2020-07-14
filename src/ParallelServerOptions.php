<?php


namespace WabLab\ParallelServer;


class ParallelServerOptions
{
    //const PROTOCOL_TCP = 'tcp';
    //const PROTOCOL_UDP = 'udp';

    /**
     * @var string
     */
    //protected $protocol = self::PROTOCOL_TCP;

    /**
     * @var string
     */
    protected $bind = '127.0.0.1';

    /**
     * @var int
     */
    protected $timeout = 0;

    /**
     * @var int
     */
    protected $port = 5000;

    /**
     * @var int
     */
    protected $workers = 50;

    /**
     * @var bool
     */
    protected $debug = false;

    /**
     * @var int
     */
    protected $connectionsBacklog = -1;

    /**
     * @var int
     */
    protected $maxReadBlockLength = 1000;

    /**
     * @return string
     *
    public function getProtocol(): string
    {
        return $this->protocol;
    }

    /**
     * @param string $protocol
     *
    public function setProtocol(string $protocol): void
    {
        $this->protocol = $protocol;
    }*/

    /**
     * @return string
     */
    public function getBind(): string
    {
        return $this->bind;
    }

    /**
     * @param string $bind
     */
    public function setBind(string $bind): void
    {
        $this->bind = $bind;
    }

    /**
     * @return int
     */
    public function getPort(): int
    {
        return $this->port;
    }

    /**
     * @param int $port
     */
    public function setPort(int $port): void
    {
        $this->port = $port;
    }

    /**
     * @return int
     */
    public function getWorkers(): int
    {
        return $this->workers;
    }

    /**
     * @param int $workers
     */
    public function setWorkers(int $workers): void
    {
        $this->workers = $workers;
    }

    /**
     * @return bool
     */
    public function getDebug(): bool
    {
        return $this->debug;
    }

    /**
     * @param bool $debug
     */
    public function setDebug(bool $debug): void
    {
        $this->debug = $debug;
    }

    /**
     * @return int
     */
    public function getConnectionsBacklog(): int
    {
        return $this->connectionsBacklog;
    }

    /**
     * @param int $connectionsBacklog
     */
    public function setConnectionsBacklog(int $connectionsBacklog): void
    {
        $this->connectionsBacklog = $connectionsBacklog;
    }

    /**
     * @return int
     */
    public function getMaxReadBlockLength(): int
    {
        return $this->maxReadBlockLength;
    }

    /**
     * @param int $maxReadBlockLength
     */
    public function setMaxReadBlockLength(int $maxReadBlockLength): void
    {
        $this->maxReadBlockLength = $maxReadBlockLength;
    }

    /**
     * @return int
     */
    public function getTimeout(): int
    {
        return $this->timeout;
    }

    /**
     * @param int $timeout
     */
    public function setTimeout(int $timeout): void
    {
        $this->timeout = $timeout;
    }


}