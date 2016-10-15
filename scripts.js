(function () {

    var width = 320;//document.getElementById("camera").clientWidth;    // We will scale the photo width to this
    var height = 0;     // This will be computed based on the input stream
    var streaming = false;
    var video = null;
    var canvas = null;
    var over = null;
    var startbutton = null;
    var xhttp = false;
    var upbtn = null;

    function startup() {
        video = document.getElementById('video');
        canvas = document.getElementById('canvas');

        startbutton = document.getElementById('startbutton');
        width = document.getElementById("camera").clientWidth;
        upbtn = document.getElementById("btn_upload");
        xhttp = new XMLHttpRequest();

        navigator.getMedia = ( navigator.getUserMedia ||
        navigator.webkitGetUserMedia ||
        navigator.mozGetUserMedia ||
        navigator.msGetUserMedia);

        navigator.getMedia(
            {
                video: true,
                audio: false
            },
            function (stream) {
                if (navigator.mozGetUserMedia) {
                    video.mozSrcObject = stream;
                } else {
                    var vendorURL = window.URL || window.webkitURL;
                    video.src = vendorURL.createObjectURL(stream);
                }
                video.play();
            },
            function (err) {
                console.log("An error occured! " + err);
            }
        );

        video.addEventListener('canplay', function (ev) {
            if (!streaming) {
                height = video.videoHeight / (video.videoWidth / width);

                // Firefox currently has a bug where the height can't be read from
                // the video, so we will make assumptions if this happens.

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

        startbutton.addEventListener('click', function (ev) {
            takepicture();
            ev.preventDefault();
        }, false);

        upbtn.addEventListener('click', function () {

            var image = document.getElementById("fileToUpload");
            var url = "upload.php";


            if ('files' in image) {
                if (image.files.length == 0) {
                    console.log("error select files");
                } else {
                    console.log("got files");
                    for (var i = 0; i < image.files.length; i++) {
                        var file = image.files[i];
                        var data = new FormData;
                        data.append("image",file);
                        xhttp.onreadystatechange = function () {
                            if (xhttp.readyState == 4 && this.status == 200) {
                                console.log("hi " + xhttp.responseText);
                                load_user_images();
                            }
                            if (this.status == 500) {
                                console.log("ho oh " + xhttp.responseText);
                            }
                        };
                        xhttp.open("POST", url);
                        xhttp.send(data);
                    }
                }
            }
        });

        init_overlays();

        load_user_images();

        clearphoto();
    }

    function init_overlays() {
        var i;
        var over = document.getElementsByClassName("over_img");
        for (i = 0; i < over.length;i++)
        {
            over[i].addEventListener('click', function chose_overlay(){
                over = this.src;
                console.log(over);
                upbtn.disabled = false;
                startbutton.disabled = false;
            });
        }
    }

    function set_overlays() {
        console.log("set over run");
        var i;
        var over = document.getElementsByClassName("over");
        for (i = 0; i < over.length;i++)
        {
            over[i].style.backgroundColor = "wight";
        }
    }

    function clearphoto() {
        var context = canvas.getContext('2d');
        context.fillStyle = "#AAA";
        context.fillRect(0, 0, canvas.width, canvas.height);
    }

    function takepicture() {
        var context = canvas.getContext('2d');
        if (width && height) {
            canvas.width = width;
            canvas.height = height;
            context.drawImage(video, 0, 0, width, height);

            var url = "save_snap.php";
            var data = canvas.toDataURL('image/png');
            console.log(data);
            data = "img=" + data;

            xhttp.onreadystatechange = function () {
                if (xhttp.readyState == 4 && this.status == 200) {
                    console.log("hi " + xhttp.responseText);
                    load_user_images();
                }
                if (this.status == 500) {
                    console.log("ho oh " + xhttp.responseText);
                }
            };
            xhttp.open("POST", url, true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send(data);
        } else {
            clearphoto();
        }
    }

    function load_user_images() {
        var div = document.getElementById("user_upload");
        var url = "user_uploads.php";

        while (div.hasChildNodes()) {
            div.removeChild(div.lastChild)
        }
        xhttp.onreadystatechange = function () {
            if (xhttp.readyState == 4 && this.status == 200) {
                //console.log("hi " + xhttp.responseText);
                if (xhttp.responseText != false) {
                    var display = JSON.parse(xhttp.responseText);
                    display.forEach(function (data, index) {
                        var img = document.createElement("IMG");
                        img.setAttribute("src", data);
                        img.setAttribute("class", "img_thumb");
                        div.appendChild(img);
                    });
                }
            }
            if (this.status == 500) {
                console.log("ho oh " + xhttp.responseText);
            }
        };
        xhttp.open("POST", url, true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send();

    }

    window.addEventListener('load', startup, false);
})();