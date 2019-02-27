<?php

namespace App\DataFixtures\Faker;


class GradeProvider extends \Faker\Provider\Base
{
    protected static $grades = [
        'name' => [
            'No Kyu',
            '5em Kyu',
            '4em Kyu',
            '3em Kyu',
            '2em Kyu',
            '1er Kyu',
            '1er Dan Shodan',
            '2em Dan Nidan',
            '3em Dan Sandan',
            '4em Dan Yondan',
            // '5em Dan Godan',
            // '6em Dan Rokudan',
            // '7em Dan Shichidan',
        ]
    ];

    public static function gradeNames()
    {
        return static::randomElement(static::$grades['name']);
    }
}