            <form>
                <br>
                <div class="row">
                    <div class="col-md-3 col-md-offset-4">
                        <input type="text" class="form-control" id="nameProfile" placeholder="Nombre del Perfil"/>
                    </div>
                </div><br>
                <div class="row">
                    <div class="col-sm-5 col-md-offset-4">
                        <label>Destinos</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-5 col-md-offset-4">
                        <select id="dual5" name="dstselect" multiple="multiple" class="fieldLoader" size='10'>
                        </select>
                        <input id="anadirDst" class="btn btn-success btn-sm" type="button" value="->"/>
                        <input id="quitarDst" class="btn btn-success btn-sm" type="button" value="<-"/>
                        <select id="dual6" multiple="multiple" name="agtselected[]" class="fieldLoader" size='10'>
                            <?php //echo $cmps; ?>
                        </select>
                    </div>
                </div><br>
                <div class="row">
                    <div class="col-md-3 col-md-offset-4">
                        <button type="button" id="saveProfile" class="btn btn-sm btn-success">Guardar</button>
                    </div>
                </div>
            </form>