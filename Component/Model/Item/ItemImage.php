<?php

namespace PM\PlentyMarketsBundle\Component\Model\Item;

use DateTime;

class ItemImage
{
    /** @var int|null */
    private ?int $id = null;

    /** @var int|null */
    private ?int $itemId = null;

    /** @var int|null */
    private ?int $position = null;

    /** @var int|null */
    private ?int $width = null;

    /** @var int|null */
    private ?int $height = null;

    /** @var int|null */
    private ?int $size = null;

    /** @var int|null */
    private ?int $documentUploadPreviewWidth = null;

    /** @var int|null */
    private ?int $documentUploadPreviewHeight = null;

    /** @var string|null */
    private ?string $type = null;

    /** @var string|null */
    private ?string $fileType = null;

    /** @var string|null */
    private ?string $path = null;

    /** @var string|null */
    private ?string $storageProviderId = null;

    /** @var string|null */
    private ?string $md5Checksum = null;

    /** @var string|null */
    private ?string $md5ChecksumOriginal = null;

    /** @var string|null */
    private ?string $cleanImageName = null;

    /** @var string|null */
    private ?string $url = null;

    /** @var string|null */
    private ?string $urlMiddle = null;

    /** @var string|null */
    private ?string $urlPreview = null;

    /** @var string|null */
    private ?string $urlSecondPreview = null;

    /** @var \DateTime|null */
    private ?\DateTime $createdAt = null;

    /** @var \DateTime|null */
    private ?\DateTime $updatedAt = null;

    /** @var list<\PM\PlentyMarketsBundle\Component\Model\Item\ItemImageName>|null */
    private ?array $names = null;

    /** @var list<\PM\PlentyMarketsBundle\Component\Model\Item\ItemImageAvailability>|null */
    private ?array $availabilities = null;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return ItemImage
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return int
     */
    public function getItemId()
    {
        return $this->itemId;
    }

    /**
     * @param int $itemId
     *
     * @return ItemImage
     */
    public function setItemId($itemId)
    {
        $this->itemId = $itemId;

        return $this;
    }

    /**
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param int $position
     *
     * @return ItemImage
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @param int $width
     *
     * @return ItemImage
     */
    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @param int $height
     *
     * @return ItemImage
     */
    public function setHeight($height)
    {
        $this->height = $height;

        return $this;
    }

    /**
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param int $size
     *
     * @return ItemImage
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * @return int
     */
    public function getDocumentUploadPreviewWidth()
    {
        return $this->documentUploadPreviewWidth;
    }

    /**
     * @param int $documentUploadPreviewWidth
     *
     * @return ItemImage
     */
    public function setDocumentUploadPreviewWidth($documentUploadPreviewWidth)
    {
        $this->documentUploadPreviewWidth = $documentUploadPreviewWidth;

        return $this;
    }

    /**
     * @return int
     */
    public function getDocumentUploadPreviewHeight()
    {
        return $this->documentUploadPreviewHeight;
    }

    /**
     * @param int $documentUploadPreviewHeight
     *
     * @return ItemImage
     */
    public function setDocumentUploadPreviewHeight($documentUploadPreviewHeight)
    {
        $this->documentUploadPreviewHeight = $documentUploadPreviewHeight;

        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return ItemImage
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string
     */
    public function getFileType()
    {
        return $this->fileType;
    }

    /**
     * @param string $fileType
     *
     * @return ItemImage
     */
    public function setFileType($fileType)
    {
        $this->fileType = $fileType;

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
     * @return ItemImage
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * @return string
     */
    public function getStorageProviderId()
    {
        return $this->storageProviderId;
    }

    /**
     * @param string $storageProviderId
     *
     * @return ItemImage
     */
    public function setStorageProviderId($storageProviderId)
    {
        $this->storageProviderId = $storageProviderId;

        return $this;
    }

    /**
     * @return string
     */
    public function getMd5Checksum()
    {
        return $this->md5Checksum;
    }

    /**
     * @param string $md5Checksum
     *
     * @return ItemImage
     */
    public function setMd5Checksum($md5Checksum)
    {
        $this->md5Checksum = $md5Checksum;

        return $this;
    }

    /**
     * @return string
     */
    public function getMd5ChecksumOriginal()
    {
        return $this->md5ChecksumOriginal;
    }

    /**
     * @param string $md5ChecksumOriginal
     *
     * @return ItemImage
     */
    public function setMd5ChecksumOriginal($md5ChecksumOriginal)
    {
        $this->md5ChecksumOriginal = $md5ChecksumOriginal;

        return $this;
    }

    /**
     * @return string
     */
    public function getCleanImageName()
    {
        return $this->cleanImageName;
    }

    /**
     * @param string $cleanImageName
     *
     * @return ItemImage
     */
    public function setCleanImageName($cleanImageName)
    {
        $this->cleanImageName = $cleanImageName;

        return $this;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     *
     * @return ItemImage
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return string
     */
    public function getUrlMiddle()
    {
        return $this->urlMiddle;
    }

    /**
     * @param string $urlMiddle
     *
     * @return ItemImage
     */
    public function setUrlMiddle($urlMiddle)
    {
        $this->urlMiddle = $urlMiddle;

        return $this;
    }

    /**
     * @return string
     */
    public function getUrlPreview()
    {
        return $this->urlPreview;
    }

    /**
     * @param string $urlPreview
     *
     * @return ItemImage
     */
    public function setUrlPreview($urlPreview)
    {
        $this->urlPreview = $urlPreview;

        return $this;
    }

    /**
     * @return string
     */
    public function getUrlSecondPreview()
    {
        return $this->urlSecondPreview;
    }

    /**
     * @param string $urlSecondPreview
     *
     * @return ItemImage
     */
    public function setUrlSecondPreview($urlSecondPreview)
    {
        $this->urlSecondPreview = $urlSecondPreview;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     *
     * @return ItemImage
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTime $updatedAt
     *
     * @return ItemImage
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return array|ItemImageName[]
     */
    public function getNames()
    {
        return $this->names;
    }

    /**
     * @param array|ItemImageName[] $names
     *
     * @return ItemImage
     */
    public function setNames($names)
    {
        $this->names = $names;

        return $this;
    }

    /**
     * @return array|ItemImageAvailability[]
     */
    public function getAvailabilities()
    {
        return $this->availabilities;
    }

    /**
     * @param array|ItemImageAvailability[] $availabilities
     *
     * @return ItemImage
     */
    public function setAvailabilities($availabilities)
    {
        $this->availabilities = $availabilities;

        return $this;
    }

}