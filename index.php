<?php
session_start();
require_once('connection.php');
$query = "SELECT users.first_name, users.last_name, messages.id as 'msg_id', messages.created_at, messages.message FROM messages LEFT JOIN users ON messages.user_id = users.id";
$messages = fetch_all($query);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Welcome to the Wall</title>
</head>
<body>
<?php if(isset($_SESSION['errors'])) 
{
?>

<?= $_SESSION['errors'] ?>
<?php
$_SESSION['errors'] = "";
}
?>
<h3>Add a new message</h3>
<form action = "process.php" method = "post">
	<input type="hidden" name="action" value = "post_message">
	<input type="text" name="message">
	<input type="submit">
</form>
<h3>Messages</h3>
<?php
	foreach($messages as $message)
	{
?>
	<p><?=$message['message'] ?></p>
	<p>- <?=$message['first_name'] ?> <?=$message['last_name'] ?></p>
	<h3>Add a new comment: </h3>
	<form action = "process.php" method = "post">
		<input type="hidden" name="action" value = "post_comment">
		<input type="hidden" name="message_id" value = "<?=$message['msg_id'] ?>">
		<input type="text" name="comment">
		<input type="submit">
	</form>
	<?php
	$c_query = "SELECT users.first_name, users.last_name,  comments.created_at, comments.comment FROM comments LEFT JOIN users ON comments.user_id = users.id WHERE comments.message_id = '{$message['msg_id']}'";
	$comments = fetch_all($c_query);
	foreach ($comments as $comment)
	{
	?>
		<p><?=$comment['comment'] ?></p>
		<p>- <?=$message['first_name'] ?> <?=$message['last_name'] ?></p>
	<?php
	}
	?>

<?php
	}
?>
</body>
</html>