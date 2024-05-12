<? include './template/template_header.tpl'; 
if (empty($_SESSION['user_id'])):
	header('Location: /auth/');
	exit;
endif;
$idshop = $_GET['idshop'];
$getshops = $this->pdo->query("SELECT * FROM `shop` WHERE id = '".$idshop."' ");
$getshops = $getshops->fetch(PDO::FETCH_ASSOC);
		$insertSql = $this->pdo->prepare("INSERT INTO activity_admin SET user_id = :user_id, text = :text, date = :date");
		$insertSql->execute([
			'user_id' => $_SESSION['user_id'],
			'text' => 'Смотрит статистику магазина: <b>'.$getshops['name'].'</b>',
			'date' => time()
			]);
?>
<style>
@media screen and (max-width: 600px) {
  .hidemobile {
    visibility: hidden;
    display: none;
  }
}
overflow:hidden;
overflow-y:hidden;  /*для вертикального*/
overflow-x:hidden;  /*для горизонтального*/
</style>
    <link rel="stylesheet" type="text/css" href="/plugins/table/datatable/datatables.css">
    <link rel="stylesheet" type="text/css" href="/plugins/table/datatable/dt-global_style.css">
      <style>
	  
	  .daterangepicker {
  position: absolute;
  color: inherit;
  background-color: #1b2e4b;
  border-radius: 4px;
  border: 0px solid #ddd;
  width: 278px;
  max-width: none;
  padding: 0;
  margin-top: 7px;
  top: 100px;
  left: 20px;
  z-index: 3001;
  display: none;
  font-size: 15px;
  line-height: 1em;
}

.daterangepicker:before, .daterangepicker:after {
  position: absolute;
  display: inline-block;
  border-bottom-color: rgba(0, 0, 0, 0.2);
  content: '';
}

.daterangepicker:before {
  top: -7px;
  border-right: 0px solid transparent;
  border-left: 0px solid transparent;
  border-bottom: 0px solid #ccc;
}

.daterangepicker:after {
  top: -6px;
  border-right: 0px solid transparent;
  border-bottom: 0px solid #fff;
  border-left: 0px solid transparent;
}

.daterangepicker.opensleft:before {
  right: 9px;
}

.daterangepicker.opensleft:after {
  right: 10px;
}

.daterangepicker.openscenter:before {
  left: 0;
  right: 0;
  width: 0;
  margin-left: auto;
  margin-right: auto;
}

.daterangepicker.openscenter:after {
  left: 0;
  right: 0;
  width: 0;
  margin-left: auto;
  margin-right: auto;
}

.daterangepicker.opensright:before {
  left: 9px;
}

.daterangepicker.opensright:after {
  left: 10px;
}

.daterangepicker.drop-up {
  margin-top: -7px;
}

.daterangepicker.drop-up:before {
  top: initial;
  bottom: -7px;
  border-bottom: initial;
  border-top: 7px solid #ccc;
}

.daterangepicker.drop-up:after {
  top: initial;
  bottom: -6px;
  border-bottom: initial;
  border-top: 6px solid #fff;
}

.daterangepicker.single .daterangepicker .ranges, .daterangepicker.single .drp-calendar {
  float: none;
}

.daterangepicker.single .drp-selected {
  display: none;
}

.daterangepicker.show-calendar .drp-calendar {
  display: block;
}

.daterangepicker.show-calendar .drp-buttons {
  display: block;
}

.daterangepicker.auto-apply .drp-buttons {
  display: none;
}

.daterangepicker .drp-calendar {
  display: none;
  max-width: 270px;
}

.daterangepicker .drp-calendar.left {
  padding: 8px 0 8px 8px;
}

.daterangepicker .drp-calendar.right {
  padding: 8px;
}

.daterangepicker .drp-calendar.single .calendar-table {
  border: none;
}

.daterangepicker .calendar-table .next span, .daterangepicker .calendar-table .prev span {
  color: #fff;
  border: solid black;
  border-width: 0 2px 2px 0;
  border-radius: 0;
  display: inline-block;
  padding: 3px;
}

.daterangepicker .calendar-table .next span {
  transform: rotate(-45deg);
  -webkit-transform: rotate(-45deg);
}

.daterangepicker .calendar-table .prev span {
  transform: rotate(135deg);
  -webkit-transform: rotate(135deg);
}

.daterangepicker .calendar-table th, .daterangepicker .calendar-table td {
  white-space: nowrap;
  text-align: center;
  vertical-align: middle;
  min-width: 32px;
  width: 32px;
  height: 24px;
  line-height: 24px;
  font-size: 12px;
  border-radius: 4px;
  border: 1px solid transparent;
  white-space: nowrap;
  cursor: pointer;
}

.daterangepicker .calendar-table {
  border: 0px solid #fff;
  border-radius: 4px;
  background-color: #1b2e4b;
}

