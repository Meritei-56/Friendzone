<?php

include("classes/loadfiles.php");
	

	$login = new Login();
	$user_info = $login->verify_login($_SESSION['myfriendzone_userid']);

	if(isset($_SERVER['HTTP_REFERER'])){
		$return_to = $_SERVER['HTTP_REFERER'];
	}else{
		$return_to = "profile.php";
	}
		if(isset($_GET['type']) && isset($_GET['id'])){

			if(is_numeric($_GET['id']))
			{
				$accepted[] = 'post';
				$accepted[] = 'user';
				$accepted[] = 'comment';

				if(in_array($_GET['type'], $accepted)){
						$post = new Posts();
						$post->like_npost($_GET['id'],$_GET['type'],$_SESSION['myfriendzone_userid']);
				}
			}
				
		}
			
	



header("Location: ". $return_to);
die;