 @extends('layouts.app')
@section('content')
<div class="content">
    <div class="container-fluid">
		<div class="row">
			<div class="col-lg-12 col-md-11">
				 <div class="card">
					<div class="header">
						<h4 class="title"><?php echo trans('lang.expense_monthly_report');?> (<?php echo date("Y");?>)</h4>
					</div>
					<div class="content">
						<div class="table-responsive">
						<table id="monthlyreportsexpense" class="table table-striped table-bordered"  cellspacing="0" width="100%">
							<thead style="font-size:10px;background:#e3f1f4">
                                <tr>
                                    <th class="bold"><b><?php echo trans('lang.category');?></b></th>
                                    <th class="bold"><b><?php echo trans('lang.jan');?></b></th>  
									<th class="bold"><b><?php echo trans('lang.feb');?></b></th>  
									<th class="bold"><b><?php echo trans('lang.mar');?></b></th>  
									<th class="bold"><b><?php echo trans('lang.apr');?></b></th>  
									<th class="bold"><b><?php echo trans('lang.may');?></b></th>  
									<th class="bold"><b><?php echo trans('lang.jun');?></b></th>  
									<th class="bold"><b><?php echo trans('lang.jul');?></b></th>  
									<th class="bold"><b><?php echo trans('lang.aug');?></b></th>  
									<th class="bold"><b><?php echo trans('lang.sep');?></b></th>  
									<th class="bold"><b><?php echo trans('lang.oct');?></b></th>  
									<th class="bold"><b><?php echo trans('lang.nov');?></b></th>  
									<th class="bold"><b><?php echo trans('lang.dec');?></b></th>                                        
									<th class="bold"><b><?php echo trans('lang.total');?></b></th>   
								</tr>
                            </thead>
								<tfoot>
									<th  style="text-align:; margin-right: 10px;">Total:</th>
									<th  style="text-align:; margin-right: 10px;">Total:</th>
									<th  style="text-align:; margin-right: 10px;">Total:</th>
									<th  style="text-align:; margin-right: 10px;">Total:</th>
									<th  style="text-align:; margin-right: 10px;">Total:</th>
									<th  style="text-align:; margin-right: 10px;">Total:</th>
									<th  style="text-align:; margin-right: 10px;">Total:</th>
									<th  style="text-align:; margin-right: 10px;">Total:</th>
									<th  style="text-align:; margin-right: 10px;">Total:</th>
									<th  style="text-align:; margin-right: 10px;">Total:</th>
									<th  style="text-align:; margin-right: 10px;">Total:</th>
									<th  style="text-align:; margin-right: 10px;">Total:</th>
									<th  style="text-align:; margin-right: 10px;">Total:</th>
						            <th></th>		
								</tfoot>
							<tbody style="font-size:12px;">
							
							</tbody>
						</table>
						</div>
					</div>
				 </div>
			</div> 
		</div>

    </div>
</div>	


<script>


