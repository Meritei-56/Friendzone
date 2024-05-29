 <!-- top bar -->
 <?php
 	
 	$tag_image = "images/user_male.jpg";
 	if($user_info['gender'] == "Female")
	{
		$tag_image = "images/user_female.jpg";

	}
 	if(isset($Account_Owner) && file_exists($Account_Owner['profile_image']))
 	{
 		$image_class = new Images();
 		$tag_image = $image_class->get_thumb_profiles($Account_Owner['profile_image']);
 	}
 ?>
<div id="bar_bl">
	<form method="get" action="search.php">
		<div style="width: 800px; margin: auto; font-size: 30px;">
		<a href="index.php" style="color: white; text-decoration: none;">
		Friendzone</a>
		

				 &nbsp &nbsp <input type="text" id="search_tab" name="search" placeholder="Search Friendzone">
		
		<a href="profile.php">
		<img src="<?php echo $tag_image ?>" style="width: 35px; float: right; border-radius: 50%; border: solid 2px white;">
		</a>	
		<a href="logout.php">
		<span style="font-size: 11px; float: right; margin: 10px; color: white;">Sign out</span></a>
		</div>
	</form>
			
			
</div>