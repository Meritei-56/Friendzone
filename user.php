<div id="friends">
<?php

	$image = ""; // Initialize image variable

	// Check if profile image exists and is a valid file
	if(!empty($FRIENDS_row['profile_image']) && file_exists($FRIENDS_row['profile_image'])) {
	    $image = $images_class->get_thumb_profiles($FRIENDS_row['profile_image']); // Use profile image
	} else {
	    // If profile image doesn't exist or is not valid, use gender-based default image
	    if($FRIENDS_row['gender'] == "Female") {
	        $image = "images/user_female.jpg"; // Female default image
	    } else {
	        $image = "images/user_male.jpg"; // Male default image
	    }
	}

?>

	<a href="profile.php?id=<?php echo $FRIENDS_row['userid']; ?>">

		<img id="friends_img" src="<?php echo $image ?>"> 
		<br>
		
		<?php echo $FRIENDS_row['first_name'] . " " . $FRIENDS_row['last_name'] ?>
	</a>
							
</div>