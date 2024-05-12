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
		"pageLength": 10
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
			url:'/ajaxcardclients/',
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
			url:"/ajaxcardclients/",
			method:"POST",
			data:formData,
			success:function(data){	
				$('#recordForm')[0].reset();
				$('#recordModal').modal('hide');				
				$('#save').attr('disabled', false);
				dataRecords.ajax.reload();
                Snackbar.show({
                text: 'Карта успешно сохранена',
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
		if(confirm("Удалить карту и всю историю транзакций?")) {
			$.ajax({
				url:"/ajaxcardclients/",
				method:"POST",
				data:{id:id, action:action},
				success:function(data) {					
					dataRecords.ajax.reload();
					Snackbar.show({
                    text: 'Карта успешно удалена',
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