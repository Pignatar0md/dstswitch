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
<form><br>
    <div class="row">
        <div class="col-md-3 col-md-offset-4">
            <input type="text" class="form-control" id="namePin" placeholder="Nombre de Pin" required/>
        </div>
    </div><br>
    <div class="row">
        <div class="col-md-3 col-md-offset-4">
            <input type="text" class="form-control" id="pin" placeholder="Pin" required/>
        </div>
    </div><br>
    <div class="row">
        <div class="col-md-3 col-md-offset-4">
            <button id="savePin" type="button" class="btn btn-sm btn-success">Guardar</button>
        </div>
    </div>
</form>