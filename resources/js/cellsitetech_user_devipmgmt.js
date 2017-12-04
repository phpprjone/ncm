$(document).ready(function() {
      
         var table =  $('#example').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":"cellt_server_ipmgmtprocess.php",   
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
            
            { "data": "market" },
            { "data": "fromipvfour" },
            { "data": "toipvfour" },
            { "data": "fromipvsix" },
            { "data": "toipvsix" }
        ],
        "order": [[1, 'asc']],
            // Per-row function to iterate cells
        "createdRow": function (row, data, rowIndex) {
             $(row).addClass('device_row');

        }
      } ); 
         
         
         $('#ip-mgmt input[type="radio"]').click(function(){
             var inputValue = $(this).attr("value");
             if(inputValue == "ip-v4"){
            	 $('#ip-v4-grp-display').show();
            	 $('#ip-v6-grp-display').hide();
             }else{
            	 $('#ip-v6-grp-display').show();
            	 $('#ip-v4-grp-display').hide();
             }
             //alert(inputValue);
         });   
         
});