(function () {
    var width = 500;
    var height = 0;
    var streaming = false;
    var video = null;
    var canvas = null;
    var photo = null;
    var startbutton = null;

    // overlay vars
    var overlay1 = null;
    var overlay2 = null;
    var overlay3 = null;
    var overlay_src = null;

    //modal vars
    var modal = null;
    var modalImg = null;
    var captionText = null;
    var span = null;


    function startup() {
        //modal dec
        span = document.getElementsByClassName("close")[0];
        modal = document.getElementById('myModal');
        modalImg = document.getElementById("photo");
        captionText = document.getElementById("caption");

        video = document.getElementById('video');
        canvas = document.getElementById('canvas');
        photo = document.getElementById('photo');
        startbutton = document.getElementById('startbutton');
        overlay1 = document.getElementById('img1');
        overlay2 = document.getElementById('img2');
        overlay3 = document.getElementById('img3');

// Get access to the camera!
        if(navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
            // Not adding `{ audio: true }` since we only want video now
            navigator.mediaDevices.getUserMedia({ video: true }).then(function(stream) {
                video.src = window.URL.createObjectURL(stream);
                video.play();
            });
        }

        video.addEventListener('canplay', function (ev) {
            if (!streaming) {
                height = video.videoHeight / (video.videoWidth / width);

                if (isNaN(height)) {
                    height = width / (4 / 3);
                }
                video.setAttribute('width', width);
                video.setAttribute('height', height);
                canvas.setAttribute('width', width);
                canvas.setAttribute('height', height);
                streaming = true;
            }
        }, false);

        span.addEventListener('click', function (ev) {
            span_fun();
        });

        startbutton.addEventListener('click', function (ev) {
            if (overlay_src != null)
                modal_fun();
            takepicture();
            ev.preventDefault();
        }, false);

        overlay1.addEventListener('click', function (ev) {
            change_1();
            overlay_src = "img/face1.png" ;

        });

        overlay2.addEventListener('click', function (ev) {
            change_2();
            overlay_src = "img/face2.png";

        });

        overlay3.addEventListener('click', function (ev) {
            change_3();
            overlay_src = "img/face3.png";
        });

        clearphoto();
    }
    ////////////
    function clearphoto() {
        var context = canvas.getContext('2d');
        context.fillStyle = "#AAA";
        context.fillRect(0, 0, canvas.width, canvas.height);
        var data = canvas.toDataURL('image/png');
        photo.setAttribute('src', data);

    }

    function takepicture() {
        var context = canvas.getContext('2d');
        if (width && height) {
            canvas.width = width;
            canvas.height = height;
            context.drawImage(video, 0, 0, width, height);
            var data = canvas.toDataURL('image/png');
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
                {
                 //   var side_container = document.getElementById("side-container");
                  //  var node = document.createElement("img");
                  //  node.src = xmlhttp.responseText;
                  //  node.id = "photo";
                    photo.setAttribute('src', xmlhttp.responseText);
                   // side_container.appendChild(node);
                }
            };
            xmlhttp.open("POST","home.php",true);
            xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
            if (overlay_src == null){
                alert("please select filter");
            }
            else {
                xmlhttp.send("img=" + data + "&overlay=" + overlay_src + "&upload=true");
            }

        } else {
            clearphoto();
        }
    }
    window.addEventListener('load', startup, false);

    function change_1() {

        if (document.getElementById('img1')) {
            document.getElementById('new-img').src = "img/face1.png";
        }
    }

    function change_2() {
        if (document.getElementById('img2')) {
            document.getElementById('new-img').src = "img/face2.png";
        }
    }

    function change_3() {

        if (document.getElementById('img3')) {
            document.getElementById('new-img').src = "img/face3.png";
        }
    }

    //////////////////////////

    function modal_fun() {
        modal.style.display = "block";
        modalImg.src = this.src;
    }
      function span_fun() {
        modal.style.display = "none";
    }

    function upload_pic() {
        if (width && height) {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
                {
                       var side_container = document.getElementById("side-container");
                      var node = document.createElement("img");
                      node.src = xmlhttp.responseText;
                      node.id = "photo";
                    photo.setAttribute('src', xmlhttp.responseText);
                    side_container.appendChild(node);
                }
            };
            xmlhttp.open("POST","home.php",true);
            xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
            if (overlay_src == null){
                alert("please select filter");
            }
            else {
                xmlhttp.send("overlay=" + overlay_src);
            }

        } else {
            clearphoto();
        }



    }
    /////////////////////////



})();



