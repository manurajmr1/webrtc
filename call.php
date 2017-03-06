<?php
session_start(); //die($_POST['inputEmail']);
if ($_POST['inputEmail'])
    $_SESSION["fingcall_userid"] = $_POST['inputEmail'];
else if (!isset($_SESSION["fingcall_userid"]))
    header('Location: login.php');
?><!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="favicon.ico">

        <title>Cover Template for Bootstrap</title>
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/cover.css" rel="stylesheet">
        <!DOCTYPE html>
    <script src="https://fts-dsk-146.ftsindia.in:9001/dist/RTCMultiConnection.min.js"></script>
    <script src="https://fts-dsk-146.ftsindia.in:9001/socket.io/socket.io.js"></script>
</head>

<body>

    <style>
        video {
            width: 40%;
            border-radius:15px;
            margin: 5px 10px;
        }
    </style>      

    <div class="site-wrapper">
        <!--Call Tools-->
        <div style="position:absolute;top:70px;left:0;width:100px;min-height:500px;border:1px solid white;" id="callToolsDiv">

        </div>

        <!--User Status-->
        <div style="position:absolute;top:70px;right:0;width:100px;min-height:500px;border:1px solid white;" id="statusDiv">

        </div>



        <div class="site-wrapper-inner">

            <div class="cover-container">

                <div class="masthead clearfix">
                    <div class="inner">
                        <h3 class="masthead-brand"><b>FTS</b> call</h3>
                        <nav>
                            <ul class="nav masthead-nav">
                                <li class="active"><a href="#">Logout</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>

                <div class="container" id="container">
                    <button id="btn-open-room">Open Room</button>
                    <button id="btn-join-room">Join Room</button><br>



                </div>

                <div class="mastfoot">
                    <div class="inner">
                        <p>FIngent Inc.</p>
                    </div>
                </div>

            </div>

        </div>

    </div>
    <script>
        var connection = new RTCMultiConnection();

    // this line is VERY_important
        connection.socketURL = 'https://fts-dsk-146.ftsindia.in:9001/';

    // all below lines are optional; however recommended.

        connection.session = {
            audio: 'many-to-many',
            video: 'many-to-many'
        };

        connection.userid = '<?php echo $_SESSION["fingcall_userid"]; ?>';

        connection.sdpConstraints.mandatory = {
            OfferToReceiveAudio: true,
            OfferToReceiveVideo: true
        };

        connection.extra = {
            name: '<?php echo $_SESSION["fingcall_userid"]; ?>',
            joinedAt: (new Date).toISOString()
        };
        
        
        connection.onstream = function (event) {
            console.log(event);
            document.getElementById('container').appendChild(event.mediaElement);
            connection.onUserStatusChanged = function (status) {

                console.log(status);
                if (status.status === 'online') {


                    if (!document.getElementById(status.userid))
                    {
                        document.getElementById("statusDiv").insertAdjacentHTML('beforeend', '<div id="' + status.userid + '" style="width:100%;padding:2px;">' + event.extra.name + '</div>');
                    }

                } else {
                    document.getElementById(status.userid).remove();
                }
            };
        };


        connection.onstreamended = function (event) {
            console.log(event);
            document.getElementById('container').appendChild(event.mediaElement);
            connection.onUserStatusChanged = function (status) {

                console.log(status);
                if (status.status === 'online') {

                    if (!document.getElementById(status.userid))
                    {
                        document.getElementById("statusDiv").insertAdjacentHTML('beforeend', '<div id="' + status.userid + '" style="width:100%;padding:2px;">' + event.extra.name + '</div>');
                    }
                } else {
                    document.getElementById(status.userid).remove();
                }
            };
        };


    //
    //connection.onstream = function(event) {
    //    document.getElementById('container').appendChild( event.mediaElement );
    //};

    //var channel = config.channel || location.href.replace( /\/|:|#|%|\.|\[|\]/g , '');
        var predefinedRoomId = prompt('Please enter room-id', 'xyzxyzxyz');

    //connection.openOrJoin(predefinedRoomId);

        document.getElementById('btn-open-room').onclick = function () {
            this.disabled = true;
            connection.open(predefinedRoomId);
        };

        document.getElementById('btn-join-room').onclick = function () {
            this.disabled = true;
            connection.join(predefinedRoomId);
        };
    </script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>



