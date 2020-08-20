<?php


namespace Project\Repositories;


use Project\Components\Session;
use Project\Models\AnswerModel;
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

    public function getQuizById(int $id): ?QuizModel
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $quiz = QuizModel::query()->where('id', '=', $id)->first();
        /* if (!$quiz) {
             Session::getInstance()->setErrorMessage("Quiz with ID '{$id}' not found");
             return null;
         }
         else {
             return $quiz;
         }*/
    }

    public function getQuestionsByQuizId(int $id): ?array
    {
        $questions = [];
        $questionModels = QuestionModel::query()->where('quiz_id', '=', $id)->get();
        foreach ($questionModels as $questionModel) {
            $questions [] = $questionModel;
        }
        if (!$questions) {
            Session::getInstance()->setErrorMessage("Quiz with ID '{$id}' not found");
            return null;
        } else {
            return $questions;
        }

    }

    public function getCorrectAnswersByQuizId(int $quizId): ?array
    {
        $correctAnswers = [];
        $someArray = [];
        $assignedQuestions = [];
        $questionModels = QuestionModel::query()->where('quiz_id', '=', $quizId)->get();
        foreach ($questionModels as $questionModel) {
            $assignedQuestions [] = $questionModel;
        }
        foreach ($assignedQuestions as $assignedQuestion)   //iegustam visus jautajumus kas piesaistiti atbildem
        {
            $someArray [] = $assignedQuestion->id;
        }

        $answerModels = AnswerModel::all()->all();
        foreach ($someArray as $questionId){
            foreach($answerModels as $answerModel){
                if($answerModel->is_correct == true && $answerModel->question_id == $questionId){
                    $correctAnswers [] = $answerModel;
                }
            }
        }
        return $correctAnswers;
    }
}