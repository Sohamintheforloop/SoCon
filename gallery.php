<?php
session_start();

include 'config.php';

if(!isset($_SESSION['user_id'])){
header("Location: login.php");
exit();
}

$user_id=$_SESSION['user_id'];

$result=$conn->query(

"SELECT * FROM notes

WHERE user_id='$user_id'
AND image_path != ''

ORDER BY created_at DESC"

);

include 'includes/header.php';
include 'includes/nav.php';
?>

<h2>Image Gallery</h2>

<div class="gallery-grid">

<?php while($row=$result->fetch_assoc()){ ?>

<div class="gallery-card">

<a
href="uploads/<?php echo $row['image_path']; ?>"
target="_blank">

<img
src="uploads/<?php echo $row['image_path']; ?>"
class="gallery-image">

</a>

<h3>
<?php echo $row['title']; ?>
</h3>

<p>
<?php
echo substr(
$row['content'],
0,
120
);
?>
...
</p>

</div>

<?php } ?>

</div>

<?php include 'includes/footer.php'; ?>