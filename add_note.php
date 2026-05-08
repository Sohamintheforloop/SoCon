<?php
session_start();

include 'config.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

/* FETCH FOLDERS */

$folders = $conn->query(
"SELECT * FROM folders
WHERE user_id='$user_id'"
);

/* FORM SUBMIT */

if($_SERVER["REQUEST_METHOD"]=="POST"){

    $title = $_POST['title'];

    $content = $_POST['content'];

    $folder_id = $_POST['folder_id'];

    $image_name = "";

    /* IMAGE UPLOAD */

    if(
        isset($_FILES['note_image'])
        &&
        $_FILES['note_image']['error']==0
    ){

        $image_name =
        time().
        basename(
            $_FILES['note_image']['name']
        );

        $tmp =
        $_FILES['note_image']['tmp_name'];

        move_uploaded_file(
            $tmp,
            "uploads/".$image_name
        );
    }

    /* INSERT NOTE */

    $sql = "
    INSERT INTO notes
    (
        user_id,
        folder_id,
        title,
        content,
        image_path
    )

    VALUES
    (
        '$user_id',
        '$folder_id',
        '$title',
        '$content',
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

<h2>New Note</h2>

<form
method="POST"
enctype="multipart/form-data">

<input
type="text"
name="title"
placeholder="Title"
required>

<textarea
name="content"
placeholder="Write your note..."
required>
</textarea>

<div class="select-wrapper">

<select name="folder_id">

<option value="">
No Folder
</option>

<?php while($folder=$folders->fetch_assoc()){ ?>

<option
value="<?php echo $folder['id']; ?>">

📁
<?php echo $folder['folder_name']; ?>

</option>

<?php } ?>

</select>

</div>

<br><br>

<label>
Upload Image
</label>

<input
type="file"
name="note_image"
accept="image/*">

<br><br>

<button type="submit">
Save Note
</button>

</form>

<?php include 'includes/footer.php'; ?>