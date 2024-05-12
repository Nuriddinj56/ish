$(document).ready(function(){	
	var dataRecords = $('#recordListingt').DataTable({
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
        /* {
            text: 'Добавить карту',
            className: 'btn btn-primary btn-sm',
            action: function(e, dt, node, config ) {
				$('#recordModal').modal('show');
				$('.modal-title').html("<i class='fa fa-plus'></i> Добавление карты");
				$('#action').val('addRecord');
				$('#save').val('Добавить карту');
				$('#recordForm')[0].reset();
            }
        }  */
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
			url:"/ajaxtransbot/",
			type:"POST",
			data:{action:'listRecords'},
			dataType:"json"
		},
 		"select": {
            style: "multi"
        }, 
		
		
		"pageLength": 20
	});	
	$("#recordListingt_filter").addClass("hidden"); // hidden search input
	
   $("#searchInput2").on("input", function (e) {
   e.preventDefault();
   $('#recordListingt').DataTable().search($(this).val()).draw();
   });
	$('#addRecord').click(function(){
		$('#recordModal').modal('show');
		$('#recordForm')[0].reset();
		$('.modal-title').html("<i class='fa fa-plus'></i> Добавление карты");
		$('#action').val('addRecord');
		$('#save').val('Добавить карту');
	});
	
	$("#recordListingt").on('click', '.update', function(){
		var id = $(this).attr("id");
		var action = 'getRecord';
		$.ajax({
			url:'/ajaxtransbot/',
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
	$("#recordListingt").on('click', '.delete', function(){
		var id = $(this).attr("id");		
		var action = "deleteRecord";
		if(confirm("Удалить пользователя?")) {
			$.ajax({
				url:"/ajaxtransbot/",
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
		$("#recordListingt").on('click', '.pays', function(){
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
	$("#recordListingt").on('click', '.sendmoney', function(){
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
	$("#recordListingt").on('click', '.wait', function(){
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
	$("#recordListingt").on('click', '.cancell', function(){
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
		$("#recordListingt").on('click', '.timeoff', function(){
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
