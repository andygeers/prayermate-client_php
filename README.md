# PrayerMate API

This PHP composer package is an API for working with the [PrayerMate platform](https://www.prayermate.net/). 

PrayerMate is an app to help you pray and this API allows you interact with the platform.

## Installation

```
composer install prayermate/prayermate-api
```

## Usage

You need to locate four pieces of information from the prayermate.net portal. 

* Log in to the portal.
* Create a feed if you have not made one yet.
* Click `API Access` at the bottom of the right menu for the feed
* Scroll down to the HTTP Requests heading
* In the Basic Authorisation section copy your `$apiKey` (60 character hex string) and `$password` (60 character hex string). 
* In the Posting New Content section, copy the copy the `$feedID` (integer?) and `$feedSlug` (38 character hex string) from the values in the json block. 

The `$apiKey` and `$password` are global values for your account to access the API. The `$feedID` and `$feedSlug` are unique per feed.

```php
$driver = new Driver\GuzzleDriver($apiKey, $password, $email);
$prayermate = new PrayerMateAPI($driver);
```

A _petition_ is one piece of content: a prayer request in a feed. It can be plain text, or markdown if you enable Markdown by clicking the button at the bottom of the API Access page on the portal.

To see what is in your feed:
```php
$petitions = $prayermate->getFeedContents($feedSlug);
```

To add a new request to the feed

```php
$petition = new Petition('My prayer *Request* content', '2018-10-11');
$petition->setTitle('A test request');
$petition->setIsMarkdown();
$prayermate->setFeedContents($feedSlug, $feedID, gmdate('Y-m-d H:i:s'), [$petition]);
```

Note that feeds can have several different "styles" (configurations) eg Calendar, Newsletter, Day of the Month which you choose on creation. 
Follow the documentation on prayermate.net for more details.
Watch out for `Petition`s with no date. These are "exclusive" which means they replace all the other petitions in the feed.
This is handy for an API that pushes out daily updates and is not concerned for historic data. Read the documentation on the
API page for your feed about handling multiple petitions carefully.
 
## Development

* Unit Tests `composer phpunit`
* Static analysis `composer phpstan`

### ToDo

* tls key pinning
* The Ruby Gem version https://github.com/andygeers/prayermate_api has a couple of other endpoints but we have no documentation for those yet.

## Contributing

Currently development and usage is internal. Contact [info@prayermate.net](mailto:info@prayermate.net) to get involved.

## Code of Conduct

Everyone interacting in the PrayerMateApi project’s codebases, issue trackers, chat rooms and mailing lists is expected to follow the [code of conduct](CODE_OF_CONDUCT.md).