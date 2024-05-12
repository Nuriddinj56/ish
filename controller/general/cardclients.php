<? 
include './template/template_header.tpl';
if (empty($_SESSION['user_id'])):
	header('Location: /auth/');
	exit;
endif;
		$insertSql = $this->pdo->prepare("INSERT INTO activity_admin SET user_id = :user_id, text = :text, date = :date");
		$insertSql->execute([
			'user_id' => $_SESSION['user_id'],
			'text' => 'В управлении обменом',
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
	
    
									
									
										
			
				<div class="col-xl-9 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">






					   <div class="widget-content widget-content-area br-6">
					<div class="widget widget-table-one" style="margin-bottom:-45px;">
								<div class="widget-heading">
<h6 class="">Управление картами<span class="" style="font-size:12px;color:#888ea8;"><br>Добавление, редактирование, настройки.</span></h6>
</div></div>
<div class="statbox widget box box-shadow" style="margin-bottom:-30px;">
							<div class="widget-content widget-content-area text-center tags-content">
								<div class="search-input-group-style input-group mb-3">
									<div class="input-group-prepend">
										<span class="input-group-text" id="basic-addon1"><i class="fa-brands fa-cc-mastercard fa-2x"></i></span>
									</div>
									<input type="text" id="searchInput" class="form-control" placeholder="Поиск по картам..." aria-label="Username" aria-describedby="basic-addon1">
								</div>
																										<small id="emailHelp" style="margin-top:-10px;" class="form-text text-muted">Поиск доступен по следующим параметрам: номер карты, имя дропа, COM порт, контакт дропа.</small>

							</div>
						</div>
						<table id="recordListing" class="table table-hover" style="width:100%">
							<thead>
								<tr>
									<th width="2%">Банк</th>
									<th width="3%">Карта</th>
									<th width="5%">Статус</th>
									<th width="5%">Лимит</th>
									<th>Порт</th>
									<th>Категория</th>
									<th></th>
								</tr>
							</thead>
						   
						</table>
					</div>
				</div>
			
				
				
<div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
<div class="widget widget-table-one">
<div class="widget-heading">
<h6 class="">Добавить карту<span class="" style="font-size:12px;color:#888ea8;"><br>Быстрое добавление карт.</span></h6>
</div>
<hr style="margin-top:-25px;">


<div class="widget-content">
			<form action="/inc/card/save.php" id="form">
				<div class="form-group">
<input type="text" class="form-control form-control-sm" name="number" id='numbers' aria-describedby="emailHelp" placeholder="XXXX XXXX XXXX XXXX" required>
<small id="emailHelp" class="form-text text-muted">Укажите номер карты, вводить можно только цифры.</small>
</div>
													
<div class="form-group input-primary">
<select class="me-sm-2 default-select2 form-control form-control-sm" id="temp" name="temp" required>
<option value="">Выберите шаблон для карты</option>
<?
$category = $this->pdo->query("SELECT * FROM smstemp");
while ($row = $category->fetch()) {
?>
<option value="<? echo $row['port'];?>"><? echo $row['name'];?> - <? echo $row['port'];?></option>
<?
}
?>
</select>
<small id="emailHelp" class="form-text text-muted">Выберите шаблон для карты.</small>
</div>
<div class="form-group">
<input type="text" class="form-control form-control-sm" name="name" id='names' placeholder="Моя лучшая карта" required>
<small id="emailHelp" class="form-text text-muted">Можете указать, название которое легко запомнить.</small>
</div>
<div class="form-group">
<input type="number" class="form-control form-control-sm" name="limitpay" id='limitpays' placeholder="Введите лимит карты" required>
<small id="emailHelp" class="form-text text-muted">После достижения лимита карта выключится или сменится, если есть свободная.</small>
</div>
<div class="form-group">
<div class="wrapper" style="margin-top:-30px;">
<input type="radio" class="radio" name="what" value="clients" id="option-1" required>
<input type="radio" class="radio" name="what" value="shopss" id="option-2">
<label for="option-1" class="option option-1" checked>
<span style="font-size:0.9rem">Клиенты</span>
</label>
<label for="option-2" class="option option-2">
<span style="font-size:0.9rem">Магазины</span>
</label>
</div>
<div id="shopss" class="radio-blocks" style="display:none;margin-top:-30px;">
<br><select class="me-sm-2 default-select2 form-control form-control-sm selectpicker"  id="groupshop" name="groupshop" required>
<option value="" selected >Выберите категорию магазинов</option>
<?
$category = $this->pdo->query("SELECT * FROM group_shops");
while ($row = $category->fetch()) {
?>
<option value="<? echo $row['id'];?>"><? echo $row['name'];?></option>
<?
}
?>
</select>
</div>
</div>
<input id="user_id" name="user_id" type="hidden" value="<?=$_SESSION['user_id']?>" required>
<input type="hidden" class="form-control form-control-sm" name="logo_card" id='logo_cards' placeholder="Ссылка на логотип">
<input type="hidden" class="form-control form-control-sm" name="bank" id='banks' placeholder="Ссылка на логотип">
<button type="button" class="btn btn-block btn-primary" id="btnSubmit" style="margin-top:-5px;">Добавить карту</button>
</form>
</div>
</div>
</div>

<div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
<div class="widget widget-table-one" style="height:100%;">
									<div class="widget-heading">
<h6 class="">Шаблоны карт<span class="" style="font-size:12px;color:#888ea8;"><br>Добавляйте шаблоны для приёма смс.</span></h6>

<div class="task-action">

<button type="button" class="btn btn-warning btn-sm"  data-toggle="modal" data-target="#exampleModal"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg></button>

</div>
</div>
<div class="widget-content">

<div id="shablon"></div>


</div>
</div></div>


<div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
				
<div class="widget-content widget-content-area br-6">
<div class="widget widget-table-one" style="margin-bottom:-75px;">
<div class="widget-heading">
<h6 class="">Управление валютой<span class="" style="font-size:12px;color:#888ea8;"><br>Добавление, редактирование, удаление валюты.</span></h6>
</div>
</div>
<table id="recordListingc" class="table table-scroll">
<thead>
<tr>								
<th>Крипта</th>
<th>Курс RUB</th>
<th>Курс USD</th>
</tr>
</thead>
<tbody>
</tbody>
</table>
</div>

</div>
				   <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
				  
						  <div class="widget-content widget-content-area br-6">
					<div class="widget widget-table-one" style="margin-bottom:-75px;">
								<div class="widget-heading">
<h6 class="">Управление парами<span class="" style="font-size:12px;color:#888ea8;"><br>Что на что меняем.</span></h6>
<div class="task-action">

<button type="button" class="btn btn-primary btn-sm" name="addp" id="addRecordp"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg></button>

</div>
</div></div>
							<table id="recordListingp" class="table table-scroll">
<thead>
										<tr>								
											<th>ID</th>
											<th>Что</th>
											<th></th>
											<th>На что</th>
											<th></th>
											<th></th>
											</tr>
								</thead>
								<tbody>
								
								</tbody>
							</table>
						</div>
				   
				</div>
				
				
				
</div></div>

			</div>
<!-- Modal -->
								<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index:999999999;">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-titles" id="exampleModalLabel">Добавление шаблона</h5>
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												  <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
												</button>
											</div>
											<div class="modal-body">
											<form method="POST" id="smstemp" class="form" action="javascript:void(null);" onsubmit="smstemp()"> 
											 <div class="form-group">
											<input type="text" class="form-control form-control-sm" id="names" name="names" placeholder="Мой шаблон" required>
											<small id="emailHelp" class="form-text text-muted">Можете указать, название которое легко запомнить.</small>
											</div>
											<div class="form-group input-primary">
											<select class="me-sm-2 default-select2 form-control form-control-sm" id="banks" name="banks" required>
											<option value="">Выберите банк</option>
											<?
											$home = $_SERVER['DOCUMENT_ROOT'].'/';
											
											$category = $this->pdo->query("SELECT * FROM banks");
											while ($row = $category->fetch()) {
											?>
											<option value="<? echo $row['id'];?>"><? echo $row['name_rus'];?></option>
											<?
											}
											?>
												</select>
												<small id="emailHelp" class="form-text text-muted">Выберите банк выпустивший карту.</small>
												</div>
											<div class="form-group">
											<textarea class="form-control form-control-sm textarea" id="inp" name="text" placeholder="Введите текст смс" required></textarea>
											<small id="emailHelp" class="form-text text-muted">Входящая смс об успешной оплате.</small>
											</div> 
											<div id="results"></div>
											
											<div class="form-row mb-4">
										<div class="form-group col-md-4">
											<input type="number" class="form-control form-control-sm" id="summa" name="summas" placeholder="Введите число" required>
											<small id="emailHelp" class="form-text text-muted">Номер поля с суммой.</small>
										</div>
										<div class="form-group col-md-4">
											<input type="number" class="form-control form-control-sm" id="balances" name="balances" placeholder="Введите число" required>
											<small id="emailHelp" class="form-text text-muted">Номер поля с балансом.</small>
										</div>
										<div class="form-group col-md-4">
											<input type="number" class="form-control form-control-sm" id="num_ident" name="num_ident" placeholder="COM порт" required>
											<small id="emailHelp" class="form-text text-muted">Номер COM порта на симбанке.</small>

										</div>
									</div>
								
									<div id="result"></div>
											</div>
											<div class="modal-footer">
											<button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Закрыть</button>
											<input type="submit" class="btn btn-primary" value="Cохранить">
											</div>												
											</form>
											

											
										</div>
									</div>
								</div>

<div class="modal fade" id="exampleModalBot" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index:999999999;">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-titles" id="exampleModalLabel">Добавление бота</h5>
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												  <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
												</button>
											</div>
											<div class="modal-body">
											<form method="POST" id="apibots" class="form" action="javascript:void(null);" onsubmit="apibots()"> 
											 <div class="form-group">
											<input type="text" class="form-control form-control-sm" id="token" name="token" placeholder="Введите токен бота" required>
											<small id="emailHelp" class="form-text text-muted">Можете указать, название которое легко запомнить.</small>
											</div>
											<div id="resultsapibots"></div>
											</div>
											<div class="modal-footer">
											<button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Закрыть окно</button>
											<input type="submit" class="btn btn-primary" value="Добавить бота">
											</div>												
											</form>
											

											
										</div>
									</div>
								</div> 									
	<!--  END CONTENT AREA  -->
<div class="modal fade" id="recordModalc">
											<div class="modal-dialog modal-dialog-centered" role="document">
												<div class="modal-content">
													<div class="modal-header">
														<h5 class="modal-title">Редактирование валюты</h5>
														<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span>&times;</span>
														</button>
													</div>
													<form method="post" id="recordFormc">
													<div class="modal-body">
								

									<div class="mb-4">
									<input id="nominal" class="form-control form-control-sm" type="text" value="" name="nominal" placeholder="Введите номинал" class="" required>
									<small id="emailHelp" class="form-text text-muted">Короткое название валюты, например BTC, LTC, ETH, и.т.п...</small>

								</div>
								<div class="mb-4">
									<input id="logo" class="form-control form-control-sm" type="text" value="" name="logo" placeholder="Ссылка на логотип (по желанию)" class="">
									<small id="emailHelp" class="form-text text-muted">Ссылка на иконку валюты</small>

								</div>
																	<div class="mb-4">
									<input id="kurs" class="form-control form-control-sm" type="text" value="" name="kurs" placeholder="Курс валюты" class="">
									<small id="emailHelp" class="form-text text-muted">Рублёвый курс валюты</small>

								</div>
									<div class="mb-4">
									<input id="user_id" class="form-control form-control-sm" type="text" value="" name="user_id" placeholder="ID кошелька" class="">
									<small id="emailHelp" class="form-text text-muted">ID кошелька от аккаунта Coinbase</small>

								</div>
									<div class="mb-4">
									<input id="network" class="form-control form-control-sm" type="text" value="" name="network" placeholder="Полное название" class="">
									<small id="emailHelp" class="form-text text-muted">Полное название валюты, например litecoin? bitcoin и.т.п...</small>

								</div>
													
													
												
												<input type="hidden" name="id" id="id" />
												<input type="hidden" name="actionc" id="actionc" value="" />
												<input type="submit" name="savec" id="savec" class="btn btn-block btn-primary" value="Сохранить изменения" />
													
													</form>
												</div>
											</div>
										</div> 

		</div>
										<div class="modal fade" id="recordModals">
											<div class="modal-dialog modal-dialog-centered" role="document">
												<div class="modal-content">
													<div class="modal-header">
														<h5 class="modal-title">Просмотр карты #<span class="id"></span></h5>
														<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span>&times;</span>
														</button>
													</div>
													
													<div class="modal-body" style="margin-top:-20px;">
													<b>ID Карты:</b> <span class="id"></span><br>
										<b>Номер карты:</b> <span class="number"></span><br>
										<b>Баланс:</b> <span class="balance"></span><br>
										<b>Лимит:</b> <span class="limitpay"></span> ₽<br>
										<b>Категория:</b> <span class="what"></span><br>
										<b>Статус:</b> <span class="active"></span><br>
										<hr>
										Инфо о дропе:<br>
<b>Номер телефона:</b> <span class="drop_tel"></span><br>
<b>Имя:</b> <span class="drop_name"></span><br>
<b>Контакт:</b> <span class="drop_contact"></span>
<hr>
<span class="zametka"></span>
<hr>						
											<button type="button" class="btn btn-primary mb-2 mr-2">
									  Копировать
									</button>
											</div>
											
												</div>
											</div>
										</div>
										
										<div class="modal fade" id="recordModalp">
											<div class="modal-dialog modal-dialog-centered" role="document">
												<div class="modal-content">
													<div class="modal-header">
														<h5 class="modal-title">Редактирование пары</h5>
														<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span>&times;</span>
														</button>
													</div>
													<form method="post" id="recordFormp">
													<div class="modal-body">
								
<div class="form-row mb-4">
												  <div class="form-group col-md-6">
											<label for="currency_in">Продажа</label>
											<select id="currency_in" name='currency_in' class="form-control" required>
											 <option value="">Выбрать...</option>
											<?
											$category = $this->pdo->query("SELECT * FROM currency_in");
											while ($row = $category->fetch()) {
											?>
											<option value="<? echo $row['nominal'];?>"><? echo $row['nominal'];?></option>
											<?
											}
											?>
											</select>
										</div>
										<div class="form-group col-md-6">
											<label for="currency_out">Покупка</label>
											<select id="currency_out" name='currency_out' class="form-control" required>
												<option value="">Выбрать...</option>
												<?
											$categorys = $this->pdo->query("SELECT * FROM currency_in");
											while ($rows = $categorys->fetch()) {
											?>
											<option value="<? echo $rows['nominal'];?>"><? echo $rows['nominal'];?></option>
											<?
											}
											?>
											</select>
										</div>
										</div>
									<div class="form-group">
									<code>Процент</code>
											<div class="custom-progress progress-down" style="width: 100%">
                                        <input type="range" min="0" max="100" name="percent" id="percent" class="custom-range progress-range-counter" value="0">
                                        <div class="range-count" style="margin-top:-3px;"><span class="range-count-number percent" data-rangecountnumber="0">0</span> <span class="range-count-unit">%</span></div>
                                    </div>
									 </div>
													
													
												
												<input type="hidden" name="id" id="ids" />
												<input type="hidden" name="actionp" id="actionp" value="" />
												<input type="submit" name="savep" id="savep" class="btn btn-block btn-primary" value="Сохранить изменения" />
													
													</form>
												</div>
											</div>
										</div> 

		</div>
		
		
		
		
		<!-- The Modal -->
<div class="modal" id="edit-employee-modal" style="z-index:9999999;">
	<div class="modal-dialog">
		<div class="modal-content">

			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title">Редактирование карты</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
				<form action="/inc/card/update.php" id="editform">
					<input class="form-control" type="hidden" name="id">
					
					<div class="modal-body" style="margin-top:0px;">
					<div class="form-group">
											<input type="text" class="form-control form-control-sm" name="number" id='number' aria-describedby="emailHelp" placeholder="XXXX XXXX XXXX XXXX" required>
											<small id="emailHelp" class="form-text text-muted">Укажите номер карты, вводить можно только цифры.</small>
										  </div>
													
												<div class="form-group input-primary">
											<select class="me-sm-2 default-select2 form-control form-control-sm" id="temp" name="temp" required>
											<option value="">Выберите шаблон для карты</option>
											<?
											$category = $this->pdo->query("SELECT * FROM smstemp");
											while ($row = $category->fetch()) {
											?>
											<option value="<? echo $row['port'];?>"><? echo $row['name'];?> - <? echo $row['port'];?></option>
											<?
											}
											?>
												</select>
												<small id="emailHelp" class="form-text text-muted">Выберите шаблон для карты.</small>
												</div>
										  <div class="form-group">
											<input type="text" class="form-control form-control-sm" name="name" id='name' placeholder="Моя лучшая карта" required>
											<small id="emailHelp" class="form-text text-muted">Можете указать, название которое легко запомнить.</small>
										  </div>
										  <div class="form-group">
											<input type="number" class="form-control form-control-sm" name="limitpay" id='limitpay' placeholder="Введите лимит карты" required>
											<small id="emailHelp" class="form-text text-muted">После достижения лимита карта выключится или сменится, если есть свободная.</small>

										  </div>
<select id="select" name="what"  class="me-sm-2 default-select2 form-control form-control-sm" >
	<option value="clients">Клиентская картв</option>
	<option value="shops">Карта для магазинов</option>
	
</select><br>
<div id="shops" class="select-blocks" style="display:none">
<select class="me-sm-2 default-select2 form-control form-control-sm"  id="groupshop" name="groupshop" required>
<option value="" selected >Выберите категорию магазинов</option>
<?
$category = $this->pdo->query("SELECT * FROM group_shops");
while ($row = $category->fetch()) {
?>
<option value="<? echo $row['id'];?>"><? echo $row['name'];?></option>
<?
}
?>
</select>
</div>





								
<input type="hidden" class="form-control form-control-sm" name="logo_card" id='logo_card' placeholder="Ссылка на логотип">
<input type="hidden" class="form-control form-control-sm" name="bank" id='bank' placeholder="Ссылка на логотип">

										<hr>		
																					
											
											<div><a href="javascript:collapsElement('identifikator')" class="btn btn-block btn-warning mb-4 mr-2 btn-sm" title="" rel="nofollow">Дополнительная информация</a>
											<div id="identifikator" style="display: none">
											<div class="form-group">
											<label for="drop_name">Имя дропа</label>
											<input type="text" class="form-control form-control-sm" id="drop_name" name="drop_name" aria-describedby="emailHelp" placeholder="Введите имя">
											<small id="emailHelp" class="form-text text-muted">По желанию укажите имя владельца карты.</small>
										  </div>
																						<div class="form-group">
											<label for="drop_tel">Телефон дропа</label>
											<input type="text" class="form-control form-control-sm" id="drop_tel" name="drop_tel" aria-describedby="emailHelp" placeholder="Введите телефон">
											<small id="emailHelp" class="form-text text-muted">По желанию укажите телефон владельца карты.</small>
										  </div>
																						<div class="form-group">
											<label for="drop_contact">Контакт дропа</label>
											<input type="text" class="form-control form-control-sm" id="drop_contact" name="drop_contact" aria-describedby="emailHelp" placeholder="Введите дополнительный контакт">
											<small id="emailHelp" class="form-text text-muted">По желанию укажите контакт например юз из телеги.</small>
										  </div>
										  
				 
											
											<div class="form-group">
											<label for="drop_contact">Заметки к карте</label>
											<textarea class="form-control form-control-sm" name="zametka" id="zametka" placeholder="Пишите что хотите...." rows="4"></textarea>
											<div class="mt-1">
												<span class="badge badge-primary w-100">
													<small id="sh-text7" class="form-text mt-0 text-left">Можете оставить заметку, всё что угодно.</small>
												</span>
											</div>
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
<!-- END MAIN CONTAINER -->

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
$(function() {
$("#" + $("#select option:selected").val()).show();
$("#select").change(function(){
	$(".select-blocks").hide();
	$("#" + $(this).val()).show();
});
});
$("input#bank").on({
keydown: function(e) {
if (e.which === 32)
  return false;
},
change: function() {
this.value = this.value.replace(/\s/g, "");
}
});
var inputbal = document.getElementById('balances');
inputbal.oninput = function (event) {
var msg   = $('#smstemp').serialize();
$.ajax({
	  type: 'POST',
	  url: '/3.php',
	  data: msg,
	  success: function(html){  
	  $("#results").html(html);  
	 },
	  
	});
};

var inputsum = document.getElementById('summa');
inputsum.oninput = function (event) {
var msg   = $('#smstemp').serialize();
$.ajax({
	  type: 'POST',
	  url: '/3.php',
	  data: msg,
	  success: function(html){  
	  $("#results").html(html);  
	 },
	  
	});
};

var input = document.getElementById('inp');

input.oninput = function (event) {
var msg   = $('#smstemp').serialize();
$.ajax({
	  type: 'POST',
	  url: '/3.php',
	  data: msg,
	  success: function(html){  
	  $("#results").html(html);  
	 },
	  
	});
};


input.onblur = function (event) {
console.log('Элемент вышел из фокуса');
};


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
</script>
<script>
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
// навешиваем обработчики посе загрузки окна
if (window.addEventListener)
window.addEventListener("load", mobileTextarea, false);
else if (window.attachEvent)
window.attachEvent("onload", mobileTextarea);
$(function() {
$("#" + $(".radio:checked").val()).show();
$(".radio").change(function(){
	$(".radio-blocks").hide();
	$("#" + $(this).val()).show();
});
});

var input = document.getElementById('number');
input.addEventListener("focusout", function() {
var msg   = $('#editform').serialize();
	$.ajax({
	  dataType: "json",
	  type: 'POST',
	  url: '/checkcard.php',
	  data: msg,
	  success: function(data) {
		if (data.resultat == "success") {
	  Snackbar.show({
	  text: data.mess,
	  showAction: false,
	  actionTextColor: '#fff',
	  backgroundColor: '#1abc9c'
});
	}
		var x=data.result;
		var x=data.result;
		var l=data.logo_card;
		document.getElementById('bank').value= x;
		document.getElementById('name').value= x;
		document.getElementById('logo_card').value= l;
	  },
	  error:  function(xhr, str){
	alert('Возникла ошибка: ' + xhr.responseCode);
	  }
	});
});

var cc = editform.number;
for (var i in ['input', 'change', 'blur', 'keyup']) {
cc.addEventListener('input', formatCardCode, false);
}
function formatCardCode() {
var cardCode = this.value.replace(/[^\d]/g, '').substring(0,16);
cardCode = cardCode != '' ? cardCode.match(/.{1,4}/g).join(' ') : '';
this.value = cardCode;
}








var input = document.getElementById('numbers');
input.addEventListener("focusout", function() {
var msg   = $('#form').serialize();
	$.ajax({
	  dataType: "json",
	  type: 'POST',
	  url: '/checkcard.php',
	  data: msg,
	  success: function(data) {
		if (data.resultat == "success") {
	  Snackbar.show({
	  text: data.mess,
	  showAction: false,
	  actionTextColor: '#fff',
	  backgroundColor: '#1abc9c'
});
	}
		var x=data.result;
		var x=data.result;
		var l=data.logo;
		document.getElementById('banks').value= x;
		document.getElementById('names').value= x;
		document.getElementById('logo_cards').value= l;
	  },
	  error:  function(xhr, str){
	alert('Возникла ошибка: ' + xhr.responseCode);
	  }
	});
});

var cc = form.number;
for (var i in ['input', 'change', 'blur', 'keyup']) {
cc.addEventListener('input', formatCardCode, false);
}
function formatCardCode() {
var cardCode = this.value.replace(/[^\d]/g, '').substring(0,16);
cardCode = cardCode != '' ? cardCode.match(/.{1,4}/g).join(' ') : '';
this.value = cardCode;
}

$(function() {
$("#" + $("#what option:selected").val()).show();
$("#what").change(function(){
	$(".shops").hide();
	$("#" + $(this).val()).show();
});
});
$("#number").mask("9999-9999-9999-9999");
</script>
<script>
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

$(document).ready(function(){	

var dataRecords = $('#recordListingp').DataTable({
	"dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
	"<'table-responsive'tr>" +
	"<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
	"oLanguage": {
		"oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
		"sInfo": "Showing page _PAGE_ of _PAGES_",
		"sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
		"sSearchPlaceholder": "Search...",
	   "sLengthMenu": "Results :  _MENU_",
	},
	"stripeClasses": [],
	"lengthChange": false,
	//"sPaginationType": "scrolling",
	"bProcessing": true,
	"buttons": false,
	"sAutoWidth": false,
	"bDestroy":true,
	"info":true,
	"sScrollY": "230",  
	"bSort": true,
	"bJQueryUI": false, // ThemeRoller-stöd
	"bLengthChange": false, //Колличество товаров на страницу
	"iDisplayStart ": 10,
	"iDisplayLength": 10,
	"paging": false,//Dont want paging                
	"bPaginate": false, //hide pagination
	"bFilter": false, //hide Search bar
	"bInfo": false, // hide showing entries
	"lengthMenu": [7, 10, 20, 50],
	"pageLength": 7,
	"serverSide":true,
	'processing': true,
	'serverMethod': 'post',		
	"order":[],
	"ajax":{
		url:"/ajaxcurrency/",
		type:"POST",
		data:{actionp:'listRecords'},
		dataType:"json"
	},
	"columnDefs":[
		{
			"targets":[0,1,2,3,4],
			"orderable":false,
		},
	],
	"pageLength": 10
});	

$('#addRecordp').click(function(){
	$('#recordModalp').modal('show');
	$('#recordFormp')[0].reset();
	$('.modal-title').html("<i class='fa fa-plus'></i> Добавление пары");
	$('#actionp').val('addRecordp');
	$('#savep').val('Добавить пару');
	// Change button class
$("input[name='percent']").TouchSpin({
verticalbuttons: true,
verticalup: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-up"><polyline points="18 15 12 9 6 15"></polyline></svg>',
verticaldown: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg>',
buttondown_class: "btn btn-classic btn-info",
buttonup_class: "btn btn-classic btn-danger"
});
});		
$("#recordListingp").on('click', '.update', function(){
	var id = $(this).attr("id");
	var actionp = 'getRecord';
	$.ajax({
		url:'/ajaxcurrency/',
		method:"POST",
		data:{id:id, actionp:actionp},
		dataType:"json",
		success:function(data){
			$('#recordModalp').modal('show');
			$('#ids').val(data.id);
			$('#percent').val(data.percent);
			$('.percent').html(data.percent);
			$('#currency_in').val(data.currency_in);
			$('#currency_out').val(data.currency_out);	
			$('.modal-title').html("<i class='fa fa-plus'></i> Редактирование пары");
			$('#actionp').val('updateRecordp');
			$('#savep').val('Сохранить изменения');
			// Change button class
$("input[name='percent']").TouchSpin({
verticalbuttons: true,
verticalup: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-up"><polyline points="18 15 12 9 6 15"></polyline></svg>',
verticaldown: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg>',
buttondown_class: "btn btn-classic btn-info",
buttonup_class: "btn btn-classic btn-danger"
});
		}
	})
});
$("#recordModalp").on('submit','#recordFormp', function(event){
	event.preventDefault();
	$('#savep').attr('disabled','disabled');
	var formData = $(this).serialize();
	$.ajax({
		url:"/ajaxcurrency/",
		method:"POST",
		data:formData,
		success:function(data){				
			$('#recordFormp')[0].reset();
			$('#recordModalp').modal('hide');				
			$('#savep').attr('disabled', false);
			dataRecords.ajax.reload();
			parent.document.getElementById("#recordFormp").reload();
				Snackbar.show({
				text: 'Пара успешно сохранена',
				showAction: false,
				actionTextColor: '#fff',
				backgroundColor: '#1abc9c'
				});
			

		}
	})
});		
$("#recordListingp").on('click', '.delete', function(){
	var id = $(this).attr("id");		
	var actionp = "deleteRecord";
		$.ajax({
			url:"/ajaxcurrency/",
			method:"POST",
			data:{id:id, actionp:actionp},
			success:function(data) {					
				dataRecords.ajax.reload();
				Snackbar.show({
				text: 'Успешно удалено',
				showAction: false,
				actionTextColor: '#fff',
				backgroundColor: '#1abc9c'
				});
			}
		})
});
	$("#recordListingp").on('click', '.active', function(){
	var id = $(this).attr("id");		
	var actionp = "activeRecord";
		$.ajax({
			url:"/ajaxcurrency/",
			method:"POST",
			data:{id:id, actionp:actionp},
			success:function(data) {					
				dataRecords.ajax.reload();
			}
		})
});
$("#recordListingp").on('click', '.inactive', function(){
	var id = $(this).attr("id");		
	var actionp = "inactiveRecord";
		$.ajax({
			url:"/ajaxcurrency/",
			method:"POST",
			data:{id:id, actionp:actionp},
			success:function(data) {					
				dataRecords.ajax.reload();
			}
		})
});
});
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
	targets:1,
	width:"30px",
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
		url:"/ajaxcardclients/",
		type:"POST",
		data:{action:'listRecords'},
		dataType:"json"
	},
	"pageLength": 5
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
		url:'/ajaxcardclients/',
		method:"POST",
		data:{id:id, action:action},
		dataType:"json",
		success:function(data){
			$('#recordModal2').modal('show');
			var x='option-2';
			$('.id').html(data.id);
			$('#name').val(data.name);
			$('#number').val(data.number);
			$('#active').val(data.active);
			$('#logo_card').val(data.logo_card);
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
$("#recordListing").on('click', '.viewsss', function(){
	var id = $(this).attr("id");
	var action = 'getRecord';
	$.ajax({
		url:'/ajaxcardclients/',
		method:"POST",
		data:{id:id, action:action},
		dataType:"json",
		success:function(data){
			$('#recordModals').modal('show');
			$('.id').html(data.id);
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
	$("#recordListing").on('click', '.active', function(){
	var id = $(this).attr("id");		
	var action = "activeRecord";
		$.ajax({
			url:"/ajaxcardclients/",
			method:"POST",
			data:{id:id, action:action},
			success:function(data) {					
				dataRecords.ajax.reload();
				Snackbar.show({
				text: 'Карта назначена активной',
				showAction: false,
				actionTextColor: '#fff',
				backgroundColor: '#1abc9c'
				});
			}
		})
});
$("#recordListing").on('click', '.inactive', function(){
	var id = $(this).attr("id");		
	var action = "inactiveRecord";
		$.ajax({
			url:"/ajaxcardclients/",
			method:"POST",
			data:{id:id, action:action},
			success:function(data) {					
				dataRecords.ajax.reload();
				Snackbar.show({
				text: 'Карта успешно отключена',
				showAction: false,
				actionTextColor: '#fff',
				backgroundColor: '#e7515a'
				});
			}
		})
});
$("#recordListing").on('click', '.blocked', function(){
	var id = $(this).attr("id");		
	var action = "blockedRecord";
		$.ajax({
			url:"/ajaxcardclients/",
			method:"POST",
			data:{id:id, action:action},
			success:function(data) {					
				dataRecords.ajax.reload();
				Snackbar.show({
				text: 'Карта отмечена как блокированная',
				showAction: false,
				actionTextColor: '#fff',
				backgroundColor: '#e7515a'
				});
			}
		})
});
$("#recordListing").on('click', '.problem', function(){
	var id = $(this).attr("id");		
	var action = "problemRecord";
		$.ajax({
			url:"/ajaxcardclients/",
			method:"POST",
			data:{id:id, action:action},
			success:function(data) {					
				dataRecords.ajax.reload();
				Snackbar.show({
				text: 'Карта отмечена как проблемная',
				showAction: false,
				actionTextColor: '#fff',
				backgroundColor: '#e7515a'
				});
			}
		})
});
	$("#recordListing").on('click', '.resh', function(){
	var id = $(this).attr("id");		
	var action = "reshRecord";
		$.ajax({
			url:"/ajaxcardclients/",
			method:"POST",
			data:{id:id, action:action},
			success:function(data) {					
				dataRecords.ajax.reload();
				Snackbar.show({
				text: 'Статус карты изменён',
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
	url: '/inc/card/all.php', // get the route value
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
				html += "<p>" + value.first_name +' '+ value.last_name + " <span class='list-number'>(" + value.number + ")</span>" + "</p>";
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

			// Reset form
			resetForm(form);
			dataRecords.ajax.reload();
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
		url: '/inc/card/get.php', // get the route value
		data: {employee_id:employeeId}, //set data
		beforeSend: function () {//We add this before send to disable the button once we submit it so that we prevent the multiple click
			
		},
		success: function (response) {//once the request successfully process to the server side it will return result here
			response = JSON.parse(response);
			$("#editform [name=\"id\"]").val(response.id);
			$("#editform [name=\"number\"]").val(response.number);
			$("#editform [name=\"temp\"]").val(response.temp);
			$("#editform [name=\"name\"]").val(response.name);
			$("#editform [name=\"limitpay\"]").val(response.limitpay);
			$("#editform [name=\"what\"]").val(response.what);
			$("#editform [name=\"groupshop\"]").val(response.groupshop);
			$("#editform [name=\"bank\"]").val(response.bank);
			$("#editform [name=\"logo_card\"]").val(response.logo_card);
			$("#editform [name=\"active\"]").val(response.active);
			$("#editform [name=\"drop_name\"]").val(response.drop_name);
			$("#editform [name=\"drop_contact\"]").val(response.drop_contact);
			$("#editform [name=\"drop_tel\"]").val(response.drop_tel);
			$("#editform [name=\"zametka\"]").val(response.zametka);
			$("#editform [name=\"user_id\"]").val(response.user_id);
			if (response.what == "clients") {
				document.getElementById('clients').selected=true;
				$(".select-blocks").hide();
				} else {
				document.getElementById('shops').selected=true;
				$(".select-blocks").show();				
				}
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
		type: "POST", //we are using POST method to submit the data to the server side
		url: route, // get the route value
		data: formData, // our serialized array data for server side
		beforeSend: function () {//We add this before send to disable the button once we submit it so that we prevent the multiple click
			$this.attr('disabled', true).html("Processing...");
		},
		success: function (response) {//once the request successfully process to the server side it will return result here
			$this.attr('disabled', false).html($caption);
            dataRecords.ajax.reload();
			// Reload lists of employees
			all();

			// We will display the result using alert
			Swal.fire({
			  icon: 'success',
			  title: 'Успешно',
			  html: "<font color='#FFF'>"+response.mess+"</font>"
			});

			// Reset form
			resetForm(form);

			// Close modal
			$('#edit-employee-modal').modal('toggle');
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
		title: 'Вы уверены что хотите удалить данную карту?',
		showDenyButton: false,
		showCancelButton: true,
		confirmButtonText: 'Да, удалить'
	}).then((result) => {
	  /* Read more about isConfirmed, isDenied below */
	  if (result.isConfirmed) {

		var employeeId = $(this).attr('data-id');
        var userId = <?=$_SESSION['user_id']?>;
		// Ajax config
		$.ajax({
			type: "GET", //we are using GET method to get data from server side
			url: '/inc/card/delete.php?user_id='+userId, // get the route value
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
		
		function apibotsshow()
	{   
		$.ajax({
			url: "/apibots/",
			method: 'GET',
			data: {},
			cache: false,
			success: function(html){
				$("#apibotsshow").html(html);
			}
		});
	}
		$(document).ready(function(){  
			apibotsshow();
		}); 
</script>		
<script>

$(document).ready(function(){	

var dataRecords = $('#recordListingc').DataTable({
	"dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
	"<'table-responsive'tr>" +
	"<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
	"oLanguage": {
		"oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
		"sInfo": "Showing page _PAGE_ of _PAGES_",
		"sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
		"sSearchPlaceholder": "Search...",
	   "sLengthMenu": "Results :  _MENU_",
	},
	"stripeClasses": [],
	"lengthChange": false,
	//"sPaginationType": "scrolling",
	"bProcessing": true,
	"buttons": false,
	"sAutoWidth": false,
	"bDestroy":true,
	"info":true,
	"sScrollY": "230", 
	"bSort": true,
	"bJQueryUI": false, // ThemeRoller-stöd
	"bLengthChange": false, //Колличество товаров на страницу
	"iDisplayStart ": 10,
	"iDisplayLength": 10,
	"paging": false,//Dont want paging                
	"bPaginate": false, //hide pagination
	"bFilter": false, //hide Search bar
	"bInfo": false, // hide showing entries
	"lengthMenu": [7, 10, 20, 50],
	"pageLength": 7,
	"serverSide":true,
	'processing': true,
	'serverMethod': 'post',		
	"order":[],
	"ajax":{
		url:"/ajaxvaluta/",
		type:"POST",
		data:{actionc:'listRecords'},
		dataType:"json"
	},
	"columnDefs":[
		{
			"targets":[0,1,2],
			"orderable":false,
		},
	],
	"pageLength": 10
});		
});
</script>
			
<script>
function apibots() {
  var msg   = $('#apibots').serialize();
	$.ajax({
	  dataType: "json",
	  type: 'POST',
	  url: '/addbots/',
	  data: msg,
	  success: function(data) {
	if (data.result == "success") {
	  $("#apibots")[0].reset();
	  Snackbar.show({
	  text: data.mess,
	  showAction: false,
	  actionTextColor: '#fff',
	  backgroundColor: '#1abc9c'
});
apibotsshow();
	} else {
		
	}
	 },
	  
	});

} 




function smstemp() {
  var msg   = $('#smstemp').serialize();
	$.ajax({
	  dataType: "json",
	  type: 'POST',
	  url: '/addsmstemp/',
	  data: msg,
	  success: function(data) {
	if (data.result == "success") {
	  $("#smstemp")[0].reset();
	  Snackbar.show({
	  text: data.mess,
	  showAction: false,
	  actionTextColor: '#fff',
	  backgroundColor: '#1abc9c'
});
show();
	} else {
		
	}
	 },
	  
	});

} 
function smstemppred() {
  var msg   = $('#smstemppred').serialize();
	$.ajax({
	  type: 'POST',
	  url: '/3.php',
	  data: msg,
	  success: function(html){  
	  $("#results").html(html);  
	 },
	  
	});

} 
	</script>
	
</body>
</html>