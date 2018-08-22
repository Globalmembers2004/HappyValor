$(function () {


    BuscarDatos('1');
});

var datagrid = new DataList('gvDatos', {
    actionbar: 'generic-actionbar',
    onSearch: function () {
        BuscarDatos(datagrid.currentPage());
    }
});

function BuscarDatos (pagina) {
    precargaExp('#pnlListado', true);

    $.ajax({
        url: 'services/ventas/ventas-search.php',
        type: 'GET',
        cache: false,
        dataType: 'json',
        data: {
            tipobusqueda:'1',
            idempresa: $('#hdIdEmpresa').val(),
            idcentro: $('#hdIdCentro').val(),
            criterio: $('#txtSearch').val(),
            pagina: pagina
        },
        success: function (data) {
            var countdata = data.length;
            var i = 0;
            var strhtml = '';

            if (countdata > 0) {
                while(i < countdata){
                    var importe_sinimpuesto = data[i].SimboloMoneda + ' ' + Number(data[i].tm_base_imponible).toFixed(2);
                    var importe_impuesto = data[i].SimboloMoneda + ' ' + Number(data[i].tm_impuesto).toFixed(2);
                    var importe_conimpuesto = data[i].SimboloMoneda + ' ' + Number(data[i].tm_total).toFixed(2);

                    strhtml += '<div ';
                    strhtml += 'data-id="' + data[i].tm_idventa + '" ';

                    strhtml += 'class="result item pos-rel animate mdl-shadow--2dp margin10">';
                    
                    strhtml += '<div class="col-md-4">';
                    strhtml += '<h4>ID Venta #' + data[i].tm_idventa + '</h4>';

                    strhtml += '<p class="lugar"><strong>Cod. Venta: </strong>' + data[i].CodigoVenta + '</p>';
                    strhtml += '<p class="lugar"><strong>Tipo de comprobante: </strong>' + data[i].TipoComprobante + '</p>';
                    strhtml += '<p class="lugar"><strong>Fecha: </strong>' + ConvertMySQLDate(data[i].tm_fecha_emision) + '</p>';
                    strhtml += '</div>';
                    
                    strhtml += '<div class="col-md-4">';
                    strhtml += '<h4>Cliente:</h4>';
                    // strhtml += '<p><span class="horario">El d&iacute;a: ' + fecha +  ', desde las: ' + horainicio + ' hasta las ' + horafinal + ' </span><br />';
                    strhtml += '<span class="duracion">' + data[i].Cliente + '</span>';
                    // strhtml += '</p>';
                    // strhtml += '<h4><span class="label label-' + data[i].color_estado_requerimiento + '">' + data[i].text_estado_requerimiento + '</span></h4>';
                    strhtml += '</div>';
                    
                    strhtml += '<div class="col-md-4">';
                    strhtml += '<h4 class="text-center">Monto de venta</h4>';

                    strhtml += '<h5 class="row"><strong class="col-md-4">Base imponible: </strong><span class="col-md-8 blue-text text-right">' + importe_sinimpuesto + '</span></h5>';
                    strhtml += '<h5 class="row"><strong class="col-md-4">Impuestos deducidos: </strong><span class="col-md-8 blue-text text-right">' + importe_impuesto + '</span></h5>';
                    strhtml += '<h5 class="row"><strong class="col-md-4">Total de importe: </strong><span class="col-md-8 blue-text text-right">' + importe_conimpuesto + '</span></h5>';
                    // strhtml += '<h4 class="text-center">Vacantes</h4>';
                    // strhtml += '<h4 class="text-center blue-text">' + cantidad + '</h4>';
                    // strhtml += '</div>';
                    
                    // strhtml += '</div>';
                    
                    // strhtml += '<small class="text-muted margin10 place-bottom-right"><i class="fa fa-clock-o"></i> Publicado el: ' + fecha_reg + '</small>';
                    strhtml += '<div class="clear"></div>';
                    strhtml += '</div>';

                    strhtml += '</div>';

                    ++i;
                };

                datagrid.currentPage(datagrid.currentPage() + 1);

                if (pagina == '1')
                    $('#gvDatos').html(strhtml);
                else
                    $('#gvDatos').append(strhtml);
            }
            else {
                if (pagina == '1')
                    $('#gvDatos').html('<h2>No se encontraron resultados.</h2>');
            };

            precargaExp('#pnlListado', false);
        },
        error: function (error) {
            console.log(error);
        }
    });
}