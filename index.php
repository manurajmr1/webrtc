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

    </head>

    <body>
        
            

        <div class="site-wrapper">

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

                    <div class="container">

                        <div class="row">
                            <div class="col-lg-4">
                                <a href="call.php"><img class="img-circle" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Generic placeholder image" width="140" height="140">
                                    <h2>Start with Audio</h2></a>

                            </div><!-- /.col-lg-4 -->
                            <div class="col-lg-4">
                                <a href="call.php"><img class="img-circle" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Generic placeholder image" width="140" height="140">
                                    <h2>Start with Video</h2></a>

                            </div><!-- /.col-lg-4 -->
                            <div class="col-lg-4">
                                <a href="call.php"><img class="img-circle" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Generic placeholder image" width="140" height="140">
                                    <h2>Join</h2></a>

                            </div><!-- /.col-lg-4 -->
                        </div>

                    </div>

                    <div class="mastfoot">
                        <div class="inner">
                            <p>FIngent Inc.</p>
                        </div>
                    </div>

                </div>

            </div>

        </div>


        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
        <script src="js/bootstrap.min.js"></script>
    </body>
</html>
