(function () {

    var image_id = null;

    function start() {
        var i;
        var gall_img = document.getElementsByClassName("gallery_img");

        for (i = 0; i < gall_img.length; i++) {
            gall_img[i].addEventListener('click', function () {
                var dialog = document.getElementById('dialog_back');
                var img = document.getElementById('gallery_dialog_img');
                image_id = this.getAttribute("data-image");

                img.src = this.src;
                load_comments();
                set_like();
                dialog.style.visibility = 'visible';
            });
        }

        document.getElementById('dialog_back').addEventListener('click', function (event) {
            if (event.target == document.getElementById('dialog_back')) {
                this.style.visibility = 'hidden';
            }
        });

        var comment = document.getElementById('gallery_dialog_add_comment_btn');
        if (comment) {
            comment.addEventListener('click', function () {
                var xhttp = new XMLHttpRequest();
                var text = document.getElementById('gallery_dialog_add_comment_txt').value;
                console.log(text);
                if (text) {
                    var send_data = "image_id=" + image_id + "&comment=" + text;
                    xhttp.onreadystatechange = function () {
                        if (xhttp.readyState == 4 && xhttp.status == 200) {
                            console.log("succes text" + xhttp.responseText);
                            load_comments();
                            document.getElementById('gallery_dialog_add_comment_txt').value = "";
                        }
                        if (xhttp.status == 500) {
                            console.log("error in submitting comment");
                        }
                    };
                    xhttp.open("POST", "postcomment.php");
                    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    xhttp.send(send_data);
                }
            });
        }
        like_add_event();
    }

    function load_comments() {
        var xhttp = new XMLHttpRequest();
        var send_data = "image=" + image_id;
        var par = document.getElementById('gallery_dialog_comments');

        while (par.hasChildNodes()) {
            par.removeChild(par.lastChild)
        }
        var h2 = document.createElement("H2");
        var textnode = document.createTextNode("comments");
        h2.appendChild(textnode);
        par.appendChild(h2);
        xhttp.onreadystatechange = function () {
            if (xhttp.readyState == 4 && this.status == 200) {
                console.log("hi " + xhttp.responseText);
                if (xhttp.responseText != false) {
                    var display = JSON.parse(xhttp.responseText);
                    display.forEach(function (data, index) {
                        var div = document.createElement("DIV");
                        div.setAttribute("class", "gallery_dialog_comment");
                        var textnode = document.createTextNode(data);
                        div.appendChild(textnode);
                        par.appendChild(div);
                    });
                }
            }
            if (this.status == 500) {
                console.log("ho oh " + xhttp.responseText);
            }
        };
        xhttp.open("POST", "getcomments.php");
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send(send_data);
    }

    function set_like() {
        var xhttp = new XMLHttpRequest();
        var like = document.getElementById('gallery_dialog_like');
        if (like) {

            var send_data = "image_id=" + image_id;

            xhttp.onreadystatechange = function () {
                if (xhttp.readyState == 4 && this.status == 200) {
                    console.log("set like " + xhttp.responseText);
                    if (xhttp.responseText == "false") {
                        like.disabled = false;
                    }
                    if (xhttp.responseText == "true") {
                        like.disabled = true;
                    }
                }
                if (this.status == 500) {
                    console.log("ho oh " + xhttp.responseText);
                }
            };
            xhttp.open("POST", "is_liked.php");
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send(send_data);

        }
    }

    function like_add_event() {
        var like = document.getElementById('gallery_dialog_like');
        var xhttp = new XMLHttpRequest();
        if (like) {
            like.addEventListener('click', function () {
                var send_data = "image_id=" + image_id;
                xhttp.onreadystatechange = function () {
                    if (xhttp.readyState == 4 && this.status == 200) {
                        console.log("set like " + xhttp.responseText);
                        if (xhttp.responseText == "false") {
                            like.disabled = false;
                        }
                        if (xhttp.responseText == "true") {
                            console.log("set like to disabled");
                            like.disabled = true;
                        }
                    }
                    if (this.status == 500) {
                        console.log("ho oh " + xhttp.responseText);
                    }
                };
                xhttp.open("POST", "add_like.php");
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttp.send(send_data);
            });
        }
    }

    window.addEventListener('load', start, false)
})();
