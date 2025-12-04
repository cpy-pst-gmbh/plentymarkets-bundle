<?php

namespace PM\PlentyMarketsBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * LimitHistory
 *
 *
 */
#[ORM\Table(name: 'pm_plenty_markets_limit_history')]
#[ORM\Index(name: 'limit_history_idx_api', columns: ['api', 'path'])]
#[ORM\Entity(repositoryClass: \PM\PlentyMarketsBundle\Repository\LimitHistoryRepository::class)]
#[ORM\HasLifecycleCallbacks]
class LimitHistory
{
    /**
     * @var int
     */
    #[ORM\Column(name: 'id', type: 'integer')]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    private $id;

    /**
     * @var string
     */
    #[ORM\Column(name: 'api', type: 'string', length: 20)]
    private $api;

    /**
     * @var string
     */
    #[ORM\Column(name: 'path', type: 'string', length: 50)]
    private $path;

    /**
     * @var \DateTime
     */
    #[ORM\Column(name: 'day', type: 'date')]
    private $day;

    /**
     * @var int
     */
    #[ORM\Column(name: 'long_period_total', type: 'integer')]
    private $longPeriodTotal;

    /**
     * @var int
     */
    #[ORM\Column(name: 'long_period_minimum', type: 'integer')]
    private $longPeriodMinimum;

    /**
     * @var int
     */
    #[ORM\Column(name: 'long_period_exception', type: 'integer')]
    private $longPeriodException;

    /**
     * @var int
     */
    #[ORM\Column(name: 'long_period_latest', type: 'integer')]
    private $longPeriodLatest;

    /**
     * @var int
     */
    #[ORM\Column(name: 'short_period_total', type: 'integer')]
    private $shortPeriodTotal;

    /**
     * @var int
     */
    #[ORM\Column(name: 'short_period_minimum', type: 'integer')]
    private $shortPeriodMinimum;

    /**
     * @var int
     */
    #[ORM\Column(name: 'short_period_exception', type: 'integer')]
    private $shortPeriodException;

    /**
     * @var int
     */
    #[ORM\Column(name: 'short_period_latest', type: 'integer')]
    private $shortPeriodLatest;

    /**
     * @var DateTime
     */
    #[ORM\Column(name: 'updated', type: 'datetime')]
    private $updated;

    /**
     * LimitHistory constructor.
     */
    public function __construct()
    {
        $this
            ->setLongPeriodException(0)
            ->setShortPeriodException(0);
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set day
     *
     * @param \DateTime $day
     *
     * @return LimitHistory
     */
    public function setDay($day)
    {
        $this->day = $day;

        return $this;
    }

    /**
     * Get day
     *
     * @return \DateTime
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * Set longPeriodTotal
     *
     * @param integer $longPeriodTotal
     *
     * @return LimitHistory
     */
    public function setLongPeriodTotal($longPeriodTotal)
    {
        $this->longPeriodTotal = $longPeriodTotal;

        return $this;
    }

    public function getLongPeriodTotal(): int
    {
        return $this->longPeriodTotal;
    }

    /**
     * Set longPeriodMinimum
     *
     * @param integer $longPeriodMinimum
     *
     * @return LimitHistory
     */
    public function setLongPeriodMinimum($longPeriodMinimum)
    {
        $this->longPeriodMinimum = $longPeriodMinimum;

        return $this;
    }

    /**
     * Get longPeriodMinimum
     *
     * @return int
     */
    public function getLongPeriodMinimum()
    {
        return $this->longPeriodMinimum;
    }

    /**
     * Set longPeriodException
     *
     * @param integer $longPeriodException
     *
     * @return LimitHistory
     */
    public function setLongPeriodException($longPeriodException)
    {
        $this->longPeriodException = $longPeriodException;

        return $this;
    }

    /**
     * Get longPeriodException
     *
     * @return int
     */
    public function getLongPeriodException()
    {
        return $this->longPeriodException;
    }

    /**
     * Set shortPeriodTotal
     *
     * @param integer $shortPeriodTotal
     *
     * @return LimitHistory
     */
    public function setShortPeriodTotal($shortPeriodTotal)
    {
        $this->shortPeriodTotal = $shortPeriodTotal;

        return $this;
    }

    /**
     * Get shortPeriodTotal
     *
     * @return int
     */
    public function getShortPeriodTotal()
    {
        return $this->shortPeriodTotal;
    }

    /**
     * Set shortPeriodMinimum
     *
     * @param integer $shortPeriodMinimum
     *
     * @return LimitHistory
     */
    public function setShortPeriodMinimum($shortPeriodMinimum)
    {
        $this->shortPeriodMinimum = $shortPeriodMinimum;

        return $this;
    }

    /**
     * Get shortPeriodMinimum
     *
     * @return int
     */
    public function getShortPeriodMinimum()
    {
        return $this->shortPeriodMinimum;
    }

    /**
     * Set shortPeriodException
     *
     * @param int $shortPeriodException
     *
     * @return LimitHistory
     */
    public function setShortPeriodException($shortPeriodException)
    {
        $this->shortPeriodException = $shortPeriodException;

        return $this;
    }

    /**
     * Get shortPeriodException
     *
     * @return int
     */
    public function getShortPeriodException()
    {
        return $this->shortPeriodException;
    }

    /**
     * Set api
     *
     * @param string $api
     *
     * @return LimitHistory
     */
    public function setApi($api)
    {
        $this->api = $api;

        return $this;
    }

    /**
     * Get api
     *
     * @return string
     */
    public function getApi()
    {
        return $this->api;
    }

    /**
     * @return DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * @param DateTime $updated
     *
     * @return LimitHistory
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    public function getLongPeriodLatest(): int
    {
        return $this->longPeriodLatest;
    }

    /**
     * @param int $longPeriodLatest
     *
     * @return LimitHistory
     */
    public function setLongPeriodLatest($longPeriodLatest)
    {
        $this->longPeriodLatest = $longPeriodLatest;

        return $this;
    }

    /**
     * @return int
     */
    public function getShortPeriodLatest()
    {
        return $this->shortPeriodLatest;
    }

    /**
     * @param int $shortPeriodLatest
     *
     * @return LimitHistory
     */
    public function setShortPeriodLatest($shortPeriodLatest)
    {
        $this->shortPeriodLatest = $shortPeriodLatest;

        return $this;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param string $path
     *
     * @return LimitHistory
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    #[ORM\PreFlush]
    public function preFlush()
    {
        $this->setUpdated(new DateTime());
    }
}

