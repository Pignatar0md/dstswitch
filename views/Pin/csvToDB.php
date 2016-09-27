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
                        <legend style="color: #48722c">Resultado de Carga de Csv para Campaña</legend>
                    </fieldset>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-lg-6 col-lg-offset-3">
                    <?php
                    include '../../controllers/Ctl_Pin.php';
                    ?>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-lg-offset-3">
                        <?php echo "<a href='../index.php'>Home</a>&nbsp;/"; ?>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</html>