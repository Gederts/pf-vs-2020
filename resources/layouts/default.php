<?php

use Project\Components\View;
/**
 * @var View $this
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
        margin: 0;
        padding: 0;
        overflow: hidden;
        background-color: #333;
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
            <li><a style="text-decoration: none;" href="/">Quiz</a></li>
            <li><a style="text-decoration: none;" href="/login">Log in</a></li>
            <li><a style="text-decoration: none;"  href="/register">Register</a></li>

        </ul>
    </nav>
    <div class="container">
        <?= $this->content ?>
    </div>
</body>