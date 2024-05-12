<? 
include './template/template_header.tpl';
if (empty($_SESSION['user_id'])):
	header('Location: /auth/');
	exit;
endif;
		$insertSql = $this->pdo->prepare("INSERT INTO activity_admin SET user_id = :user_id, text = :text, date = :date");
		$insertSql->execute([
			'user_id' => $_SESSION['user_id'],
			'text' => 'В разделе SIM-Банка',
			'date' => time()
			]);
?>
<!--  BEGIN CUSTOM STYLE FILE  -->
<link rel="stylesheet" type="text/css" href="/plugins/table/datatable/datatables.css">
<link rel="stylesheet" type="text/css" href="/plugins/table/datatable/dt-global_style.css">
<link rel="stylesheet" type="text/css" href="/assets/css/forms/theme-checkbox-radio.css">
<link href="/assets/css/apps/invoice-list.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="/assets/css/widgets/modules-widgets.css"> 
<link rel="stylesheet" type="text/css" href="/assets/css/elements/alert.css">
<link href="/plugins/notification/snackbar/snackbar.min.css" rel="stylesheet" type="text/css" />
	<link href="/assets/css/elements/search.css" rel="stylesheet" type="text/css" />
	<link href="/greeva/assets/libs/datatables/select.bootstrap4.min.css" rel="stylesheet" type="text/css" />

<!-- BEGIN THEME GLOBAL STYLES -->
<link href="/plugins/flatpickr/flatpickr.css" rel="stylesheet" type="text/css">
<link href="/plugins/noUiSlider/nouislider.min.css" rel="stylesheet" type="text/css">
<!-- END THEME GLOBAL STYLES -->

<!--  BEGIN CUSTOM STYLE FILE  -->
<link href="/assets/css/scrollspyNav.css" rel="stylesheet" type="text/css" />
<link href="/plugins/flatpickr/custom-flatpickr.css" rel="stylesheet" type="text/css">
<link href="/plugins/noUiSlider/custom-nouiSlider.css" rel="stylesheet" type="text/css">
<link href="/plugins//bootstrap-range-Slider/bootstrap-slider.css" rel="stylesheet" type="text/css">
<!--  END CUSTOM STYLE FILE  -->
<link rel="stylesheet" href="/assets/plugins/sweetalert2/sweetalert2.min.css">

<style>
.swal2-modal {
background-color: #0e1726 !important;
}
.swal2-styled.swal2-confirm {
border: 0;
border-radius: 0.25em;
background: initial;
background-color: #4361ee;
color: #fff;
font-size: 1em;
}
.swal2-styled.swal2-cancel {
border: 0;
border-radius: 0.25em;
background: initial;
background-color: #1b2e4b;
color: #fff;
font-size: 1em;
}
.swal2-title {
position: relative;
max-width: 100%;
margin: 0;
padding: 0.8em 1em 0;
color: #fff;
font-size: 1.875em;
font-weight: 600;
text-align: center;
text-transform: none;
word-wrap: break-word;
}
.dropdown-menu {
position: absolute;
top: 100%;
left: 0;
z-index: 1000;
display: none;
float: left;
min-width: 90%;
padding: 5px 0;
margin: 2px 0 0;
font-size: 14px;
text-align: left;
list-style: none;
background-color: #222430;
-webkit-background-clip: padding-box;
	  background-clip: padding-box;
border: 1px solid #ccc;
border: 1px solid rgba(0, 0, 0, .15);
border-radius: 4px;
-webkit-box-shadow: 0 6px 12px rgba(0, 0, 0, .175);
	  box-shadow: 0 6px 12px rgba(0, 0, 0, .175);
}
.dropdown-menu.pull-right {
right: 0;
left: auto;
}
.dropdown-menu .divider {
height: 1px;
margin: 9px 0;
overflow: hidden;
background-color: #e5e5e5;
}
.dropdown-menu > li > a {
display: block;
padding: 3px 20px;
clear: both;
font-weight: normal;
line-height: 1.42857143;
color: #a3ff12;
white-space: nowrap;
}
.dropdown-menu > li > a:hover,
.dropdown-menu > li > a:focus {
color: #262626;
text-decoration: none;
background-color: #f5f5f5;
}
.modal-backdrop {
background-color: #000; 
zoom: 90;
}
.widget-four {
position: relative;
background: #0e1726;
padding: 2px;
border-radius: 6px;
height: 100%;
box-shadow: none;
box-shadow: 0 0.1px 0px rgba(0, 0, 0, 0.002), 0 0.2px 0px rgba(0, 0, 0, 0.003), 0 0.4px 0px rgba(0, 0, 0, 0.004), 0 0.6px 0px rgba(0, 0, 0, 0.004), 0 0.9px 0px rgba(0, 0, 0, 0.005), 0 1.2px 0px rgba(0, 0, 0, 0.006), 0 1.8px 0px rgba(0, 0, 0, 0.006), 0 2.6px 0px rgba(0, 0, 0, 0.007), 0 3.9px 0px rgba(0, 0, 0, 0.008), 0 7px 0px rgba(0, 0, 0, 0.01);
}
.dataTables_filter, .dataTables_info { display: none; }
.table > tbody > tr > td .usr-img-frame {
background-color: transparent;
padding: 0px;
width: 35px;
height: 35px; }
.table > tbody > tr > td .usr-img-frame img {
width: 35px;
margin: 0; }

