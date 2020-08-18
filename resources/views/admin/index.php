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
        <th>Is admin?</th>
        <th>Created at</th>
        <th></th>
        <th></th>
    </tr>

    </thead>
    <tbody>
    <?php foreach ($users as $user): ?>
        <tr>
            <td><?= $user->id ?></td>
            <td><?= htmlspecialchars($user->email) //ja nav specialchars var injecet <script> ?></td>
            <td><?= htmlspecialchars($user->name) ?></td>
            <td><?= ($user->is_admin) ?></td>
            <td><?= htmlspecialchars($user->created_at) ?></td>
            <td>
            <a class="btn btn-sm btn-success" href="/admin/view-user?id=<?= e($user->id); ?>">
              View
            </a>
            </td>
            <!--<td>
                <form action="/edit/user/<?= $user->id ?>" method="post">
                    <input type="submit" value="Promote/Demote"/>
                    <input type="hidden" name="identity" value="<?php echo $user->id; ?>" />

                </form>
            </td>
            <td>
                <form action="/delete/user/<?= $user->id ?>" method="post">
                    <input type="submit" value="Delete"/>
                    <input type="hidden" name="identity" value="<?php echo $user->id; ?>" />

                </form>
            </td>-->
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
