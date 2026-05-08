<?php
include 'config.php';

if($_SERVER["REQUEST_METHOD"]=="POST"){

$username=$_POST['username'];

$password=password_hash(
$_POST['password'],
PASSWORD_DEFAULT
);

$conn->query(
"INSERT INTO users
(username,password)
VALUES
('$username','$password')"
);

header("Location: login.php");
exit();
}

include 'includes/header.php';
?>

<h2>Register</h2>

<form method="POST">

<input
name="username"
placeholder="Username">

<input
type="password"
name="password"
placeholder="Password">

<button type="submit">
Register
</button>

</form>

<?php include 'includes/footer.php'; ?>