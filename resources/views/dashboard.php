<?php

use Project\Components\Session;
use Project\Components\View;
use Project\Models\UserModel;
/**
 * @var View $this
 * @var UserModel $user;
 */

$this->title = 'Dashboard';
$isQuizActive = (bool)Session::getInstance()->get(Session::KEY_CURRENT_ATTEMPT_ID);
?>

<h1>Welcome to Dashboard, <?= htmlspecialchars($user->name); ?> </h1>

<quiz-main :user-name="'<?= e($user->name); ?>'" :p-is-quiz-active="<?= json_encode($isQuizActive); ?>">
</quiz-main>