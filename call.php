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
    <script src="https://fts-dsk-146.ftsindia.in:9001/dist/RTCMultiConnection.js"></script>
    <script src="https://fts-dsk-146.ftsindia.in:9001/socket.io/socket.io.js"></script>
    <script src="https://cdn.webrtc-experiment.com/getMediaElement.js"></script>
    <script src="https://cdn.webrtc-experiment.com:443/getScreenId.js"></script>
</head>

<body>
     

    <div class="site-wrapper">
        <!--Call Tools-->
        <div style="" id="callToolsDiv">            

            <div class="toolIcon" >
                <a href="#" class="btn btn-info btn-lg" id="start-call" title="Start Call">
                    <span class="glyphicon glyphicon-earphone"></span>
                </a>
            </div>

            <div class="toolIcon" >
                <a href="#" class="btn btn-info btn-lg" id="share-screen" title="Share Screen">
                    <span class="glyphicon glyphicon-credit-card"></span> 
                </a>
            </div>

            <div class="toolIcon" >
                <a href="#" class="btn btn-info btn-lg" id="end-call"  title="End">
                    <span class="glyphicon glyphicon-earphone"></span>
                </a>
            </div>
        </div>

        <!--User Status-->
        <div style="" id="statusDiv">
            <div id="userList" >
                
            </div>
            <div id="conversations">
                <h4><u>Conversations</u></h4>
                <div id="conversation-list">
                
                </div>
            </div>
            <textarea id="text-chat" placeholder="Say something"></textarea>
        </div>



        <div class="site-wrapper-inner">

            <div class="cover-container">

                <div class="masthead clearfix topbar">
                    <div class="inner">
                        <h3 class="masthead-brand"><a href="index.php"><b>FTS</b> call</a></h3>
                        <nav>
                            <ul class="nav masthead-nav">
                                <li class="active"><a href="logout.php">  Logout </a></li>
                            </ul> 
                            <ul class="nav masthead-nav">
                                <li class="active" style="padding: 10px 15px;"><?php echo $_SESSION["fingcall_userid"]; ?>  </li>
                            </ul>
                        </nav>
                    </div>
                </div>


                <div class="container" id="container">

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
        
        connection.enableScalableBroadcast = true;
        
        // this line is VERY_important
        connection.socketURL = 'https://fts-dsk-146.ftsindia.in:9001/';

        // all below lines are optional; however recommended.

        connection.session = {
            audio: true,
            video: true,
            data: true
        };

//        connection.userid = '<?php echo $_SESSION["fingcall_userid"]; ?>';

        connection.sdpConstraints.mandatory = {
            OfferToReceiveAudio: true,
            OfferToReceiveVideo: true
        };
        
        var username = '<?php echo $_SESSION["fingcall_userid"]; ?>';
        var user_chat;
        
        connection.extra = {
            name: '<?php echo $_SESSION["fingcall_userid"]; ?>',
            joinedAt: (new Date).toISOString()
        };
        
        document.getElementById('text-chat').onkeyup = function(e) {
                if (e.keyCode != 13) return;

                // removing trailing/leading whitespace
                this.value = this.value.replace(/^\s+|\s+$/g, '');
                if (!this.value.length) return;

                connection.send(this.value);
                appendDIV(this.value);
                this.value = '';
            };
            
        var chatContainer = document.querySelector('#conversation-list');

            function appendDIV(event) { console.log(event);
                if(typeof event.data === "undefined") user_chat = username;
                else user_chat = event.extra.name;
                var div = document.createElement('div');
                div.innerHTML = (event.data || event) + "<p class='chat-head-name'>"+user_chat+"</p>";
                chatContainer.insertBefore(div, chatContainer.firstChild);
                div.tabIndex = 0;
                div.className = 'chat-head';
                div.focus();
            }    
        
        connection.getScreenConstraints = function(callback) {
                getScreenConstraints(function(error, screen_constraints) {
                    if (!error) {
                        screen_constraints = connection.modifyScreenConstraints(screen_constraints);
                        callback(error, screen_constraints);
                        return;
                    }
                    throw error;
                });
            };
//        connection.updateExtraData();

//        connection.onExtraDataUpdated = function (event) {
//           
//            var name = event.extra.name;
//            var userid = event.userid; // remote-userid
//            
//            document.getElementById("statusDiv").insertAdjacentHTML('beforeend', '<div id="' + event.extra.name + '" style="width:100%;padding:2px;">' + event.extra.name + '</div>');
//        };

        var videosContainer = document.getElementById('container');
        var userList = document.getElementById('userList');
        
        connection.onmessage = appendDIV;
        
        connection.onstream = function (event) {
//            console.log(event);

//           Add video/audio
            if(document.getElementById(event.streamid)) {
                var existing = document.getElementById(event.streamid);
                existing.parentNode.removeChild(existing);
            }
            var div = document.createElement('div');
            div.id = event.streamid;
            div.className = 'video-div';
            var mediaElement = getMediaElement(event.mediaElement, {
                    title: event.extra.name,
                    buttons: ['full-screen'],
                    width: 320,
                    showOnMouseEnter: false
                });
            
            div.appendChild(mediaElement); // appending VIDOE to DIV
            setTimeout(function() {
                    mediaElement.media.play();
                }, 5000);
//            mediaElement.id = event.streamid;    
            var h2 = document.createElement('h4');
            h2.innerHTML = event.extra.name;
            div.appendChild(h2);

            videosContainer.appendChild(div);



//          Add User status   
            if(document.getElementById(event.userid)) {
                var existing = document.getElementById(event.userid);
                existing.parentNode.removeChild(existing);
            }
            var span = document.createElement('span');
            span.id = event.userid;
            span.innerHTML = "<p class='userStatus'></p>" + event.extra.name;
            span.className = 'users';
            userList.appendChild(span);
//            console.log(connection.peers);
            
//            if(connection.peers[event.userid] != undefined){
//            connection.peers[event.userid].addStream({
//            screen: true,
//            oneway: true
//            });
//            }
            
        };


        connection.onstreamended = function (event) {

            var div = document.getElementById(event.streamid);
            if (div && div.parentNode) {
                div.parentNode.removeChild(div); // remove stream from the DOM
            }

            var div = document.getElementById(event.userid);
            if (div && div.parentNode) {
                div.parentNode.removeChild(div); // remove status from the DOM
            }

        };


        //
        //connection.onstream = function(event) {
        //    document.getElementById('container').appendChild( event.mediaElement );
        //};

        //var channel = config.channel || location.href.replace( /\/|:|#|%|\.|\[|\]/g , '');
        var predefinedRoomId = prompt('Please enter room-id', 'xyzxyzxyz');

        //connection.openOrJoin(predefinedRoomId);

        document.getElementById('start-call').onclick = function () {
//            this.disabled = true;
            connection.openOrJoin(predefinedRoomId);
        };



        document.getElementById('share-screen').onclick = function () {
            connection.addStream({
                screen: true,
                oneway: true
            });
        };

        document.getElementById('end-call').onclick = function () { 
//            this.disabled = true;
            connection.leave();
        };
        
        connection.openOrJoin(predefinedRoomId);
        
    </script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>