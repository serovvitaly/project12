<?php

namespace AppBundle\Entity;


class OfferEntity
{
    protected $id;
    protected $title;
    protected $content;
    protected $sourceUrl;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return OfferEntity
     */
    public function setId(int $id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return OfferEntity
     */
    public function setTitle(string $title)
    {
        $this->title = trim($title);
        return $this;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     * @return OfferEntity
     */
    public function setContent(string $content)
    {
        $this->content = trim($content);
        return $this;
    }

    /**
     * @return string
     */
    public function getSourceUrl()
    {
        return $this->sourceUrl;
    }

    /**
     * @param string $sourceUrl
     * @return OfferEntity
     */
    public function setSourceUrl(string $sourceUrl)
    {
        $this->sourceUrl = trim($sourceUrl);
        return $this;
    }
}