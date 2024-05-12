
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title><?=$get_setting['name']?> - <?=$get_setting['descr']?></title>
    <link rel="icon" type="image/x-icon" href="/assets/img/favicon.ico"/>
    <link href="/assets/css/loader.css" rel="stylesheet" type="text/css" />
    <script src="/assets/js/loader.js"></script>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&display=swap" rel="stylesheet">
    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/css/plugins.css" rel="stylesheet" type="text/css" />

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->
    <link href="/plugins/apex/apexcharts.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="/assets/css/widgets/modules-widgets.css">    
    <!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->    
    <!-- END PAGE LEVEL /plugins/CUSTOM STYLES -->
	    <!-- END GLOBAL MANDATORY STYLES -->
    <link href="/assets/vendor/fontawesome/css/all.css" rel="stylesheet">
    <!-- END PAGE LEVEL /plugins/CUSTOM STYLES -->
	<link href="/assets/css/components/custom-modal.css" rel="stylesheet" type="text/css" />
    <!-- BEGIN PAGE LEVEL CUSTOM STYLES -->
    <link href="/assets/css/scrollspyNav.css" rel="stylesheet" type="text/css" />
    <link rel="/stylesheet" type="text/css" href="/assets/css/forms/theme-checkbox-radio.css">
    <link href="/assets/css/tables/table-basic.css" rel="stylesheet" type="text/css" />
    <link href="/assets/css/customss.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="/assets/panel/css/styles.css">
    <link href="/assets/css/components/custom-counter.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" type="text/css" href="/assets/css/forms/theme-checkbox-radio.css">
	    <link href="/assets/css/apps/notes.css" rel="stylesheet" type="text/css" />
    <link href="/assets/css/forms/theme-checkbox-radio.css" rel="stylesheet" type="text/css" />
<style>

