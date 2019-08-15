<?php

session_start();

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']) {
    header('location: /');
    exit;
}

$username = null;

if ($_POST) {
    $user = new User();

    $username = htmlspecialchars(strip_tags(trim($_POST['username'] ?? '')));
    $password = htmlspecialchars(strip_tags(trim($_POST['password'] ?? '')));

    $isError = true;
    if (empty($username)) {
        echo '<div class="alert alert-danger">Username is required!</div>';
    } elseif (empty($password)) {
        echo '<div class="alert alert-danger">Password is required!</div>';
    } else {
        $isError = false;
    }

    if (!$isError) {
        try {
            if ($user->validate($username, $password)) {
                session_start();

                $_SESSION['loggedin'] = true;

                header('location: /');
            } else {
                echo '<div class="alert alert-danger">User authentication failed!</div>';
            }
        } catch (Throwable $exception) {
            echo '<div class="alert alert-danger">User authentication failed! '.$exception->getMessage().'</div>';
        }
    }
}

require_once 'templates/header.php';
?>

<h3>Login</h3>
<p>Please fill in your credentials to login.</p>
<form action="../../login.php" method="POST">
    <div class="form-group">
        <label for="user-name">Username</label>
        <input id="user-name" type="text" name="username" class="form-control" value="<?= $username; ?>">
    </div>
    <div class="form-group">
        <label for="user-pass">Password</label>
        <input id="user-pass" type="password" name="password" class="form-control">
    </div>
    <input type="submit" class="btn btn-primary mb-3" value="Login">
    <p>Don't have an account? <a href="../../signup.php">Sign up now</a>.</p>
</form>

<?php
require_once 'templates/footer.php';