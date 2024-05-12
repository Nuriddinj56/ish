<? 
include './template/template_header.tpl';
if (empty($_SESSION['user_id'])):
	header('Location: /auth/');
	exit;
endif;
		$insertSql = $this->pdo->prepare("INSERT INTO activity_admin SET user_id = :user_id, text = :text, date = :date");
		$insertSql->execute([
			'user_id' => $_SESSION['user_id'],
			'text' => 'В транзакциях',
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
<h6 class="">Управление заявками/транзакциями<span class="" style="font-size:12px;color:#888ea8;"><br>Просмотр статусов заявок, изменение и т.д.</span></h6>
</div></div>
<div class="statbox widget box box-shadow" style="margin-bottom:-30px;">
<div class="widget-content widget-content-area text-center tags-content">
<div class="search-input-group-style input-group mb-3">
<div class="input-group-prepend">
<span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-file-invoice-dollar fa-2x"></i></span>
</div>
<input type="text" id="searchInput2" class="form-control" placeholder="Например: 2022-04-07 12:54:48" aria-label="Username" aria-describedby="basic-addon1">
</div>
<small id="emailHelp" style="margin-top:-10px;" class="form-text text-muted">Поиск доступен по следующим параметрам: номер карты, ID транзы, COM порт, CHAT-ID, название магазина, дата, ID заявки, реквизиты.</small>
</div>
</div>
<table id="recordListing" class="table">
<thead>
<tr>
<th width="5%">ID</th>
<th width="5%">Магазин</th>
<th width="5%"></th>
<th width="5%">Что</th>
<th width="5%"></th>
<th width="5%">На что</th>
<th width="5%">Статус</th>
<th width="5%"></th>				
<th width="5%">Дата</th>
<th width="5%"></th>
</tr>
</thead>
</table>
</div>
</div>				
</div>	

<div class="modal fade" id="edit-employee-modal" style="margin-top:40px;padding-bottom:40px;">
<div class="modal-dialog">
<div class="modal-content">
	<!-- Modal Header -->
	<div class="modal-header">
		<div class="widget-heading">
<h6 class="">Редактирование транзакции<span class="" style="font-size:12px;color:#888ea8;"><br>Внесите изменения.</span></h6>
</div>
		<button type="button" class="close" data-dismiss="modal">&times;</button>
	</div>
	<div class="modal-body" style="margin-top:0px;">
	<code>*</code> - обязательное поле
		<form class="select mt-4" action="/inc/trans/update.php" id="editform" action="javascript:void(0);">
		<input class="form-control" type="hidden" name="id">
<div class="form-group">
										<input type="text" id="sum_rub" name="sum_rub" class="form-control form-control-sm" placeholder="Название магазина" required />
										<small id="emailHelp" class="form-text text-muted">Сумма в рублях <code>*</code></small>
									  </div>
									  <div class="form-group">
										<input type="text" id="sendclient_crypto" name="sendclient_crypto"  class="form-control form-control-sm" placeholder="CHAT-ID Админа" required />
										<small id="emailHelp" class="form-text text-muted">Сумма в крипте <code>*</code></small>
									  </div>
									  
							<div class="form-row">
<div class="col-md-12">
	<div id="select_menu" class="form-group mb-4">
	   <select class="form-control form-control-sm" id="status" name="status" required>
										<option selected disabled >Статус выплаты</option>
										<option value="Выплачено">Выплачено</option>
										<option value="Переводим средства">Переводим средства</option>
										<option value="Зачислено на счёт">Зачислено на счёт</option>
										<option value="Ждём оплату">Ждём оплату</option>
										<option value="Просрочено">Просрочено</option>
										</select>
										<small id="emailHelp" class="form-text text-muted">Выберите статус выплаты. <code>*</code></small>
	</div>
</div>
</div>
<div class="form-row">
<div class="col-md-12">
	<div id="select_menu" class="form-group mb-4">
	   <select class="form-control form-control-sm" id="status_payclient" name="status_payclient" required>
										<option selected disabled >Статус оплаты</option>
										<option value="Оплата получена">Оплата получена</option>
										<option value="В ожидании">В ожидании</option>
										<option value="Время истекло">Время истекло</option>
										<option value="Отменён">Отменён</option>
										</select>
										<small id="emailHelp" class="form-text text-muted">Выберите статус выплаты. <code>*</code></small>
	</div>
</div>
</div>
							
 



										
										<input id="userid" name="userid" type="hidden" value="<?=$_SESSION['user_id']?>" required>
<button type="button" class="btn btn-primary" id="btnUpdateSubmit">Сохранить</button>
			<button type="button" class="btn btn-danger float-right" data-dismiss="modal">Закрыть окно</button>
</form>
	</div>
</div>
</div>
</div>	
				</div>   
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<? include './template/template_footer.tpl'; ?>

<script>
	$(document).ready(function() {
		App.init();
	});
</script>
<script src="/plugins/highlight/highlight.pack.js"></script>
<script src="/assets/js/custom.js"></script>
<!-- END GLOBAL MANDATORY STYLES -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="/assets/js/scrollspyNav.js"></script>
<script src="/plugins/flatpickr/flatpickr.js"></script>
<script src="/plugins/noUiSlider/nouislider.min.js"></script>

<script src="/plugins/flatpickr/custom-flatpickr.js"></script>
<script src="/plugins/noUiSlider/custom-nouiSlider.js"></script>
<script src="/plugins//bootstrap-range-Slider//bootstrap-rangeSlider.js"></script>
<!-- END PAGE LEVEL SCRIPTS -->
</body>
</html>
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
<!-- Sweetalert2 JS -->
<script src="/assets/plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Page Script -->

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
		"info":false,
		"bFilter": true, // show search input
		"bSort": true,
        "bJQueryUI": false, // ThemeRoller-stöd
        "bLengthChange": false, //Колличество товаров на страницу
		"dom": "<'inv-list-top-section'<'row'<'col-sm-12 col-md-6 d-flex justify-content-md-start justify-content-center'l<'dt-action-buttons align-self-center'B>><'col-sm-12 col-md-6 d-flex justify-content-md-end justify-content-center mt-md-0 mt-3'f<'toolbar align-self-center'>>>>" +
        "<'table-responsive'tr>" +
        "<'inv-list-bottom-section d-sm-flex justify-content-sm-between text-center'<'inv-list-pages-count  mb-sm-0 mb-3'i><'inv-list-pagination'p>>",


    columnDefs:[ {
        targets:'_all',
        className:"",
        orderable:false
    }],
    buttons: [
    ],
    "order": [[ 1, "asc" ]],
    "oLanguage": {
        "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
        "sInfo": "Страница _PAGE_ из _PAGES_",
		"sInfoFiltered": "(отфильтровано из _MAX_ записей)",
		"sEmptyTable": "Ничего не найдено",
        "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
        "sSearchPlaceholder": "Поиск...",
        "sLengthMenu": "Results :  _MENU_",
    },
    "stripeClasses": [],
    "lengthMenu": [7, 10, 20, 50],
    "pageLength": 20,
	
		"serverSide":true,
		'processing': true,
		'serverMethod': 'post',		
		"order":[],
	"ajax":{
		url:"/ajaxtransbot/",
		type:"POST",
		data:{action:'listRecords'},
		dataType:"json"
	},
	"select": {
		style: "multi"
	}, 
});	
$("#recordListing_filter").addClass("hidden"); // hidden search input

