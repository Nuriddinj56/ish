<? include './template/template_header.tpl'; 
if (empty($_SESSION['user_id'])):
	header('Location: /auth/');
	exit;
endif;

		$insertSql = $this->pdo->prepare("INSERT INTO activity_admin SET user_id = :user_id, text = :text, date = :date");
		$insertSql->execute([
			'user_id' => $_SESSION['user_id'],
			'text' => 'В настройках обменника',
			'date' => time()
			]);
?>
<link href="/plugins/notification/snackbar/snackbar.min.css" rel="stylesheet" type="text/css" />
<script src="/assets/js/components/notification/custom-snackbar.js"></script>
<!--  BEGIN CUSTOM STYLE FILE  -->
<link href="/assets/css/apps/invoice-add.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="/plugins/dropify/dropify.min.css">
<link rel="stylesheet" type="text/css" href="/assets/css/forms/theme-checkbox-radio.css">
<link href="/plugins/flatpickr/flatpickr.css" rel="stylesheet" type="text/css">
<link href="/plugins/flatpickr/custom-flatpickr.css" rel="stylesheet" type="text/css">
<!--  END CUSTOM STYLE FILE  -->
<style>
.placeholder-form {
box-sizing: border-box;
width: 320px;
margin: 20px auto;
}
.placeholder-container {
position: relative;
width: 100%;
margin-bottom: 20px;
}
.placeholder-container input {
background-color: transparent;
outline: 0;
width: 100%;
}
.placeholder-container label {
background-color: #0e1726;
pointer-events: none;
position: absolute;
transition: all 200ms;
top: 5px;
left: 10px;
background-color: #0e1726;
}
.placeholder-container input:focus + label,
.placeholder-container input:not(:placeholder-shown) + label{
top: -20px;
left: 10px;
background-color: #0e1726;
padding: 2px 10px;
}
</style>
	   
			<div class="row invoice layout-spacing layout-top-spacing">
				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
					
					<div class="doc-container">

						<div class="row">
							<div class="col-xl-4">

								<div class="invoice-content">

									<div class="invoice-detail-body">


										<div class="invoice-detail-header">
<h5>Настройки сайта</h5>
											<div class="row justify-content-between">
												<div class="col-xl-5 invoice-address-company">
													<div class="invoice-address-company-fields">

<div class="placeholder-form">
<div class="form-group row">
<div class="placeholder-container">
	<input type="url" class="form-control form-control-sm" placeholder=" " />
	<label>Домен обменника</label>
</div>
 </div>
<div class="form-group row">
<div class="placeholder-container">
	<input type="url" class="form-control form-control-sm" placeholder=" " />
	<label>Описание обменника</label>
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

						<div class="col-xl-4">

								<div class="invoice-content">

									<div class="invoice-detail-body">


										<div class="invoice-detail-header">
<h5>Настройки сайта</h5>
											<div class="row justify-content-between">
												<div class="col-xl-5 invoice-address-company">
													<div class="invoice-address-company-fields">

<div class="placeholder-form">
<div class="form-group row">
<div class="placeholder-container">
	<input type="url" class="form-control form-control-sm" placeholder=" " />
	<label>Домен обменника</label>
</div>
 </div>
<div class="form-group row">
<div class="placeholder-container">
	<input type="url" class="form-control form-control-sm" placeholder=" " />
	<label>Описание обменника</label>
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
						</div>
						
						
					</div>

				</div>
			</div>
			
<? include './template/template_footer.tpl'; ?>
<script src="/plugins/notification/snackbar/snackbar.min.js"></script>
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
var input = document.getElementById('inp');

input.onfocus = function (event) {

};

input.onblur = function (event) {
Snackbar.show({
	  text: 'dasdasd',
	  showAction: false,
	  actionTextColor: '#fff',
	  backgroundColor: '#1abc9c'
});
};

</script>
<script src="/plugins/dropify/dropify.min.js"></script>
<script src="/plugins/flatpickr/flatpickr.js"></script>
<script src="/assets/js/apps/invoice-add.js"></script>
</body>
</html>