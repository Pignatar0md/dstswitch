<?php
session_start();
if (!$_SESSION['Usuario']) {
    header('Location: ../index.php');
}
if ($_SESSION['REMOTE_ADDR'] != $_SERVER['REMOTE_ADDR'] ||
        $_SESSION['HTTP_USER_AGENT'] != $_SERVER['HTTP_USER_AGENT']) {
    header('Location: ../index.php');
}
?>
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
        <div class="container-fluid">
            <div class="row"><br>
                <div class="col-md-6 col-md-offset-3">
                    <fieldset>
                        <legend style="color: #48722c">Importacion de Datos</legend>
                        <form style="position: absolute" class="form-inline col-lg-12" enctype="multipart/form-data" action="ImportPin.php" method="POST">
                            <div class="row">
                                <input type="hidden" name="MAX_FILE_SIZE" value="10000000" />
                                <input type="hidden" name="op" value="createCsvFile" />
                                <input name="file" type="file" id="file" class="form-control">
                                <input class="btn btn-warning form-control" id="load" type="submit" value="Cargar" name="Cargar">
                                <span class="col-lg-offset-1">
                                    <a href="controllers/download.php?file=csvEj.csv&task=Ej" style="padding-left: 3%">
                                        archivo csv de ejemplo
                                    </a>
                                </span>
                            </div>
                        </form>
                    </fieldset>
                </div>
            </div>
        </div>
    </body>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</html>