<? include './template/template_header.tpl'; 
if (empty($_SESSION['user_id'])):
header('Location: /auth/');
exit;
endif;
$insertSql = $this->pdo->prepare("INSERT INTO activity_admin SET user_id = :user_id, text = :text, date = :date");
$insertSql->execute([
	'user_id' => $_SESSION['user_id'],
	'text' => 'В редакторе текстов ботов',
	'date' => time()
	]);
?>
<?PHP
		if($get_setting['on_off'] == 'on') {$sw1="on"; $ch1="checked";}
		if($get_setting['on_off'] == 'off') {$sw2="off"; $ch2="checked";}
		if($get_setting['kurs'] == '1') {$sw3="1"; $ch3="checked";}
		if($get_setting['kurs'] == '0') {$sw4="0"; $ch4="checked";} 
?>
    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->
    <link href="/assets/css/pages/faq/faq2.css" rel="stylesheet" type="text/css" /> 
    <!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->
    <!-- BEGIN PAGE LEVEL CUSTOM STYLES -->
    <link href="/assets/css/scrollspyNav.css" rel="stylesheet" type="text/css" />
    <!-- BEGIN PAGE LEVEL CUSTOM STYLES -->
<link href="/plugins/notification/snackbar/snackbar.min.css" rel="stylesheet" type="text/css" />
    <!--  END CUSTOM STYLE FILE  -->
<style>
			textarea {
				padding: 10px;
				vertical-align: top;
				width: 200px;
			}
			textarea:focus {
				outline-style: solid;
				outline-width: 2px;
			}
</style>
<!--  BEGIN CONTENT AREA  -->
        <div id="content" class="main-content">
            <div class="layout-px-spacing">

              

               

                        <div class="fq-tab-section layout-top-spacing">
                            <div class="row">
                                <div class="col-md-12">

                                    <div class="row">
                                        
                                        <div class="col-lg-6">

                                            <div class="accordion" id="simple_faq">
                                                <div class="card">
                                                    <div class="card-header" id="fqheadingOne">
                                                        <div class="mb-0" data-toggle="collapse" role="navigation" data-target="#fqcollapseOne" aria-expanded="false" aria-controls="fqcollapseOne">
                                                            <span class="faq-q-title">Текстовая информация</span>
                                                        </div>
                                                    </div>
                                                    <div id="fqcollapseOne" class="collapse show" aria-labelledby="fqheadingOne" data-parent="#simple_faq">
                                                        <div class="card-body">
<form id="glavnoe" method="post">
<small id="emailHelp" class="form-text text-muted">Время на заявку (в минутах)</small>
<input type="number" class="form-control form-control-sm" maxlength="100" name="time_zakaz" id="number" value="<?PHP echo $get_setting['time_zakaz'];?>" />

<small id="emailHelp" class="form-text text-muted">Режим работы обменника?</small>
                                            <div class="n-chk">
                                                <label class="new-control new-radio new-radio-text radio-success">
                                                  <input type="radio" class="new-control-input" value="on" id="on_off" name="on_off" <?=$ch1?>>
                                                  <span class="new-control-indicator"></span><span class="new-radio-content" style="font-weight:600;">Работает</span>
                                                </label>
                                            </div>

                                            <div class="n-chk">
                                                <label class="new-control new-radio new-radio-text radio-danger">
                                                  <input type="radio" class="new-control-input" value="off" id="on_off" name="on_off" <?=$ch2?>>
                                                  <span class="new-control-indicator"></span><span class="new-radio-content" style="font-weight:600;">Отключен</span>
                                                </label>
                                            </div>
											

<small id="emailHelp" class="form-text text-muted">Название обменника.</small>
<input type="text" class="form-control form-control-sm threshold" maxlength="100" name="name" id="moreoptions" value="<?PHP echo $get_setting['name'];?>" />
<small id="emailHelp" class="form-text text-muted">Главное описание в начале бота.</small>
<textarea  class="form-control textarea" name='descr' maxlength="500"><?PHP echo $get_setting['descr'];?></textarea>
<small id="emailHelp" class="form-text text-muted">Текст в управлении магазинами.</small>
<textarea  class="form-control textarea" name='page_one' maxlength="100"><?PHP echo $get_setting['page_one'];?></textarea>
<small id="emailHelp" class="form-text text-muted">Текст в реферальном кабинете</small>
<textarea  class="form-control textarea" name='page_two' maxlength="100"><?PHP echo $get_setting['page_two'];?></textarea>
<small id="emailHelp" class="form-text text-muted">Контакты обменника</small>
<textarea  class="form-control textarea" name='contacts' maxlength="500"><?PHP echo $get_setting['contacts'];?></textarea>
</form>
                            
              

                                                        </div>
                                                    </div>
                                                </div>

                                                
                                            </div>  

                                        </div>
                                        


                                    </div>

                                </div>
                            </div>                            
                        </div>

                

                </div>
    
<!-- END MAIN CONTAINER -->
<? include './template/template_footer.tpl'; ?>
<script src='/js/autosize.js'></script>
	<script>
var timeoutId;
$('form input, form textarea, #number, #on_off').on('input propertychange change', function() {
    clearTimeout(timeoutId);
    timeoutId = setTimeout(function() {
        // Runs 1 second (1000 ms) after the last change    
        saveToDB();
    }, 1000);
});

function saveToDB()
{
	 var msg   = $('#glavnoe').serialize();
     $.ajax({
        url: "/5.php",
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
    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
    <script src="/assets/js/pages/faq/faq2.js"></script>
    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
    <script src="/assets/js/scrollspyNav.js"></script>
    <script src="/plugins/bootstrap-maxlength/bootstrap-maxlength.js"></script>
    <script src="/plugins/bootstrap-maxlength/custom-bs-maxlength.js"></script>
	    <!-- toastr -->
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
</body>
</html>