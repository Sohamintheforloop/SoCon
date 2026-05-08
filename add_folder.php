<?php
session_start();

include 'config.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

if($_SERVER["REQUEST_METHOD"]=="POST"){

    $folder_name = trim($_POST['folder_name']);

    $user_id = $_SESSION['user_id'];

    if(!empty($folder_name)){

        $sql = "
        INSERT INTO folders
        (
            user_id,
            folder_name
        )

        VALUES
        (
            '$user_id',
            '$folder_name'
        )
        ";

        $conn->query($sql);

        header("Location: dashboard.php");
        exit();
    }
}

include 'includes/header.php';
include 'includes/nav.php';
?>

<h2>Create Folder</h2>

<form method="POST">

<input
type="text"
name="folder_name"
placeholder="Folder Name"
required>

<button type="submit">
Create Folder
</button>

</form>

<?php include 'includes/footer.php'; ?>