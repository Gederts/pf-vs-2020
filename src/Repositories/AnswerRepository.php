<?php


namespace Project\Repositories;


use Project\Models\AnswerModel;

class AnswerRepository
{
    public function getById(int $answerId): ?AnswerModel
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return AnswerModel::query()->where('id', '=', $answerId)->first();
    }
}