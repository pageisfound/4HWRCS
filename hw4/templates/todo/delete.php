<?php

$id = htmlspecialchars(strip_tags(trim($_GET['id'])));
if (empty($id)) {
    echo '<div class="alert alert-danger">No ID given!</div>';
} else {
    try {
        if ((new Todo())->delete((int)$id)) {
            echo '<div class="alert alert-success">Todo removed successfully!</div>';
        } else {
            echo '<div class="alert alert-danger">Todo removal failed!</div>';
        }
    } catch (Throwable $exception) {
        echo '<div class="alert alert-danger">Todo removal failed! '.$exception->getMessage().'</div>';
    }
}

?>

<a class="btn btn-secondary" href="/">Back</a>
