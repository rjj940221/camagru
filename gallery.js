(function () {
        var xhttp = null;

        function start() {
            xhttp = new XMLHttpRequest();

            var i;
            var gall_img = document.getElementsByClassName("gallery_img");
            for (i = 0; i < gall_img.length; i++) {
                gall_img[i].addEventListener('click', function () {
                    console.log("gallery image clicked");
                    var dialog = document.getElementById('dialog_back');
                    var img = document.getElementById('gallery_dialog_img');
                    var data;
                    img.src = this.src;

                    xhttp.onreadystatechange = function () {
                        if (xhttp.readyState == 4 && this.status == 200) {
                            console.log("hi " + xhttp.responseText);
                            var par = document.getElementById('gallery_dialog_comments');
                            var display = JSON.parse(xhttp.responseText);
                            display.forEach(function (data, index) {
                                var div = document.createElement("DIV");
                                var textnode = document.createTextNode("data");
                                div.appendChild(textnode);
                                par.appendChild(div);
                            });
                            if (this.status == 500) {
                                console.log("ho oh " + xhttp.responseText);
                            }
                        }
                        xhttp.open("POST", "getcomments.php");
                        xhttp.send(data);
                        console.log(dialog);

                    };

                    dialog.style.visibility = 'visible';
                });
            }
            document.getElementById('dialog_back').addEventListener('click', function (event) {
                if (event.target == document.getElementById('dialog_back')) {
                    this.style.visibility = 'hidden';
                }
            });
        }

        window.addEventListener('load', start, false)
    })();
