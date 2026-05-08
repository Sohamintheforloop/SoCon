<?php
session_start();
include 'config.php';

if(!isset($_SESSION['user_id'])){
header("Location: login.php");
exit();
}

$user_id=$_SESSION['user_id'];

if(!isset($_GET['id'])){
die("No note selected");
}

$note_id=intval($_GET['id']);

/* Delete only if owned by user */
$sql="DELETE FROM notes
WHERE id='$note_id'
AND user_id='$user_id'";

if($conn->query($sql)){
header("Location: dashboard.php");
exit();
}
else{
echo "Delete failed";
}
?>