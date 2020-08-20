<?php

use Project\Components\ActiveUser;
use Project\Components\Session;
use Project\Components\View;
/**
 * @var View $this
 */


use Project\Models\UserModel;
/**
 * @var View $this
 * @var UserModel $user;
 */
?>

<!DOCTYPE html>
<head>
    <title>
       <?= $this->title ?>
    </title>
    <link rel="stylesheet" href="/assets/app.css">
    <script>
      window.csrf = "<?= Session::getInstance()->getCsrf(); ?>";
    </script>
</head>
<style>
    ul {
        list-style-type: none;


        overflow: hidden;

    }

    li {
        float: left;
    }

    li a {
        display: block;
        color: white;
        text-align: center;
        padding: 14px 16px;

    }


</style>
<body>
    <nav>
        <ul>
            <li><a href="/">Quiz</a></li>
            <?php if(!ActiveUser::isLoggedIn()): ?>
            <li><a href="/login">Log in</a></li>
            <li><a href="/register">Register</a></li>
            <?php endif; ?>
            <?php if(ActiveUser::isLoggedIn()): ?>
            <li><a href="/my-results">My results</a></li>
            <li><a href="/dashboard">Dashboard</a></li>
                <?php if (ActiveUser::getUser()->is_admin): ?>
                    <li class="nav-item">
                        <a href="/admin">Admin</a>
                    </li>
                <?php endif; ?>
            <li><a href="/logout" onclick="onLogoutClicked()">Logout</a></li>

            <form id="js--logout-form" action="/logout" method="post">
                <input type="hidden" name="csrf" value="<?= e(Session::getInstance()->getCsrf()); ?>">
            </form>
            <li class="navbar user">Your username is <?php echo htmlspecialchars(ActiveUser::getUser()->name); ?></li>
            <?php endif; ?>
        </ul>
    </nav>
    <div id="app" class="container">
        <?php if (Session::getInstance()->hasSuccessMessage()): ?>
            <div class="alert alert-success">
                <?= e(Session::getInstance()->getSuccessMessage()) ?>
            </div>
        <?php endif; ?>
        <?php if (Session::getInstance()->hasErrorMessage()): ?>
            <div class="alert alert-danger">
                <?= e(Session::getInstance()->getErrorMessage()) ?>
            </div>
        <?php endif; ?>

        <?= $this->content ?>
    </div>
<script>
    function onLogoutClicked(){
        event.preventDefault();
        document.getElementById('js--logout-form').submit();
    }
</script>
<script src="/assets/script.js"></script>
</body>