<?php

session_start();

if(isset($_SESSION['myfriendzone_userid']))
{
	$_SESSION['myfriendzone_userid'] == NULL;
	unset($_SESSION['myfriendzone_userid']);
}


header("Location: login.php");
die;