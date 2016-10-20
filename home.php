<?php
include_once "config/database.php";

session_start();
$selfie = $_REQUEST['img'];
$overlay = $_REQUEST['overlay'];

function merge_img($img, $overlay){
    if (!file_exists($_SERVER["DOCUMENT_ROOT"]."/usr"))
        mkdir($_SERVER["DOCUMENT_ROOT"]."/usr", 0777, true);
    if (!file_exists($_SERVER["DOCUMENT_ROOT"] . "/usr/" . $_SESSION['loggued_on_user']))
        mkdir($_SERVER["DOCUMENT_ROOT"]."/usr/" . $_SESSION['loggued_on_user'], 0777, true);
    $selfienew = imagecreatefromstring($img);
    list($swidth, $shight) = getimagesizefromstring($img);
    $overlaynew = imagecreatefrompng($overlay);
    $overlaynew = imagescale($overlaynew, $swidth, $shight);
    imagealphablending($selfienew, true);
    imagesavealpha($selfienew, true);
    imagecopy($selfienew, $overlaynew, 0, 0, 0, 0, $swidth, $shight);
    return ($selfienew);
}

if (isset($_SESSION['loggued_on_user'])){

    $file_name = $_SESSION['loggued_on_user'] . " " .  date("Y-m-d-His") . ".png";
    $file_location = $_SERVER["DOCUMENT_ROOT"] . "/usr/" . $_SESSION['loggued_on_user'] . "/";
    $file_location2 = "/usr/" . $_SESSION['loggued_on_user'] . "/";

    if (isset($_POST['upload']) && $_POST['upload'] == true ) {


        $img = str_replace('data:image/png;base64,', '', $selfie);
        $img = str_replace(' ', '+', $img);
        $img = base64_decode($img);

        $selfienew = merge_img($img, $overlay);
        imagepng($selfienew, $file_location . $file_name);
        echo $file_location2 . $file_name;
        exit();
    }

    if (isset($_POST['submit']) && $_POST['submit'] == true) {
        $target_file = $file_location . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if($check != false) {
            $uploadOk = 1;
        } else {
            $err_upload = $err_upload . " File is not an image.";
            $uploadOk = 0;
        }

        if (file_exists($target_file)) {
            $err_upload = $err_upload . " Sorry, file already exists, rename";
            $uploadOk = 0;
        }

        if ($_FILES["fileToUpload"]["size"] > 500000) {
            $err_upload = $err_upload . " Sorry, your file is too large.";
            $uploadOk = 0;
        }

        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
            $err_upload = $err_upload . " Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {
            $err_upload = $err_upload . " Sorry, your file was not uploaded.";
        }
        else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                $img = imagecreatefrompng($file_location . basename($_FILES["fileToUpload"]["name"]));
                $selfienew =  merge_img($img, $overlay);
                imagepng($selfienew, $file_location . $file_name . date());

                echo $file_location2 . basename($_FILES["fileToUpload"]["name"]);
                exit();
            } else {
                $err_upload = $err_upload . " Sorry, there was an error uploading your file.";
            }
        }
    }
}
else
    header('Location: index.php');

?>
<html lang="en" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="page_style.css">
    <script src="cam.js"></script>
    <link rel="stylesheet" href="home.css">
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
    <div id="myModal" class="modal">
        <span class="close">×</span>
        <div id="caption"> <?php echo $_SESSION['loggued_on_user'] ?> </div>
        <img id="photo" class="modal-content" alt="The screen capture will appear in this box.">
        <form method="post" name="upload" action="home.php">
            <div>
                <input id="comments" placeholder="Write a Comment..." type="text">
            </div>
            <button  id="submit btn-login" class="btnStyle">Submit</button>
            <button id="delete" class="btnStyle">Delete</button>
        </form>
    </div>
    <div class=" page container">
        <div id="home-container">
            <div id="webcam">

                      <form style="width: 50%" action="home.php" method="post" enctype="multipart/form-data">
                          <div>
                          <input style="margin-left: 1% " id="file-upload" class="btnStyle"  type="file" name="fileToUpload" id="fileToUpload">
                          <input class="btnStyle" type="submit" value="Upload Image" name="submit">
                          </div>
                            <p style="color: red; padding: 1%"> <?php echo $err_upload?> </p>
                          <button id="startbutton" ">Take photo </button>
                      </form>
                <div id="video-div" style="position: relative" >
                        <img id="new-img" >
                        <video id="video">Video stream not available.</video>
                </div>

            <div id="super-img">
                <img id="img1" src="img/face1.png" >
                <img id="img2" src="img/face2.png" >
                <img id="img3" src="img/face3.png" >
            </div>
        </div>
        <div id="side-container">
            <div class="output">
                <canvas id="canvas"></canvas>
            </div>
        </div>
        </div>

</div>
<div id="footer"><p>Tony Mack © 2016 </p> </div>
</body>
</html>
