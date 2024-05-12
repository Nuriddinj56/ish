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
.list-group-item {
	
	background-color: #0e1726;
	width: 100%;
}
.list-group-item:hover {
background-color: #191e3a;	
}
.list-group-item:active {
background-color: #191e3a;	
}
</style>	
<div class="row layout-top-spacing">
   
	    	<div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
<div class="widget widget-table-one">
<div class="widget-heading">
<h6 class="">Добавить бота<span class="" style="font-size:12px;color:#888ea8;"><br>Быстрое добавление бота.</span></h6>
</div>
<hr style="margin-top:-25px;">
<div class="widget-content">
<form action="/inc/mybots/save.php" id="form">

<div class="input-group mb-4">
<input type="text" name="token" id='token' class="form-control" placeholder="Введите токен нового бота" aria-label="Recipient's username">
<div class="input-group-append">
<button id="btn" class="btn btn-primary" type="button">Проверить</button>
</div>
</div>
<div id="resultsapibots"></div>

<input id="user_id" name="user_id" type="hidden" value="10" required>
<input type="hidden" class="form-control form-control-sm" name="logo_card" id='logo_cards' placeholder="Ссылка на логотип">
<input type="hidden" class="form-control form-control-sm" name="bank" id='banks' placeholder="Ссылка на логотип">
<button type="button" class="btn btn-block btn-primary" id="btnSubmit" style="margin-top:-5px;">Добавить бота</button>
</form>
</div>
</div>
</div>

	    	<div class="col-md-8">
	    		<div id="employees-list"></div>
	    	</div>

</div></div></div>
	<!-- Must put our javascript files here to fast the page loading -->
	
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
		$('#btn').click(function(){
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
	
let token = document.querySelector("#token");
let button = document.querySelector("#btnSubmit");

token.addEventListener("input", ButtonED);

function ButtonED(){
  if (token.value == ""){
    button.disabled = true;
  } else {
    button.disabled = false;
  }
}
ButtonED()
</script>
	
	
	<script src="/assets/plugins/sweetalert2/sweetalert2.min.js"></script>
	<script>
	

function all() 
{
	// Ajax config
	$.ajax({
        type: "GET", //we are using GET method to get all record from the server
        url: '/inc/mybots/all.php', // get the route value
        success: function (response) {//once the request successfully process to the server side it will return result here
            
            // Parse the json result
        	response = JSON.parse(response);

            var html = "";
            // Check if there is available records
            if(response.length) {
            	html += '<div class="list-group">';
	            // Loop the parsed JSON
	            $.each(response, function(key,value) {
	            	if (value.status == "Активирован") {
						var status = "<font color='GREEN'>" + value.status + "</font>";
					} else {
						
						var status = "<font color='RED'>" + value.status + "</font>";
						
					}
					html += '<a href="#" class="list-group-item">';
					html += "<p>" + value.name +' '+ status + " <span class='list-username'>(" + value.username + ")</span>" + "</p>";
					html += "<p class='list-token' style='font-size:0.7rem'>" + value.token + "</p>";
					html += "<button class='btn btn-sm btn-danger mt-2 ml-2 btn-delete-employee' onclick='return false' data-id='"+value.id+"' typle='button'>Удалить бота</button>";
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
	        url: '/inc/mybots/get.php', // get the route value
	        data: {employee_id:employeeId}, //set data
	        beforeSend: function () {//We add this before send to disable the button once we submit it so that we prevent the multiple click
	            
	        },
	        success: function (response) {//once the request successfully process to the server side it will return result here
	            response = JSON.parse(response);
	            $("#edit-form [name=\"id\"]").val(response.id);
	            $("#edit-form [name=\"username\"]").val(response.username);
	            $("#edit-form [name=\"name\"]").val(response.name);
	            $("#edit-form [name=\"status\"]").val(response.status);
	            $("#edit-form [name=\"token\"]").val(response.token);
	        }
	    });
	});
}

function update() 
{
	$("#btnUpdateSubmit").on("click", function() {
		var $this 		    = $(this); //submit button selector using ID
        var $caption        = $this.html();// We store the html content of the submit button
        var form 			= "#edit-form"; //defined the #form ID
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

	            // Reload lists of employees
	            all();

	            // We will display the result using alert
	            Swal.fire({
				  icon: 'success',
				  title: 'Success.',
				  text: response
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
title: 'Вы уверены что хотите удалить данного бота?',
showDenyButton: false,
showCancelButton: true,
confirmButtonText: 'Да, удалить',
cancelButtonText: 'Нет, не удалять'
}).then((result) => {
/* Read more about isConfirmed, isDenied below */
if (result.isConfirmed) {
var employeeId = $(this).attr('data-id');
// Ajax config
$.ajax({
	type: "GET", //we are using GET method to get data from server side
	url: '/inc/mybots/delete.php', // get the route value
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
	
	</script>

</body>
  
</html>