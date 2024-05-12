

    </div>
    <!-- END MAIN CONTAINER -->

       <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <script src="/assets/js/libs/jquery-3.1.1.min.js"></script>
    <script src="/plugins/jquery-ui/jquery-ui.min.js"></script>
    <script src="/bootstrap/js/popper.min.js"></script>
    <script src="/bootstrap/js/bootstrap.min.js"></script>
    <script src="/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="/assets/js/app.js"></script>
    
    <script>
        $(document).ready(function() {
            App.init();
        });
    </script>
    <script src="/plugins/highlight/highlight.pack.js"></script>
    <script src="/assets/js/custom.js"></script>
    <!-- END GLOBAL MANDATORY STYLES -->
	<script src="/assets/panel/js/main.js"></script> <!-- Resource jQuery -->
<script src="/assets/panel/js/modernizr.js"></script> <!-- Modernizr -->
<script src="/plugins/bootstrap-select/bootstrap-select.min.js"></script>
<script src="/assets/js/forms/bootstrap_validation/bs_validation_script.js"></script>
    <script>
	function statmenu()  
            {  
                $.ajax({  
                    url: "/statmenu/",  
                    cache: false,  
                    success: function(html){  
                        $("#statmenu").html(html);
                    }  
                });  
            }
			
			$(document).ready(function(){
				statmenu();
				setInterval('statmenu();',7000);
            });
        $(document).ready(function() {
            App.init();
        });
    </script>
	
    <script src="/assets/js/custom.js"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->
	<script type='text/javascript' src='https://massivecryptopro.blocksera.com/wp-content/plugins/contact-form-7/includes/js/index.js' id='contact-form-7-js'></script>

<script type='text/javascript' id='mcw-crypto-common-js-extra'>
/* <![CDATA[ */
var mcw = {"url":"https:\/\/massivecryptopro.blocksera.com\/wp-content\/plugins\/massive-cryptocurrency-widgets\/","ajax_url":"https:\/\/massivecryptopro.blocksera.com\/wp-admin\/admin-ajax.php","currency_format":{"USD":{"iso":"USD","symbol":"$","position":"{symbol}{space}{price}","thousands_sep":",","decimals_sep":".","decimals":"2"},"EUR":{"iso":"EUR","symbol":"\u20ac","position":"{price}{space}{symbol}","thousands_sep":".","decimals_sep":",","decimals":"2"},"INR":{"iso":"INR","symbol":"\u20b9","position":"{symbol}{space}{price}","thousands_sep":",","decimals_sep":".","decimals":"2"},"GBP":{"iso":"GBP","symbol":"\u00a3","position":"{price}{space}{symbol}","thousands_sep":".","decimals_sep":",","decimals":"2"}},"default_currency_format":{"iso":"USD","symbol":"$","position":"{symbol}{space}{price}","thousands_sep":",","decimals_sep":".","decimals":"2"},"text":{"previous":"Previous","next":"Next","lengthmenu":"Coins per page: _MENU_"},"api":"coingecko"};
/* ]]> */
</script>
<script type='text/javascript' src='https://massivecryptopro.blocksera.com/wp-content/plugins/massive-cryptocurrency-widgets/assets/public/js/common.min.js' id='mcw-crypto-common-js'></script>
<script src='/js/autosize.js'></script>
<script src="https://snipp.ru/cdn/maskedinput/jquery.maskedinput.min.js"></script>
<script>
$('.mask-phone').mask('9.99999999');
</script>
<script>

function sendmoneygo() {
  var msg   = $('#sendmoneygo').serialize();
    $("#loadingsendmoney").css("display", "block");
	$.ajax({
	  type: 'POST',
	  url: '/sendmoneygo/',
	  data: msg,
	  success: function(html){  
	  $("#resultsendmoneygo").html(html);  
	 },
	  complete: function(){
        $("#loadingsendmoney").css("display", "none");
      }
	});

}


function myFunction() {

  var x = document.getElementById("mySelect").value;
  //document.getElementById("demo").innerHTML = "You selected: " + x;

$.ajax({
	  type: 'POST',
	  url: '/sendmoney/',
	  data: {coin:x},
	  success: function(html){  
	  $("#resultssend").html(html);  
	 },
});
}
</script>


	<script>
var timeoutId;
$('#basic-url, #nameobmen, #descrobmen, #page_oneobmen, #page_twoobmen, #contactsobmen, #numberobmen, #on_off').on('input propertychange change', function() {
    clearTimeout(timeoutId);
    timeoutId = setTimeout(function() {
        // Runs 1 second (1000 ms) after the last change    
        saveToDB();
    }, 1000);
});

function saveToDB()
{
	 var msg = $('#glavnoe').serialize();
     $.ajax({
        url: "/botsetting/",
        type: "POST",
        data: msg,
        success: function(data) {
 Snackbar.show({
        text: 'Сохранено в : ' + d.toLocaleTimeString(),
        pos: 'bottom-center',
		actionText: ''
    });
        }
    });
    var d = new Date();
    $('.form-status-holder').html('Сохранено в : ' + d.toLocaleTimeString());
}
	
	
	
		autosize(document.querySelectorAll('textarea'));
	</script>
    <script src="/plugins/notification/snackbar/snackbar.min.js"></script>
    <!-- END PAGE LEVEL PLUGINS -->

    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <script src="/assets/js/components/notification/custom-snackbar.js"></script>
    <!--  END CUSTOM SCRIPTS FILE  -->

    <script>
        // Get the Toast button
        var toastButton = document.getElementById("toast-btn");
        // Get the Toast element
        var toastElement = document.getElementsByClassName("toast")[0];

        toastButton.onclick = function() {
            $('.toast').toast('show');
        }


    </script>