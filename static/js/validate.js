function validar(valor, type) {
    debugger;
    var ok = true;
    var textExp = /[!@#$%\^&*\(\)-=+_,<>/?;:\[\{\}\]'"]/;
    if(type == "num") {
        if(isNaN(valor)) {
            ok = false;
        }
    } else if(type == "text") {
        if(textExp.test(valor)) {
            ok = false;
        }
    } else if(type == "combo") {
        if(valor != 0 && valor != null) {
            ok = true;
        }
    }
    return ok;
}