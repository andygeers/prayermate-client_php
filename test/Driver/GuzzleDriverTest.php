<?php
/**
 * @file
 * @author Lightly Salted Software Ltd
 * Date: 30/07/18
 */

declare(strict_types=1);

namespace PrayerMate\Driver;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class GuzzleDriverTest extends TestCase
{
    const API_KEY  = 'abc123';
    const PASSWORD = 'thepassword';

    /** @var \GuzzleHttp\Handler\MockHandler */
    private $handler;

    /** @var array */
    private $container = [];

    public function getSubject(): GuzzleDriver
    {
        // instrument Guzzle so we can see the requests and responses
        $stack = HandlerStack::create($this->handler = new MockHandler());
        $stack->push(Middleware::history($this->container));
        $driver = new GuzzleDriver(self::API_KEY, self::PASSWORD);
        $driver->setHandler($stack);
        return $driver;
    }


    public function testHttpGet()
    {
        // test timeout, 404, 500, invalid content type, json failure
//        $subject = $this->getSubject();
//        $this->handler->append(new Response());
//        $expected = [];
//        $this->assertEquals($expected, $subject->httpGet($endpoint = 'foo'));
    }

    public function testHttpPost()
    {

    }
}
