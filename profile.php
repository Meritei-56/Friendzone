
<?php
	

	include("classes/loadfiles.php");
	


	$login = new Login();
	$user_info = $login->verify_login($_SESSION['myfriendzone_userid']);

	$Account_Owner = $user_info;
	

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
				header("Location: profile.php");
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

	//retrieve previous posts
	$post = new Posts();
	$id = $user_info['userid'];

	$posts = $post->retrieve_posts($id);

	//retrieve friends
	$user = new User();
	
	$friends = $user->retrieve_friends($id);

	$images_class = new Images();



?>


<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
		<script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
		
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

		
		<title>Profile | Friendzone</title>
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
		#entry_box{
			width: 100%;
			height: 20px;
			border-radius: 5px;
			border: none;
			padding: 4px;
			font-size: 14px;
			border: solid thin grey;
			margin: 10px;
			
		}
		#prof_pic{
			width: 40px;
			margin-top: -200px;
			border-radius: 50%;
			border: solid 2px white;

		}
		
		.nav-link {
		      color: #fff; /* Text color */
		    }
		.nav-link:hover {
		    color: #000; /* Text color on hover */
		}
		.nav-item.active .nav-link {
		    background-color: #007bff; /* Background color */
		}
		.nav-item {
        	padding: 10px; /* Adjust the padding as needed */
    	}
    	

		#friends_img{
			width: 75px;
			float: left;
			margin: 8px;
            border-radius: 50%;
            border: solid 2px white;
            background-color: white;
		}
		#friends_sec{
			background-color: #ffe6e6;
			min-height: 400px;
			margin-top: 20px;
			color: #aaa;
			padding: 8px;

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
		/* CSS */
		#profileContainer {
		    position: relative;
		    display: inline-block; /* Ensures the message appears next to the image */
		}

		#changeMessage {
		    position: absolute;
		    bottom: 0;
		    left: 50%;
		    transform: translateX(-50%);
		    background-color: rgba(0, 0, 0, 0.5);
		    color: #fff;
		    padding: 5px 10px;
		    border-radius: 5px;
		    visibility: hidden; /* Initially hidden */
		}

		#profileContainer:hover #changeMessage {
		    visibility: visible; /* Show message on hover */
		}
		/* CSS */
		#coverContainer {
		    position: relative;
		    display: inline-block;
		}

		#coverChangeMessage {
		    position: absolute;
		    bottom: 0;
		    left: 50%;
		    transform: translateX(-50%);
		    background-color: rgba(0, 0, 0, 0.5);
		    color: #fff;
		    padding: 5px 10px;
		    border-radius: 5px;
		    visibility: hidden;
		}

		#coverContainer:hover #coverChangeMessage {
		    visibility: visible;
		}



	</style>
	<body style="font-family: tahoma; background-color: #ffe6e6;">
		<br>
		<!-- top bar -->
		<?php include("header.php"); ?>
		<!-- cover area -->
		<div style="width: 800px; margin: auto; min-height: 400px;">
			<div style="background-color: white; text-align: center; color: #405d9b;">
				
					<?php

						$cover_image = "images/cover_image.jpg";
						if(file_exists($user_info['cover_image']))
						{
							$cover_image = $images_class->get_thumb_covers($user_info['cover_image']);
						}
					?>

					<img src="<?php echo $cover_image ?>" style="width: 100%; height: 50%;" >
				

				<span style="font-size: 12px;">
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
					<!-- HTML -->
					<div id="profileContainer">
					    <img src="<?php echo $image ?>" id="prof_pic" alt="Profile Picture">
					    <div id="changeMessage">Change Profile Photo</div>
					</div>
					<a style="text-decoration: none;" href="change_profileImage.php?change=cover"> Update Cover</a>

					<!-- JavaScript -->
					<script>
					    document.getElementById("prof_pic").addEventListener("click", function() {
					        window.location.href = "change_profileImage.php?change=profile";
					    });
					</script>

				</span>
				<br>
				
				<div style="font-size: 20px">
					<a href="profile.php?id=<?php echo $user_info['userid'] ?>" style="text-decoration: none;">
						<?php echo $user_info['first_name'] . " " . $user_info['last_name']  ?>
					</a>
						
				</div>
				
				
				<nav class="navbar navbar-expand-lg navbar-light bg-light" style="background-color: #F0F0F0 !important;">
				    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				        <span class="navbar-toggler-icon"></span>
				    </button>
				    <div class="collapse navbar-collapse" id="navbarSupportedContent">
				        <ul class="navbar-nav mr-auto justify-content-between w-100">
				            <li class="nav-item active">
				                <a class="nav-link active" href="index.php" data-toggle="tooltip" data-placement="bottom" title="Timeline"><i class="far fa-clock"></i></a>
				            </li>
				            <li class="nav-item">
				                <a class="nav-link active" href="profile.php?session=About&id=<?php echo $user_info['userid'] ?>" data-toggle="tooltip" data-placement="bottom" title="About"><i class="fas fa-info-circle"></i></a>
				            </li>
				            <li class="nav-item ">
				                <a class="nav-link active" href="#" data-toggle="tooltip" data-placement="bottom" title="Followers"><i class="fas fa-users"></i></a>
				            </li>
				            <li class="nav-item">
				                <a class="nav-link active" href="profile.php?session=photos&id=<?php echo $user_info['userid'] ?>" data-toggle="tooltip" data-placement="bottom" title="Photos"><i class="fas fa-camera"></i></a>
				            </li>
				            <li class="nav-item">
				                <?php
				                if($user_info['userid'] == $_SESSION['myfriendzone_userid']){
				                    echo '<a class="nav-link active" href="profile.php?session=settings&id='. $user_info['userid'] .'" data-toggle="tooltip" data-placement="bottom" title="Settings"><i class="fas fa-cog"></i></a>';
				                }
				                ?>
				            </li>
				        
				            <!-- Message Button -->
				            <li class="nav-item">
				                <a class="nav-link active" href="#" data-toggle="tooltip" data-placement="bottom" title="Messages"><i class="far fa-envelope"></i></a>
				            </li>
				        </ul>
				    </div>
				</nav>

				<!-- Include necessary JavaScript and CSS for Bootstrap Tooltip -->
				<script>
				    $(document).ready(function(){
				        $('[data-toggle="tooltip"]').tooltip();
				    });
				</script>

		</div>
		<!-- area below cover -->
		<?php
			$session = "default";
			if(isset($_GET['session']))
			{
				$session = $_GET['session'];
			}
			if($session == "default"){
				include("default_profile.php");

			}elseif($session == "photos"){
				include("profile_photos.php");

			}elseif($session == "About"){
				include("profile_about.php");

			}elseif($session == "settings"){
				include("profile_settings.php");

			}

		?>

		</div>

	</body>
</html>

