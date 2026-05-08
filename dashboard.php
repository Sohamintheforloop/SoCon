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
WHERE user_id=$user_id
ORDER BY created_at DESC"
);

include 'includes/header.php';
include 'includes/nav.php';
?>

<h2>Your Notes</h2>

<?php while($row=$result->fetch_assoc()){ ?>

<div class="note">

<h3>
<?php echo htmlspecialchars(
$row['title']
); ?>
</h3>

<p>
<?php echo nl2br(
htmlspecialchars($row['content'])
); ?>
</p>

<small>
Created:
<?php echo $row['created_at']; ?>
</small>

<div class="actions">

<a href="edit_note.php?id=<?php echo $row['id']; ?>">
Edit
</a>

<a href="delete_note.php?id=<?php echo $row['id']; ?>"
onclick="return confirm('Delete this note?');">
Delete
</a>

</div>

</div>

<?php } ?>
<?php

$uncategorized = $conn->query(

"SELECT * FROM notes

WHERE user_id='$user_id'

AND folder_id IS NULL

ORDER BY created_at DESC"

);

?>

<?php if($uncategorized->num_rows > 0){ ?>

<div class="note">

<h2>Uncategorized</h2>

<?php while($row=$uncategorized->fetch_assoc()){ ?>

<div class="note">

<h3>
<?php echo $row['title']; ?>
</h3>

<p>
<?php
echo nl2br(
htmlspecialchars(
$row['content']
)
);
?>
</p>

<?php if(!empty($row['image_path'])){ ?>

<img
src="uploads/<?php echo $row['image_path']; ?>"
class="note-image">

<?php } ?>

<small>
Created:
<?php echo $row['created_at']; ?>
</small>

<div class="actions">

<a href="edit_note.php?id=<?php echo $row['id']; ?>">
Edit
</a>

<a
href="delete_note.php?id=<?php echo $row['id']; ?>"
onclick="return confirm('Delete this note?');">

Delete

</a>

</div>

</div>

<?php } ?>

</div>

<?php } ?>
<h2>SoCon</h2>

<?php

$maps=$conn->query(
"SELECT * FROM game_maps
ORDER BY created_at DESC"
);

?>

<div class="gallery-grid">

<?php while($map=$maps->fetch_assoc()){ ?>

<div class="gallery-card">

<a
href="view_map.php?id=<?php echo $map['id']; ?>">

<img
src="uploads/<?php echo $map['map_image']; ?>"
class="gallery-image">

</a>

<h3>
<?php echo $map['map_name']; ?>
</h3>

</div>

<?php } ?>

</div>

<?php include 'includes/footer.php'; ?>