table.dataTable tbody > tr.selected,
table.dataTable tbody > tr > .selected {
background-color: #000;
}
table.dataTable.stripe tbody > tr.odd.selected,
table.dataTable.stripe tbody > tr.odd > .selected, table.dataTable.display tbody > tr.odd.selected,
table.dataTable.display tbody > tr.odd > .selected {
background-color: #000;
}
table.dataTable.hover tbody > tr.selected:hover,
table.dataTable.hover tbody > tr > .selected:hover, table.dataTable.display tbody > tr.selected:hover,
table.dataTable.display tbody > tr > .selected:hover {
background-color: #000;
}
table.dataTable.order-column tbody > tr.selected > .sorting_1,
table.dataTable.order-column tbody > tr.selected > .sorting_2,
table.dataTable.order-column tbody > tr.selected > .sorting_3,
table.dataTable.order-column tbody > tr > .selected, table.dataTable.display tbody > tr.selected > .sorting_1,
table.dataTable.display tbody > tr.selected > .sorting_2,
table.dataTable.display tbody > tr.selected > .sorting_3,
table.dataTable.display tbody > tr > .selected {
background-color: #000;
}
table.dataTable.display tbody > tr.odd.selected > .sorting_1, table.dataTable.order-column.stripe tbody > tr.odd.selected > .sorting_1 {
background-color: #000;
}
table.dataTable.display tbody > tr.odd.selected > .sorting_2, table.dataTable.order-column.stripe tbody > tr.odd.selected > .sorting_2 {
background-color: #000;
}
table.dataTable.display tbody > tr.odd.selected > .sorting_3, table.dataTable.order-column.stripe tbody > tr.odd.selected > .sorting_3 {
background-color: #000;
}
table.dataTable.display tbody > tr.even.selected > .sorting_1, table.dataTable.order-column.stripe tbody > tr.even.selected > .sorting_1 {
background-color: #000;
}
table.dataTable.display tbody > tr.even.selected > .sorting_2, table.dataTable.order-column.stripe tbody > tr.even.selected > .sorting_2 {
background-color: #000;
}
table.dataTable.display tbody > tr.even.selected > .sorting_3, table.dataTable.order-column.stripe tbody > tr.even.selected > .sorting_3 {
background-color: #afbdd8;
}
table.dataTable.display tbody > tr.odd > .selected, table.dataTable.order-column.stripe tbody > tr.odd > .selected {
background-color: #000;
}
table.dataTable.display tbody > tr.even > .selected, table.dataTable.order-column.stripe tbody > tr.even > .selected {
background-color: #000;
}
table.dataTable.display tbody > tr.selected:hover > .sorting_1, table.dataTable.order-column.hover tbody > tr.selected:hover > .sorting_1 {
background-color: #000;
}
table.dataTable.display tbody > tr.selected:hover > .sorting_2, table.dataTable.order-column.hover tbody > tr.selected:hover > .sorting_2 {
background-color: #000;
}
table.dataTable.display tbody > tr.selected:hover > .sorting_3, table.dataTable.order-column.hover tbody > tr.selected:hover > .sorting_3 {
background-color: #000;
}
table.dataTable.display tbody > tr:hover > .selected,
table.dataTable.display tbody > tr > .selected:hover, table.dataTable.order-column.hover tbody > tr:hover > .selected,
table.dataTable.order-column.hover tbody > tr > .selected:hover {
background-color: #000;
}
table.dataTable tbody td.select-checkbox,
table.dataTable tbody th.select-checkbox {
position: relative;
}
table.dataTable tbody td.select-checkbox:before, table.dataTable tbody td.select-checkbox:after,
table.dataTable tbody th.select-checkbox:before,
table.dataTable tbody th.select-checkbox:after {
display: block;
position: absolute;
top: 1.2em;
left: 50%;
width: 12px;
height: 12px;
box-sizing: border-box;
}
table.dataTable tbody td.select-checkbox:before,
table.dataTable tbody th.select-checkbox:before {
content: " ";
margin-top: -6px;
margin-left: -6px;
border: 1px solid black;
border-radius: 3px;
}
table.dataTable tr.selected td.select-checkbox:after,
table.dataTable tr.selected th.select-checkbox:after {
content: "✓";
font-size: 20px;
margin-top: -19px;
margin-left: -6px;
text-align: center;
text-shadow: 1px 1px #B0BED9, -1px -1px #B0BED9, 1px -1px #B0BED9, -1px 1px #B0BED9;
}
table.dataTable.compact tbody td.select-checkbox:before,
table.dataTable.compact tbody th.select-checkbox:before {
margin-top: -12px;
}
table.dataTable.compact tr.selected td.select-checkbox:after,
table.dataTable.compact tr.selected th.select-checkbox:after {
margin-top: -16px;
}

