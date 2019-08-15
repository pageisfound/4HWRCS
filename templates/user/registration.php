<?php

$username = $password = $confirmPassword = null;

if ($_POST) {
    $user = new User();

    $username        = htmlspecialchars(strip_tags(trim($_POST['username'] ?? '')));
    $password        = htmlspecialchars(strip_tags(trim($_POST['password'] ?? '')));
    $confirmPassword = htmlspecialchars(strip_tags(trim($_POST['confirm_password'] ?? '')));

    $isError = true;
    if (empty($username)) {
        echo '<div class="alert alert-danger">Username is required!</div>';
    } elseif ($user->isUsernameTaken($username)) {
        echo '<div class="alert alert-danger">Username is taken!</div>';
    } elseif (empty($password)) {
        echo '<div class="alert alert-danger">Password is required!</div>';
    } elseif (strlen(trim($_POST['password'])) < 6) {
        echo '<div class="alert alert-danger">Password must have at least 6 characters!</div>';
    } elseif (empty($confirmPassword)) {
        echo '<div class="alert alert-danger">Confirm password!</div>';
    } elseif ($password !== $confirmPassword) {
        echo '<div class="alert alert-danger">Password mismatch!</div>';
    } else {
        $isError = false;
    }

    if (!$isError) {
        try {
            if ($user->create($username, $password)) {
                header('location: /login.php');
            } else {
                echo '<div class="alert alert-danger">User creation failed!</div>';
            }
        } catch (Throwable $exception) {
            echo '<div class="alert alert-danger">User creation failed! '.$exception->getMessage().'</div>';
        }
    }
}

require_once 'templates/header.php';
?>

<h3>Sign Up</h3>
<p>Please fill this form to create an account.</p>
<form action="../../signup.php" method="POST">
    <div class="form-group">
        <label for="user-name">Username</label>
        <input id="user-name" type="text" name="username" class="form-control" value="<?= $username ?>">
    </div>
    <div class="form-group">
        <label for="user-pass">Password</label>
        <input id="user-pass" type="password" name="password" class="form-control" value="<?= $password ?>">
    </div>
    <div class="form-group">
        <label for="user-cpass">Confirm Password</label>
        <input id="user-cpass" type="password" name="confirm_password" class="form-control" value="<?= $confirmPassword ?>">
    </div>
        <input type="submit" class="btn btn-primary mb-3" value="Register">
        <p>Already have an account? <a href="../../login.php">Login here</a>.</p>
</form>

<?php
require_once 'templates/footer.php';
