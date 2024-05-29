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
    

    $Post = new Posts();
    $ROW = false;

    $error = "";
    if(isset($_GET['id']))
    {
        
        $ROW = $Post->retrieve_single_post($_GET['id']); 

    }else
    {
        $error = "No photo found!";
    }

   
?>


<!DOCTYPE html>
<html>
    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        
        <title>Comment Post | Friendzone</title>
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
        #prof_pic{
            width: 40px;
            border-radius: 50%;
            border: solid 2px white;

        }
        #menu_bton{
            width:100px; 
            display: inline-block;
            margin: 2px;
        }
        #friends_img{
            width: 75px;
            float: left;
            margin: 8px;
        }
        #friends_sec{
            min-height: 400px;
            margin-top: 20px;
            padding: 8px;
            text-align: center;
            font-size: 20px;
            color: #405d9b;

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

    </style>
    <body style="font-family: tahoma; background-color: #ffe6e6;">
        <br>
        <?php
    
            $tag_image = "images/user_male.jpg";
            if(isset($user_info))
            {
                $tag_image = $user_info['profile_image'];
            }
         ?>
        <!-- top bar -->
        <div id="bar_bl">

            <form method="get" action="search.php">
                <div style="width: 800px; margin: auto; font-size: 30px;">
                    <a style="text-decoration: none; color: white;" href="profile.php"> Friendzone </a> 
                    &nbsp &nbsp <input type="text" name="search" id="search_tab" placeholder="Search Friendzone">

                    <img src="<?php echo $tag_image ?>"style="width: 35px; float: right; border-radius: 50%; border: solid 2px white;">
                    <a href="logout.php">
                    <span style="font-size: 11px; float: right; margin: 10px; color: white;">Sign out</span></a>    
                </div>
            </form>
            
        </div>
        <!-- cover area -->
        <div style="width: 800px; margin: auto; min-height: 400px;">

            

        <!-- area below cover -->
            <div style="display: flex;">

                <!-- friends section -->
                <div style=" min-height: 400px; flex: 1; ">
                    
                
                <!-- posts section -->
                <div style="min-height: 400px; flex: 2.5; padding: 20px; padding-right: 0px;">
                    <div style="border:solid thin #aaa; padding: 10px; background-color: white;">
                        
                        <?php
                            $user = new User();
                            $images_class = new Images();

                            if(is_array($ROW)){

                                echo "<img src='$ROW[image]' style='width: 100%;' />";   
                                

                            }

                        ?>
                        <br style="clear:both;">
                    
                    </div>
                </div>
            </div>
        </div>

    </body>
</html>