<?php
use Project\Components\View;
use Project\Structures\UserRegisterItem;

/**
 * @var View $this
 * @var array $errors
 * @var UserRegisterItem $registerItem
 */
$this->title = 'Register';
?>

<?php if (!empty($errors)): ?>
    <div style="margin-top: 30px;" class="alert alert-danger" role="alert">
        <ul class="mb-0">
            <?php foreach ($errors as $error): ?>
                <li class="float-none"><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form action="/register" method="POST">
    <div class="form-group">
        <label for="exampleInputEmail1">Name</label>
        <input type="name" name="name" class="form-control" id="inputName" value="<?= htmlspecialchars($registerItem->name); ?>">
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Email address</label>
        <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="<?= htmlspecialchars($registerItem->email)?>">
        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
    </div>
    <div class="form-group">
        <label for="exampleInputPassword1">Password</label>
        <input type="password" name="password" class="form-control" id="exampleInputPassword1">
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>