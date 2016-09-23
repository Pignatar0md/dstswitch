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
        <script src="static/js/boxes.js"></script>
        <div class="container-fluid">
            <div class="row-fluid">
                <?php
                include_once 'navbar.php';
                include('helpers/path_helper.php');
                ?>
            </div>
            <div class="row-fluid">
                <?php
                include obtenerPath();
                ?>
            </div>
        </div>
    </body>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</html>
