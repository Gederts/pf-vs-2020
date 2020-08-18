<?php


namespace Project\Controllers;


use Project\Components\Controller;
use Project\Structures\QuizStructure;

class QuizRpcController extends Controller
{
    public function getAll(): string
    {
        $quizzes = [];

        $quizStructure = new QuizStructure();
        $quizStructure->id = 1;
        $quizStructure->name = 'Quiz Name';
        $quizStructure->questionCount = 20;

        $quizzes[] = $quizStructure;
        $quizzes[] = $quizStructure;


        return json_encode(
            [
                'success' => true,
                'quizData' => array_map( fn ($quizDatum) => $quizDatum->toArray(), $quizzes),
            ]
        );
    }

}