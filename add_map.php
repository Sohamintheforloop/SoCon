<?php
session_start();

include 'config.php';

if(!isset($_SESSION['user_id'])){
header("Location: login.php");
exit();
}

$user_id=$_SESSION['user_id'];

if($_SERVER["REQUEST_METHOD"]=="POST"){

$map_name=$_POST['map_name'];

$image_name="";

if(
isset($_FILES['map_image'])
&&
$_FILES['map_image']['error']==0
){

$image_name=
time().
basename(
$_FILES['map_image']['name']
);

$tmp=
$_FILES['map_image']['tmp_name'];

move_uploaded_file(
$tmp,
"uploads/".$image_name
);

}

$sql="

INSERT INTO game_maps

(
user_id,
map_name,
map_image
)

VALUES

(
'$user_id',
'$map_name',
'$image_name'
)

";

$conn->query($sql);

header("Location: dashboard.php");
exit();
}

include 'includes/header.php';
include 'includes/nav.php';
?>

<h2>Add Tactical Map</h2>

<form
method="POST"
enctype="multipart/form-data">

<input
type="text"
name="map_name"
placeholder="Map Name"
required>

<input
type="file"
name="map_image"
accept="image/*"
required>

<button type="submit">
Upload Map
</button>

</form>

<?php include 'includes/footer.php'; ?>