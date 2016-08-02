<?php
session_start();
if(isset($_SESSION['errors']))
{
?>

<!DOCTYPE html>
<html>
<head>
	<title>Login or Register</title>
</head>
<body>
<?= $_SESSION['errors'] ?>

<?php
$_SESSION['errors']= "";
}
?>
<h3>Register</h3>
<form action = "process.php" method = "post">
	<input type="hidden" name="action" value = "register">
	First Name: <input type="text" name="first_name">
	Last Name: <input type="text" name="last_name">
	Email: <input type="text" name="email">
	Password: <input type="text" name="password">
	Confirm Password: <input type="text" name="password_confirm">
	<input type="submit">
</form>
<h3>Login</h3>
<form action = "process.php" method = "post">
	<input type="hidden" name="action" value = "login">
	Email: <input type="text" name="email">
	Password: <input type="text" name="password">
	<input type="submit">
</form>
</body>
</html>