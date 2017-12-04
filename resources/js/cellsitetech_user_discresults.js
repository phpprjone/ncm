$(document).ready(function() {
      
         var table =  $('#example').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":"cellt_server_discresultsprocess.php",   
          "pageLength": 25,       
            "language": {
            "lengthMenu": "Display _MENU_ records per page",
            "zeroRecords": "No records found",
            "info": "Showing page _PAGE_ of _PAGES_",
            "infoEmpty": "",
            "infoFiltered": ""
            },
          "columns": [
            {  
                "orderable":      false,
                "data":           null,
                "defaultContent": ''},
            { "data": "scantime" },
            { "data": "deviceipaddr" },
            { "data": "ping" },
            { "data": "deviceid" },
            { "data": "deviceos" },
            { "data": "nodeversion" },
            { "data": "deviceseries" },
            { "data": "processed" },
        ],
        "order": [[1, 'asc']],
            // Per-row function to iterate cells
        "createdRow": function (row, data, rowIndex) {
             $(row).addClass('device_row');

        }
      } );       
});