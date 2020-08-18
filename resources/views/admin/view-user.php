<?php

use Project\Components\ActiveUser;
use Project\Components\View;
use Project\Models\UserModel;

/**
 * @var View $this
 * @var UserModel $user
 */
$this->title = 'User: '.e($user->name);
?>

<h3 class="mt-3">
    <?= e($user->name); ?>
    <?php if($user->name === htmlspecialchars(ActiveUser::getUser()->name)): ?>
    <div class="badge badge-success">
        It's you!
    </div>
    <?php endif; ?>
</h3>

<p>
    Email: <?= $user->email; ?><br/>
    Joined at: <?= $user->created_at; ?>
</p>

<hr class="my-4">

<h4>Admin status:</h4>

<form action="/admin/toggle-user-admin" method="post">
    <input type="hidden" name="id" value="<?= $user->id ?>">

    <?php if ($user->is_admin): ?>
        <p>User currently is an admin.</p>
        <button type="submit" class="btn btn-danger">
            Remove admin
        </button>
    <?php else: ?>
        <p>User currently is not an admin.</p>
        <button type="submit" class="btn btn-success">
            Make admin
        </button>
    <?php endif; ?>
</form>

<hr class="my-4">

<h4>Danger zone:</h4>

<form action="/admin/delete-user" method="post">
    <input type="hidden" name="id" value="<?= $user->id ?>">
    <button type="submit" class="btn btn-danger">
        Delete user
    </button>
</form>



