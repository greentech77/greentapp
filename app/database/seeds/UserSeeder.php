<?php

class UserSeeder
extends DatabaseSeeder
{
    public function run()
    {
        $users = [
            [
                "username" => "greentech",
                "password" => Hash::make("gr33nt3ch"),
                "email"    => "gregakop@gmail.com"
            ]
        ];

        foreach ($users as $user)
        {
            User::create($user);
        }
    }
}