.table > tbody > tr > td .inv-status.badge-darks {
  background-color: rgba(0, 0, 0, 0.1);
  color: #1abc9c; }
  select.bs-select-hidden, select.selectpicker {
  display: none !important; }

.bootstrap-select {
  width: 220px \0; }
  .bootstrap-select .dropdown-divider {
    border-color: #191e3a; }
  .bootstrap-select.btn-group > .dropdown-toggle {
    height: auto;
    border: 1px solid #1b2e4b;
    color: #009688;
    font-size: 15px;
    padding: 8px 10px;
    letter-spacing: 1px;
    background-color: #1b2e4b;
    height: auto;
    padding: .75rem 1.25rem;
    border-radius: 0px 0px 6px 6px;
    box-shadow: none; }
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

</style>
</head>

<!--<div class="environment"></div>-->
<body class="alt-menu sidebar-noneoverflow">

<div class="cryptoboxes" id="mcw-4037" data-realtime="off" style="text-transform: uppercase;z-index:1;">
<div class="mcw-ticker mcw-ticker-1 mcw-header" data-speed="40">
<div class="cc-ticker mcw-midnight-theme">
<div class="cc-stats">
<?php
$res_data = $this->pdo->query("SELECT * FROM currency_in WHERE id != 4");
			while ($row = $res_data->fetch()) {
			$str = strtolower($row['nominal']);
			$kurss = intval($row['kurs']);
		    $kurs = number_format($kurss);
			$kurss_usd = intval($row['kurs_usd']);
		    $kurs_usd = number_format($kurss_usd);
?>
<div class="cc-coin">
<div>
<img class="coin-img" alt="bitcoin" src="https://cdn.jsdelivr.net/gh/atomiclabs/cryptocurrency-icons@bea1a9722a8c63169dcc06e86182bf2c55a76bbc/128/color/<? echo $str;?>.png" height="25" />
</div>
<? echo $row['network'];?> (<? echo $row['nominal'];?>)  
<span class="mcw-up" style="">
<span>&nbsp; <? echo $kurs;?> ₽</span>&nbsp; 
</span>
 / 
<span class="mcw-down" style="">
<span>&nbsp; <? echo $kurs_usd;?> $</span>
</span>
</div>
<?php
}
?>
</div></div></div></div>	
   
	
<!-- BEGIN LOADER -->
    <div id="load_screen"> <div class="loader"> <div class="loader-content">
        <svg id="mainSVG" xmlns="http://www.w3.org/2000/svg" viewBox="200 150 400 300">
<defs>
<g id="container" filter="url(#goo)" >
<path class="seg" d="M412.9,251.7c-4.1-1.1-8.5-1.7-12.9-1.7"/>
</g>
<filter id="goo" color-interpolation-filters="sRGB" filterUnits="objectBoundingBox" x="-100%" y="-100%" width="250%" height="250%">
<feGaussianBlur in="SourceGraphic" stdDeviation="8" result="blur" />
<feColorMatrix in="blur" mode="matrix" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 21 -9" result="cm" />
<feBlend/>
</filter>  
<radialGradient id="grad" cx="400.5176" cy="298.0287" r="125.9247" gradientUnits="userSpaceOnUse">
<stop  offset="0.39" style="stop-color:#FF4F59"/>
<stop  offset="0.45" style="stop-color:#FFFC31"/>
</radialGradient>
</defs>
<g id="wrapper" >
<use x="20" y="20" xlink:href="#container"  fill="none" stroke-width="20" stroke-miterlimit="10" stroke-linejoin="round" stroke-linecap="round" stroke="#5B1E00" opacity="0.05" />
<use xlink:href="#container"  fill="none" stroke-width="20" stroke-miterlimit="10" stroke-linejoin="round" stroke-linecap="round" stroke="url(#grad)" />
</g>
</svg>			
    </div></div></div>
		
				
<script type="text/javascript" src="https://imapo.ru/js/gsap.min.js"></script>
<script type="text/javascript">
let select = s => document.querySelector(s),
selectAll = s =>  document.querySelectorAll(s),
mainSVG = select('#mainSVG'),
container = select('#container'),
seg = select('.seg'),
allSegs = []
gsap.set('svg', {
visibility: 'visible'
})
let num = 360 / 15;
let duration = 0.25;
allSegs.push(seg);
for(var i = 1; i < (num - 8); i++) {
let clone = seg.cloneNode(true);
container.appendChild(clone);
gsap.set(clone, {
rotation: i * 15,
svgOrigin: '400 300'
})
allSegs.push(clone)
}
let mainTl = gsap.timeline({});
allSegs.forEach((item, count) => {
let tl = gsap.timeline()
tl.to(item, {
rotation: '-=120',
svgOrigin: '400 300',
repeat: -1,
repeatRefresh: true,
ease: 'sine.inOut',
repeatDelay: (num - 10) * duration 
})
mainTl.add(tl, count * duration)
})
gsap.to(container, {
duration: 1,
rotation: 360,
svgOrigin: '400 300',
ease: 'linear',
repeat: -1
}, 0)
gsap.globalTimeline.timeScale(0.5)
</script>
						
		

    <!--  BEGIN NAVBAR  -->
    <div class="header-container" style="margin-top:45px;">
        <header class="header navbar navbar-expand-sm">

<div class="hidemobile"><span style="margin-top:-5px;" >
                        <a href="/shops/" class="nav-link" style="font-weight:800;font-size:1.5rem;"><?PHP echo $get_setting['name'];?></a>
                               </a>
							   
               </span></div>

                                        
                                                <div id="statmenu"></div>
                                          
                                     
                                           

            <ul class="navbar-item flex-row mr-auto">
            </ul>

            <ul class="navbar-item flex-row nav-dropdowns">
			<li class="nav-item dropdown message-dropdown">
                    <a href="javascript:void(0);" class="nav-link dropdown-toggle" id="messageDropdown" data-toggle="modal" data-target="#sendmoneymodal">
                       <i class="fa-regular fa-money-bill-simple-wave fa-lg"></i>
                    </a>
                </li>
			
<li class="nav-item dropdown message-dropdown">
                    <a href="javascript:void(0);" class="nav-link dropdown-toggle" id="messageDropdown" data-toggle="modal" data-target="#registerModal">
                        <i class="fa-light fa-gear fa-lg"></i>
                    </a>
                </li>
                <li class="nav-item dropdown notification-dropdown">
                    <a href="javascript:void(0);" class="nav-link dropdown-toggle" id="notificationDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa-light fa-bell fa-lg"></i>
                    </a>
                    <div class="dropdown-menu position-absolute" aria-labelledby="notificationDropdown">
                        <div class="notification-scroll">

                           <span style="color:#fff;"> Уведомлений нет</span>
                        </div>
                    </div>
                </li>
            </ul>
        </header>
    </div>
    <!--  END NAVBAR  -->
<link rel="stylesheet" type="text/css" href="/plugins/bootstrap-select/bootstrap-select.min.css">
<!-- Modal -->
                                    <div class="modal fade" id="sendmoneymodal" tabindex="-1" role="dialog" aria-labelledby="sendmoneymodalCenter" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalCenterTitle">Перевод валюты</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                      <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
												<form method="POST" id="sendmoneygo" action="javascript:void(null);" onsubmit="sendmoneygo()">
<div class="form-group">
												<select class="me-sm-2 default-select2 form-control form-control-sm selectpicker"  name="biracc"  id="mySelect" onchange="myFunction()" required>
												<option value="" disabled selected >Выберите аккаунт биржи</option>
												<?
												$category = $this->pdo->query("SELECT * FROM exchanges ");
												while ($row = $category->fetch()) {
													?>
													<option value="<? echo $row['id'];?>"><? echo $row['name'];?></option>
													<?
													}
													?>
													</select>
													</div>
													<div class="form-group">
													<p id="resultssend"></p>
													</div>	
													<div class="form-group">
													<div class="form_radio_group">
	<div class="form_radio_group-item">
		<input id="radio-1" type="radio" name="bircurrencys" value="BTC" >
		<label for="radio-1">BTC</label>
	</div>
	<div class="form_radio_group-item">
		<input id="radio-2" type="radio" name="bircurrencys" value="LTC">
		<label for="radio-2">LTC</label>
	</div>
	<div class="form_radio_group-item">
		<input id="radio-3" type="radio" name="bircurrencys" value="ETH">
		<label for="radio-3">ETH</label>
	</div>
	<div class="form_radio_group-item">
		<input id="radio-4" type="radio" name="bircurrencys" value="USDT">
		<label for="radio-4">USDT</label>
	</div>
</div>
		</div>	
<div class="form-group">
                                                <input type="text" name="pometkabir" class="form-control form-control-sm mb-4" placeholder="Введите текст" required>
                                            <small id="emailHelp" class="form-text text-muted" style="margin-top:-20px;">Укажите пометку кому, зачем и куда и.т.п.</small>

											</div>
<div class="form-group">
                                                <input type="text" name="summbir" class="form-control form-control-sm mb-4 mask-phone" placeholder="Введите сумму" required>
                                            </div>
<div class="input-group mb-4">
                                      <input type="text" class="form-control form-control-sm" placeholder="Введите адрес кошелька" aria-label="Введите адрес кошелька" name="adress_bir" id="adress_bir" required>
                                      <div class="input-group-append">
                                        <input type="submit" class="btn btn-success" value="Отправить">
                                      </div>
                                    </div>
									<div id="loadingsendmoney" class="spinner-border text-success  align-self-center" style='display:none;'></div>
<div id="resultsendmoneygo"></div>
</form>									
													</div>

                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                            
    <div class="main-container" id="container">

        <div class="overlay"></div>
        <div class="search-overlay"></div>

        <!--  BEGIN TOPBAR  -->
        <div class="topbar-nav header navbar" role="banner" style="margin-top:40px;">
		<?php $url = $_SERVER["REQUEST_URI"];?>
            <nav id="topbar">
                <ul class="navbar-nav theme-brand flex-row  text-center">
                    <li class="nav-item theme-logo">
                        <a href="index.html">
                            <img src="assets/img/90x90.jpg" class="navbar-logo" alt="logo">
                        </a>
                    </li>
                    <li class="nav-item theme-text">
                        <a href="index.html" class="nav-link"> ORION </a>
                    </li>
                </ul>

                <ul class="list-unstyled menu-categories" id="topAccordion">

                    <li class="menu single-menu <?php if ($url == "/shops/") {echo 'active';}?>">
                        <a href="/shops/" aria-expanded="true" class="dropdown-toggle autodroprown">
                            <div class="">
                                <i class="fa-thin fa-house-blank"></i>
                                <span>Главное меню</span>
                            </div>
                        </a>
                    </li>


					
					
					 <li class="menu single-menu <?php if ($url == "/cardclients/" or $url == "/transactions/" or $url == "/exchange/") {echo 'active';}?>">
                        <a href="#components" aria-expanded="true" class="dropdown-toggle">
                            <div class="">
                               <i class="fa-thin fa-arrow-right-arrow-left"></i>
                                <span>Управление обменом</span>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        </a>
                        <ul class="collapse submenu list-unstyled" id="components" data-parent="#topAccordion">
                            <li class="<?php if ($url == "/cardclients/") {echo 'active';}?>">
                                <a href="/cardclients/"> Карты и валюта </a>
                            </li>
                          <li class="<?php if ($url == "/transactions/") {echo 'active';}?>">
                                <a href="/transactions/"> Транзакции  </a>
                            </li>
							<li class="<?php if ($url == "/cryptotrans/") {echo 'active';}?>">
                                <a href="/cryptotrans/"> Исходящие транзы  </a>
                            </li>
							 <li class="<?php if ($url == "/exchange/") {echo 'active';}?>">
                                <a href="/exchange/"> Управление биржами  </a>
                            </li>
                        </ul>
                    </li>
                    
                    <li class="menu single-menu <?php if ($url == "/groupshops/" or $url == "/apishops/" or $url == "/apibots/") {echo 'active';}?>">
                        <a href="#components" aria-expanded="true" class="dropdown-toggle">
                            <div class="">
                                <i class="fa-thin fa-shop"></i>
                                <span>API магазины</span>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        </a>
                        <ul class="collapse submenu list-unstyled" id="components" data-parent="#topAccordion">
                            <li class="<?php if ($url == "/groupshops/") {echo 'active';}?>">
                                <a href="/groupshops/"> Категории магазинов </a>
                            </li>
                          <li class="<?php if ($url == "/apishops/") {echo 'active';}?>">
                                <a href="/apishops/"> Список магазинов  </a>
                            </li>
							 <li class="<?php if ($url == "/apibots/") {echo 'active';}?>">
                                <a href="/apibots/"> Боты автопродаж  </a>
                            </li>
                        </ul>
                    </li>


                    <li class="menu single-menu <?php if ($url == "/users/") {echo 'active';}?>">
                        <a href="/users/" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                            <i class="fa-thin fa-users"></i>
							<span>Пользователи</span>
                            </div>
                        </a>
                    </li>

                    <li class="menu single-menu <?php if ($url == "/simbank/") {echo 'active';}?>" >
                        <a href="/simbank/" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                          <i class="fa-thin fa-sim-card"></i>
                                <span>SIM Банк</span>
                            </div>
                        </a>
                    </li>
					
					<li class="menu single-menu <?php if ($url == "/mybots/") {echo 'active';}?>" >
                        <a href="/mybots/" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <i class="fa-thin fa-message-bot"></i>
                                <span>Мои боты</span>
                            </div>
                        </a>
                    </li>
                    <li class="menu single-menu">
                        <a href="#" aria-expanded="false" class="dropdown-toggle" data-toggle="modal" data-target="#registerModal">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clipboard"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path><rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect></svg>
                                <span>Настройки</span>
                            </div>
                        </a>
                    </li>
                   
                </ul>
            </nav>
        </div>
  <style>
.placeholder-form {
box-sizing: border-box;
}
.placeholder-container {
position: relative;
margin-bottom: 20px;
}
.placeholder-container input {
outline: 0;
}
.placeholder-container label {
pointer-events: none;
position: absolute;
transition: all 200ms;
top: 5px;
left: 10px;
}
.placeholder-container input:focus + label,
.placeholder-container input:not(:placeholder-shown) + label{
top: -20px;
left: 10px;
padding: 2px 10px;
}
</style>
<?PHP
		if($get_setting['on_off'] == 'on') {$sw1="on"; $ch1="checked";}
		if($get_setting['on_off'] == 'off') {$sw2="off"; $ch2="checked";}
		if($get_setting['kurs'] == '1') {$sw3="1"; $ch3="checked";}
		if($get_setting['kurs'] == '0') {$sw4="0"; $ch4="checked";} 
?>	
        <!--  BEGIN CONTENT PART  -->
        <div id="content" class="main-content">
            <div class="layout-px-spacing" style="margin-top:20px;">
			<?php $url = $_SERVER["REQUEST_URI"];?>
	<div class="showmobile">
<select class="selectpicker" data-width="100%" data-show-subtext="true" onchange="window.location.href = this.options[this.selectedIndex].value" style="margin-top:40px;">
	<option value="/shops/" data-subtext="статистика и.т.п" <?php if ($url == "/shops/") {echo 'selected';}?>>Главное меню</option>
	<option value="/mybots/" data-subtext="зеркала ботов" <?php if ($url == "/mybots/") {echo 'selected';}?>>Мои боты</option>
    <option value="/cardclients/" data-subtext="валюта/карты" <?php if ($url == "/cardclients/") {echo 'selected';}?>>Управление обменом</option>
	<option value="/transactions/" data-subtext="список заявок" <?php if ($url == "/transactions/") {echo 'selected';}?>>Транзакции</option>
	<option value="/cryptotrans/" data-subtext="все" <?php if ($url == "/cryptotrans/") {echo 'selected';}?>>Криптовалютные транзы</option>
	<option value="/cryptotransbir/" data-subtext="свободные платежи" <?php if ($url == "/cryptotransbir/") {echo 'selected';}?>>Исходящие платежи</option>
	<option value="/exchange/" data-subtext="coinbase" <?php if ($url == "/exchange/") {echo 'selected';}?>>Биржи</option>
    <option value="/apishops/" data-subtext="API" <?php if ($url == "/apishops/") {echo 'selected';}?>>Магазины</option>
    <option value="/groupshops/" data-subtext="Группы" <?php if ($url == "/groupshops/") {echo 'selected';}?>>Категории</option>
	<option value="/simbank/" data-subtext="СМС" <?php if ($url == "/simbank/") {echo 'selected';}?>>SIM-Банк</option>
	<option value="/users/" data-subtext="Клиенты" <?php if ($url == "/users/") {echo 'selected';}?>>Пользователи</option>


</select></div>
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

                                    <div class="modal fade" style="padding-top:50px;padding-bottom:40px;" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="settingModalLabel" aria-hidden="true">
                                      <div class="modal-dialog" role="document">
                                        <div class="modal-content">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="modal"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                          <div class="modal-header" id="settingModalLabel">
                                            <h4 class="modal-title">Настройки</h4>
                                          </div>
                                          <div class="modal-body">

<form id="glavnoe" method="post">

<div class="form-group">
<div class="input-group mb-4">
<div class="input-group-prepend">
<span class="input-group-text" id="basic-addon7">https://</span>
</div>
<input type="text" class="form-control" value='<?=$get_setting['domain']?>' id="basic-url" name="domainobmen" aria-describedby="basic-addon3" placeholder="Главный домен">

</div>
<small id="emailHelp" class="form-text text-muted" style="margin-top:-20px;">Укажите главный домен, на который будут поступать запросы. <code>*</code></small>
</div>
<small id="emailHelp" class="form-text text-muted">Время на заявку (в минутах)</small>
<input type="number" class="form-control form-control-sm" maxlength="100" name="time_zakaz" id="numberobmen" value="<?PHP echo $get_setting['time_zakaz'];?>" />

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
<input type="text" class="form-control form-control-sm threshold" maxlength="100" name="name" id="nameobmen" value="<?PHP echo $get_setting['name'];?>" />
<small id="emailHelp" class="form-text text-muted">Главное описание в начале бота.</small>
<textarea  class="form-control textarea" id="descrobmen" name='descr' maxlength="500"><?PHP echo $get_setting['descr'];?></textarea>
<small id="emailHelp" class="form-text text-muted">Текст в управлении магазинами.</small>
<textarea  class="form-control textarea" id="page_oneobmen" name='page_one' maxlength="100"><?PHP echo $get_setting['page_one'];?></textarea>
<small id="emailHelp" class="form-text text-muted">Текст в реферальном кабинете</small>
<textarea  class="form-control textarea" id="page_twoobmen" name='page_two' maxlength="100"><?PHP echo $get_setting['page_two'];?></textarea>
<small id="emailHelp" class="form-text text-muted">Контакты обменника</small>
<textarea  class="form-control textarea" id="contactsobmen" name='contacts' maxlength="500"><?PHP echo $get_setting['contacts'];?></textarea>
										
                                            </form> </div>
                                          
                                        </div>
                                      </div>
                                    </div>
									
									
									