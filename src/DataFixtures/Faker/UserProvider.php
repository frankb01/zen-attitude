<?php
 
 namespace App\DataFixtures\Faker;
 
 class UserProvider extends \Faker\Provider\Base
 {
    protected static $roles = [
        'code' => [
            'ROLE_TEACHER',
            'ROLE_USER'
        ],
        'role' => [
            'ROLE_TEACHER' => 'Professeur',
            'ROLE_USER' => 'Utilisateur'
        ],
    ];
    public static function rolesCode()
    {
        return static::randomElement(static::$roles['code']);
    }
    public static function RoleName($key)
    {
        return static::$roles['role'][$key];
    }
 }