<?php
declare(strict_types=1);

namespace Project\Services;


use Project\Models\UserModel;
use Project\Structures\UserRegisterItem;

class UserService
{
    public function signUp(UserRegisterItem $item): UserModel
    {
        var_dump($item);
        // TODO implement
        $user = new UserModel();


        return $user;
    }

    public function signIn(string $email): ?UserModel
    {
        return null;
    }

    public function signOut():void //glabasies sesijaa
    {
        //TODO implement
    }
}