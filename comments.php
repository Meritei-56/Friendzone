<div id="posts" style='background-color: #F0F0F0;'>
    <div>
    <?php
        $ROW_user = $user->identify_user($COMMENT['user_id']);
        $image = "images/user_male.jpg";
        if ($ROW_user['gender'] == "Female") {
            $image = "images/user_female.jpg";
        }
        if (file_exists($user_info['profile_image'])) {
            $image = $images_class->get_thumb_profiles($user_info['profile_image']);
        }
    ?>
    <img src="<?php echo $image ?>" style="width: 75px; margin: 4px; border-radius: 50%; border: solid 2px white;">
    </div>
    <div style="width: 100%;">
        <div style="font-weight: bold; color: #405d9b">
            <?php
                
                echo "<a href='profile.php?id=$COMMENT[user_id]'>";
                echo htmlentities($ROW_user['first_name']) . " " . htmlentities($ROW_user['last_name']);
                echo "</a>";

                if ($COMMENT['is_profile_photo']) {
                    $pronoun = "his";
                    if ($ROW_user['gender'] == "Female") {
                        $pronoun = "her";
                    }
                    echo "<span style='font-weight: normal; color: #aaa;'> updated $pronoun profile photo</span>";
                }

                if ($COMMENT['is_cover_photo']) {
                    $pronoun = "his";
                    if ($ROW_user['gender'] == "Female") {
                        $pronoun = "her";
                    }
                    echo "<span style='font-weight: normal; color: #aaa;'> updated $pronoun cover photo</span>";
                }




            ?>
        </div>
        <!--for html scripting -->
        <span style="color: #999;">
            <?php echo $COMMENT['date'] ?>
        </span><br>
        <?php echo htmlentities($COMMENT['post']) ?> 
        <br><br>
        <?php
             if($COMMENT['has_image'])
            {
                echo "<a href='view_full_photos.php?id=$COMMENT[post_id]' >";
             
                if (file_exists($COMMENT['image'])) {
                    $post_photo = $images_class->get_thumb_posts($COMMENT['image']);
                    echo "<img src='$post_photo'; style='width: 50%;'/>";
                }
                echo "</a>";
            }
        ?>
        <br/><br/>
        <?php

    
            
            $likes = "";
            $likes = ($COMMENT['likes'] > 0) ? "(" .$COMMENT['likes']. ")" : "";


        ?>
        
        <br>

        <a href="likes.php?type=post&id=<?php echo $COMMENT['post_id'] ?>" class="btn btn-primary" style='font-size:15px; background-color: #A8A8A8;'>
            <i class="bi bi-hand-thumbs-up bi-sm"></i> Like<span id="like_count"><?php echo $likes ?></span>
        </a>


        
        <span style="color: #999; float: right;">
            <?php 
                $post = new Posts();

                if ($post->check_post_ownership($COMMENT['post_id'], $_SESSION['myfriendzone_userid'])) {
                    echo "
                    <a href='edit.php?id=$COMMENT[post_id]' class='btn btn-warning' style='font-size:15px; background-color: #A8A8A8;'>
                        <i class='bi bi-pencil bi-sm'></i> Edit 
                    </a>
                    <a href='delete.php?id=$COMMENT[post_id]' class='btn btn-danger' style='font-size:15px; background-color: #A8A8A8;'>
                        <i class='bi bi-trash bi-sm'></i> Delete
                    </a>";
                }



            ?>
        </span>

        <?php
        $i_liked = false;

        if(isset($_SESSION['myfriendzone_userid'])){
            $DB = new Database();
            // Save likes details
            $post_id = $COMMENT['post_id']; // Assuming $ROW['post_id'] contains the post ID
            $sql_query = "SELECT likes FROM likes_table WHERE type='post' AND postId = '$post_id' LIMIT 1";
            $result = $DB->read_from_db($sql_query);

            if ($result && is_array($result) && count($result) > 0) 
            {
                $likes = json_decode($result[0]['likes'], true);

                $user_ids = array_column($likes, "userid");

                if (in_array($_SESSION['myfriendzone_userid'], $user_ids)) 
                {
                    $i_liked = true;
                }
            }
        }

        if($COMMENT['likes'] > 0){
            echo "<br/>";
            echo "<a href='actlikes.php?type=post&id=$ROW[post_id]'>";
            if($COMMENT['likes'] == 1){
                if($i_liked){
                    echo "<div style='text-align:left;'> You  </div>";

                }else{
                    echo "<div style='text-align:left;'> other </div>";
                }
                
            }else{
                if($i_liked){
                    $text = "others";
                    if($COMMENT['likes'] - 1 == 1){
                        $text = "other";
                    }

                    echo "<div style='text-align:left;'> You and " . ($COMMENT['likes'] - 1) . " $text </div>";
                }else{
                    echo "<div style='text-align:left;'>" . $COMMENT['likes'] . " </div>";
                }
                
            }

            echo "<a/>";
            
        }
        ?>


    

            
        </span>

        </div>
                            
    </div>