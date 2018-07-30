<?php
/**
 * @file
 * @author Lightly Salted Software Ltd
 * @date   30 7 2018
 */

namespace PrayerMate;

/**
 * one prayer request
 *
 * data transfer object to make some of the "business logic" around how petitions work a little easier to manage
 */
class Petition implements \JsonSerializable
{
    const IS_EXCLUSIVE = '';

    /** @var string required. will be set to a random guid if not provided */
    private $uniqueID = '';

    /** @var string YYYY-MM-DD required. if not set, the petition will be "exclusive" and replace all other petitions */
    private $date = self::IS_EXCLUSIVE;

    /** @var string required. the content */
    private $description = '';

    /** @var bool */
    private $isMarkdown = false;

    /** @var string for notifications only */
    private $title = '';

    /** @var string public url of this petition: todo i assume this means an external / third party url? */
    private $publicUrl = '';

    /** @var string for embedded video e.g. https://www.youtube.com/embed/uo3kXcNghGg?list=PL4zD5797LHdfkVYi1Fq5OT5-FeP3mn1p0 */
    private $videoEmbedUrl = '';

    /** @var string public url for a downloadable attachment etc pdf. todo Is this 3rd party as well? */
    private $remoteAttachmentUrl = '';

    public function __construct(string $description, string $date = self::IS_EXCLUSIVE)
    {
        $this->description = $description;
        $this->date        = $date;
    }

    public function setUniqueID(string $uniqueID): self
    {
        $this->uniqueID = $uniqueID;
        return $this;
    }

    public function setIsMarkdown(bool $isMarkdown = true): self
    {
        $this->isMarkdown = $isMarkdown;
        return $this;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function setPublicUrl(string $publicUrl): self
    {
        $this->publicUrl = $publicUrl;
        return $this;
    }

    public function setVideoEmbedUrl(string $videoEmbedUrl): self
    {
        $this->videoEmbedUrl = $videoEmbedUrl;
        return $this;
    }

    public function setRemoteAttachmentUrl(string $remoteAttachmentUrl): self
    {
        $this->remoteAttachmentUrl = $remoteAttachmentUrl;
        return $this;
    }

    public function toArray(): array
    {
        $result = array_filter([
            'uid'                   => $this->uniqueID ?: uniqid(),
            'date'                  => $this->date ?: gmdate('Y-m-d'),
            'exclusive'             => empty($this->date),
            'title'                 => $this->title,
            'description'           => $this->description,
            'markdown'              => $this->isMarkdown,
            'public_url'            => $this->publicUrl,
            'video_embed_url'       => $this->videoEmbedUrl,
            'remote_attachment_url' => $this->remoteAttachmentUrl,
        ]);
        return $result;
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
