<?php
session_start();

include 'config.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id=$_SESSION['user_id'];

/* NOTES */

$result=$conn->query(
"SELECT * FROM notes
WHERE user_id='$user_id'
ORDER BY created_at DESC"
);

/* REMINDERS */

$activeReminders=[];

$reminderQuery=$conn->query(

"SELECT * FROM notes

WHERE user_id='$user_id'

AND reminder_datetime IS NOT NULL

AND reminder_datetime <= NOW()

AND reminder_completed=0"

);

while($reminder=$reminderQuery->fetch_assoc()){

$activeReminders[]=
$reminder['title'];

}

include 'includes/header.php';
include 'includes/nav.php';
?>

<h2>Your Notes</h2>

<?php while($row=$result->fetch_assoc()){ ?>

<div class="note

<?php

if(

$row['reminder_datetime']

&&

strtotime(
$row['reminder_datetime']
) < time()

&&

$row['reminder_completed']==0

){

echo ' overdue';

}

?>

">

<h3>
<?php echo htmlspecialchars(
$row['title']
); ?>
</h3>

<p>
<?php echo nl2br(
htmlspecialchars(
$row['content']
)
); ?>
</p>

<!-- REMINDER -->

<?php if($row['reminder_datetime']){ ?>

<div class="reminder-box">

⏳ Reminder:

<?php

echo date(

"d M Y - h:i A",

strtotime(
$row['reminder_datetime']
)

);

?>

</div>

<?php } ?>

<!-- IMAGE -->

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

<a
href="edit_note.php?id=<?php echo $row['id']; ?>">

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

<!-- MAP SECTION -->

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
<?php echo htmlspecialchars(
$map['map_name']
); ?>
</h3>

</div>

<?php } ?>

</div>

<!-- REMINDER POPUP -->

<script>

const reminders =

<?php
echo json_encode($activeReminders);
?>;

if(reminders.length > 0){

setTimeout(()=>{

alert(

"Reminder Due:\\n\\n" +

reminders.join("\\n")

);

},1000);

}

</script>

<?php include 'includes/footer.php'; ?>