div.dataTables_wrapper span.select-info,
div.dataTables_wrapper span.select-item {
margin-left: 0.5em;
}

@media screen and (max-width: 640px) {
div.dataTables_wrapper span.select-info,
div.dataTables_wrapper span.select-item {
margin-left: 0;
display: block;
}
}
	.table > tbody > tr > td .inv-status.badge-success {
  background-color: rgba(26, 188, 156, 0.1);
  color: #1abc9c; }
.table > tbody > tr > td .inv-status.badge-danger {
  color: #e7515a;
  background-color: rgba(231, 81, 90, 0.09); }
.table > tbody > tr > td .inv-status.badge-wait {
  color: #FFB700;
  background-color: rgba(255, 183, 0, 0.09); }
  .table > tbody > tr > td .inv-status.badge-primary {
  color: #4361ee;
  background-color: rgba(67, 97, 238, 0.09); }
  
  .input-group .input-group-prepend .input-group-text {
border: 1px solid #1b2e4b;
background-color: #1b2e4b;
color: #888ea8; }
.input-group .input-group-prepend .input-group-text svg {
color: #888ea8; }
</style>
<style>
.bootstrap-select > .dropdown-toggle {
width: 100%;
padding-right: 25px;
z-index: 1; }
.bootstrap-select > .dropdown-toggle.bs-placeholder {
  color: #888ea8; }
  .bootstrap-select > .dropdown-toggle.bs-placeholder:hover, .bootstrap-select > .dropdown-toggle.bs-placeholder:focus, .bootstrap-select > .dropdown-toggle.bs-placeholder:active {
	color: #888ea8; }
.bootstrap-select > select {
position: absolute !important;
bottom: 0;
left: 50%;
display: block !important;
width: 0.5px !important;
height: 100% !important;
padding: 0 !important;
opacity: 0 !important;
border: 0; }
.bootstrap-select > select.mobile-device {
  top: 0;
  left: 0;
  display: block !important;
  width: 100% !important;
  z-index: 2; }
  swal2-html-container {
  z-index: 1;
  justify-content: center;
  margin: 0;
  padding: 1em 1.6em 0.3em;
  color: #FFF;
  font-size: 1.125em;
  font-weight: normal;
  line-height: normal;
  text-align: center;
  word-wrap: break-word;
  word-break: break-word;
}
.swal2-footer {
  justify-content: center;
  margin: 1em 0 0;
  padding: 1em 1em 0;
  border-top: 1px solid #eee;
  color: #FFF;
  font-size: 1em;
}
</style>	
<div class="row layout-top-spacing">
                
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
					
                        <div class="widget-content widget-content-area br-6">
						<div class="widget widget-table-one" style="margin-bottom:-45px;">
									<div class="widget-heading">
<h6 class="">Управление SIM-банком<span class="" style="font-size:12px;color:#888ea8;"><br>Просмор входящих смс сообщений.</span></h6>


</div></div>
 <div class="statbox widget box box-shadow" style="margin-bottom:-40px;">
                                <div class="widget-content widget-content-area text-center tags-content">
                                    <div class="demo-search-overlay"></div>

                                    <div class="full-search search-form-overlay">
                                        <form class="form-inline form-inline search mt-lg-0" role="search">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                                            <div class="search-bar">
                                                <input type="text" id="searchInput" class="form-control search-form-control  ml-lg-auto" placeholder="Поиск смс...">
                                            </div>
											
                                        </form>
										
                                    </div>
									<small id="emailHelp" class="form-text text-muted">Поиск доступен по следующим параметрам: от кого, текст, сумма, ID, порт, ID заявки.</small>
                                </div>
                            </div>
                            <table id="recordListing" class="table" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>От кого</th>
										<th>Порт</th>
										<th>Текст</th>
                                        <th>Заявка</th>
										<th>Сумма</th>
										<th>Баланс</th>
										<th>ID SMS</th>
                                    </tr>
                                </thead>
                               
                            </table>
                        </div>
                    </div>

					  
</div>
<div class="modal fade" id="recordModal">
											<div class="modal-dialog modal-dialog-centered" role="document">
												<div class="modal-content">
													<div class="modal-header">
														<h5 class="modal-title">Редактирование категории</h5>
														<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span>&times;</span>
														</button>
													</div>
													<form method="post" id="recordForm">
													<div class="modal-body">
								
								
								<span class="msg"></span>
									
													
													
												
												<input type="text" name="id" id="id" />
												<input type="hidden" name="action" id="action" value="" />
												<input type="submit" name="save" id="save" class="btn btn-block btn-primary" value="Сохранить изменения" />
													
													</form>
												</div>
											</div>
										</div> 

		</div>	
              <? include './template/template_footer.tpl'; ?>
    <!-- END GLOBAL MANDATORY SCRIPTS -->
    <script src="/plugins/table/datatable/datatables.js"></script>
    <script src="/plugins/table/datatable/button-ext/dataTables.buttons.min.js"></script>
	 <script src="https://cdn.datatables.net/select/1.3.4/js/dataTables.select.min.js"></script>
	    <!-- toastr -->
    <script src="/plugins/notification/snackbar/snackbar.min.js"></script>
    <!-- END PAGE LEVEL PLUGINS -->
    <script src="/assets/js/elements/custom-search.js"></script>

    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <script src="/assets/js/components/notification/custom-snackbar.js"></script>
    <!--  END CUSTOM SCRIPTS FILE  -->
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="/plugins/table/datatable/custom_miscellaneous.js"></script>
	<script src="/plugins/bootstrap-select/bootstrap-select.min.js"></script>
	    <script>

	
	
        // Get the Toast button
        var toastButton = document.getElementById("toast-btn");
        // Get the Toast element
        var toastElement = document.getElementsByClassName("toast")[0];

        toastButton.onclick = function() {
            $('.toast').toast('show');
        }


    </script>
	


 
		
<script>
$(document).ready(function(){	
	var dataRecords = $('#recordListing').DataTable({
		"lengthChange": false,
		//"sPaginationType": "scrolling",
		"bProcessing": true,
        "bDestroy":true,
		"info":true,
		"bSort": true,
        "bJQueryUI": false, // ThemeRoller-stöd
        "bLengthChange": false, //Колличество товаров на страницу
		"dom": "<'inv-list-top-section'<'row'<'col-sm-12 col-md-6 d-flex justify-content-md-start justify-content-center'l<'dt-action-buttons align-self-center'B>><'col-sm-12 col-md-6 d-flex justify-content-md-end justify-content-center mt-md-0 mt-3'f<'toolbar align-self-center'>>>>" +
        "<'table-responsive'tr>" +
        "<'inv-list-bottom-section d-sm-flex justify-content-sm-between text-center'<'inv-list-pages-count  mb-sm-0 mb-3'i><'inv-list-pagination'p>>",


    columnDefs:[ {
        targets:"_all",
        width:"",
        className:"",
        orderable:false
    }],
	
    buttons: [
/*         {
            text: 'Добавить карту',
            className: 'btn btn-primary btn-sm',
            action: function(e, dt, node, config ) {
				$('#recordModal').modal('show');
				$('.modal-title').html("<i class='fa fa-plus'></i> Добавление карты");
				$('#action').val('addRecord');
				$('#save').val('Добавить карту');
				$('#recordForm')[0].reset();
            }
        } */
    ],
    "order": [[ 1, "asc" ]],
    "oLanguage": {
        "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
        "sInfo": "Страница _PAGE_ из _PAGES_",
		"sInfoFiltered": "(отфильтровано из _MAX_ записей)",
		"sEmptyTable": "Ничего нет",
        "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
        "sSearchPlaceholder": "Поиск...",
        "sLengthMenu": "Results :  _MENU_",
    },
    "stripeClasses": [],
    "lengthMenu": [7, 10, 20, 50],
    "pageLength": 7,
	
		"serverSide":true,
		'processing': true,
		'serverMethod': 'post',		
		"order":[],
		"ajax":{
			url:"/ajaxsimbank/",
			type:"POST",
			data:{action:'listRecords'},
			dataType:"json"
		},
		"select": {
            style: "multi"
        },
		
		
		"pageLength": 20
	});	
	$("#recordListing_filter").addClass("hidden"); // hidden search input
	
	$("#searchInput").on("input", function (e) {
   e.preventDefault();
   $('#recordListing').DataTable().search($(this).val()).draw();
   });
	$('#addRecord').click(function(){
		$('#recordModal').modal('show');
		$('#recordForm')[0].reset();
		$('.modal-title').html("<i class='fa fa-plus'></i> Добавление карты");
		$('#action').val('addRecord');
		$('#save').val('Добавить карту');
	});
	$("#recordListing").on('click', '.updates', function(){
		var id = $(this).attr("id");
		var action = 'getRecord';
		$.ajax({
			url:'/ajaxsimbank/',
			method:"POST",
			data:{id:id, action:action},
			dataType:"json",
			success:function(data){
				$('#recordModal2').modal('show');
				var x='option-2';
				$('.id').html(data.id);
				$('#name').val(data.name);
				$('#number').val(data.number);
				$('#text').val(data.text);
				$('#logo').val(data.logo);
				$('#balance').val(data.balance);
                $('#drop_name').val(data.drop_name);
				$('#drop_contact').val(data.drop_contact);
				$('#drop_tel').val(data.drop_tel);
				$('#zametka').val(data.zametka);				
				$('#bank').val(data.bank);
				$('#limitpay').val(data.limitpay);
				$('#what').val(data.what);
				$('#groupshop').val(data.groupshop);
				$('.modal-title').html("<i class='fa fa-plus'></i> Редактирование карты");
				$('#action').val('updateRecord');
				$('#save').val('Сохранить изменения');
				if (data.what == "clients") {
				document.getElementById('option-1').checked=true;
				$(".radio-blocks").hide();
				} else {
				document.getElementById('option-2').checked=true;
				$(".radio-blocks").show();				
				}
			}
		})
	}); 
	$("#recordListing").on('click', '.update', function(){
		var id = $(this).attr("id");
		var action = 'getRecord';
		$.ajax({
			url:'/ajaxsimbank/',
			method:"POST",
			data:{id:id, action:action},
			dataType:"json",
			success:function(data){
			$('#recordModal').modal('show');
				var x='option-2';
				$('#idp').val(data.id);
				$('#name').val(data.name);
				$('#number').val(data.number);
				$('.msg').html(data.msg);
				$('#logo').val(data.logo);
				$('.balance').html(data.balance);
                $('#drop_name').val(data.drop_name);
				$('#drop_contact').val(data.drop_contact);
				$('#drop_tel').val(data.drop_tel);
				$('#zametka').val(data.zametka);				
				$('#bank').val(data.bank);
				$('#limitpay').val(data.limitpay);
				$('#temp').val(data.temp);
				$('#what').val(data.what);
				$('#groupshop').val(data.groupshop);
				$('.modal-title').html("<i class='fa fa-plus'></i> Редактирование карты");
				$('#action').val('updateRecord');
				$('#save').val('Сохранить изменения');
				if (data.what == "clients") {
				document.getElementById('option-1').checked=true;
				$(".radio-blocks").hide();
				} else {
				document.getElementById('option-2').checked=true;
				$(".radio-blocks").show();				
				}	
			
			
			
			}
		})
	});
	
	$("#recordListing").on('click', '.viewsss', function(){
		var id = $(this).attr("id");
		var action = 'getRecord';
		$.ajax({
			url:'/ajaxsimbank/',
			method:"POST",
			data:{id:id, action:action},
			dataType:"json",
			success:function(data){
				$('#recordModals').modal('show');
				$('.id').html(data.id);
				$('.name').html(data.name);
				$('.number').html(data.number);
				$('.active').html(data.active);
				$('.logo').html(data.logo);
				$('.balance').html(data.balance);
				if (data.drop_name == "") {
				$('.drop_name').html('Не указано');	
				} else {
				$('.drop_name').html(data.drop_name);	
				}
				if (data.drop_contact == "") {
				$('.drop_contact').html('Не указано');	
				} else {
				$('.drop_contact').html(data.drop_contact);	
				}
				if (data.drop_tel == "") {
				$('.drop_tel').html('Не указано');	
				} else {
				$('.drop_tel').html(data.drop_tel);	
				}
				if (data.zametka == "") {
				$('.zametka').html('Заметок к карте нет');	
				} else {
				$('.zametka').html(data.zametka);	
				}				
				$('.bank').html(data.bank);
				$('.limitpay').html(data.limitpay);
				$('.what').html(data.what);
				$('.groupshop').html(data.groupshop);
				$('.modal-title').html("<i class='fa fa-plus'></i> Просмотр карты");
			}
		})
	});
	$("#recordModal").on('submit','#recordForm', function(event){
		event.preventDefault();
		$('#save').attr('disabled','disabled');
		var formData = $(this).serialize();
		$.ajax({
			url:"/ajaxsimbank/",
			method:"POST",
			data:formData,
			success:function(data){	
				$('#recordForm')[0].reset();
				$('#recordModal').modal('hide');				
				$('#save').attr('disabled', false);
				dataRecords.ajax.reload();
                Snackbar.show({
                text: 'Пользователь успешно сохранён',
		        showAction: false,
                actionTextColor: '#fff',
                backgroundColor: '#1abc9c'
                });
				
			}
		})
	});		
	$("#recordListing").on('click', '.delete', function(){
		var id = $(this).attr("id");		
		var action = "deleteRecord";
		if(confirm("Удалить пользователя?")) {
			$.ajax({
				url:"/ajaxsimbank/",
				method:"POST",
				data:{id:id, action:action},
				success:function(data) {					
					dataRecords.ajax.reload();
					Snackbar.show({
                    text: 'Пользователь успешно удалён',
		            showAction: false,
                    actionTextColor: '#fff',
                    backgroundColor: '#e7515a'
                   });
				}
			})
		} else {
			return false;
		}
		});
		$("#recordListing").on('click', '.admin', function(){
		var id = $(this).attr("id");		
		var action = "adminRecord";
			$.ajax({
				url:"/ajaxsimbank/",
				method:"POST",
				data:{id:id, action:action},
				success:function(data) {					
					dataRecords.ajax.reload();
					Snackbar.show({
                    text: 'Пользователь успешно назначен адином',
		            showAction: false,
                    actionTextColor: '#fff',
                    backgroundColor: '#1abc9c'
                   });
				}
			})
		
	});
	$("#recordListing").on('click', '.adminoff', function(){
		var id = $(this).attr("id");		
		var action = "adminoffRecord";
			$.ajax({
				url:"/ajaxsimbank/",
				method:"POST",
				data:{id:id, action:action},
				success:function(data) {					
					dataRecords.ajax.reload();
					Snackbar.show({
                    text: 'Пользователь успешно снят с админов',
		            showAction: false,
                    actionTextColor: '#fff',
                    backgroundColor: '#e7515a'
                   });
				}
			})
		
		
	});
		$("#recordListing").on('click', '.banned', function(){
		var id = $(this).attr("id");		
		var action = "bannedRecord";
			$.ajax({
				url:"/ajaxsimbank/",
				method:"POST",
				data:{id:id, action:action},
				success:function(data) {					
					dataRecords.ajax.reload();
					Snackbar.show({
                    text: 'Пользователь успешно забанен',
		            showAction: false,
                    actionTextColor: '#fff',
                    backgroundColor: '#e7515a'
                    });
				}
			})
	});
	$("#recordListing").on('click', '.bannedoff', function(){
		var id = $(this).attr("id");		
		var action = "bannedoffRecord";
			$.ajax({
				url:"/ajaxsimbank/",
				method:"POST",
				data:{id:id, action:action},
				success:function(data) {					
					dataRecords.ajax.reload();
					Snackbar.show({
                    text: 'Пользователь успешно разабанен',
		            showAction: false,
                    actionTextColor: '#fff',
                    backgroundColor: '#1abc9c'
                    });
				}
			})
	});
	
	//$("div.toolbar").html('<button class="dt-button dt-delete btn btn-danger btn-sm" tabindex="0" aria-controls="invoice-list"><span>Delete</span></button>');

multiCheck(invoiceList);


$('.dt-delete').on('click', function() {
      // Read all checked checkboxes
    $(".select-customers-info:checked").each(function () {
        if (this.classList.contains('chk-parent')) {
            return;
        } else {
            $(this).parents('tr').remove();
        }
    });
    
})


$('.action-delete').on('click', function() {
    $(this).parents('tr').remove();
})
});

function show()
		{   
			$.ajax({
				url: "/smstemp/",
				method: 'GET',
				data: {},
				cache: false,
				success: function(html){
					$("#shablon").html(html);
				}
			});
		}
		    $(document).ready(function(){  
                show();
            }); 
</script>		

</body>
</html>