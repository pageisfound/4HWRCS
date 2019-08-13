<?php

$id = htmlspecialchars(strip_tags(trim($_GET['id'] ?? '')));
if (empty($id)) {
    echo '<div class="alert alert-danger">No ID given!</div>';
    echo '<a class="btn btn-secondary" href="/">Back</a>';
    return;
}

$todo        = new Todo();
$currentTodo = $todo->readSingle($id);
if (!$currentTodo) {
    echo '<div class="alert alert-danger">No todo exists!</div>';
    echo '<a class="btn btn-secondary" href="/">Back</a>';
    return;
}

if ($_POST) {
    $name        = htmlspecialchars(strip_tags(trim($_GET['name'] ?? '')));
    $description = htmlspecialchars(strip_tags(trim($_GET['description'] ?? '')));

    if (empty($name)) {
        echo '<div class="alert alert-danger">Name is required!</div>';
    } else {
        try {
            if ($todo->update((int)$id, $name, $description)) {
                echo '<div class="alert alert-success">Todo updated successfully!</div>';
                $currentTodo = $todo->readSingle($id);
            } else {
                echo '<div class="alert alert-danger">Todo update failed!</div>';
            }
        } catch (Throwable $exception) {
            echo '<div class="alert alert-danger">Todo update failed! '.$exception->getMessage().'</div>';
        }
    }
}

?>

<form action="../../show.php?id=<?= $id ?>" method="POST">
    <div class="form-group">
        <label for="todo-name">Name</label>
        <input id="todo-name" type="text" name="name" class="form-control" value="<?= $currentTodo['name'] ?>" />
    </div>
    <div class="form-group">
        <label for="todo-description">Description</label>
        <textarea id="todo-description" name="description" class="form-control"><?= $currentTodo['description'] ?></textarea>
    </div>
    <div class="form-group">
        Created at: <?= $currentTodo['created_at'] ?>
    </div>
    <button type="submit" class="btn btn-success">Update</button>
    <a class="btn btn-secondary" href="/">Back</a>
</form>
