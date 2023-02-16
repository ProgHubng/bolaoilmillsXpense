 @extends('layouts.app')
@section('content')
<div class="content">
    <div class="container-fluid">
		<div class="row">
			<div class="col-lg-12 col-md-11">
				 <div class="card">
					<div class="header">
						<h4 class="title">Expense Reports</h4>
					</div>
					<div class="content">
						<div class="row">
							<form action="" method="POST" id="form">

							<div class="col-lg-4">
							 <label><?php echo trans('lang.name');?></label>
							 <input id="name" type="text" class="form-control" name="name" placeholder="<?php echo trans('lang.name');?>"/>
							</div>	
								
							<div class="col-lg-4">
							 <label><?php echo trans('lang.category');?></label>
							 <select id="category" class="form-control" name="category" required>
							 <option value=""><?php echo trans('lang.select_a_category');?></option>
							 </select>
							</div>
							<div class="col-lg-4">
							 <label><?php echo trans('lang.sub_category');?></label>
							 <select id="subcategory" class="form-control" name="subcategory">
							 </select>
							</div>
							
						</div>
						<div class="row">
							<div class="col-lg-4">
							<label for="date" class="control-label"> 
									<?php echo trans('lang.from_date');?></label>
									<div  class="input-group date" data-date-format="mm-dd-yyyy">
										<input id="fromdate" name="fromdate" class="form-control" type="text" value=""/>
										<span class="input-group-addon" style="border: 1px solid #cecece;"><i class="fa fa-calendar"></i></span>
									</div>
							</div>
							<div class="col-lg-4">
							<label for="date" class="control-label"> 
									<?php echo trans('lang.to_date');?></label>
									<div  class="input-group date" data-date-format="mm-dd-yyyy">
										<input id="todate" name="todate" class="form-control" type="text" value=""/>
										<span class="input-group-addon" style="border: 1px solid #cecece;"><i class="fa fa-calendar"></i></span>
									</div>
							</div>
						</div>							
						<div class="row">
								<div class="col-lg-2">
									<button type="submit" class="form-control btn btn-sm btn-fill btn-info"><i class="ti-search"></i> <?php echo trans('lang.search');?></button>
								</div>
						</div>
							</form>
						
					</div>
				 </div>
			</div> 
		</div>
		
        <div class="row">

            <div class="col-lg-12 col-md-11">
                <div class="card">
                    <div class="header">
						<h4 class="title"><?php echo trans('lang.expense_reports');?></h4>
                    </div>
                    <div class="content">
					<div class="table-responsive">
						<table id="data" class="table table-striped table-bordered"  cellspacing="0" width="100%">
							<thead>
								<tr>

									<th><?php echo trans('lang.name');?></th>
									<th><?php echo trans('lang.category');?></th>
									<th><?php echo trans('lang.sub_category');?></th>
									<th><?php echo trans('lang.account');?></th>
									<th><?php echo trans('lang.amount');?> ₦</th>
									<th><?php echo trans('lang.date');?></th>											
								</tr>
							</thead>
							<tfoot>
								<tr>

									<!-- <th><?php echo trans('lang.name');?></th>
									<th><?php echo trans('lang.category');?></th>
									<th><?php echo trans('lang.sub_category');?></th>
									<th><?php echo trans('lang.account');?></th>
									<th><?php echo trans('lang.amount');?></th>
									<th><?php echo trans('lang.date');?></th>		 -->

									
						            <th></th>
						            <th></th>
						            <th></th>
						            <th colspan="1" style="text-align:right; margin-right:10px;">Total:</th>
						            <th></th>
								</tr>
							</tfoot>
							<tbody>
							
							</tbody>

							 
 
						</table>
					</div>
                    </div>
                </div>
            </div>
        </div>
		<div class="row">
			<div class="col-lg-6">
				<div class="card">
					<div class="header">
						<div class="pull-left">
							<h5><b><?php echo trans('lang.12_monthly_expense_chart');?></b></h5>
						</div>
						<div class="pull-right">
							<div class="text-danger">
								<b><span id="currencys"></span><span id="totalyear"></span></b><br/>
								<small><?php echo trans('lang.in_this_year');?></small>
							</div>
						</div>
					</div>
					<div class="content">
					<input type="hidden" class="currency"/>
							<canvas id="chart1"></canvas>
					</div>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="card">
					<div class="header">
						<h5><b><?php echo trans('lang.expense_by_category');?> (<?php echo date("Y");?>)</b></h5>
					</div>
					<div class="content">
							<canvas id="chart2"></canvas>
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
	
	//Expense total
	$.ajax({
        type: "GET",
        url: "{{ url('expense/gettotal')}}",
        dataType: "json",
        data: "{}",
        success: function (data) {
			$("#totalyear").html(data.year);
			
        },
    });

	//get currency
	$.ajax({
        type: "GET",
        url: "{{ url('settings/getapplication')}}",
        dataType: "json",
        data: "{}",
        success: function (html) {
			var objs = html.data;
			$(".currency").val(objs[0].currency);
			$(".currencys").html(objs[0].currency);
        },
    });
   
	//get income category
	$.ajax({
        type: "GET",
        url: "{{ url('expensecategory/getdata')}}",
        dataType: "json",
        data: "{}",
        success: function (html) {
			var objs = html.data;
			jQuery.each(objs, function (index, record) {
                var id = decodeURIComponent(record.categoryid);
                var name = decodeURIComponent(record.name);
				//alert(name);
                $("#form #category").append($("<option></option>")
                    .attr("value",id)
                    .text(name));                 
            });
        },
    });
	
	//get income sub category
	$("#form #category").change(function(e){
		var id = $(this).val();
		$.ajax({
        type: "POST",
        url: "{{ url('expensecategory/subgetdatabycat')}}",
        dataType: "json",
        data: {id:id},
        success: function (html) {
			var objs = html.message;
			var options;
			if (objs.length === 0) {
				$('#subcategory').empty();
			}
			$.each(objs, function(index, object) {
					options += '<option value="' + object.subcategoryid + '">' + object.name + '</option>';
				});
				$('#form #subcategory').html(options);
			},
		});
	});
	
	//get data
    var table = $('#data').DataTable( {
		

			processing: true,
			serverSide: true,
			filter : false,
			order:true,
			select: true,
			
            ajax: {
				url : "{{ url('reports/gettransactions')}}",
				data: function (d) {
					d.type 		= '2';
					d.category = $('select[name=category]').val();
					d.names = $('input[name=name]').val();
					//d.category = 'Salary';
					d.subcategory = $('select[name=subcategory]').val();
					d.fromdate = $('input[name=fromdate]').val();
					d.todate = $('input[name=todate]').val();
				},
			},
			"language": {
            "decimal":        "",
                "emptyTable":     "<?php echo trans('lang.demptyTable');?>",
                "info":           "<?php echo trans('lang.dshowing');?> _START_ <?php echo trans('lang.dto');?> _END_ <?php echo trans('lang.dof');?> _TOTAL_ <?php echo trans('lang.dentries');?>",
                "infoEmpty":      "<?php echo trans('lang.dinfoEmpty');?>",
                "infoFiltered":   "(<?php echo trans('lang.dfilter');?> _MAX_ <?php echo trans('lang.total');?> <?php echo trans('lang.dentries');?>)",
                "infoPostFix":    "",
                "thousands":      ",",
                // "lengthMenu":     "<?php echo trans('lang.dshow');?> _MENU_ <?php echo trans('lang.dentries');?>",
                // "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
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
				{ data: 'name', name:'name'},
				{ data: 'category', name:'category'},
				{ data: 'subcategory', name:'subcategory'},
				{ data: 'account', name:'account'},				
				{ data: 'amount', name:'amount'},		
				{ data: 'transactiondate', name:'transactiondate'},

			],
			dom: 'l	Bfrtip',
			// dom: '<"top"i>rt<"bottom"flp><"clear">',
			lengthMenu: [
            [ 10, 25, 50, -1 ],
            [ 10, 25, 50, "All"]
        ],

			buttons: [
				{
					extend: 'copy',
					text:   'Copy <i class="fa fa-files-o"></i>',
					pages: 'all',
					title: '<?php echo trans('lang.expense_reports');?>',
					className: 'btn btn-sm btn-fill btn-info ',
					footer: true,
					exportOptions: {
						columns: [ 0, 1, 2, 3, 4, 5],
						
					}					
				}, 
				{
					extend:'csv',
					charset: 'UTF-8',
					bom:true,
					text:   'CSV <i class="fa fa-file-excel-o"></i>',
					title: '<?php echo trans('lang.expense_reports');?>',
					pages: 'All',
					className: 'btn btn-sm btn-fill btn-info ',
					footer: true,
					exportOptions: {
						columns: [ 0, 1, 2, 3, 4, 5 ]
					}
				},
                {
                    extend: 'csv',
                    charset: 'UTF-8',
                    bom: true,
                    text: 'Export All (CSV) <i class="fa fa-file-excel-o"></i>',
                    title: '<?php echo trans('lang.expense_reports');?>',
                    className: 'btn btn-sm btn-fill btn-info ',
                    action: newexportaction,
                    footer: true,
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4, 5 ],
                  
                    },
                },
				{
					extend:'pdfHtml5',
					text:   'PDF <i class="fa fa-file-pdf-o"></i>',
					title: '<?php echo trans('lang.expense_reports');?>',
					className: 'btn btn-sm btn-fill btn-info ',
					orientation:'landscape',
					footer: true,
					exportOptions: {
						columns: [0, 1, 2, 3, 4, 5]
					},
					customize : function(doc){
						doc.styles.tableHeader.alignment = 'left';
						doc.content[1].table.widths = Array(doc.content[1].table.body[0].length + 1).join('*').split('');
					}

				},
                {
                    extend: 'pdf',
                    text: 'Export All (PDF) <i class="fa fa-file-pdf-o"></i>',
                    title: '<?php echo trans('lang.expense_reports');?>',
                    className: 'btn btn-sm btn-fill btn-info ',
                    action: newexportaction,
                    orientation:'landscape',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                    },
                    customize : function(doc){
                        doc.styles.tableHeader.alignment = 'left';
                        doc.content[1].table.widths = Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                    }
                },

				{
					extend:'print',
					title: '<?php echo trans('lang.expense_reports');?>',
					text:   'Print <i class="fa fa-print"></i>',
					className: 'btn btn-sm btn-fill btn-info ',
					footer: true,
					exportOptions: {
						columns: [ 0, 1, 2, 3, 4, 5],
					
					},


				},

                {
                    extend: 'print',
                    footer: true,
                    text: 'Print All <i class="fa fa-print"></i>',
                    title: '<?php echo trans('lang.expense_reports');?>',
                    className: 'btn btn-sm btn-fill btn-info ',
                    action: newexportaction,
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                    },
                    

                },
			],
        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api();
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
            	// console.log("Value passed to intVal:", i);
              return typeof i === 'string' ? i.replace(/[\₦,]/g, '') * 1 : typeof i === 'number' ? i : 0;
            };
 
            // Total over all pages
            // var tot = api
            //     .column(4)
            //     .data()
            //     .reduce( function (a, b) {
            //         return intVal(a) + intVal(b);
            //     }, 0);
 
 	        //     // Total over this page
            // var pageTotal = api
            //     .column(4, { page: 'current'} )
            //     .data()
            //     .reduce( function (a, b) {
            //         return intVal(a) + intVal(b);
            //     }, 0 );


            var pageTotal = api
    .column(4, { page: 'current' } )
    .data()
    .reduce( function (a, b) {
        return intVal(a) + intVal(b);
    }, 0 );