.daterangepicker .calendar-table table {
  width: 100%;
  margin: 0;
  border-spacing: 0;
  border-collapse: collapse;
}

.daterangepicker td.available:hover, .daterangepicker th.available:hover {
  background-color: #191e3a;
  border-color: transparent;
  color: inherit;
}

.daterangepicker td.week, .daterangepicker th.week {
  font-size: 80%;
  color: #ccc;
}

.daterangepicker td.off, .daterangepicker td.off.in-range, .daterangepicker td.off.start-date, .daterangepicker td.off.end-date {
  background-color: #1b2e4b;
  border-color: transparent;
  color: #999;
}

.daterangepicker td.in-range {
  background-color: #191e3a;
  border-color: transparent;
  color: #d3d3d3;
  border-radius: 0;
}

.daterangepicker td.start-date {
  border-radius: 4px 0 0 4px;
}

.daterangepicker td.end-date {
  border-radius: 0 4px 4px 0;
}

.daterangepicker td.start-date.end-date {
  border-radius: 4px;
}

.daterangepicker td.active, .daterangepicker td.active:hover {
  background-color: #009688;
  border-color: transparent;
  color: #000;
}

.daterangepicker th.month {
  width: auto;
}

.daterangepicker td.disabled, .daterangepicker option.disabled {
  color: #000;
  cursor: not-allowed;
  text-decoration: line-through;
}

.daterangepicker select.monthselect, .daterangepicker select.yearselect {
  font-size: 12px;
  padding: 1px;
  height: auto;
  margin: 0;
  cursor: default;
}

.daterangepicker select.monthselect {
  margin-right: 2%;
  width: 56%;
}

.daterangepicker select.yearselect {
  width: 40%;
}

.daterangepicker select.hourselect, .daterangepicker select.minuteselect, .daterangepicker select.secondselect, .daterangepicker select.ampmselect {
  width: 50px;
  margin: 0 auto;
  background: #1b2e4b;
  border: 0px solid #eee;
  padding: 2px;
  outline: 0;
  color:#FFF;
  font-size: 12px;
}

.daterangepicker .calendar-time {
  text-align: center;
  margin: 4px auto 0 auto;
  line-height: 30px;
  position: relative;
}

.daterangepicker .calendar-time select.disabled {
  color: #ccc;
  cursor: not-allowed;
}

.daterangepicker .drp-buttons {
  clear: both;
  text-align: right;
  padding: 8px;
  border-top: 1px solid #ddd;
  display: none;
  line-height: 12px;
  vertical-align: middle;
}

.daterangepicker .drp-selected {
  display: inline-block;
  font-size: 12px;
  padding-right: 8px;
}

.daterangepicker .drp-buttons .btn {
  margin-left: 8px;
  font-size: 12px;
  font-weight: bold;
  padding: 4px 8px;
}

.daterangepicker.show-ranges.single.rtl .drp-calendar.left {
  border-right: 1px solid #ddd;
}

.daterangepicker.show-ranges.single.ltr .drp-calendar.left {
  border-left: 1px solid #ddd;
}

.daterangepicker.show-ranges.rtl .drp-calendar.right {
  border-right: 1px solid #ddd;
}

.daterangepicker.show-ranges.ltr .drp-calendar.left {
  border-left: 1px solid #ddd;
}

.daterangepicker .ranges {
  float: none;
  text-align: left;
  margin: 0;
}

.daterangepicker.show-calendar .ranges {
  margin-top: 8px;
}

.daterangepicker .ranges ul {
  list-style: none;
  margin: 0 auto;
  padding: 0;
  width: 100%;
}

.daterangepicker .ranges li {
  font-size: 12px;
  padding: 8px 12px;
  cursor: pointer;
}

.daterangepicker .ranges li:hover {
  background-color: #0e1726;
}

.daterangepicker .ranges li.active {
  background-color: #0e1726;
  color: #0e1726;
}

/*  Larger Screen Styling */
@media (min-width: 564px) {
  .daterangepicker {
    width: auto;
  }

  .daterangepicker .ranges ul {
    width: 140px;
  }

  .daterangepicker.single .ranges ul {
    width: 100%;
  }

  .daterangepicker.single .drp-calendar.left {
    clear: none;
  }

  .daterangepicker.single .ranges, .daterangepicker.single .drp-calendar {
    float: left;
  }

  .daterangepicker {
    direction: ltr;
    text-align: left;
  }

  .daterangepicker .drp-calendar.left {
    clear: left;
    margin-right: 0;
  }

  .daterangepicker .drp-calendar.left .calendar-table {
    border-right: none;
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
  }

  .daterangepicker .drp-calendar.right {
    margin-left: 0;
  }

  .daterangepicker .drp-calendar.right .calendar-table {
    border-left: none;
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
  }

  .daterangepicker .drp-calendar.left .calendar-table {
    padding-right: 8px;
  }

  .daterangepicker .ranges, .daterangepicker .drp-calendar {
    float: left;
  }
}

