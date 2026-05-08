<?php
session_start();
include 'config.php';

if($_SERVER["REQUEST_METHOD"]=="POST"){

$username=$_POST['username'];
$password=$_POST['password'];

$result=$conn->query(
"SELECT * FROM users
WHERE username='$username'"
);

$user=$result->fetch_assoc();

if($user &&
password_verify(
$password,
$user['password']
)){
$_SESSION['user_id']=$user['id'];

header("Location: dashboard.php");
exit();
}

echo "Invalid Login";
}

include 'includes/header.php';
?>

<h2>Login</h2>

<form method="POST">

<input name="username"
placeholder="Username">

<input
type="password"
name="password"
placeholder="Password">

<button type="submit">
Login
</button>

</form>

<p>
No account?
<a href="register.php">
Register
</a>
</p>

<?php include 'includes/footer.php'; ?>