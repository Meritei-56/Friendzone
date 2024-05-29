
<div style="min-height: 400px; width: 100%; background-color:#f5ffff; text-align: center;">
	<div style="padding: 20px;max-width: 500px; display: inline-block;">
		<form method="post" enctype="multipart/form-data">
			
							
					
			<?php

				$settings_entr = new Settings();

				$settings = $settings_entr->obtain_settings($_SESSION['myfriendzone_userid']);

				if(is_array($settings))
				{
					echo "<input type='text' id='entry_box' name='first_name' value='".htmlspecialchars($settings['first_name'])."'placeholder='First name'/>";
					echo "<input type='text' id='entry_box' name='last_name' value='".htmlspecialchars($settings['last_name'])."'placeholder='Last name'/>";

					echo "<select  id='entry_box' name='gender' style='height:30px;'> 

						<option>".htmlspecialchars($settings[
							'gender'])."</option>
						<option>Male</option>
						<option>Female</option>



						</select>";




					echo "<input type='text' id='entry_box' name='email' value='".htmlspecialchars($settings['email'])."' placeholder='Email'/>";
					echo "<input type='password' id='entry_box' name='password' value='".htmlspecialchars($settings['password'])."' placeholder='Password'/>";
					echo "<input type='password' id='entry_box' name='password2' value='".htmlspecialchars($settings['password'])."' placeholder=' Retype Password'/>";

					echo "About me:<br>
						<textarea id='entry_box' style='height: 200px;' name='about'>".htmlspecialchars($settings['about'])."</textarea> 

						";

					echo '<input id="posts_butn" type="submit" value="Save">';

				}

				
				


			?>
		</form>
	</div>

</div>