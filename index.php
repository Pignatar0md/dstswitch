<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>dstswitch</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"/>
        <link rel="stylesheet" href="static/css/abm.css"/>
    </head>
    <body>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="static/js/abm.js"></script>
        <script src="static/js/validate.js"></script>
        <script src="static/js/boxes.js"></script>
        <div class="container-fluid">
            <div class="row-fluid">
                <?php
                session_start();
                include('helpers/path_helper.php');
                if (isset($_SESSION["Usuario"])) {
                    //echo $_SESSION["Usuario"];
                    $_SESSION['REMOTE_ADDR'] = $_SERVER['REMOTE_ADDR'];
                    $_SESSION['HTTP_USER_AGENT'] = $_SERVER['HTTP_USER_AGENT'];
                    include_once 'helpers/navbar.php';
                } else {
                    include_once 'views/login.php';
                }
                ?>
            </div>
            <div class="row-fluid">
                <?php
                if (isset($_SESSION["Usuario"])) {
                    include obtenerPath();
                }
                ?>
            </div>
        </div>
    </body>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</html>