$(document).ready(function() {
	$.ajaxSetup({
       headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'), sameSite: "None",
        secure: true,
        httpOnly: true
       }
	});
	
	
	
	//get data
    var table = $('#monthlyreportsexpense').DataTable( {
			
			processing: true,
			serverSide: true,
			bFilter : false,
            ajax: {
				url : "{{ url('reports/getexpensemonthly')}}",
				
			},
			"language": {
            "decimal":        "",
                "emptyTable":     "<?php echo trans('lang.demptyTable');?>",
                "info":           "<?php echo trans('lang.dshowing');?> _START_ <?php echo trans('lang.dto');?> _END_ <?php echo trans('lang.dof');?> _TOTAL_ <?php echo trans('lang.dentries');?>",
                "infoEmpty":      "<?php echo trans('lang.dinfoEmpty');?>",
                "infoFiltered":   "(<?php echo trans('lang.dfilter');?> _MAX_ <?php echo trans('lang.total');?> <?php echo trans('lang.dentries');?>)",
                "infoPostFix":    "",
                "thousands":      ",",
                "lengthMenu":     "<?php echo trans('lang.dshow');?> _MENU_ <?php echo trans('lang.dentries');?>",
                "loadingRecords": "<?php echo trans('lang.dloadingRecords');?>",
                "processing":     "<?php echo trans('lang.dprocessing');?>",
                "search":         "<?php echo trans('lang.dsearch');?>",
                "zeroRecords":    "<?php echo trans('lang.dzeroRecords');?>",
                "paginate": {
                    "first":      "<?php echo trans('lang.dfirst');?>",
                    "last":       "<?php echo trans('lang.dlast');?>",
                    "next":       "<?php echo trans('lang.dnext');?>",
                    "previous":   "<?php echo trans('lang.dprevious');?>"
                }
            },
			columns: [
				{ data: 'category', name:'category'},
				{ data: 'ijan', name:'ijan'},
				{ data: 'ifeb', name:'ifeb'},
				{ data: 'imar', name:'imar'},				
				{ data: 'iapr', name:'iapr'},		
				{ data: 'imay', name:'imay'},
				{ data: 'ijun', name:'ijun'},
				{ data: 'ijul', name:'ijul'},
				{ data: 'iags', name:'iags'},
				{ data: 'isep', name:'isep'},
				{ data: 'iokt', name:'iokt'},
				{ data: 'inov', name:'inov'},
				{ data: 'idec', name:'idec'},
				{ data: 'total', name:'total'}
			],
			dom: 'lBfrtip',
			lengthMenu: [
            [ 10, 25, 50, -1 ],
            [ 10, 25, 50, "All"]
        ],

			buttons: [
				{
					extend: 'copy',
					footer: true,
					text:   'Copy <i class="fa fa-files-o"></i>',
					title: '<?php echo trans('lang.expense_monthly_report');?>',
					className: 'btn btn-sm btn-fill btn-info ',
					exportOptions: {
						columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13]
					}
					
				}, 
				{
					extend:'csv',
					charset: 'UTF-8',
                    bom: true,
					footer: true,
					text:   'CSV <i class="fa fa-file-excel-o"></i>',
					title: '<?php echo trans('lang.expense_monthly_report');?>',
					className: 'btn btn-sm btn-fill btn-info ',
					exportOptions: {
						columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13]
					},
					
			      
				},
				{
					extend:'pdf',
					text:   'PDF <i class="fa fa-file-pdf-o"></i>',
					title: '<?php echo trans('lang.expense_monthly_report');?>',
					className: 'btn btn-sm btn-fill btn-info ',
					orientation:'landscape',
					 pageSize: 'A3',
					footer: true,
					exportOptions: {
						columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13]
					},
					customize : function(doc){
						doc.styles.tableHeader.alignment = 'left';
						doc.content[1].table.widths = Array(doc.content[1].table.body[0].length + 1).join('*').split('');
					}
				},
				{
					extend:'print',
					title: '<?php echo trans('lang.expense_monthly_report');?>',
					text:   'Print <i class="fa fa-print"></i>',
					className: 'btn btn-sm btn-fill btn-info ',
					footer: true,
					exportOptions: {
						columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13]
					}
					
				}
			],

			  "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
               return typeof i === 'string' ? i.replace(/[\₦,]/g, '') * 1 : typeof i === 'number' ? i : 0;
            };
  //for jan column
            var pageTotal = api
                .column(1)
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column(1).footer() ).html( 
             '₦'+ pageTotal
            );

            // 
// for feb column
			var pageTotal1 = api
                .column(2)
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column(2).footer() ).html( 
             '₦'+ pageTotal1 
            );	           

// for march column  
               	var pageTotal2 = api
                .column(3)
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column(3).footer() ).html( 
             '₦'+ pageTotal2 
            );	

 // for april column           
            	var pageTotal3 = api
                .column(4)
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column(4).footer() ).html( 
             '₦'+ pageTotal3 
            );	

      // for May column      
            	var pageTotal4 = api
                .column(5)
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column(5).footer() ).html( 
             '₦'+ pageTotal4
            );	
       //  for june column    
            	var pageTotal5 = api
                .column(6)
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column(6).footer() ).html( 
             '₦'+ pageTotal5 
          );	

            // for july column 
            	var pageTotal6 = api
                .column(7)
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column(7).footer() ).html( 
             '₦'+ pageTotal6 
            );	
            
            //for august column
            	var pageTotal7 = api
                .column(8)
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column(8).footer() ).html( 
             '₦'+ pageTotal7 
           );	
           
            // for september column
            	var pageTotal8 = api
                .column(9)
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column(9).footer() ).html( 
             '₦'+ pageTotal8
            );

            // for oct column	
            	var pageTotal9 = api
                .column(10)
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column(10).footer() ).html( 
             '₦'+ pageTotal9             	
            );	

            // for nov column
            	var pageTotal10 = api
                .column(11)
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column(11).footer() ).html( 
             '₦'+ pageTotal10 
         	);	

         	// for the dec column
            	var pageTotal11 = api
                .column(12)
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column(12).footer() ).html( 
             '₦'+ pageTotal11 
            );	

            	var pageTotal12 = api
                .column(13)
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column(13).footer() ).html( 
             '₦'+ pageTotal12
            );	
        },
    } );
	
	
		
} );


</script>
@endsection