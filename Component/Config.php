<?php
/**
 * Created by PhpStorm.
 * User: sjoder
 * Date: 12.07.2017
 * Time: 10:05
 */

namespace PM\PlentyMarketsBundle\Component;

use PM\PlentyMarketsBundle\Component\Helper\ServiceHelper;
use PM\PlentyMarketsBundle\Services\RestfulService;


/**
 * Class Config
 *
 * @package PM\PlentyMarketsBundle\Component
 */
class Config
{
    /**
     * Config constructor.
     *
     * @param string $uri
     * @param string $username
     * @param string $password
     */
    public function __construct(
        private $uri,
        private $username,
        private $password,
        private readonly float $limitLock,
        private readonly float $shortLimitLock,
        private bool $priority = false,
        private bool $wait = true
    ){
    }

    /**
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return float
     */
    public function getLimitLock()
    {
        return $this->limitLock;
    }

    public function getShortLimitLock(): float
    {
        return $this->shortLimitLock;
    }

    public function isPriority(): bool
    {
        return $this->priority;
    }

    /**
     * @return Config
     */
    public function setPriority(bool $priority): Config
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * Whether a request waits: for a lock that ends within a minute, out a short period limit
     * (70 seconds), and before trying again after a failed connection or a server error. Right
     * for an import; a web request turns it off and gets the exception at once.
     */
    public function isWait(): bool
    {
        return $this->wait;
    }

    public function setWait(bool $wait): Config
    {
        $this->wait = $wait;

        return $this;
    }

    /**
     * Get API Id
     *
     * @return string
     */
    public function getApiId()
    {
        return ServiceHelper::createApiId(RestfulService::getBaseUri($this->getUri()), $this->getUsername(), $this->getPassword());
    }

}