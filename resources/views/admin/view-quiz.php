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
 * @var QuestionModel $questions
 * @var AnswerModel $correctAnswers
 */
$this->title = 'Quiz: '.e($quiz->name);

?>

<h3 class="mt-3">
    Quiz name: <?= e($quiz->name); ?>
</h3>

<hr class="my-4">

<h4><?= e($quiz->name); ?>'s questions:</h4>
<table class="table">
  <thead>
    <tr>
      <th>ID / Question</th>
      <th>Correct answer</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($questions as $k => $item1): ?>
    <tr>
        <th>(<?= $item1->id; ?>). <?= $item1->title ?> </th>
        <th> <?= $correctAnswers[$k]->title ?> </th>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>



