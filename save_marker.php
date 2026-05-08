<?php
session_start();

include 'config.php';

if(!isset($_SESSION['user_id'])){
exit();
}

$user_id=$_SESSION['user_id'];

$x=$_POST['x'];
$y=$_POST['y'];

$title=$_POST['title'];
$note=$_POST['note'];

$map_id=$_POST['map_id'];

$sql="

INSERT INTO map_markers

(
user_id,
map_id,
marker_x,
marker_y,
marker_title,
marker_note
)

VALUES

(
'$user_id',
'$map_id',
'$x',
'$y',
'$title',
'$note'
)

";

$conn->query($sql);

echo "saved";
?>