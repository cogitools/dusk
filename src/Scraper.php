<?php

namespace Laravel\Dusk;

use Exception;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Laravel\Dusk\Chrome\SupportsChrome;
use Laravel\Dusk\Concerns\ProvidesScraper;

abstract class Scraper
{
    use ProvidesScraper, SupportsChrome;

    function __construct()
    {
        $classname = class_basename($this);
        $screenshots_dir = storage_path('scrapers/'.$classname.'/screenshots');
        $console_dir = storage_path('scrapers/'.$classname.'/console');
        $source_dir = storage_path('scrapers/'.$classname.'/source');

        if (!file_exists($screenshots_dir)) { mkdir($screenshots_dir, 0777, true); }
        if (!file_exists($console_dir)) { mkdir($console_dir, 0777, true); }
        if (!file_exists($source_dir)) { mkdir($source_dir, 0777, true); }

        ScraperBrowser::$baseUrl = $this->baseUrl();

        ScraperBrowser::$storeScreenshotsAt = $screenshots_dir;

        ScraperBrowser::$storeConsoleLogAt = $console_dir;

        ScraperBrowser::$storeSourceAt = $source_dir;

        // ScraperBrowser::$userResolver = function () {
        //     return $this->user();
        // };
    }

    /**
     * Create the RemoteWebDriver instance.
     *
     * @return \Facebook\WebDriver\Remote\RemoteWebDriver
     */
    protected function driver()
    {
        return RemoteWebDriver::create(
            'http://localhost:9515', DesiredCapabilities::chrome()
        );
    }

    /**
     * Determine the application's base URL.
     *
     * @return string
     */
    protected function baseUrl()
    {
        return rtrim(config('app.url'), '/');
    }

    /**
     * Return the default user to authenticate.
     *
     * @return \App\User|int|null
     *
     * @throws \Exception
     */
    // protected function user()
    // {
    //     throw new Exception('User resolver has not been set.');
    // }

    /**
     * Determine if the tests are running within Laravel Sail.
     *
     * @return bool
     */
    protected static function runningInSail()
    {
        return isset($_ENV['LARAVEL_SAIL']) && $_ENV['LARAVEL_SAIL'] == '1';
    }
}
