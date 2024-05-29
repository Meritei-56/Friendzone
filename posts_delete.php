

	
	<div id="posts">
		<div>
		<?php

			$images_class = new Images();

			$image ="images/user_male.jpg";
			if($ROW_user['gender'] == "Female")
			{
				$image = "images/user_female.jpg";
			}
			if(file_exists($user_info['profile_image']))
			{
				$image = $images_class->get_thumb_profiles($user_info['profile_image']);
			}

		?>
		<img src="<?php echo $image ?>" style="width: 75px; margin: 4px; border-radius: 50%; border: solid 2px white;">
		</div>
		<div style="width: 100%;">


			<div style="font-weight: bold; color: #405d9b">
				<?php
			 		echo $ROW_user['first_name'] . " " . $ROW_user['last_name']; 

			 		if($ROW['is_profile_photo'])
			 		{
			 			$pronoun = "his";
			 			if($ROW_user['gender'] == "Female")
			 			{
			 				$pronoun = "her";
			 			}
			 			echo "<span style='font-weight: normal; color: #aaa;'> updated $pronoun profile photo</span>";
			 		}

			 		if($ROW['is_cover_photo'])
			 		{
			 			$pronoun = "his";
			 			if($ROW_user['gender'] == "Female")
			 			{
			 				$pronoun = "her";
			 			}
			 			echo "<span style='font-weight: normal; color: #aaa;'> updated $pronoun cover photo</span>";
			 		}

			 	?>

			 		
				
			</div>
			<!--for html scripting -->
			<?php echo htmlentities($ROW['post']) ?> 
			<br><br>
			<?php

				if(file_exists($ROW['image']))
				{
					$post_photo = $images_class->get_thumb_posts($ROW['image']);
					echo "<img src='$post_photo'; style='width: 50%;'/>";
				}

				
			?>

		<br/><br/>
		
		</div>
							
	</div>