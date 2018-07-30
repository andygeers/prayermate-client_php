<?php
/**
 * @file
 * @author Lightly Salted Software Ltd
 * @date   30 7 2018
 */

declare(strict_types=1);

namespace PrayerMate\Driver;

/**
 * Generic driver interface so you can unit test, replace with a curl driver or other
 */
interface DriverInterface
{
    const BASE_URI = 'https://www.prayermate.net/api/';

    public function httpGet(string $endpoint): array;

    public function httpPost(string $endpoint, array $data): array;
}