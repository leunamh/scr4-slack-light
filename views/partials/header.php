<?php
/**
 * Created by PhpStorm.
 * User: hinterreiter
 * Date: 20.05.2018
 * Time: 08:44
 */

use Slack\Util;
use Slack\AuthenticationManager;
use Slack\Controller;

$user = AuthenticationManager::getAuthenticatedUser(); ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">

    <title>Slack Light</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet">
    <link href="assets/main.css" rel="stylesheet">

</head>
<body>


<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/slack-light">Slack Light</a>
        </div>


        <div class="navbar-collapse collapse" id="bs-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li <?php
                if (!isset($_GET['view'])) print ' class="active"';
                ?>><a href="index.php">Home</a></li>
                <li <?php
                if (isset($_GET['view']) && $_GET['view'] == 'channels') print ' class="active"';
                ?>><a href="index.php?view=channels">Channels</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right login">
                <li class="dropdown">
                    <?php if ($user == null): ?>
                        <a href="index.php?view=login" class="dropdown-toggle" data-toggle="dropdown" role="button"
                           aria-expanded="true">
                            Not logged in!
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a href="index.php?view=login">Login now</a>
                            </li>
                            <li>
                                <a href="index.php?view=new-user">New user</a>
                            </li>
                        </ul>
                    <?php else: ?>
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            Logged in as <span class="badge"><?php echo Util::escape($user->getUserName()); ?></span>
                            <b class="caret"></b>
                        </a>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li class="centered">
                                <form method="post"
                                      action="<?php echo Util::action(Slack\Controller::ACTION_LOGOUT); ?>">
                                    <input class="btn btn-xs" role="button" type="submit" value="Logout"/>
                                </form>
                            </li>
                        </ul>
                    <?php endif; ?>

                </li>
            </ul> <!-- /. login -->
        </div><!--/.nav-collapse -->
    </div>
</div>
<!-- Success Messages -->
<div class="container">
    <?php
    $type = $_SESSION[Controller::USER_LOGIN_FEEDBACK] ?? null;
    switch ($type) {
        case Controller::USER_LOGIN_SUCCESS:
            ?>
            <div class="alert alert-success">
                <strong>User successfully created!</strong> Please login to continue.
            </div>
            <?php
            break;
    }
    ?>

    <!-- Error Messages -->

    <?php switch ($type) {
        case Controller::USER_ALREADY_EXISTS:
            ?>
            <div class="alert alert-danger">
                <strong>User already exists!</strong> Please try again.
            </div>
            <?php
            break;
        case Controller::USER_INVALID_CREDENTIALS:
            ?>
            <div class="alert alert-danger">
                <strong>Invalid credentials</strong> Please try again.
            </div>
            <?php
            break;
    }
    ?>


    <?php unset($_SESSION[Controller::USER_LOGIN_FEEDBACK]); ?>
</div>

<div class="container">

