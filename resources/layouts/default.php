<?php

use Project\Components\ActiveUser;
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
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
        <ul style="display: flex; justify-content: center; background-color: #333; margin: 0;">
            <li><a style="text-decoration: none;" href="/">Quiz</a></li>
            <?php if(!ActiveUser::isLoggedIn()): ?>
            <li><a style="text-decoration: none;" href="/login">Log in</a></li>
            <li><a style="text-decoration: none;"  href="/register">Register</a></li>
            <?php endif; ?>
            <?php if(ActiveUser::isLoggedIn()): ?>
            <li><a style="text-decoration: none;" href="/dashboard">Dashboard</a></li>
                <?php if (ActiveUser::getUser()->is_admin): ?>
                    <li class="nav-item">
                        <a style="text-decoration: none;" href="/admin">Admin</a>
                    </li>
                <?php endif; ?>
            <li><a style="text-decoration: none;" href="/logout" onclick="onLogoutClicked()">Logout</a></li>

            <form id="js--logout-form" action="/logout" method="post"></form>
            <?php endif; ?>
        </ul>
    </nav>
    <div class="container">
        <?= $this->content ?>
    </div>
<script>
    function onLogoutClicked(){
        event.preventDefault();
        document.getElementById('js--logout-form').submit();
    }
</script>
</body>