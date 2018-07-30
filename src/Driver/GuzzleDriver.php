<?php
/**
 * @file
 * @author Lightly Salted Software Ltd
 * @date   30 7 2018
 */

namespace PrayerMate\Driver;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use PrayerMate\PrayerMateException;

/**
 */
class GuzzleDriver implements DriverInterface
{
    /** @var string */
    private $apiKey;

    /** @var string */
    private $password;

    /** @var string: usually left blank */
    private $email;

    /** @var object */
    private $handler;

    public function __construct(string $apiKey, string $password, string $email = '')
    {
        $this->apiKey   = $apiKey;
        $this->password = $password;
        $this->email    = $email;
    }

    public function httpGet(string $endpoint): array
    {
        return $this->parseResponse('GET', $endpoint);
    }

    public function httpPost(string $endpoint, array $data): array
    {
        return $this->parseResponse('POST', $endpoint,
            ['headers' => ['Content-Type' => 'application/json'], 'body' => json_encode($data)]);
    }

    /**
     * inject a mock handler for testing
     * @param object $handler Guzzle doesn't return a convenient type hint
     */
    public function setHandler($handler)
    {
        $this->handler = $handler;
    }

    protected function parseResponse(string $method, string $endpoint, array $options = []): array
    {
        $client  = new Client(array_filter(['base_uri' => self::BASE_URI, 'handler' => $this->handler]));
        $options = array_merge_recursive(['auth'    => [$this->email, $this->password],
                                          'headers' => ['X-API-Key' => $this->apiKey]], $options);
        try {
            $response = $client->request($method, $endpoint, $options);
        } catch (RequestException $ex) {
            // convert Guzzle exceptions to PrayerMate exceptions so they are easier to catch by the caller
            throw new PrayerMateException($ex->getMessage(), $ex->getCode(), $ex);
        }
        if (strpos($response->getHeaderLine('Content-Type'), 'application/json') === false) {
            throw new PrayerMateException('Unexpected content type returned: ' . strip_tags($response->getHeaderLine('Content-Type')));
        }
        $body = json_decode($response->getBody()->getContents(), true) ?: [];
//        if (isset($body['error'])) {
//            throw new PrayerMateException('API Error: ' . strip_tags($body['error']));
//        }
        return $body;
    }
}
