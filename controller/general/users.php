<? include './template/template_header.tpl';
if (empty($_SESSION['user_id'])):
	header('Location: /auth/');
	exit;
endif;

		$insertSql = $this->pdo->prepare("INSERT INTO activity_admin SET user_id = :user_id, text = :text, date = :date");
		$insertSql->execute([
			'user_id' => $_SESSION['user_id'],
			'text' => 'В пользователях',
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

<style>
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
.badge-user {
  color: #fff;
  background-color: #17212b; }	
</style>

			
                <div class="row layout-top-spacing">
                
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
					
                        <div class="widget-content widget-content-area br-6">
						<div class="widget widget-table-one" style="margin-bottom:-45px;">
									<div class="widget-heading">
<h6 class="">Управление пользователями<span class="" style="font-size:12px;color:#888ea8;"><br>Редактирование, настройки.</span></h6>


</div></div>
 <div class="statbox widget box box-shadow" style="margin-bottom:-40px;">
                                <div class="widget-content widget-content-area text-center tags-content">
                                    <div class="demo-search-overlay"></div>

                                    <div class="full-search search-form-overlay">
                                        <form class="form-inline form-inline search mt-lg-0" role="search">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                                            <div class="search-bar">
                                                <input type="text" id="searchInput" class="form-control search-form-control  ml-lg-auto" placeholder="Поиск пользователя...">
                                            </div>
											
                                        </form>
										
                                    </div>
									<small id="emailHelp" class="form-text text-muted">Поиск доступен по следующим параметрам: chat-id, имя, фамилия, username.</small>
                                </div>
                            </div>
                            <table id="recordListing" class="table" style="width:100%">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>CHAT ID</th>
										<th>Пользователь</th>
										<th>Статус</th>
										<th class="text-center"></th>
										<th>Регистрация</th>
                                        <th>Группа</th>
										<th></th>
                                    </tr>
                                </thead>
                               
                            </table>
                        </div>
                    </div>

					  
</div></div>

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
			url:"/ajaxusers/",
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
			url:'/ajaxusers/',
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
			url:'/ajaxusers/',
			method:"POST",
			data:{id:id, action:action},
			dataType:"json",
			success:function(data){
			$('#recordModal').modal('show');
				var x='option-2';
				$('#idp').val(data.id);
				$('#name').val(data.name);
				$('#number').val(data.number);
				$('#active').val(data.active);
				$('#logo').val(data.logo);
				$('#balance').val(data.balance);
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
			url:'/ajaxusers/',
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
			url:"/ajaxusers/",
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
				url:"/ajaxusers/",
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
				url:"/ajaxusers/",
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
				url:"/ajaxusers/",
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
				url:"/ajaxusers/",
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
				url:"/ajaxusers/",
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