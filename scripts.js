(function() {

    var width = 320;//document.getElementById("camera").clientWidth;    // We will scale the photo width to this
    var height = 0;     // This will be computed based on the input stream
    var streaming = false;
    var video = null;
    var canvas = null;
    var photo = null;
    var startbutton = null;
    var xhttp = false;
    function startup() {
        video = document.getElementById('video');
        canvas = document.getElementById('canvas');
        photo = document.getElementById('photo');
        startbutton = document.getElementById('startbutton');
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
            function(stream) {
                if (navigator.mozGetUserMedia) {
                    video.mozSrcObject = stream;
                } else {
                    var vendorURL = window.URL || window.webkitURL;
                    video.src = vendorURL.createObjectURL(stream);
                }
                video.play();
            },
            function(err) {
                console.log("An error occured! " + err);
            }
        );

        video.addEventListener('canplay', function(ev){
            if (!streaming) {
                height = video.videoHeight / (video.videoWidth/width);

                // Firefox currently has a bug where the height can't be read from
                // the video, so we will make assumptions if this happens.

                if (isNaN(height)) {
                    height = width / (4/3);
                }

                video.setAttribute('width', width);
                video.setAttribute('height', height);
                canvas.setAttribute('width', width);
                canvas.setAttribute('height', height);
                streaming = true;
            }
        }, false);

        startbutton.addEventListener('click', function(ev){
            takepicture();
            ev.preventDefault();
        }, false);

        clearphoto();
    }

    // Fill the photo with an indication that none has been
    // captured.

    function clearphoto() {
        var context = canvas.getContext('2d');
        context.fillStyle = "#AAA";
        context.fillRect(0, 0, canvas.width, canvas.height);
    }

    // Capture a photo by fetching the current contents of the video
    // and drawing it into a canvas, then converting that to a PNG
    // format data URL. By drawing it on an offscreen canvas and then
    // drawing that to the screen, we can change its size and/or apply
    // other changes before drawing it.

    function takepicture() {
        var context = canvas.getContext('2d');
        if (width && height) {
            canvas.width = width;
            canvas.height = height;
            context.drawImage(video, 0, 0, width, height);

            var url = "save_snap.php";
            var data = canvas.toDataURL('image/png');
            data = "img="+data;

            xhttp.onreadystatechange = function() {
                if (xhttp.readyState == 4 && this.status == 200) {
                    console.log("hi " + xhttp.responseText);
                }
            };
            xhttp.open("POST", url,true);
            xhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
            xhttp.send(data);
        } else {
            clearphoto();
        }
    }

    // Set up our event listener to run the startup process
    // once loading is complete.
    window.addEventListener('load', startup, false);
})();