			<div style="display: flex;">

				<!-- friends section -->
				<div style="min-height: 400px; flex: 1;">
				    <div id="friends_sec">
				        <button id="toggleFriends" style="color:#0000ff; font-size: 20px;" class='fas fa-user-friends'> Users</button>
				        <!-- Icon to toggle visibility -->
				        <!-- Friends list (initially hidden) -->
				        <div id="friendsList" style="display: none;">
				            <?php
				                if ($friends) {
				                    foreach ($friends as $FRIENDS_row) {
				                        include("user.php");
				                    }
				                }
				            ?>
				        </div>
				    </div>
				</div>
				<script>
				    // JavaScript to toggle friends list visibility
				    document.getElementById('toggleFriends').addEventListener('click', function() {
				        var friendsList = document.getElementById('friendsList');
				        
				        // Toggle visibility
				        if (friendsList.style.display === 'none') {
				            friendsList.style.display = 'block';
				        } else {
				            friendsList.style.display = 'none';
				        }
				    });
				</script>


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