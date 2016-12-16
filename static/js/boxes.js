function busqueda(pattern, element) {
    var find = false;
    var needle = pattern.selectedIndex;
    var nameneedle = pattern.options[needle];
    var selectednameneedle = nameneedle.value;
    var cdad = element.length;
    if (cdad > 0) {
        for (i = 0; i < cdad; i++) {
            var hay = element.options[i];
            var hayToCompare = hay.value;
            if (selectednameneedle == hayToCompare) {
                find = true;
            }
        }
    }
    return find;
}
function cargarExtensiones() {
    var extToSelec = document.getElementById("dual1");
    var extSelected = document.getElementById("dual2");
    var seleccionados = extToSelec.selectedOptions;
    var z = 0;
    var length = seleccionados.length;
    while (z < length) {
        var encontrado = busqueda(extToSelec, extSelected);
        var child = seleccionados[0];
        if (encontrado == false) {
            extSelected.appendChild(child);
        } else {
            extToSelec.removeChild(child);
        }
        z++;
    }
}
function quitarExtensiones() {
    var campana1 = document.getElementById("dual1");
    var campana2 = document.getElementById("dual2");
    var optseleccionados = campana2.selectedOptions;
    var z = 0;
    var length = optseleccionados.length;
    while (z < length) {
        var encontrado = busqueda(campana2, campana1);
        var child = optseleccionados[0];
        if (encontrado == false) {
            campana1.appendChild(child);
            campana1.appendChild(child).selected = false;
        } else {
            campana2.removeChild(child);
        }
        z++;
    }
}
function cargarPins() {
    var Selected = document.getElementById("dual3");
    var Selec = document.getElementById("dual4");
    var seleccionados = Selected.selectedOptions;
    var z = 0;
    var length = seleccionados.length;
    while (z < length) {
        var encontrado = busqueda(Selected, Selec);
        var child = seleccionados[0];
        if (encontrado == false) {
            Selec.appendChild(child);
        } else {
            Selected.removeChild(child);
        }
        z++;
    }
}
function quitarPins() {
    var campana1 = document.getElementById("dual3");
    var campana2 = document.getElementById("dual4");
    var optseleccionados = campana2.selectedOptions;
    var z = 0;
    var length = optseleccionados.length;
    while (z < length) {
        var encontrado = busqueda(campana2, campana1);
        var child = optseleccionados[0];
        if (encontrado == false) {
            campana1.appendChild(child);
            campana1.appendChild(child).selected = false;
        } else {
            campana2.removeChild(child);
        }
        z++;
    }
}
function cargarDestinos() {
    var Selec = document.getElementById("dual5");
    var Selected = document.getElementById("dual6");
    var seleccionados = Selec.selectedOptions;
    var z = 0;
    var length = seleccionados.length;
    while (z < length) {
        var encontrado = busqueda(Selec, Selected);
        var child = seleccionados[0];
        if (encontrado == false) {
            Selected.appendChild(child);
        } else {
            Selec.removeChild(child);
        }
        z++;
    }
}
function quitarDestinos() {
    var campana1 = document.getElementById("dual5");
    var campana2 = document.getElementById("dual6");
    var optseleccionados = campana2.selectedOptions;
    var z = 0;
    var length = optseleccionados.length;
    while (z < length) {
        var encontrado = busqueda(campana2, campana1);
        var child = optseleccionados[0];
        if (encontrado == false) {
            campana1.appendChild(child);
            campana1.appendChild(child).selected = false;
        } else {
            campana2.removeChild(child);
        }
        z++;
    }
}
//funcion que quita un elem de un dual y devuelve un elem para agregar al otro dual
function quitAndMake(value, dualToQuit) {
    var optToReturn;
    for (i = 0; i < dualToQuit[0].length; i++) {
        if (dualToQuit.children()[i].value == $.trim(value)) {
            optToReturn = dualToQuit.children()[i];
            dualToQuit.children()[i].parentNode.removeChild(dualToQuit.children()[i]);
            break;
        }
    }
    return optToReturn;
}
//---------------------------------------------------------------------------------
$(function () {
    $("#anadirExt").click(function () {
        cargarExtensiones();
    });
    $("#quitarExt").click(function () {
        quitarExtensiones();
    });
    $("#anadirPin").click(function () {
        cargarPins();
    });
    $("#quitarPin").click(function () {
        quitarPins();
    });
    $("#anadirDst").click(function () {
        cargarDestinos();
    });
    $("#quitarDst").click(function () {
        quitarDestinos();
    });
});