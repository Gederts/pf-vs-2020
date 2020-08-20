<?php

use Project\Components\ActiveUser;
use Project\Components\View;
use Project\Models\AnswerModel;
use Project\Models\QuestionModel;
use Project\Models\QuizModel;
use Project\Models\UserModel;

/**
 * @var View $this
 * @var QuizModel $quiz
 * @var UserModel $user
 * @var  array $quizzesTaken
 * @var QuestionModel $questions
 * @var AnswerModel $correctAnswers
 */
$this->title = 'Results: '.e($user->name);
$i = 0;
?>

<h3 class="mt-3">
    Results for user: <?= e($user->name); ?>
</h3>

<hr class="my-4">

<h4>My recent quizzes:</h4>
<table class="table">
    <thead>
    <tr>
        <th>Quiz taken:</th>
        <th>Correctly answered:</th>
        <th>Started at:</th>
    </tr>
    </thead>
    <tbody>

    <?php if($quizzesTaken[0]!=null){
            for($i = 0; $i <= count($quizzesTaken[0]); $i++ ){ ?>
                <tr>
                    <th><?= $quizzesTaken[0][$i]; ?></th>
                    <th> <?= $quizzesTaken[3][$i]; ?> / <?= $quizzesTaken[2][$i]; ?> </th>
                    <th><?= $quizzesTaken[1][$i]; ?></th>
                </tr>
    <?php }} ?>
    </tbody>
</table>
