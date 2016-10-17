<?php
include_once "config/database.php";

session_start();
$selfie = $_REQUEST['img'];
$overlay = $_REQUEST['overlay'];

if (isset($_SESSION['loggued_on_user'])){

    $img = str_replace('data:image/png;base64,', '', $selfie);
    $img = str_replace(' ', '+', $img);
    $img = base64_decode($img);
    $selfienew = imagecreatefromstring($img);
    list($swidth, $shight) = getimagesizefromstring($img);
    $overlaynew = imagecreatefrompng($overlay);
    $overlaynew = imagescale($overlaynew, $swidth, $shight);
    imagealphablending($selfienew, true);
    imagesavealpha($selfienew, true);
    $x = 379;
    $y = 460;
    imagecopy($selfienew, $overlaynew, 0, 0, 0, 0, $swidth, $shight);
    imagepng($selfienew, "temp1.png");


}
else
    header('Location login.php');

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="page_style.css">
    <link rel="stylesheet" href="home.css">
    <script src="cam.js"></script>
    <title>Login</title>
</head>

<body>
<div id="header">
    <div class="container">
        <div id="logo"><img src="img/Camagru.png"> </div>
        <div id="navigation">
            <ul id="navtabs">
                <a href=""><li>Home</li></a>
                <a href=""><li>Profile</li></a>
                <a href=""><li>Gallery</li></a>
                <a href="Create_account.php"><li>Create Account</li></a>
                <a href=""><li>Logout</li></a>se
            </ul>
        </div>
    </div>
</div>

<div id="body">
    <div class=" page container">
        <div id="home-container">
            <div id="webcam">
                  <div id="video-div" >

                          <img id="new-img" src="img/face1_over1.png">

                      <video id="video">Video stream not available.</video>
                      <button id="startbutton" onclick="">Take photo</button>
                  </div>

            <div id="super-img">
                <img id="img1" src="img/face1.png" onclick=change_1()>
                <img id="img2" src="img/face2.png" onclick=change_2()>
                <img id="img3" src="img/face3.png" onclick=change_3()>
            </div>
        </div>
        <div id="side-container">
            <div class="output">
                <img id="photo" alt="The screen capture will appear in this box.">
                <canvas id="canvas"></canvas>
            </div>

        </div>
            </div>

</div>
<div id="footer"><p>Tony Mack © 2016 </p> </div>
</body>
</html>
