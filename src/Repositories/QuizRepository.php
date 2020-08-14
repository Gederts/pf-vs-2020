<?php


namespace Project\Repositories;


use Project\Models\QuestionModel;
use Project\Models\QuizModel;

class QuizRepository
{
    public function addQuiz(int $id, string $name): QuizModel
    {

    }

    public function addQuizQuestion(int $id, int $quizId, string $title): QuestionModel
    {

    }

    public function getAll(): array //atgriež UserModel masīvu jeb UserModel []
    {
        return QuizModel::all()->all(); //tas pats kas query()->get()->all()
    }
}