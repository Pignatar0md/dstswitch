$(function () {
    function validate_fechaMayorQue(fechaInicial, fechaFinal) {
                valuesStart = fechaInicial.split('/');
                valuesEnd = fechaFinal.split('/');
                // Verificamos que la fecha no sea posterior a la actual
                var mensaje = '';
                var dateStart = new Date(valuesStart[2], (valuesStart[1] - 1), valuesStart[0]);
                var dateEnd = new Date(valuesEnd[2], (valuesEnd[1] - 1), valuesEnd[0]);
                if (dateStart > dateEnd)
                {
                    mensaje = 'El rango de tiempo es inválido. Asegúrese que Fecha Hasta sea mayor que Fecha Desde.';
                }
                return mensaje;
            }
            function validate_hour(m, n) {
                x = m.split(':');
                y = n.split(':');
                var mensaje = '';
                if (x[0] >= y[0]) {
                    mensaje = 'Rango de tiempo invalido. Asegurese que Hora Hasta sea mayor que Hora Desde.';
                }
                return mensaje;
            }
});