@media (min-width: 730px) {
  .daterangepicker .ranges {
    width: auto;
  }

  .daterangepicker .ranges {
    float: left;
  }

  .daterangepicker.rtl .ranges {
    float: right;
  }

  .daterangepicker .drp-calendar.left {
    clear: none !important;
  }
}
	  </style>
    </head>
    <body style='overflow-x:hidden;'>

       <div id="content" class="main-content">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col col-sm-3">
                            <input type="text" id="daterange_textbox" style="font-size:14px;" class="form-control" readonly />
                        </div>
                    </div>
                </div>
              
                    <div class="table-responsive" style='overflow-x:hidden;'>
                        <table class="table" id="order_table" style='overflow-x:hidden;'>
                            <thead>
                                <tr>
                                    <th>Магазин</th>
                                    <th>Сумма</th>
									<th>Дата</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                
            </div>
        </div>
    </body>
</html>


<div
  class='hiddensss'
  data-idshop='<?=$idshop?>'
></div>


<? include './template/template_footer.tpl'; ?>
        <script src="/library/bootstrap-5/bootstrap.bundle.min.js"></script>
        <script src="/library/moment.min.js"></script>
        <script src="/library/daterangepickers.min.js"></script>
        <script src="/library/Chart.bundle.min.js"></script>
        <script src="/library/jquery.dataTables.min.js"></script>
        <script src="/library/dataTables.bootstrap5.min.js"></script>
		
<script>


var idshop = $('div.hiddensss').data('idshop');
$(document).ready(function(){

    fetch_data();
    
    var sale_chart;
    function fetch_data(start_date = '', end_date = '')
    {
        var dataTable = $('#order_table').DataTable({
			"lengthChange": false,
		//"sPaginationType": "scrolling",
		"bProcessing": true,
        "bDestroy":true,
		"info":false,
		"bFilter": false, // show search input
		"bSort": true,
        "bJQueryUI": false, // ThemeRoller-stöd
        "bLengthChange": false, //Колличество товаров на страницу
		"dom": "<'inv-list-top-section'<'row'<'col-sm-12 col-md-6 d-flex justify-content-md-start justify-content-center'l<'dt-action-buttons align-self-center'B>><'col-sm-12 col-md-6 d-flex justify-content-md-end justify-content-center mt-md-0 mt-3'f<'toolbar align-self-center'>>>>" +
        "<'table-responsive'tr>" +
        "<'inv-list-bottom-section d-sm-flex justify-content-sm-between text-center'<'inv-list-pages-count  mb-sm-0 mb-3'i><'inv-list-pagination'p>>",


    columnDefs:[ {
        targets:'_all',
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
		"sEmptyTable": "Ничего не найдено",
        "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
        "sSearchPlaceholder": "Поиск...",
        "sLengthMenu": "Results :  _MENU_",
    },
	
    "stripeClasses": [],
    "lengthMenu": [7, 10, 20, 50],
    "pageLength": 20,
            "processing" : true,
            "serverSide" : true,
            "order" : [],
            "ajax" : {
                url:"/action.php?idshop="+idshop,
                type:"POST",
                data:{action:'fetch', start_date:start_date, end_date:end_date}
            },

            "drawCallback" : function(settings)
            {
                var sales_date = [];
                var sale = [];
				
            }
        });
    }

    $('#daterange_textbox').daterangepicker({
    timePicker: true,
	timePicker24Hour: true,
    startDate: moment().startOf('hour'),
    endDate: moment().startOf('hour').add(32, 'hour'),
   "locale": {
	   
        "format": "YYYY-MM-DD hh:mm",
        "separator": " - ",
        "applyLabel": "Поиск",
        "cancelLabel": "Закрыть",
        "fromLabel": "From",
        "toLabel": "To",
        "customRangeLabel": "Custom",
        "weekLabel": "W",
        "daysOfWeek": [
            "Вс",
            "Пн",
            "Вт",
            "Ср",
            "Чт",
            "Пт",
            "Сб"
        ],
        "monthNames": [
            "Январь",
            "Февраль",
            "Март",
            "Апрель",
            "Май",
            "Июнь",
            "Июль",
            "Август",
            "Сентябрь",
            "Октябрь",
            "Ноябрь",
            "Декабрь"
        ],
        "firstDay": 1
    },


    }, function(start, end){

        $('#order_table').DataTable().destroy();

        fetch_data(start.format('YYYY-MM-DD hh:mm'), end.format('YYYY-MM-DD hh:mm'));

    });

});

</script>