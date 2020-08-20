<?php
declare(strict_types=1);

namespace Project\Repositories;


use Project\Components\Session;
use Project\Models\QuestionModel;
use Project\Models\QuizModel;
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
        $user = UserModel::query()->where('id', '=', $id)->first();
        if (!$user) {
            Session::getInstance()->setErrorMessage("User with ID '{$id}' not found");
            return null;
        }
        else {
            return $user;
        }
    }


    public function deleteUser(int $id): void
    {
        UserModel::destroy($id);
    }


    public function getAll(): array //atgriež UserModel masīvu jeb UserModel []
    {
        return UserModel::all()->all(); //pirmais all atgriež kolekciju. otrais all atgriež elementus
    }




}