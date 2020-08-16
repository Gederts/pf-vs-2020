<?php

use Project\Components\View;
use Project\Models\QuizModel;
use Project\Models\UserModel;

/**
 * @var View $this
 * @var UserModel[] $users
 * @var QuizModel[] $quizzes
 */

$this->title = 'Admin panel';

?>

<h1>Admin Panel</h1>

<h2>All users</h2>
<table class="table">
    <thead>
    <tr>
        <th>ID</th>
        <th>Email</th>
        <th>Name</th>
        <th>Created at</th>
        <th></th>
    </tr>

    </thead>
    <tbody>
    <?php foreach ($users as $user): ?>
        <tr>
            <td><?= $user->id ?></td>
            <td><?= htmlspecialchars($user->email) //ja nav specialchars var injecet <script> ?></td>
            <td><?= htmlspecialchars($user->name) ?></td>
            <td><?= htmlspecialchars($user->created_at) ?></td>
            <td>
                <form id="js--delete-form" action="/delete/user/<?= $user->id ?>" method="post">
                    <input type="submit" name="" value="Delete"/>
                    <input type="hidden" name="identity" value="<?php echo $user->id; ?>" />
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<h2>All quizzes</h2>
<table class="table">
    <thead>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Question count
        </th?
    </tr>
    </thead>
    <tbody>
    <?php foreach ($quizzes as $quiz): ?>
        <tr>
            <td><?= $quiz->id ?></td>
            <td><?= htmlspecialchars($quiz->name) ?></td>
            <td><?= $quiz->questions()->count() ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<script>
    function onDeleteClicked() {
        event.preventDefault();
        document.getElementById('js--delete-form').submit();
    }
</script>