<?php

use Project\Components\Session;

$this->title = 'Login';
/**
 *  * @var string $error
 */
?>

<?php if (!empty($error)): ?>
  <div style="margin-top: 30px;" class="alert alert-danger" role="alert">
    <ul class="mb-0">

      <li class="float-none"><?= htmlspecialchars($error) ?></li>

    </ul>
  </div>
<?php endif; ?>
<!--<form action="/login" method="POST">-->
<!--   <div class="form-group">-->
<!--        <input class="form-control" type="text" name="csrf" value="--><? //= e(Session::getInstance()->getCsrf()); ?><!--"-->
<!--    </div>  -->
<!--    <div class="form-group">-->
<!--        <label for="exampleInputEmail1">Email address</label>-->
<!--        <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">-->
<!--        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>-->
<!--    </div>-->
<!--    <div class="form-group">-->
<!--        <label for="exampleInputPassword1">Password</label>-->
<!--        <input type="password" name="password" class="form-control" id="exampleInputPassword1">-->
<!--    </div>-->
<!--    <button type="submit" class="btn btn-primary">Submit</button>-->
<!--</form>-->
<style>


</style>

<div id="form-menu">
  <div>
    <div class="form-wrap">
      <label>Login</label>
      <form action="/login" method="post">
        <div class="input-field">
          <input class="input" name="email" type="text" required>
          <label class="input-label">Email</label>
        </div>
        <div class="input-field">
          <input class="input" name="password" type="password" required>
          <label class="input-label">Password</label>
        </div>
        <input class="button" type="submit" value="Sign In">
      </form>
    </div>
  </div>
</div>