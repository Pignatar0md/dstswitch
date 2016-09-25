<div class="container">
            <form class="form-signin" action="controllers/Login.php" method="post" role="form">
                <div class="row"><br><br>
                    <div class="col-md-5 col-md-offset-6">
                        <img src="static/img/lg2.png" width="160" height="76" border="0">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-md-offset-4">
                        <h3 style="color: #fd5019" class="form-signin-heading">Bienvenidos</h3><br>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-md-offset-4">
                        <input type="text" name="usuario" for="user" class="form-control" placeholder="Usuario" required autofocus>
                    </div>
                </div><br>
                <div class="row">
                    <div class="col-md-4 col-md-offset-4">
                        <input type="password" name="clave" class="form-control" placeholder="Clave" required>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-4 col-md-offset-4">
                        <button class="btn btn-lg btn-success btn-block" value="login" name="login" type="submit">Ingresar</button>
                    </div>
                    <?php
                    $auth = isset($_GET['auth']) ? $_GET['auth'] : null;
                    if ($auth != null) {
                        echo '<div class="row">
                                <div class="col-md-4 col-md-offset-4"><br>
                                    <label style="color: darkred">&nbsp;&nbsp;Usuario o clave incorrecta.</label>
                                </div>
                                </div>';
                    }
                    ?>
                </div>
            </form>
        </div>