$("#searchInput2").on("input", function (e) {
e.preventDefault();
$('#recordListing').DataTable().search($(this).val()).draw();
});

$("#recordListing").on('click', '.viewsss', function(){
	var id = $(this).attr("id");
	var action = 'getRecord';
	$.ajax({
		url:'/ajaxtransbot/',
		method:"POST",
		data:{id:id, action:action},
		dataType:"json",
		success:function(data){
			$('#recordModals').modal('show');
			$('.id').html(data.id);
		}
	})
});	
	$("#recordListing").on('click', '.pays', function(){
	var id = $(this).attr("id");		
	var action = "paysRecord";
		$.ajax({
			url:"/ajaxtransbot/",
			method:"POST",
			data:{id:id, action:action},
			success:function(data) {					
				dataRecords.ajax.reload();
				Snackbar.show({
				text: 'Статус успешно изменён',
				showAction: false,
				actionTextColor: '#fff',
				backgroundColor: '#1abc9c'
				});
			}
		})
});
$("#recordListing").on('click', '.sendmoney', function(){
	var id = $(this).attr("id");		
	var action = "sendmoneyRecord";
		$.ajax({
			url:"/ajaxtransbot/",
			method:"POST",
			data:{id:id, action:action},
			success:function(data) {					
				dataRecords.ajax.reload();
				Snackbar.show({
				text: 'Статус успешно изменён',
				showAction: false,
				actionTextColor: '#fff',
				backgroundColor: '#1abc9c'
				});
			}
		})
});
$("#recordListing").on('click', '.wait', function(){
	var id = $(this).attr("id");		
	var action = "waitRecord";
		$.ajax({
			url:"/ajaxtransbot/",
			method:"POST",
			data:{id:id, action:action},
			success:function(data) {					
				dataRecords.ajax.reload();
				Snackbar.show({
				text: 'Статус успешно изменён',
				showAction: false,
				actionTextColor: '#fff',
				backgroundColor: '#1abc9c'
				});
			}
		})
});
$("#recordListing").on('click', '.cancell', function(){
	var id = $(this).attr("id");		
	var action = "cancellRecord";
		$.ajax({
			url:"/ajaxtransbot/",
			method:"POST",
			data:{id:id, action:action},
			success:function(data) {					
				dataRecords.ajax.reload();
				Snackbar.show({
				text: 'Статус успешно изменён',
				showAction: false,
				actionTextColor: '#fff',
				backgroundColor: '#1abc9c'
				});
			}
		})
});
	$("#recordListing").on('click', '.timeoff', function(){
	var id = $(this).attr("id");		
	var action = "timeoffRecord";
		$.ajax({
			url:"/ajaxtransbot/",
			method:"POST",
			data:{id:id, action:action},
			success:function(data) {					
				dataRecords.ajax.reload();
				Snackbar.show({
				text: 'Статус карты изменён',
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
		if(confirm("Удалить транзакцию??")) {
			$.ajax({
				url:"/ajaxtransbot/",
				method:"POST",
				data:{id:id, action:action},
				success:function(data) {					
					dataRecords.ajax.reload();
					Snackbar.show({
                    text: 'Транзакция успешно удалена',
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
		
		
		function all() 
{
// Ajax config
$.ajax({
type: "GET", //we are using GET method to get all record from the server
url: '/inc/trans/all.php', // get the route value
success: function (response) {//once the request successfully process to the server side it will return result here
// Parse the json result
response = JSON.parse(response);
var html = "";
// Check if there is available records
if(response.length) {
	html += '<div class="list-group">';
	// Loop the parsed JSON
	$.each(response, function(key,value) {
		// Our employee list template
		html += '<a href="#" class="list-group-item list-group-item-action">';
		html += "<p>" + value.first_name +' '+ value.last_name + " <span class='list-number'>(" + value.chat + ")</span>" + "</p>";
		html += "<p class='list-address'>" + value.address + "</p>";
		html += "<button class='btn btn-sm btn-primary mt-2' data-toggle='modal' data-target='#edit-employee-modal' data-id='"+value.id+"'>Edit</button>";
		html += "<button class='btn btn-sm btn-danger mt-2 ml-2 btn-delete-employee' data-id='"+value.id+"' typle='button'>Delete</button>";
		html += '</a>';
	});
	html += '</div>';
} else {
	html += '<div class="alert alert-warning">';
	  html += 'No records found!';
	html += '</div>';
}
// Insert the HTML Template and display all employee records
$("#employees-list").html(html);
}
});
}
function save() 
{
$("#btnSubmit").on("click", function() {
var $this 		    = $(this); //submit button selector using ID
var $caption        = $this.html();// We store the html content of the submit button
var form 			= "#form"; //defined the #form ID
var formData        = $(form).serializeArray(); //serialize the form into array
var route 			= $(form).attr('action'); //get the route using attribute action
// Ajax config
$.ajax({
dataType: "json", //we are using POST method to submit the data to the server side
url: route, // get the route value
data: formData, // our serialized array data for server side
beforeSend: function () {//We add this before send to disable the button once we submit it so that we prevent the multiple click
	$this.attr('disabled', true).html("Processing...");
},
success: function (response) {
	if (response.result == "success") {
	//once the request successfully process to the server side it will return result here
	$this.attr('disabled', false).html($caption);
	// Reload lists of employees
	all();
	// We will display the result using alert
	Swal.fire({
	  icon: 'success',
	  title: 'Успешно.',
	  html: "<font color='#FFF'>"+response.mess+"</font>"
	});
	dataRecords.ajax.reload();
	// Reset form
	resetForm(form);
	} else {
	// We will display the result using alert
	Swal.fire({
	  icon: 'error',
	  title: 'Ошибка!',
	  html: "<font color='#FFF'>"+response.mess+"</font>"
	});
	//once the request successfully process to the server side it will return result here
	$this.attr('disabled', false).html($caption);
	}
	// Close modal
	$('#addModal').modal('toggle');
},
error: function (XMLHttpRequest, textStatus, errorThrown) {
	// You can put something here if there is an error from submitted request
}
});
});
}
function resetForm(selector) 
{
$(selector)[0].reset();
}
function get() 
{
$(document).delegate("[data-target='#edit-employee-modal']", "click", function() {
var employeeId = $(this).attr('data-id');
// Ajax config
$.ajax({
type: "GET", //we are using GET method to get data from server side
url: '/inc/trans/get.php', // get the route value
data: {employee_id:employeeId}, //set data
beforeSend: function () {//We add this before send to disable the button once we submit it so that we prevent the multiple click
},
success: function (response) {//once the request successfully process to the server side it will return result here
	response = JSON.parse(response);
	$("#editform [name=\"id\"]").val(response.id);
	$("#editform [name=\"sum_rub\"]").val(response.sum_rub);
	$("#editform [name=\"sendclient_crypto\"]").val(response.sendclient_crypto);
	$("#editform [name=\"status\"]").val(response.status);
	$("#editform [name=\"status_payclient\"]").val(response.status_payclient);
}
});
});
}
function update() 
{
$("#btnUpdateSubmit").on("click", function() {
var $this 		    = $(this); //submit button selector using ID
var $caption        = $this.html();// We store the html content of the submit button
var form 			= "#editform"; //defined the #form ID
var formData        = $(form).serializeArray(); //serialize the form into array
var route 			= $(form).attr('action'); //get the route using attribute action
// Ajax config
$.ajax({
dataType: "json", //we are using POST method to submit the data to the server side
url: route, // get the route value
data: formData, // our serialized array data for server side
beforeSend: function () {//We add this before send to disable the button once we submit it so that we prevent the multiple click
	$this.attr('disabled', true).html("Processing...");
},
success: function (response) {//once the request successfully process to the server side it will return result here
if (response.result == "success") {
	//once the request successfully process to the server side it will return result here
	$this.attr('disabled', false).html($caption);
	// Reload lists of employees
	all();
	// We will display the result using alert
	Swal.fire({
	  icon: 'success',
	  title: 'Успешно.',
	  html: "<font color='#FFF'>"+response.mess+"</font>"
	});
	dataRecords.ajax.reload();
	// Reset form
	resetForm(form);
	$('#edit-employee-modal').modal('toggle');
	} else {
	// We will display the result using alert
	Swal.fire({
	  icon: 'error',
	  title: 'Ошибка!',
	  html: "<font color='#FFF'>"+response.mess+"</font>"
	});
	//once the request successfully process to the server side it will return result here
	$this.attr('disabled', false).html($caption);
	}
	// Close modal
},
error: function (XMLHttpRequest, textStatus, errorThrown) {
	// You can put something here if there is an error from submitted request
}
});
});
}
function del() 
{
$(document).delegate(".btn-delete-employee", "click", function() {
Swal.fire({
icon: '',
title: 'Вы уверены что хотите удалить данную транзакцию?',
showDenyButton: false,
showCancelButton: true,
confirmButtonText: 'Да, удалить',
cancelButtonText: 'Нет, не удалять'
}).then((result) => {
/* Read more about isConfirmed, isDenied below */
if (result.isConfirmed) {
var employeeId = $(this).attr('data-id');
var userId = <?=$_SESSION['user_id']?>;
// Ajax config
$.ajax({
	type: "GET", //we are using GET method to get data from server side
	url: '/inc/trans/delete.php?user_id='+userId, // get the route value
	data: {employee_id:employeeId}, //set data
	beforeSend: function () {//We add this before send to disable the button once we submit it so that we prevent the multiple click
	},
	success: function (response) {//once the request successfully process to the server side it will return result here
		// Reload lists of employees
		all();
		dataRecords.ajax.reload();
		Swal.fire('Успешно.', response, 'success')
	}
});
} else if (result.isDenied) {
Swal.fire('Changes are not saved', '', 'info')
}
});
});
}
$(document).ready(function() {
// Get all employee records
all();
// Submit form using AJAX To Save Data
save();
// Get the data and view to modal
get();
// Updating the data
update();
// Delete record via ajax
del();
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

</script>			
	
</body>
</html>