// Total over all pages
var total = api
    .column(4)
    .data()
    .reduce( function (a, b) {
        return intVal(a) + intVal(b);
        // return parseInt(a) + parseInt(b);
        
    }, 0);
 
            // Update footer
            $( api.column(4).footer() ).html( 
             // '₦'+ tot +''
            	'₦'+pageTotal +' ( ₦'+ total +' total)'
            );


            // console.log("Total over all pages:", tot);
        },
 

    });


    function newexportaction(e, dt, button, config) {
        var self = this;
        var oldStart = dt.settings()[0]._iDisplayStart;
        dt.one('preXhr', function (e, s, data) {
            // Just this once, load all data from the server...
            data.start = 0;
            data.length = -1;
            dt.one('preDraw', function (e, settings) {
                // Call the original action function
                if (button[0].className.indexOf('buttons-copy') >= 0) {
                    $.fn.dataTable.ext.buttons.copyHtml5.action.call(self, e, dt, button, config);
                } else if (button[0].className.indexOf('buttons-excel') >= 0) {
                    $.fn.dataTable.ext.buttons.excelHtml5.available(dt, config) ?
                        $.fn.dataTable.ext.buttons.excelHtml5.action.call(self, e, dt, button, config) :
                        $.fn.dataTable.ext.buttons.excelFlash.action.call(self, e, dt, button, config);
                } else if (button[0].className.indexOf('buttons-csv') >= 0) {
                    $.fn.dataTable.ext.buttons.csvHtml5.available(dt, config) ?
                        $.fn.dataTable.ext.buttons.csvHtml5.action.call(self, e, dt, button, config) :
                        $.fn.dataTable.ext.buttons.csvFlash.action.call(self, e, dt, button, config);
                } else if (button[0].className.indexOf('buttons-pdf') >= 0) {
                    $.fn.dataTable.ext.buttons.pdfHtml5.available(dt, config) ?
                        $.fn.dataTable.ext.buttons.pdfHtml5.action.call(self, e, dt, button, config) :
                        $.fn.dataTable.ext.buttons.pdfFlash.action.call(self, e, dt, button, config);
                } else if (button[0].className.indexOf('buttons-print') >= 0) {
                    $.fn.dataTable.ext.buttons.print.action(e, dt, button, config);
                }
                dt.one('preXhr', function (e, s, data) {
                    // DataTables thinks the first item displayed is index 0, but we're not drawing that.
                    // Set the property to what it was before exporting.
                    settings._iDisplayStart = oldStart;
                    data.start = oldStart;
                });
                // Reload the grid with the original page. Otherwise, API functions like table.cell(this) don't work properly.
                setTimeout(dt.ajax.reload, 0);
                // Prevent rendering of the full data to the DOM
                return false;
            });
        });
        // Requery the server with the new one-time export settings
        dt.ajax.reload();
    }

	//do search
	$('#form').on('submit', function(e) {
        table.draw();
        e.preventDefault();
    });
	
	//income graph
	$.ajax({
        type: "GET",
        url: "{{ url('home/incomevsexpense')}}",
        dataType: "json",
        data: "{}",
        success: function (data) {
			// var cchart1 = document.getElementById("chart1");
			// var chart1 = 
			new Chart(document.getElementById("chart1"), {
				type: 'line',
				legendPosition: 'bottom',
				data: {
					labels: ["<?php echo trans('lang.jan');?>", "<?php echo trans('lang.feb');?>", "<?php echo trans('lang.mar');?>", "<?php echo trans('lang.apr');?>", "<?php echo trans('lang.may');?>", "<?php echo trans('lang.jun');?>", "<?php echo trans('lang.jul');?>", "<?php echo trans('lang.aug');?>", "<?php echo trans('lang.sep');?>", "<?php echo trans('lang.oct');?>", "<?php echo trans('lang.nov');?>", "<?php echo trans('lang.dec');?>"],
					datasets: [
					{
						label: 'Expense',
						data: [data.ejan, data.efeb, data.emar, data.eapr, data.emay, data.ejun, data.ejun, data.ejun, data.ejul, data.eags, data.esep, data.eokt, data.enov, data.edes],
						backgroundColor: 'rgba(255, 99, 132, 0.2)',
						borderColor:	'rgba(255,99,132,1)',
						borderWidth: 1
					}
					]
				},
				options: {
					 pieceLabel: {
					  // render 'label', 'value', 'percentage' or custom function, default is 'percentage'
					  render: 'label'
					 }, 
					legend: {
						   position: 'bottom',
						},
					tooltips: {
							mode: 'index',
							intersect: false,
							callbacks: {
								label: function(tooltipItem, data) {
									return $('.currency').val()+tooltipItem.yLabel.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
								},
							}
						},
					hover: {
							mode: 'nearest',
							intersect: true
						},
					scales: {
						yAxes: [{
							ticks: {
								beginAtZero:true,
								callback: function(value, index, values) {
								  if(parseInt(value) >= 1000){
									return  $('.currency').val()+value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
								  } else {
									return $('.currency').val() + value;
								  }
								}
							}
						}]
					}
				}
			});
			
        },
    });
	
	//incomebycategory
	$.ajax({
        type: "GET",
        url: "{{ url('home/expensebycategoryyearly')}}",
        dataType: "json",
        success: function (data) {
			var label = [];
			var amount = [];
			var color = [];
			
			for(var i in data) {
				label.push(data[i].category);
				amount.push(data[i].amount);
				color.push(data[i].color);
			}
// 			element.addEventListener("touchstart", function(event) {
//   // Event handler code here
// }, { passive: true });

			// var cchart2 = document.getElementById("chart2");
			// var chart2 = 
			new Chart(document.getElementById("chart2"), {
				type: 'bar',
				legendPosition: 'bottom',
				data: {
					labels: label,
					datasets: [
					{
						label: '<?php echo trans('lang.category');?>',
						data: amount,
						backgroundColor: 'rgba(255, 99, 132, 0.2)',
						borderColor:	'rgba(255,99,132,1)',
						borderWidth: 1
					}
					]
				},
				options: {
					passive: true,
					legend: {
						   position: 'bottom',
					},
					tooltips: {
					  callbacks: {
						title: function(tooltipItem, data) {
						  return data['labels'][tooltipItem[0]['index']];
						},
						label: function(tooltipItem, data) {
						  return $('.currency').val()+data['datasets'][0]['data'][tooltipItem['index']].toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
						}
					  },
					}
				}
			});
		}
	});	
		
} );

	$('#fromdate').datepicker({
            autoclose: true,
            dateFormat: "yy-mm-dd",
            todayHighlight: true
        });	
	$('#todate').datepicker({
            autoclose: true,
            dateFormat: "yy-mm-dd",
            todayHighlight: true
        });	

</script>
@endsection