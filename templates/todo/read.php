<?php

session_start();

if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
    header('location: /login.php');
    exit;
}

$todo = new Todo();

if ($_POST && isset($_POST['date']) && $_POST['date']) {
    try {
        // sanitize posted values
        $date  = htmlspecialchars(strip_tags($_POST['date']));
        $todos = $todo->readByDate($date);
        if (empty($todos)) {
            echo '<div class="alert alert-danger">No todos found by ' . $date . '</div>';
        }
    } catch (Throwable $exception) {
        echo '<div class="alert alert-danger">Filter execution failed! ' . $exception->getMessage() . '</div>';
    }
} else {
    $todos = $todo->readAll();
}

?>
<div class="float-left">
    <form class="form-inline" action="../../index.php" method="POST">
        <div class="form-group">
            <label for="todo-date"></label>
            <input id="todo-date" type="date" name="date" class="form-control m-2" value="<?= $date ?>" />
        </div>
        <button type="submit" class="btn btn-primary">Filter</button>
    </form>
</div>
<a class="float-right" href="../../logout.php">Logout</a>

<table class="table">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Created at</th>
            <th scope="col"><a href="../../add.php" class="btn btn-primary btn-sm">Add</a></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($todos as $todo) { ?>
        <tr>
            <th scope="row"><?= $todo ['id']; ?></th>
            <td><?= $todo['name'] ?></td>
            <td><?= $todo['created_at'] ?></td>
            <td>
                <a href="../../show.php?id=<?= $todo['id'] ?>" class="btn btn-success btn-sm">Show</a>
                <a href="../../remove.php?id=<?= $todo['id'] ?>" class="btn btn-danger btn-sm">Remove</a>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>
