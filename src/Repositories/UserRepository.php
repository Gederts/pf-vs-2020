<?php
declare(strict_types=1);

namespace Project\Repositories;


use Project\Models\UserModel;

class UserRepository
{

    public function checkIsEmailRegistered(string $email): bool
    {
        return UserModel::query()->where('email', '=', $email)->exists();
    }

    public function saveModel(UserModel $user): UserModel
    {
        $user->save();

        return $user;
    }

    public function getUserByEmail(string $email): ?UserModel
    {
        /** @noinspection  PhpIncompatibleReturnTypeInspection */
        return UserModel::query()->where('email', '=', $email)->first();
    }

    public function getUserById(int $id): ?UserModel
    {
        /** @noinspection  PhpIncompatibleReturnTypeInspection */
        return UserModel::query()->where('id', '=', $id)->first();
    }

    public function deleteUser(int $id): void
    {
        UserModel::destroy($id);
    }

    public function changeUserPrivilege(int $id): void
    {
        if (UserModel::query()->where('id', '=', $id)->first()->is_admin === 0){
            UserModel::query()->where('id', '=', $id)->first()->update(['is_admin' => '1']);
        }
        else {
            UserModel::query()->where('id', '=', $id)->first()->update(['is_admin' => '0']);
        }
    }


    public function getAll(): array //atgriež UserModel masīvu jeb UserModel []
    {
        return UserModel::all()->all(); //pirmais all atgriež kolekciju. otrais all atgriež elementus
    }


}