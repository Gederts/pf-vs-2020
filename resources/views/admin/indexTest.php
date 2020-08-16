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

        <tr>
            <td><?= $users->id ?></td>
            <td><?= htmlspecialchars($users->email) //ja nav specialchars var injecet <script> ?></td>
            <td><?= htmlspecialchars($users->name) ?></td>
            <td><?= htmlspecialchars($users->created_at) ?></td>
            <td>
                <form id="js--delete-form" action="/delete/user/<?= $users->id ?>" method="post">
                    <input type="submit" name="" value="Delete"/>
                </form>
            </td>
        </tr>

    </tbody>
</table>

<script>
    function onDeleteClicked() {
        event.preventDefault();
        document.getElementById('js--delete-form').submit();
    }
</script>