<?php
/**
 * Created by PhpStorm.
 * User: sjoder
 * Date: 12.07.2017
 * Time: 11:30
 */

namespace PM\PlentyMarketsBundle\Component\Response;


/**
 * Class PaginationResponse
 *
 * @package PM\PlentyMarketsBundle\Component\Response
 */
class PaginationResponse
{

    /** @var int|null */
    private ?int $page = null;

    /** @var int|null */
    private ?int $totalsCount = null;

    /** @var bool|null */
    private ?bool $isLastPage = null;

    /** @var int|null */
    private ?int $lastPageNumber = null;

    /** @var int|null */
    private ?int $firstOnPage = null;

    /** @var int|null */
    private ?int $lastOnPage = null;

    /** @var int|null */
    private ?int $itemsPerPage = null;

    /**
     * @return int
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @param int $page
     *
     * @return PaginationResponse
     */
    public function setPage($page)
    {
        $this->page = $page;

        return $this;
    }

    /**
     * @return int
     */
    public function getTotalsCount()
    {
        return $this->totalsCount;
    }

    /**
     * @param int $totalsCount
     *
     * @return PaginationResponse
     */
    public function setTotalsCount($totalsCount)
    {
        $this->totalsCount = $totalsCount;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isIsLastPage()
    {
        return $this->isLastPage;
    }

    /**
     * @param boolean $isLastPage
     *
     * @return PaginationResponse
     */
    public function setIsLastPage($isLastPage)
    {
        $this->isLastPage = $isLastPage;

        return $this;
    }

    /**
     * @return int
     */
    public function getLastPageNumber()
    {
        return $this->lastPageNumber;
    }

    /**
     * @param int $lastPageNumber
     *
     * @return PaginationResponse
     */
    public function setLastPageNumber($lastPageNumber)
    {
        $this->lastPageNumber = $lastPageNumber;

        return $this;
    }

    /**
     * @return int
     */
    public function getFirstOnPage()
    {
        return $this->firstOnPage;
    }

    /**
     * @param int $firstOnPage
     *
     * @return PaginationResponse
     */
    public function setFirstOnPage($firstOnPage)
    {
        $this->firstOnPage = $firstOnPage;

        return $this;
    }

    /**
     * @return int
     */
    public function getLastOnPage()
    {
        return $this->lastOnPage;
    }

    /**
     * @param int $lastOnPage
     *
     * @return PaginationResponse
     */
    public function setLastOnPage($lastOnPage)
    {
        $this->lastOnPage = $lastOnPage;

        return $this;
    }

    /**
     * @return int
     */
    public function getItemsPerPage()
    {
        return $this->itemsPerPage;
    }

    /**
     * @param int $itemsPerPage
     *
     * @return PaginationResponse
     */
    public function setItemsPerPage($itemsPerPage)
    {
        $this->itemsPerPage = $itemsPerPage;

        return $this;
    }

}