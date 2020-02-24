 @extends("back_end.home")

@section('content')
@push('css')
    
    <link rel="stylesheet" href="{{ asset('/') }}css/jquery.dataTables.min.css">

@endpush

<div class="container p-"5>
    
      <table class="table table-bordered" id="users-table">
        <thead>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Email</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tfoot>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
        </tfoot>
    </table>
</div>


@push('js')
<script src="{{ asset('/') }}js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.colVis.min.js"></script>
     <script>
$(function() {
    //     $('#users-table tfoot th').each( function () {

    //     var title = $(this).text();
    //     $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
    // } );
    
   var table =  $('#users-table').DataTable({
         dom: 'lBfrtip',
         
        processing: true,
        serverSide: true,
        ajax: '{!! url("admin/get-members") !!}',

        buttons: [
            {
                extend: 'copyHtml5',
                exportOptions: {
                    columns: [ 0, ':visible' ]
                }
            },
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: ':visible'
                }
            },

             {
                extend: 'pdfHtml5',
                exportOptions: {
                     columns: ':visible'
                }
            },
     
            
            'colvis',
        ],
            
        columns: [
           {data : 'DT_RowIndex'},
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'created_at', name: 'created_at' },
            { data: 'updated_at', name: 'updated_at' },
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ],





         initComplete: function () {

            this.api().columns([1]).every( function () {
          var column = this;
           //  console.log(this);
                        var select = $('<select><option value=""></option></select>')
                            .appendTo( $(column.footer()).empty() )
                            .on( 'change', function () {

                            var val = $.fn.dataTable.util.escapeRegex($(this).val());
                            
                            column.search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                        });
                        column.data().unique().sort().each( function ( d, j )
                        {
                          
                            select.append( '<option value="'+d+'">'+d+'</option>' )
                              //console.log(   column);
                        });
            } );
        }


    });

    //  table.columns().every( function () {
    //     var that = this;
 
    //     $( 'input', this.footer() ).on( 'keyup change', function () {
    //         if ( that.search() !== this.value ) {
    //             that
    //                 .search( this.value )
    //                 .draw();
    //         }
    //     } );
    // } );
});
</script>
@endpush


@endsection