
<div style="min-height: 400px; width: 100%; background-color:#f5ffff; text-align: center;">
	<div style="padding: 20px;">
		<?php
			
			$DB = new Database();
			$sql_query = "SELECT image, post_id FROM posts_table WHERE has_image = 1 AND user_id = $user_info[userid] ORDER BY id DESC limit 30";
			$images = $DB->read_from_db($sql_query);

			$photos_class = new Images();

			if(is_array($images)){
				foreach($images as $row_image){
					echo "<img src='" . $photos_class->get_thumb_posts($row_image['image']) . "' style='width: 150px;' />";

				}
				

			}else{
				echo "No images found";
			}

		?>
	</div>

</div>