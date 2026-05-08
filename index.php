<?php
session_start();

if(isset($_SESSION['user_id'])){
header("Location: dashboard.php");
exit();
}

include 'includes/header.php';
?>

<div style="padding-top:40px;">

<h1 style="font-size:52px;margin-bottom:20px;">
Smart Notes Manager
</h1>

<p style="font-size:22px;max-width:700px;">
A minimalist notes management system built using
Linux Apache MySQL PHP (LAMP Stack).
Create, edit, organize and manage personal notes.
</p>

<br><br>

<div class="actions">
<a href="login.php">Login</a>
<a href="register.php">Register</a>
</div>

<hr style="margin:50px 0;">

<h2>Features Implemented</h2>

<div class="note">

<h3>Completed Modules</h3>

<ul style="padding-left:30px;font-size:20px;line-height:2;">
<li>User Registration</li>
<li>User Login Authentication</li>
<li>Session Management</li>
<li>Create Notes</li>
<li>View Notes Dashboard</li>
<li>Edit Notes</li>
<li>Delete Notes</li>
<li>Responsive UI</li>
<li>MySQL Database Integration</li>
</ul>

</div>


<div class="note">

<h3>Technology Stack</h3>

<p>
Frontend:
HTML, CSS
</p>

<p>
Backend:
PHP
</p>

<p>
Server:
Apache
</p>

<p>
Database:
MySQL
</p>

<p>
Deployment:
XAMPP
</p>

</div>


<div class="note">

<h3>Project Workflow</h3>

<p>

Register User
<br>

↓
<br>

Login
<br>

↓
<br>

Add Notes
<br>

↓
<br>

Edit / Delete Notes
<br>

↓
<br>

Persistent Storage in Database

</p>

</div>


<div class="note">

<h3>Project Objective</h3>

<p>
Provide a simple, efficient and secure note
management platform for storing and managing
personal notes using the LAMP stack.
</p>

</div>

</div>

<?php include 'includes/footer.php'; ?>