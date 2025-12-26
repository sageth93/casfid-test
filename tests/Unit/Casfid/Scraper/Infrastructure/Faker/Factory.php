<?php

namespace App\Tests\Unit\Casfid\Scraper\Infrastructure\Faker;

use App\Tests\Unit\Casfid\Scraper\Infrastructure\Faker\Provider\SourceProvider;

class Factory extends \Faker\Factory
{
    private static \Faker\Generator|null $instance = null;

    public static function create($locale = self::DEFAULT_LOCALE): ?\Faker\Generator
    {
        if (null === static::$instance) {
            static::$instance = new Generator();
        }

        static::$instance->addProvider(new SourceProvider(static::$instance));

        return static::$instance;
    }
}
