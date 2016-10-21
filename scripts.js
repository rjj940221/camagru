(function () {

    var width = 0;//document.getElementById("camera").clientWidth;    // We will scale the photo width to this
    var height = 0;     // This will be computed based on the input stream
    var streaming = false;
    var video = null;
    var canvas = null;
    var over = null;
    var startbutton = null;
    var xhttp = false;
    var upbtn = null;
    var image_id = null;
    var content = null;
    var over_pre = null;

    function startup() {
        content = document.getElementById('content');
        if (document.getElementById('capture')) {
            console.log("startup run");
            video = document.getElementById('video');
            canvas = document.createElement("CANVAS");
            over_pre = document.getElementById('over_pre');

            startbutton = document.getElementById('startbutton');
            width = document.getElementById("camera").clientWidth;
            upbtn = document.getElementById("btn_upload");
            width = document.getElementById("camera").clientWidth;
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

            video.addEventListener('canplay', function () {
                if (!streaming) {
                    height = video.videoHeight / (video.videoWidth / width);


                    if (isNaN(height)) {
                        height = width / (4 / 3);
                    }

                    video.setAttribute('width', width);
                    video.setAttribute('height', height);
                    canvas.setAttribute('width', width);
                    canvas.setAttribute('height', height);
                    content.style.marginBottom = "8%";
                    streaming = true;
                }
            }, false);

            startbutton.addEventListener('click', function (ev) {
                takepicture();
                ev.preventDefault();
            }, false);

            upbtn.addEventListener('click', function () {

                var image = document.getElementById("fileToUpload");
                var url = "/camagru/phpscripts/upload.php";


                if ('files' in image) {
                    if (image.files.length == 0) {
                        console.log("error select files");
                    } else {
                        console.log("got files");
                        for (var i = 0; i < image.files.length; i++) {
                            var file = image.files[i];
                            var data = new FormData;
                            data.append("image", file);
                            data.append("overlay", over);
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

            document.getElementById('dialog_back').addEventListener('click', function (event) {
                if (event.target == document.getElementById('dialog_back')) {
                    this.style.visibility = 'hidden';
                }
            });

            document.getElementById('index_dialog_delete').addEventListener('click', function () {
                var dell_xhttp = new XMLHttpRequest();
                var send_data = "image_id=" + image_id;

                dell_xhttp.onreadystatechange = function () {

                    if (dell_xhttp.readyState == 4 && xhttp.status == 200) {
                        console.log("delete: " + dell_xhttp.responseText);
                        if (dell_xhttp.responseText == "true") {
                            console.log();
                            load_user_images();
                            document.getElementById('dialog_back').style.visibility = 'hidden';
                        }
                    }
                };
                console.log(send_data);
                dell_xhttp.open('POST', '/camagru/phpscripts/delete_image.php');
                dell_xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                dell_xhttp.send(send_data);
            });

            init_overlays();
            load_user_images();
            set_overlays();
            clearphoto();
        }
    }

    function resize() {
        console.log("resize run");
        if (document.getElementById('capture')) {

            width = document.getElementById("camera").clientWidth;
            height = video.videoHeight / (video.videoWidth / width);


            if (isNaN(height)) {
                height = width / (4 / 3);
            }

            video.setAttribute('width', width);
            video.setAttribute('height', height);
            canvas.setAttribute('width', width);
            canvas.setAttribute('height', height);
            content.style.marginBottom = "8%";
        }
    }

    function init_overlays() {
        var i;
        var doc_over = document.getElementsByClassName("over_img");
        for (i = 0; i < doc_over.length; i++) {
            doc_over[i].addEventListener('click', function () {
                over = this.src;
                over_pre.src=this.src;
                console.log(over);
                upbtn.disabled = false;
                startbutton.disabled = false;
            });
        }
        doc_over = document.getElementsByClassName("over");
        for (i = 0; i < doc_over.length; i++) {
            doc_over[i].addEventListener('click', function () {
                set_overlays();
                this.style.backgroundColor = "darkgray";
            });
        }
    }

    function set_overlays() {
        console.log("set over run");
        var i;
        var over = document.getElementsByClassName("over");
        for (i = 0; i < over.length; i++) {
            over[i].style.backgroundColor = "white";
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

            var url = "/camagru/phpscripts/save_snap.php";
            var data = canvas.toDataURL('image/png');
            data = "img=" + data + "&over_name=" + over;

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
        var url = "/camagru/phpscripts/user_uploads.php";

        while (div.hasChildNodes()) {
            div.removeChild(div.lastChild)
        }
        xhttp.onreadystatechange = function () {
            if (xhttp.readyState == 4 && this.status == 200) {
                if (xhttp.responseText != false) {
                    var display = JSON.parse(xhttp.responseText);
                    display.forEach(function (data, index) {
                        var img = document.createElement("IMG");
                        img.setAttribute("src", data['image_data']);
                        img.setAttribute("class", "img_thumb");
                        img.setAttribute("data-image", data['id']);
                        img.addEventListener('click', function () {
                            var dialog = document.getElementById('dialog_back');
                            document.getElementById('index_dialog_img').src = this.src;
                            image_id = this.getAttribute("data-image");
                            console.log("image id set to: "+image_id);
                            dialog.style.visibility = 'visible';
                        });
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
    window.addEventListener("resize", resize);
})();