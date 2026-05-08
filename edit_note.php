<?php
session_start();
include 'config.php';

if(!isset($_SESSION['user_id'])){
header("Location: login.php");
exit();
}

$user_id=$_SESSION['user_id'];

$id=intval($_GET['id']);

$result=$conn->query(
"SELECT * FROM notes
WHERE id='$id'
AND user_id='$user_id'"
);

$note=$result->fetch_assoc();

if($_SERVER["REQUEST_METHOD"]=="POST"){

$title=$_POST['title'];
$content=$_POST['content'];

$conn->query(
"UPDATE notes
SET title='$title',
content='$content'
WHERE id='$id'
AND user_id='$user_id'"
);

header("Location: dashboard.php");
exit();
}

include 'includes/header.php';
include 'includes/nav.php';
?>

<h2>Edit Note</h2>

<form method="POST">

<input
name="title"
value="<?php echo $note['title'];?>"
required>

<textarea
name="content"
required><?php echo $note['content'];?>
</textarea>

<button type="submit">
Update Note
</button>

</form>

<?php include 'includes/footer.php'; ?>