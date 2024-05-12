<? include './template/template_header.tpl'; 
if (empty($_SESSION['user_id'])):
header('Location: /auth/');
exit;
endif;
$insertSql = $this->pdo->prepare("INSERT INTO activity_admin SET user_id = :user_id, text = :text, date = :date");
$insertSql->execute([
	'user_id' => $_SESSION['user_id'],
	'text' => 'В разделе магазины',
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
<link href="/assets/css/components/custom-list-group.css" rel="stylesheet" type="text/css">
<style>
.table > tbody > tr > td .inv-status.badge-darks {
background-color: rgba(0, 0, 0, 0.1);
color: #1abc9c; }
.dataTables_filter, .dataTables_info { display: none; }
</style>
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
z-index: 99999999999999999;
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
.badge-user {
color: #fff;
background-color: #17212b; }
.badge-moder {
color: #fff;
background-color: #FFDC73; }

input[type="datetime-local"]:before{
    color:lightgray;
    content:attr(placeholder);
	display: none;
}
@media only screen
and (min-device-width : 320px)
and (max-device-width : 480px){ input[type="datetime-local"]:before { display: inline; }}

input[type="datetime-local"].full:before {
    color:black;
    content:""!important;
	display: none;
}
@media only screen
and (min-device-width : 320px)
and (max-device-width : 480px){ input[type="datetime-local"].full:before { display: inline; }}

</style>	
		<div class="row layout-top-spacing">
<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
			<div class="widget-content widget-content-area br-6">
				<div class="widget widget-table-one" style="margin-bottom:-45px;">
							<div class="widget-heading">
<h6 class="">Управление магазинами<span class="" style="font-size:12px;color:#888ea8;"><br>Добавление, редактирование, настройки.</span></h6>
<div class="task-action">
<button type="button" class="btn btn-primary btn-sm" style="width:100%;margin-top:-5px;" data-toggle="modal" data-target="#addModal"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg></button>
</div>
</div></div>
					<div class="statbox widget box box-shadow" style="margin-bottom:-40px;">
						<div class="widget-content widget-content-area text-center tags-content">
							<div class="demo-search-overlay"></div>
							<div class="full-search search-form-overlay">
								<form class="form-inline form-inline search mt-lg-0" role="search">
									<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
									<div class="search-bar">
										<input type="text" id="searchInput" class="form-control search-form-control  ml-lg-auto" placeholder="Поиск по магазинам...">
									</div>
								</form>
							</div>
						</div>
					</div>
					<table id="recordListing" class="table">
						<thead>
							<tr>
							<th >Название</th>
							<th ></th>
							<th >Категория</th>
							<th >Бот</th>
							<th ></th>
							<th >Статус</th>
							<th>Режим</th>
							<th></th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
<!-- Modal -->
							<div class="modal fade" id="addModal"  style="margin-top:40px;padding-bottom:40px;">
<div class="modal-dialog">
<div class="modal-content">
	<!-- Modal Header -->
	<div class="modal-header">
		<div class="widget-heading">
<h6 class="">Добавить магазин<span class="" style="font-size:12px;color:#888ea8;"><br>Быстрое добавление магазина.</span></h6>
</div>
		<button type="button" class="close" data-dismiss="modal">&times;</button>
	</div>
	<div class="modal-body" style="margin-top:0px;">
	<code>*</code> - обязательное поле
<form class="select mt-4" action="/inc/shop/save.php" id="form" action="javascript:void(0);">
<div class="form-group">
										<input type="text" id="name" name="name" class="form-control form-control-sm" placeholder="Название магазина" required />
										<small id="emailHelp" class="form-text text-muted">Название магазина <code>*</code></small>
									  </div>
									  <div class="form-group">
									  <select name="chat" data-live-search="true" id="chat" class="form-control form-control-sm" title="Выбрать админа"> </select>			
										<small id="emailHelp" class="form-text text-muted">Укажите админа магазина <code>*</code></small>
									  </div>
									  <div class="form-group">
									<div class="custom-progress progress-down" style="width: 100%">
									<small id="emailHelp" class="form-text text-muted">Если нужно брать дополнительный процент с покупателей введите процент, или оставьте поле пустым..</small>
								<input type="range" min="0" max="100" id="percent" name="percent" class="custom-range progress-range-counter" value="0">
								<div class="range-count" style="margin-top:-3px;"><span class="range-count-number" data-rangecountnumber="0">0</span> <span class="range-count-unit">%</span></div>
							</div>
							 </div>
							<div class="form-group">
							<select name="referal" data-live-search="true" id="referals" class="form-control form-control-sm" title="Выбрать реферала"> </select>			
							</div>
							<div class="form-group">
							<code>Процент реферала</code>
									<div class="custom-progress progress-down" style="width: 100%">
								<input type="range" min="0" max="100" name="percent_referal" id="percent_referal" class="custom-range progress-range-counter" value="0">
								<div class="range-count" style="margin-top:-3px;"><span class="range-count-number" data-rangecountnumber="0">0</span> <span class="range-count-unit">%</span></div>
							</div>
							 </div>
							 <div class="form-row">
							  <div class="col-md-12">
								<div id="select_menu" class="form-group mb-4">
							  <select name="pay_referal" class="form-control form-control-sm" required>
										<option selected disabled >Кто платит рефералу?</option>
										<option value="Магазин">Магазин</option>
										<option value="Обменник">Обменник</option>
									</select>
									<small id="emailHelp" class="form-text text-muted">Выберите с кого будет сниматься процент для рефа. <code>*</code></small>
									</div>
									</div>
									</div>
<div class="form-row">
<div class="col-md-12">
	<div id="select_menu" class="form-group mb-4">
	   <select class="form-control form-control-sm" id="vivod" name="vivod" required>
										<option selected disabled >Режим выплат</option>
										<option value="Накопительный">Накопительный</option>
										<option value="Моментальный">Моментальный</option>
										</select>
										<small id="emailHelp" class="form-text text-muted">Выберите режим выплат для магазина. <code>*</code></small>
	</div>
</div>
</div>
<div class="form-row">
<div class="col-md-12">
	<div id="select_menu" class="form-group mb-4">
	   <select class="form-control form-control-sm" id="groupshop" name="groupshop" required>
										<option selected disabled >Выберите категорию магазинов</option>
										<?
										$home = $_SERVER['DOCUMENT_ROOT'].'/';
										$category = $this->pdo->query("SELECT * FROM group_shops");
										while ($row = $category->fetch()) {
										?>
										<option value="<? echo $row['id'];?>"><? echo $row['name'];?></option>
										<?
										}
										?>
										</select>
										<small id="emailHelp" class="form-text text-muted">Выберите категорию магазина. <code>*</code></small>
	</div>
</div>
</div>
<div class="input-group">
											<input class="form-control form-control-sm" id="apikey" name="apikey" type="text" value="" placeholder="API ключ" required>
											<div class="input-group-append">
												<button class="btn btn-primary waves-effect waves-light" id="keygen" onclick="return false" type="button">Создать</button>
											</div>
										</div>
										<small id="emailHelp" class="form-text text-muted">API ключ для доступа к функциям обменника. <code>*</code></small>
										<br>
										<input id="user_id" name="user_id" type="hidden" value="<?=$_SESSION['user_id']?>" required>
<button class="btn btn-block btn-primary mt-2" id="btnSubmit"  type="submit">Добавить магазин</button>
</form>
</div>
</div>
								  </div>
								</div>
							<div class="modal fade" id="edit-employee-modal" style="margin-top:40px;padding-bottom:40px;">
<div class="modal-dialog">
<div class="modal-content">
	<!-- Modal Header -->
	<div class="modal-header">
		<div class="widget-heading">
<h6 class="">Редактирование магазина<span class="" style="font-size:12px;color:#888ea8;"><br>Внесите изменения.</span></h6>
</div>
		<button type="button" class="close" data-dismiss="modal">&times;</button>
	</div>
	<div class="modal-body" style="margin-top:0px;">
	<code>*</code> - обязательное поле
		<form class="select mt-4" action="/inc/shop/update.php" id="editform" action="javascript:void(0);">
		<input class="form-control" type="hidden" name="id">
<div class="form-group">
										<input type="text" id="name" name="name" class="form-control form-control-sm" placeholder="Название магазина" required />
										<small id="emailHelp" class="form-text text-muted">Название магазина <code>*</code></small>
									  </div>
									  <div class="form-group">
										<input type="text" id="chat" name="chat"  class="form-control form-control-sm" placeholder="CHAT-ID Админа" required />
										<small id="emailHelp" class="form-text text-muted">Админ магазина <code>*</code></small>
									  </div>
									  <div class="form-group">
									<div class="custom-progress progress-down" style="width: 100%">
																			<small id="emailHelp" class="form-text text-muted">Если нужно брать дополнительный процент с покупателей введите процент, или оставьте поле пустым..</small>
								<input type="range" min="0" max="100" id="percent" name="percent" class="custom-range progress-range-counter" value="0">
								<div class="range-count" style="margin-top:-3px;"><span class="range-count-number" data-rangecountnumber="0"><div class="percent"></div></span> <span class="range-count-unit">%</span></div>
							</div>
							 </div>
							<div class="form-group">
							<select name="referal" data-live-search="true" id="referal" class="form-control" title="Выбрать реферала"> </select>			
							<small id="emailHelp" class="form-text text-muted">Сейчас реферал: <span class="referal"></span> </small>
							</div>
							<div class="form-group">
							<code>Процент реферала</code>
									<div class="custom-progress progress-down" style="width: 100%">
								<input type="range" min="0" max="100" name="percent_referal" id="percent_referal" class="custom-range progress-range-counter" value="0">
								<div class="range-count" style="margin-top:-3px;"><span class="range-count-number" data-rangecountnumber="0"><div class="percent_referal"></div></span> <span class="range-count-unit">%</span></div>
							</div>
							 </div>
 <div class="form-row">
							  <div class="col-md-12">
								<div id="select_menu" class="form-group mb-4">
							  <select name="pay_referal" class="form-control form-control-sm" required>
										<option selected disabled >Кто платит рефералу?</option>
										<option value="Магазин">Магазин</option>
										<option value="Обменник">Обменник</option>
									</select>
									<small id="emailHelp" class="form-text text-muted">Выберите с кого будет сниматься процент для рефа. <code>*</code></small>
									</div>
									</div>
									</div>
<div class="form-row">
<div class="col-md-12">
	<div id="select_menu" class="form-group mb-4">
	   <select class="form-control form-control-sm" id="vivod" name="vivod" required>
										<option selected disabled >Режим выплат</option>
										<option value="Накопительный">Накопительный</option>
										<option value="Моментальный">Моментальный</option>
										</select>
										<small id="emailHelp" class="form-text text-muted">Выберите режим выплат для магазина. <code>*</code></small>
	</div>
</div>
</div>
<div class="form-row">
<div class="col-md-12">
	<div id="select_menu" class="form-group mb-4">
	   <select class="form-control form-control-sm" id="groupshop" name="groupshop" required>
										<option selected disabled >Выберите категорию магазинов</option>
										<?
										$home = $_SERVER['DOCUMENT_ROOT'].'/';
										$category = $this->pdo->query("SELECT * FROM group_shops");
										while ($row = $category->fetch()) {
										?>
										<option value="<? echo $row['id'];?>"><? echo $row['name'];?></option>
										<?
										}
										?>
										</select>
										<small id="emailHelp" class="form-text text-muted">Выберите категорию магазина. <code>*</code></small>
	</div>
</div>
</div>
<div class="input-group">
											<input class="form-control form-control-sm" id="apikey" name="apikey" type="text" value="" placeholder="API ключ" required>
											<div class="input-group-append">
												<button class="btn btn-primary waves-effect waves-light" id="keygen" onclick="return false" type="button">Создать</button>
											</div>
										</div>
										<small id="emailHelp" class="form-text text-muted">API ключ для доступа к функциям обменника. <code>*</code></small><br>
										<div><a href="javascript:collapsElement('identifikator')" class="btn btn-block btn-warning mb-4 mr-2 btn-sm" title="" rel="nofollow">Добавить бота для магазина</a>
									<div id="identifikator" style="display: none">
									<div class="input-group mb-4">
							  <input type="text" class="form-control form-control-sm" id="token" name="token" aria-describedby="emailHelp" placeholder="Введите токен" aria-label="Recipient's username" required>
							  <div class="input-group-append">
								<button class="btn btn-primary" type="button">Проверить</button>
							  </div>
							</div>
										<div id="resultsapibots"></div>
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
<div class="modal fade" id="recordModals" style="z-index:99999999999;">
											<div class="modal-dialog modal-dialog-centered" role="document">
												<div class="modal-content">
													<div class="modal-header">
		<div class="widget-heading">
<h6 class="">Статистика магазина<span class="" style="font-size:12px;color:#888ea8;"><br>Просмотр статистики.</span></h6>
</div>
		<button type="button" class="close" data-dismiss="modal">&times;</button>
	</div>
													
													<div class="modal-body" style="margin-top:-20px;">
													
										<form method="POST" id="statshop" class="form" action="javascript:void(null);" onsubmit="statshop()">
			 <div class="form-group mb-4">
			 <div class="input-group" style="">
			<input type="datetime-local" class="form-control form-control-sm" placeholder="Дата начала"  name="start" id="start"  />
			</div>
			</div>
	         <div class="form-group mb-4">
			 <div class="input-group" style="margin-top:-20px;">		
			 <input type="datetime-local" class="form-control form-control-sm" placeholder="Конечная дата"  name="end" id="end" />
			</div>
			</div>
			<div class="form-group mb-4">
			 <div id="resultstatshop"></div>
			 </div>
			 <input type="hidden" name="id" id="id" />

														<input type="submit" class="btn btn-block btn-primary" value="Начать поиск">

		</form>

											</div>
											
												</div>
											</div>
										</div>
<!-- END MAIN CONTAINER -->
<? include './template/template_footer.tpl'; ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
<script src="/assets/js/forms/bootstrap_validation/bs_validation_script.js"></script>			
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="/assets/js/scrollspyNav.js"></script>
<script src="/plugins/flatpickr/flatpickr.js"></script>
<script src="/plugins/noUiSlider/nouislider.min.js"></script>
<script src="/plugins/flatpickr/custom-flatpickr.js"></script>
<script src="/plugins/noUiSlider/custom-nouiSlider.js"></script>
<script src="/plugins/bootstrap-range-Slider/bootstrap-rangeSlider.js"></script>
<script>
$("#start").on("input",function(){
    if($(this).val().length>0){
    $(this).addClass("full");
}
else{
   $(this).removeClass("full");
   }
 });
 $("#end").on("input",function(){
    if($(this).val().length>0){
    $(this).addClass("full");
}
else{
   $(this).removeClass("full");
   }
 });

function collapsElement(id) {
if ( document.getElementById(id).style.display != "none" ) {
document.getElementById(id).style.display = 'none';
}
else {
document.getElementById(id).style.display = '';
}
}
</script>
<script>
$(function() {
$("#" + $(".radio:checked").val()).show();
$(".radio").change(function(){
$(".radio-blocks").hide();
$("#" + $(this).val()).show();
});
});
	$(document).ready(function () {
		$("#chat").selectpicker();
		load_admin("userAdmin");
		function load_admin(type, category_id = "") {
			$.ajax({
				url: "/searchadmin/",
				method: "POST",
				data: { type: type, category_id: category_id },
				dataType: "json",
				success: function (data) {
					var html = "";
					for (var count = 0; count < data.length; count++) {
						html += '<option value="' + data[count].chat + '">' + data[count].chat + ' - ' + data[count].name + "</option>";
					}
					if (type == "userAdmin") {
						$("#chat").html(html);
						$("#chat").selectpicker("refresh");
					}
				},
			});
		}
		$(document).on("change", "#chat", function () {
			var category_id = $("#chat").val();
			load_admin("carModeldata", category_id);
		});
	});
</script>		
<script>
	$(document).ready(function () {
		$("#referal").selectpicker();
		load_data("userData");
		function load_data(type, category_id = "") {
			$.ajax({
				url: "/searchreferal/",
				method: "POST",
				data: { type: type, category_id: category_id },
				dataType: "json",
				success: function (data) {
					var html = "";
					for (var count = 0; count < data.length; count++) {
						html += '<option value="' + data[count].chat + '">' + data[count].chat + ' - ' + data[count].name + "</option>";
					}
					if (type == "userData") {
						$("#referal").html(html);
						$("#referal").selectpicker("refresh");
					}
				},
			});
		}
		$(document).on("change", "#referal", function () {
			var category_id = $("#referal").val();
			load_data("carModeldata", category_id);
		});
	});
</script>
<script>
	$(document).ready(function () {
		$("#referals").selectpicker();
		load_datas("userDatas");
		function load_datas(type, category_id = "") {
			$.ajax({
				url: "/searchreferals/",
				method: "POST",
				data: { type: type, category_id: category_id },
				dataType: "json",
				success: function (data) {
					var html = "";
					for (var count = 0; count < data.length; count++) {
						html += '<option value="' + data[count].chat + '">' + data[count].chat + ' - ' + data[count].name + "</option>";
					}
					if (type == "userDatas") {
						$("#referals").html(html);
						$("#referals").selectpicker("refresh");
					}
				},
			});
		}
	});
</script>				
		<script>
var input = document.getElementById('token');
input.addEventListener("focusout", function() {
var msg   = $('#token').serialize();
$.ajax({
  type: 'POST',
  url: '/checkbot/',
  data: msg,
  success: function(html){  
  $("#resultsapibots").html(html);  
 },
});
});
		$( document ).ready(function() {
			$('input.typeahead').typeahead({
			source:  function (query, process) {
			return $.get('/searchdata/', { query: query }, function (data) {				
			data = $.parseJSON(data);
			return process(data);
			});
			},
			});
			});
			$( document ).ready(function() {
			$('input.typeaheads').typeahead({
			source:  function (query, process) {
			return $.get('/searchdatabots/', { query: query }, function (data) {				
			data = $.parseJSON(data);
			return process(data);
			});
			},
			});
			});
			</script>
<script>
$(document).ready(function() {
	App.init();
});
</script>
<script src="/assets/js/custom.js"></script>
<!-- END GLOBAL MANDATORY SCRIPTS -->
<script src="/plugins/table/datatable/datatables.js"></script>
<script src="/plugins/table/datatable/button-ext/dataTables.buttons.min.js"></script>
<script src="/plugins/bootstrap-select/bootstrap-select.min.js"></script>
<!-- Sweetalert2 JS -->
<script src="/assets/plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Page Script -->
<!-- toastr -->
<script src="/plugins/notification/snackbar/snackbar.min.js"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!--  BEGIN CUSTOM SCRIPTS FILE  -->
<script src="/assets/js/components/notification/custom-snackbar.js"></script>
<!--  END CUSTOM SCRIPTS FILE  -->
<script src="/assets/js/elements/custom-search.js"></script>
<script src="https://cdn.datatables.net/select/1.3.4/js/dataTables.select.min.js"></script>
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
/**
* Function to produce UUID.
* See: http://stackoverflow.com/a/8809472
*/
function generateUUID() {
var d = new Date().getTime();
if (window.performance && typeof window.performance.now === "function") {
d += performance.now();
}
var uuid = "xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx".replace(
/[xy]/g,
function (c) {
var r = (d + Math.random() * 16) % 16 | 0;
d = Math.floor(d / 16);
return (c == "x" ? r : (r & 0x3) | 0x8).toString(16);
}
);
return uuid;
}
/**
* Generate new key and insert into input value
*/
$("#keygen").on("click", function () {
$("#apikey").val(generateUUID());
});
function mobileTextarea(){
var elem = document.getElementById('inp'); // здесь textarea - это идентификатор поля, которое будет растягиваться.
var minRows = 2; // высота поля textarea
if (elem) {
// функция расчета строк
function setRows() {
	elem.rows = minRows; // минимальное количество строк
	// цикл проверки вместимости контента
	do {
		if (elem.clientHeight != elem.scrollHeight) elem.rows += 1;
	} while (elem.clientHeight < elem.scrollHeight);
}
setRows();
elem.rows = minRows;
// пересчет строк в зависимости от набранного контента
elem.onkeyup = function(){
	setRows();
}
}
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
	url:"/ajaxapishops/",
	type:"POST",
	data:{action:'listRecords'},
	dataType:"json"
},
"select": {
style: "multi"
}, 
});	
$("#recordListing_filter").addClass("hidden"); // hidden search input
$("#searchInput").on("input", function (e) {
e.preventDefault();
$('#recordListing').DataTable().search($(this).val()).draw();
});
$('#addRecord').click(function(){
$('#recordModal').modal('show');
$('#recordForm')[0].reset();
$('.modal-title').html("<i class='fa fa-plus'></i> Добавление магазина");
$('#action').val('addRecord');
$('#save').val('Добавить магазин');
});
$("#recordListing").on('click', '.active', function(){
var id = $(this).attr("id");		
var action = "activeRecord";
	$.ajax({
		url:"/ajaxapishops/",
		method:"POST",
		data:{id:id, action:action},
		success:function(data) {					
			dataRecords.ajax.reload();
			Snackbar.show({
			text: 'Магазин назначен активным',
			showAction: false,
			actionTextColor: '#fff',
			backgroundColor: '#1abc9c'
			});
		}
	})
});
$("#recordListing").on('click', '.nakop', function(){
var id = $(this).attr("id");		
var action = "nakopRecord";
	$.ajax({
		url:"/ajaxapishops/",
		method:"POST",
		data:{id:id, action:action},
		success:function(data) {					
			dataRecords.ajax.reload();
			Snackbar.show({
			text: 'Режим выплаты изменён на накопительный',
			showAction: false,
			actionTextColor: '#fff',
			backgroundColor: '#1abc9c'
			});
		}
	})
});
$("#recordListing").on('click', '.moment', function(){
var id = $(this).attr("id");		
var action = "momentRecord";
	$.ajax({
		url:"/ajaxapishops/",
		method:"POST",
		data:{id:id, action:action},
		success:function(data) {					
			dataRecords.ajax.reload();
			Snackbar.show({
			text: 'Режим выплаты изменён на моментальный',
			showAction: false,
			actionTextColor: '#fff',
			backgroundColor: '#1abc9c'
			});
		}
	})
});
$("#recordListing").on('click', '.active', function(){
var id = $(this).attr("id");		
var action = "activeRecord";
$.ajax({
	url:"/ajaxapishops/",
	method:"POST",
	data:{id:id, action:action},
	success:function(data) {					
		dataRecords.ajax.reload();
		Snackbar.show({
		text: 'Магазин успешно включён',
		showAction: false,
		actionTextColor: '#fff',
		backgroundColor: '#1abc9c'
		});
	}
})
});
$("#recordListing").on('click', '.viewsss', function(){
	var id = $(this).attr("id");
	var action = 'getRecord';
	$.ajax({
		url:'/ajaxapishops/',
		method:"POST",
		data:{id:id, action:action},
		dataType:"json",
		success:function(data){
			$('#recordModals').modal('show');
			$('#id').val(data.id);
			$('.name').html(data.name);
			$('.number').html(data.number);
			$('.active').html(data.active);
			$('.logo_card').html(data.logo_card);
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

$("#recordListing").on('click', '.inactive', function(){
var id = $(this).attr("id");		
var action = "inactiveRecord";
$.ajax({
	url:"/ajaxapishops/",
	method:"POST",
	data:{id:id, action:action},
	success:function(data) {					
		dataRecords.ajax.reload();
		Snackbar.show({
		text: 'Магазин успешно отключён',
		showAction: false,
		actionTextColor: '#fff',
		backgroundColor: '#e7515a'
		});
	}
})
});
function all() 
{
// Ajax config
$.ajax({
type: "GET", //we are using GET method to get all record from the server
url: '/inc/shop/all.php', // get the route value
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
url: '/inc/shop/get.php', // get the route value
data: {employee_id:employeeId}, //set data
beforeSend: function () {//We add this before send to disable the button once we submit it so that we prevent the multiple click
},
success: function (response) {//once the request successfully process to the server side it will return result here
	response = JSON.parse(response);
	$("#editform [name=\"id\"]").val(response.id);
	$("#editform [name=\"chat\"]").val(response.chat);
	$("#editform [name=\"percent\"]").val(response.percent);
	$('.percent').html(response.percent);
	$('.referal').html(response.referal);
	$("#editform [name=\"name\"]").val(response.name);
	$("#editform [name=\"percent_referal\"]").val(response.percent_referal);
	$('.percent_referal').html(response.percent_referal);
	$("#editform [name=\"referal\"]").val(response.referal);
	$("#editform [name=\"groupshop\"]").val(response.groupshop);
	$("#editform [name=\"vivod\"]").val(response.vivod);
	$("#editform [name=\"apikey\"]").val(response.apikey);
	$("#editform [name=\"pay_referal\"]").val(response.pay_referal);
	$("#editform [name=\"user_id\"]").val(response.user_id);
	$("#editform [name=\"token\"]").val(response.token);
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
title: 'Вы уверены что хотите удалить данный магазин?',
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
	url: '/inc/shop/delete.php?user_id='+userId, // get the route value
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
function allbotsnecro()
{   
	$.ajax({
		url: "/allbotsnecro/",
		method: 'GET',
		data: {},
		cache: false,
		success: function(html){
			$("#allbotsnecro").html(html);
		}
	});
}
	$(document).ready(function(){  
		allbotsnecro();
	}); 
function apibots() {
var msg   = $('#apibots').serialize();
$.ajax({
  dataType: "json",
  type: 'POST',
  url: '/addbotsnecro/',
  data: msg,
  success: function(data) {
if (data.result == "success") {
  $("#apibots")[0].reset();
  Snackbar.show({
  text: data.mess,
  showAction: false,
  actionTextColor: '#fff',
  backgroundColor: '#191e3a'
});
allbotsnecro();
} else {
}
 },
});
}
function statshop() {
var msg   = $('#statshop').serialize();
$.ajax({
		url: '/statshop/', 
		method: 'post',
		dataType: 'html',
		data: msg,
		success: function(data){
			$('#resultstatshop').html(data);
		}
	});
} 
</script>
</body>
</html>