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
        <div class="col-sm-3 col-md-offset-2">
            <input type="hidden" id="idGroup"  value="<?php echo $_GET['id'] ?>"/>
            <input type="text" id="nameGroup" class="form-control" placeholder="nombre de grupo"/>
        </div>
    </div><br>
    <div class="row">
        <div class="col-sm-2 col-md-offset-2">
            <label>Extensiones</label>
        </div>
        <div class="col-sm-2 col-md-offset-2">
            <label>Destinos</label>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4 col-md-offset-2">
            <select id="dual1" name="extselect" multiple="multiple" class="fieldLoader" size='8'>
            </select>
            <input id="anadirExt" class="btn btn-sm btn-warning" type="button" value="->"/>
            <input id="quitarExt" class="btn btn-sm btn-warning" type="button" value="<-"/>
            <select id="dual2" multiple="multiple" name="extselected[]" class="fieldLoader" size='8'>
            </select>
        </div>
        <div class="col-sm-4">
            <select id="dual5" name="destselect" multiple="multiple" class="fieldLoader" size='8'>
            </select>
            <input id="anadirDst" class="btn btn-sm btn-warning" type="button" value="->"/>
            <input id="quitarDst" class="btn btn-sm btn-warning" type="button" value="<-"/>
            <select id="dual6" multiple="multiple" name="destselected[]" class="fieldLoader" size='8'>
            </select>
        </div>
    </div><br>
    <div class="row">
        <div class="col-sm-2 col-md-offset-2">
            <label>Pines</label>
        </div>
    </div><br>
    <div class="row">
        <div class="col-sm-4 col-md-offset-2">
            <select id="dual3" name="pinselect" multiple="multiple" class="fieldLoader" size='8'>
            </select>
            <input id="anadirPin" class="btn btn-sm btn-warning" type="button" value="->"/>
            <input id="quitarPin" class="btn btn-sm btn-warning" type="button" value="<-"/>
            <select id="dual4" multiple="multiple" name="pinselected[]" class="fieldLoader" size='8'>
            </select>
        </div><br>
        <div class="col-sm-1">
            <label>tarifa</label>
        </div>
        <div class="col-md-2">
            <select id="billing" class="form-control">
            </select>
        </div><br>
        <br><br><br><br>
        <div class="col-md-2 col-md-offset-2">
            <button id="updateGroup" type="button" class="btn btn-sm btn-success">Guardar</button>
        </div>
    </div>
</form>