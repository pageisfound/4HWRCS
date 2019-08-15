<?php

if ($_POST) {
    $name        = htmlspecialchars(strip_tags(trim($_POST['name'] ?? '')));
    $description = htmlspecialchars(strip_tags(trim($_POST['description'] ?? '')));

    if (empty($name)) {
        echo '<div class="alert alert-danger">Name is required!</div>';
    } else {
        try {
            if ((new Todo())->create($name, $description)) {
                echo '<div class="alert alert-success">New todo created successfully!</div>';
            } else {
                echo '<div class="alert alert-danger">Creating new todo failed!</div>';
            }
        } catch (Throwable $exception) {
            echo '<div class="alert alert-danger">Creating new todo failed! '.$exception->getMessage().'</div>';
        }
    }
}

?>

<form action="../../add.php" method="POST">
    <div class="form-group">
        <label for="todo-name">Name</label>
        <input id="todo-name" type="text" name="name" class="form-control" />
    </div>
    <div class="form-group">
        <label for="todo-description">Description</label>
        <textarea id="todo-description" name="description" class="form-control"></textarea>
    </div>
    <button type="submit" class="btn btn-success">Create</button>
    <a class="btn btn-secondary" href="/">Back</a>
</form>
