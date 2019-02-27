<?php

namespace App\DataFixtures\Faker;

class TechniqueProvider extends \Faker\Provider\Base
{
    protected static $techniques = [
        'title' => [
            'Ikkyo',
            'Nikkyo',
            'Sankyo',
            'Irimi Nage',
            'Kote Gaeshi',
            'Shiho Nage',
            'Soto Kaiten Nage',
            'Uchi Kaiten Nage',
            'Juji Garami'

        ],
        'attack' => [
            'AI HANMI KATATE DORI',
            'KATATE DORI (GYAKU HANMI)',
            'KATADORI MEN UCHI',
            'SHOMEN UCHI',
            'YOKOMEN UCHI',
            'CHUDAN TSUKI',
        ],
        'side' => [
            'Omote',
            'Ura'

        ],
        'position' => [
            'Tachi waza',
            'Hanmi handachi waza',
            'Suwari waza'

        ]
    ];

    public static function TechniqueTitles()
    {
        return static::randomElement(static::$techniques['title']);
    }

    public static function TechniqueAttacks()
    {
        return static::randomElement(static::$techniques['attack']);
    }

    public static function TechniqueSides()
    {
        return static::randomElement(static::$techniques['side']);
    }

    public static function TechniquePositions()
    {
        return static::randomElement(static::$techniques['position']);
    }
}