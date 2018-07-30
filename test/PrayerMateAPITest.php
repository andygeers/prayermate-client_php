<?php
/**
 * @file
 * @author Lightly Salted Software Ltd
 * Date: 30/07/18
 */

declare(strict_types=1);

namespace PrayerMate;

use PHPUnit\Framework\TestCase;
use PrayerMate\Driver\DriverInterface;

class PrayerMateAPITest extends TestCase
{
    const SLUG    = 'abc123';
    const FEED_ID = '4567';

    public function testGetFeedContents()
    {
        $driver = $this->createMock(DriverInterface::class);
        $driver->expects(self::once())
               ->method('httpGet')
               ->with('feeds/' . self::SLUG)
               ->willReturn($expected = ['foo']);
        $subject = new PrayerMateAPI($driver);
        $this->assertEquals($expected, $subject->getFeedContents(self::SLUG));
    }

    public function testSetFeedContents()
    {
        $driver = $this->createMock(DriverInterface::class);
        $driver->expects(self::once())
               ->method('httpPost')
               ->with('input_feeds/process',
                   ['feed'      => ['id'             => self::FEED_ID,
                                    'user_feed_slug' => self::SLUG,
                                    'last_modified'  => $lastModified = '2018-01-01 02:03:04'],
                    'petitions' => $petitions = ['foo']])
               ->willReturn($expected = ['foo']);
        $subject = new PrayerMateAPI($driver);
        $this->assertEquals($expected, $subject->setFeedContents(self::SLUG, self::FEED_ID, $lastModified, $petitions));
    }
}
