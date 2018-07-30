<?php
/**
 * @file
 * @author Lightly Salted Software Ltd
 * @date   30 7 2018
 */

namespace PrayerMate;

/**
 * Main entry points
 */
class PrayerMateAPI
{
    /** @var Driver\DriverInterface */
    private $driver;

    public function __construct(Driver\DriverInterface $driver)
    {
        $this->driver = $driver;
    }

    public function getFeedContents(string $feedSlug): array
    {
        return $this->driver->httpGet('feeds/' . $feedSlug);
    }

    /**
     * @param string     $feedSlug
     * @param string     $feedID
     * @param string     $lastModified
     * @param Petition[] $petitions
     * @return array returned from the portal. Don't usually need to check it: it just says 'ok' or will throw an
     *               exception on failure
     */
    public function setFeedContents(string $feedSlug, string $feedID, string $lastModified, array $petitions): array
    {
        return $this->driver->httpPost('input_feeds/process',
            ['feed'      => ['id' => $feedID, 'user_feed_slug' => $feedSlug, 'last_modified' => $lastModified],
             'petitions' => $petitions]);
    }
}
