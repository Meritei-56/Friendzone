<?php

    include("classes/loadfiles.php");



    $login = new Login();
    $user_info = $login->verify_login($_SESSION['myfriendzone_userid']);

    $Account_owner = $user_info;

    $images_class = new Images();

    

    //codes to upload friends/other users profiles
    if(isset($_GET['id']) && is_numeric($_GET['id']))
    {
        $user_profile = new Profile();
        $profile_info = $user_profile->get_profiles($_GET['id']);

        if(is_array($profile_info))
        {
            $user_info = $profile_info[0];
        }
    }


    	//to submit posts
	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		
		if(isset($_POST['first_name'])){

			$settings_entry = new Settings();
			$settings_entry->save_new_details($_POST,$_SESSION['myfriendzone_userid']);


		}else
		{
			$post = new Posts();
			$id = $_SESSION['myfriendzone_userid'];
			$result = $post->create_posts($id, $_POST, $_FILES);

			if($result == "")
			{
				header("Location: index.php");
				exit;
			}else
			{
				echo "<div style='text-align: center; font-size:12px; color: white; background-color: grey;'>";

				echo "Errors detected:<br><br>";
				echo $result;
				echo "</div>";
			}
		}
		
	}


?>


<!DOCTYPE html>
<html>
<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
		<script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
		
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

		
		<title>Timeline | Friendzone</title>
	</head>

	<style type="text/css">
		/* Responsive CSS for mobile devices */
		@media only screen and (max-width: 600px) {
			#bar_bl {
				height: 40px; /* Adjust height for smaller screens */
				font-size: 14px; /* Decrease font size */
			}
			
			.post_container {
				padding: 8px; /* Adjust padding */
				margin-bottom: 15px; /* Reduce margin */
			}
		}
		#bar_bl{
			height: 50px;
			background-color: #405d9b;
			color: #d9dfeb;

		}
		.post_container {
	        border: 1px solid #ccc;
	        padding: 10px;
	        margin-bottom: 20px;
	        background-color: rgb(240,240,240);   
	    }
		#search_tab{
			width: 400px;
			height: 25px;
			border-radius: 5px;
			border: none;
			padding: 4px;
			font-size: 14px;
			background-image: url(search.png);
			background-size: auto 100%;
			background-repeat: no-repeat;
			background-position: right center;
		}
		#prof_pic{
			width: 40px;
			border-radius: 50%;
			border: solid 2px white;

		}
		#menu_bton{
			width:100px; 
			display: inline-block;
			margin: 2px;
		}
		#friends_img{
			width: 75px;
			float: left;
			margin: 8px;
		}
		#friends_sec{
			min-height: 400px;
			margin-top: 20px;
			padding: 8px;
			text-align: center;
			font-size: 20px;
			color: #405d9b;

		}
		#friends{
			clear: both;
			font-size: 12px;
			font-weight: bold;
			color: #405d9b;
		}
		textarea{
			width: 100%;
			border: none;
			font-family: tahoma;
			font-size: 14px;
			height: 60px;

		}
		#posts_butn{
			float: right;
			background-color: #405d9b;
			border:none;
			color: white;
			padding: 4px;
			font-size: 14px;
			border-radius: 2px;
			width: 50px;

		}
		#posts_sec{
			margin-top: 20px;
			background-color: white;
			padding: 10px;
		}
		#posts{
			padding: 4px;
			font-size: 13px;
			display: flex;
			margin-bottom: 20px;
		}

	</style>
	<body style="font-family: tahoma; background-color: #ffe6e6;">
		<br>
		<?php

						
			$image = "images/user_male.jpg";
			if($user_info['gender'] == "Female")
			{
				$image = "images/user_female.jpg";

			}
			if(file_exists($user_info['profile_image']))
			{
				$image = $images_class->get_thumb_profiles($user_info['profile_image']);
			}

		?>
		<!-- top bar -->
		<?php include("header.php"); ?>     

		<!-- cover area -->
		<div style="width: 800px; margin: auto; min-height: 400px;">

		<!-- area below cover -->
			<div style="display: flex;">

				<!-- friends section -->
				<div style=" min-height: 400px; flex: 1; ">
					<div id="friends_sec">
						<img src="<?php echo $image ?>" id="prof_pic"><br>
						<a href="profile.php" style="text-decoration: none; color: #405d9b;" ><?php echo $user_info['first_name'] . " " . $user_info['last_name']; ?></a>


					</div>
				</div>
				
				<!-- posts section -->
				<div style="min-height: 400px; flex: 2.5; padding: 20px; padding-right: 0px;">
					<div style="border:solid thin #aaa; padding: 10px; background-color: white;">
						<form method="post" enctype="multipart/form-data">
							<textarea name="post" placeholder="Say hi!"></textarea>
							<input type="file" name="file">
							<input id="posts_butn" type="submit" value="Post">
							<br>
						</form>
					</div>
					<!--posts-->
					<div id="posts_sec">
						<?php
						$DB = new Database();
						$users = new User();
						$images_class = new Images();
						$friends = $users->retrieve_friends($_SESSION['myfriendzone_userid'], "user");
						$friends_ids = false;
						if(is_array($friends)){
							$friends_ids = array_column($friends, "userid");
							$friends_ids = implode("','", $friends_ids);
						}
						if($friends_ids){
							$my_userid = $_SESSION['myfriendzone_userid'];
							$query = "SELECT * FROM posts_table WHERE (user_id = '$my_userid' OR user_id IN('" .$friends_ids. "')) AND parent = 0 ORDER BY id DESC LIMIT 30";
							$posts = $DB->read_from_db($query);


						}
						
					    if($posts) {
					        foreach($posts as $ROW) {
					            $user = new User();
					            $ROW_user = $user->identify_user($ROW['user_id']);
					            // Start a new div for each post
					            echo '<div class="post_container">';
					            include("post.php");
					            // Close the div for this post
					            echo '</div>';
					        }
					    }
					    ?>
						
					</div>

				</div>
			</div>
		</div>

	</body>
</html>