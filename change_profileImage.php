<?php

include("classes/loadfiles.php");



	$login = new Login();
	$user_info = $login->verify_login($_SESSION['myfriendzone_userid']);

	
	//profile photo uploading
	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		

		if(isset($_FILES['file']['name']) && $_FILES['file']['name'] != "")
		{
			
			
			if($_FILES['file']['type'] == "image/jpeg")
			{
				$accepted_size = (1024 * 1024) * 3;
				if($_FILES['file']['size'] < $accepted_size)
				{
					

					//all requirements have been met
					$user_folder = "image_uploads/" . $user_info['userid'] . "/";

					//create folder
					if(!file_exists($user_folder))
					{
						mkdir($user_folder,0777,true);
					}

					$image = new Images();	
					$filename = $user_folder . $image->generate_Imagefolders(15) . ".jpg";
					move_uploaded_file($_FILES['file']['tmp_name'], $filename);

					
					//check for change mode
					if(isset($_GET['change']))
					{
						$change = $_GET['change'];
					}
					if(file_exists($filename))
					{
						$userid = $user_info['userid'];

						

						//determine if cover is to be changed
						if($change == "cover")
						{
							$query = "update users set cover_image = '$filename' where userid = '$userid' limit 1";
							$_POST['is_cover_photo'] = 1;

						}else
						{
							$query = "update users set profile_image = '$filename' where userid = '$userid' limit 1";
							$_POST['is_profile_photo'] = 1;
						}
						
						$DB = new Database();
						$DB->save_to_db($query);

						//create posts
						$post = new Posts();
						$post->create_posts($userid, $_POST, $filename);


						header(("Location: profile.php"));
						die;

					}


									

					if($change == "cover")
					{
						//to delete files if they exist
						if(file_exists($user_info['cover_image']))
						{
							unlink($user_info['cover_image']);
						}
						$image->resize_images($filename,$filename,1500,1500);
					}else
					{
						if(file_exists($user_info['profile_image']))
						{
							unlink($user_info['profile_image']);
						}
						$image->resize_images($filename,$filename,1500,1500);
					}

					


				}else
				{

					echo "<div style='text-align: center; font-size:12px; color: white; background-color: grey;'>";

					echo "The following error was detected:<br><br>";
					echo "Only images of size 3Mb or lower can be uploaded";
					echo "</div>";

				}

			}else
			{
				echo "<div style='text-align: center; font-size:12px; color: white; background-color: grey;'>";

				echo "Errors detected:<br><br>";
				echo "Only jpeg image type accepted";
				echo "</div>";
		
			}

			
		}else
		{
			echo "<div style='text-align: center; font-size:12px; color: white; background-color: grey;'>";

			echo "Errors detected:<br><br>";
			echo "image invalid, please try again";
			echo "</div>";
		}
		
	}


	

?>


<!DOCTYPE html>
<html>
	<head>
	

	<meta charset="utf-8">

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

	<title>Change Profile Image | Friendzone</title>

		
		
	</head>
	<style type="text/css">
		#bar_bl{
			height: 50px;
			background-color: #405d9b;
			color: #d9dfeb;

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
		
		
		
		#posts_butn{
			float: right;
			background-color: #405d9b;
			border:none;
			color: white;
			padding: 4px;
			font-size: 14px;
			border-radius: 2px;
			//width: 100px;
			

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
		<!-- top bar -->
		<div id="bar_bl">
			<div style="width: 800px; margin: auto; font-size: 30px;">
				Friendzone &nbsp &nbsp <input type="text" id="search_tab" placeholder="Search Friendzone">
				<a href="profile.php">
				<?php

						
					$image = "images/user_male.jpg";
					if($user_info['gender'] == "Female")
					{
						$image = "images/user_female.jpg";

					}
					if(isset($user_info))
				 	{
				 		$image = $user_info['profile_image'];
				 	}

				?>
				<img src="<?php echo $image ?>"style="width: 35px; float: right; border-radius: 50%; border: solid 2px white;">	
				</a>
				<a href="logout.php">
				<span style="font-size: 11px; float: right; margin: 10px; color: white;">Sign out</span></a>
			</div>
			
			
		</div>
		<!-- cover area -->
		<div style="width: 800px; margin: auto; min-height: 400px;">

		<!-- area below cover -->
			<div style="display: flex;">

				
				
				<!-- posts section -->
				<div style="min-height: 400px; flex: 2.5; padding: 20px; padding-right: 0px;">
					<form method="post" enctype="multipart/form-data">
						<div style="border:solid thin #aaa; padding: 10px; background-color: white;">
							<input type="file" name="file">
							<input id="posts_butn" type="submit" value="Update">
							<br>
							<div style="text-align: center;">
								<br><br>
								<?php

									//check for change mode
									if(isset($_GET['change']) && $_GET['change'] == "cover")
									{
										$change = "cover";
										echo "<img src='$user_info[cover_image]' style='max-width:500px;' >";
									}else
									{
										echo "<img src='$user_info[profile_image]' style='max-width:500px;' >";
									}

									echo ""

								?>
							</div>
							
						</div>
					</form>
					<!--posts-->
					

				</div>
			</div>
		</div>

	</body>
</html>