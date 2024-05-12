

	
	
        // Get the Toast button
        var toastButton = document.getElementById("toast-btn");
        // Get the Toast element
        var toastElement = document.getElementsByClassName("toast")[0];

        toastButton.onclick = function() {
            $('.toast').toast('show');
        }

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
 var msg   = $('#recordForm').serialize();
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
            document.getElementById('bank').value= x;
			document.getElementById('name').value= x;
			document.getElementById('logo').value= l;
          },
          error:  function(xhr, str){
	    alert('Возникла ошибка: ' + xhr.responseCode);
          }
        });
});

var cc = recordForm.number;
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

 function collapsElement(id) {
 if ( document.getElementById(id).style.display != "none" ) {
 document.getElementById(id).style.display = 'none';
 }
 else {
 document.getElementById(id).style.display = '';
 }
 }

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
