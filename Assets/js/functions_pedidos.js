//MOSTRAR TABLA DE PEDIDOS
let tablePedidos;
tablePedidos = $('#tablePedidos').DataTable({
    "aProcessing":true,
    "aServerside":true,
    "language": {
        "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json" 
    },
    "ajax":{
        "url": " "+base_url+"/Pedidos/getPedidos",
    "dataSrc":""
    },
    "columns":[
        {"data":"idpedido"},
        {"data":"transaccion"},
        {"data":"fecha"},
        {"data":"monto"},
        {"data":"tipopago"},
        {"data":"status"},
        {"data":"options"}
    ],
    //centrar las columnas 
    "columnDefs": [     
                        { 'className': "textcenter","targets":[0]},
                        { 'className': "textcenter","targets":[1]},
                        { 'className': "textcenter","targets":[2]},
                        { 'className': "textcenter", "targets": [3]}, //la columna 3 se alinea en el centro
                        { 'className': "textcenter", "targets": [4]}, //la columna 4 se alinea hacia la derecha
                        { 'className': "textcenter", "targets": [5]}, //la columna 5 se alinea en el centro
                    ],
    'dom': 'lBfrtip',
    'buttons': [
            {
            "extend": "excelHtml5", 
            "text": "<i class='fas fa-file-excel'></i> Excel",
            "titleAttr": "Exportar a Excel",
            "className": "btn btn-success",
            "exportOptions": {
                //indicamos las columnas que vamos a exportar
                "columns":  [0, 1, 2, 3, 4, 5]

            }
            },{
            "extend": "pdfHtml5",
            "text": "<i class='fas fa-file-pdf'></i> PDF",
            "titleAttr": "Exportar a PDF",
            "className": "btn btn-danger",
            "exportOptions": {
                //indicamos las columnas que vamos a exportar
                "columns": [0, 1, 2, 3, 4, 5]
            }
            }
    ],
    "responsieve":"true",
    "bDestroy": true,
    "iDisplayLength": 10, 
    "order":[[0,"asc"]] 

});