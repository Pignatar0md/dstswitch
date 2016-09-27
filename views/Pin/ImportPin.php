<?php
include '../../controllers/Ctl_Pin.php';
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
            <div class="row">
                <div class="col-lg-4 col-md-offset-5">
                    <form method="POST" action="csvToDB.php"><br>
                        <div>Escribir a Base de Datos?</div>
                        <button type="submit" class="btn btn-warning" name="op" value="importPin">Aceptar</button>
                        <button type="submit" class="btn btn-danger" name="abortar" value="Abortar">Cancelar</button>
                    </form>
                </div>
            </div>

        </div>
    </body>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</html>