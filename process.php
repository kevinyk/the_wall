<?php 
session_start();
require_once('connection.php');
if(isset($_POST['action']) && $_POST['action'] == "register")
{
	if(isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email']) && isset($_POST['password']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
	{		
		if(isset($_POST['password']) == $_POST['password_confirm'])
		{
			$query = "INSERT INTO users (first_name, last_name, email, password, created_at, updated_at) VALUES ('{$_POST['first_name']}', '{$_POST['last_name']}', '{$_POST['email']}','{$_POST['password']}', NOW(), NOW())";
			run_mysql_query($query);
			header("Location: login.php");
		}
		else
		{
			$_SESSION['login_errors'] = "Incorrect registration data, try again.";
			header("Location: login.php");
		}
	}
	else{
		$_SESSION['login_errors'] = "Incorrect registration data, try again.";
			header("Location: login.php");
	}
}
elseif (isset($_POST['action']) && $_POST['action'] == "login")
{
	if(isset($_POST['email']) && isset($_POST['password']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
	{
		$query = "SELECT * FROM users WHERE email = '{$_POST['email']}' && password = '{$_POST['password']}'";
		$_SESSION['current_user']= fetch_record($query);
		if(isset($_SESSION['current_user']) && $_SESSION['current_user']['password'] == $_POST['password'])
		{
			header("Location: index.php");
		}
		else
		{
			$_SESSION['login_errors'] = "Incorrect login data, try again";
			header("Location: login.php");
		}
	}
	else
	{
		$_SESSION['login_errors'] = "Incorrect login data, try again";
			header("Location: login.php");
	}
}
elseif (isset($_POST['action']) && $_POST['action'] == "post_message")
{
	if(strlen($_POST['message'])!=0)
	{
		$query = "INSERT INTO messages (message, user_id, created_at, updated_at) VALUES ('{$_POST['message']}', '{$_SESSION['current_user']['id']}', NOW(), NOW())";
		run_mysql_query($query);
		header("Location: index.php");
	}
	else
	{
		$_SESSION['errors'] = "Cannot add blank message";
		header("Location: index.php");
	}
}
elseif (isset($_POST['action']) && $_POST['action'] == "post_comment")
{
	if(strlen($_POST['comment'])!=0)
	{
		$query = "INSERT INTO comments (comment, user_id, message_id, created_at, updated_at) VALUES ('{$_POST['comment']}', '{$_SESSION['current_user']['id']}', '{$_POST['message_id']}', NOW(), NOW())";
		run_mysql_query($query);
		header("Location: index.php");
	}
	else
	{
		$_SESSION['errors'] = "Cannot add blank comment";
		header("Location: index.php");
	}
}

?>