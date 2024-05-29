
<div style="min-height: 400px; width: 100%; background-color:#f5ffff; text-align: center;">
	<div style="padding: 20px;max-width: 500px; display: inline-block;">
		<form method="post" enctype="multipart/form-data">
			
							
					
			<?php

				$settings_entr = new Settings();

				$settings = $settings_entr->obtain_settings($_SESSION['myfriendzone_userid']);

				if(is_array($settings))
				{


					echo "About me:<br>
						<div id='entry_box' style='height: 200px; border: none;' >".htmlspecialchars($settings['about'])."</div> 

						";

					

				}

				
				


			?>
		</form>
	</div>

</div>