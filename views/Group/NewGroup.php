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
            <input type="text" class="form-control" id="groupName" placeholder="Nombre grupo"/>
        </div>
    </div><br>
    <div class="row">
        <div class="col-sm-5 col-md-offset-4">
            <label>Extensiones</label>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-5 col-md-offset-4">
            <select id="dual1" name="extselect" multiple="multiple" class="fieldLoader" size='8'>
            </select>
            <input id="anadirExt" class="btn btn-sm btn-success" type="button" value="->"/>
            <input id="quitarExt" class="btn btn-sm btn-success" type="button" value="<-"/>
            <select id="dual2" multiple="multiple" name="extselected[]" class="fieldLoader" size='8'>
            </select>
        </div>
    </div><br>
    <div class="row">
        <div class="col-sm-5 col-md-offset-4">
            <label>Pines</label>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-5 col-md-offset-4">
            <select id="dual3" name="pinselect" multiple="multiple" class="fieldLoader" size='8'>
            </select>
            <input id="anadirPin" class="btn btn-sm btn-success" type="button" value="->"/>
            <input id="quitarPin" class="btn btn-sm btn-success" type="button" value="<-"/>
            <select id="dual4" multiple="multiple" name="pinselected[]" class="fieldLoader" size='8'>
            </select>
        </div>
    </div><br>
    <div class="row">
        <div class="col-md-3 col-md-offset-4">
            <select id="comboProfile" class="form-control">
                <option>Selec. Perfil</option>
            </select>
        </div>
    </div><br>
    <div class="row">
        <div class="col-md-3 col-md-offset-4">
            <button id="saveGroup" type="button" class="btn btn-sm btn-success">Guardar</button>
        </div>
    </div>
</form>