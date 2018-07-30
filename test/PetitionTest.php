<?php
/**
 * @file
 * @author Lightly Salted Software Ltd
 * Date: 30/07/18
 */

declare(strict_types=1);

namespace PrayerMate;

use PHPUnit\Framework\TestCase;

class PetitionTest extends TestCase
{
    public function testMinimalConstructor()
    {
        $subject = new Petition($description = 'foo bar');
        $array   = $subject->toArray();
        $this->assertEquals($description, $array['description']);
        $this->assertNotEmpty($array['uid']);
        $this->assertTrue($array['exclusive']);
        $this->assertNotEmpty($array['date']);
        $this->assertArrayNotHasKey('markdown', $array);
    }

    public function testAllParameters()
    {
        $subject = (new Petition($description = 'foo bar', $date = '2018-01-01'))
            ->setTitle($title = 'the title')
            ->setUniqueID($uniqueID = 'foobar123')
            ->setIsMarkdown()
            ->setPublicUrl($publicUrl = 'https://foo/bar')
            ->setVideoEmbedUrl($videoEmbedUrl = 'https://youtube.com')
            ->setRemoteAttachmentUrl($remoteAttachmentUrl = 'https://remote/url');
        $array   = $subject->toArray();
        $this->assertEquals($description, $array['description']);
        $this->assertEquals($uniqueID, $array['uid']);
        $this->assertArrayNotHasKey('exclusive', $array);
        $this->assertTrue($array['markdown']);
        $this->assertEquals($publicUrl, $array['public_url']);
        $this->assertEquals($videoEmbedUrl, $array['video_embed_url']);
        $this->assertEquals($remoteAttachmentUrl, $array['remote_attachment_url']);
        $this->assertEquals($array, $subject->jsonSerialize());
    }
}
