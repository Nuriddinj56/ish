
<!DOCTYPE html>
<html lang="zxx">
<head>

	<!-- Basic Page Needs
	================================================== -->
	<title>exorion.biz</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="description" content="exorion.biz">
	<meta name="author" content="">
	<meta name="keywords" content="exorion.biz">
	<link rel="shortcut icon" href="/assets_general/img/favicons/favicon.ico">
	<link rel="apple-touch-icon" sizes="120x120" href="/assets_general/img/favicons/favicon-120.png">
	<link rel="apple-touch-icon" sizes="152x152" href="/assets_general/img/favicons/favicon-152.png">
	<meta name="viewport" content="width=device-width,initial-scale=1.0">
	<link href="/assets_general/vendor/magnific-popup/css/magnific-popup.css" rel="stylesheet">
	<link href="/assets_general/vendor/slick/css/slick.css" rel="stylesheet">
	<link href="/assets_general/vendor/nanoscroller/css/nanoscroller.css" rel="stylesheet">
	<link href="/assets_general/vendor/fontawesome/css/brands.css" rel="stylesheet">
	<link href="/assets_general/css/style.css" rel="stylesheet">
	<link href="/assets_general/css/dark.css" rel="stylesheet">
	 <style type="text/css">
/* Всплывающее окно 
* при загрузке сайта            
*/
/* базовый контейнер, фон затемнения*/
#overlay {
    position: fixed;
    top: 0;
    left: 0;
    display: none;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.65);
    z-index: 999;
    -webkit-animation: fade .6s;
    -moz-animation: fade .6s;
    animation: fade .6s;
    overflow: auto;
}
/* модальный блок */
.popup {
    top: 25%;
    left: 0;
    right: 0;       
    margin: auto;
    width: 85%;
    min-width: 320px;
    max-width: 600px;
    position: absolute;
    padding: 15px 20px;
    border: 0px solid #383838;
    background: #fefefe;
    z-index: 1000;
    -webkit-animation: fade .6s;
    -moz-animation: fade .6s;
    animation: fade .6s;
}
/* заголовки в модальном блоке */
.popup h2, .popup h3 {
    margin: 0 0 1rem 0;
    font-weight: 800;
    line-height: 1.3;
    color: #009032;
    text-shadow: 1px 2px 4px #ddd;
}
/* кнопка закрытия */
.close {
    top: 10px;
    right: 10px;
    width: 32px;
    height: 32px;
    position: absolute;
    border: none;
    -webkit-border-radius: 50%;
    -moz-border-radius: 50%;
    -ms-border-radius: 50%;
    -o-border-radius: 50%;
    border-radius: 50%;
    background-color: rgba(0, 131, 119, 0.9);
    -webkit-box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
    -moz-box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
    box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
    cursor: pointer;
    outline: none;

}
.close:before {
    color: rgba(255, 255, 255, 0.9);
    content: "X";
    font-family:  Arial, Helvetica, sans-serif;
    font-size: 14px;
    font-weight: normal;
    text-decoration: none;
    text-shadow: 0 -1px rgba(0, 0, 0, 0.9);
    -webkit-transition: all 0.5s;
    -moz-transition: all 0.5s;
    transition: all 0.5s;
}
/* кнопка закрытия при наведении */
.close:hover {
    background-color: rgba(252, 20, 0, 0.8);
}
/* изображения в модальном окне */
.popup img {
    width: 100%;
    height: auto;
    box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
}
/* миниатюры изображений */
.pl-left,
.pl-right {
    width: 25%;
    height: auto;
}
/* миниатюры справа */
.pl-right {
    float: right;
    margin: 5px 0 5px 15px;
}
/* миниатюры слева */
.pl-left {
    float: left;
    margin: 5px 18px 5px 0;
}
/* анимация при появлении блоков с содержанием */
@-moz-keyframes fade {
    from { opacity: 0; }
    to { opacity: 1 }
}
@-webkit-keyframes fade {
    from { opacity: 0; }
    to { opacity: 1 } 
}
@keyframes fade {
    from { opacity: 0; }
    to { opacity: 1 }
}
</style>
  <style>
   hr {
    border: none; /* Убираем границу для браузера Firefox */
    color: white; /* Цвет линии для остальных браузеров */
    background-color: white; /* Цвет линии для браузера Firefox и Opera */
    height: 2px; /* Толщина линии */
   }
.header-logo--img img {
  max-width: 150px;
  margin-top: 10px;
  z-index: 9;
}

@media (min-width: 992px) and (max-width: 1919px) {
  .site-header--landing .header-logo--img img {
    max-width: 28.229167vh;
  }
}
.moon {
  position: absolute;
  margin-top: 0;
  right: 0;
  position: fixed;
  background: url(https://reshi.cam/assets/img/moon.svg?sanitize=true) right 150% no-repeat;
  background-size: 30% 30%;
  background-attachment: fixed;
  width: 100%;
  height: 100%;
  z-index: -1;
  opacity: 0;
  -webkit-animation: moon-move-in 1.2s 1s forwards;
          animation: moon-move-in 1.2s 1s forwards;
}
.glitch, .glow {
color: #dfbfbf;
position: relative;
font-size: 9vw;
z-index: 9;
animation: glitch 5s 5s infinite;
}
.glitch::before, .glow::before {
content: attr(data-text);
position: absolute;
background: transparent;
animation: noise-1 3s linear infinite alternate-reverse, glitch 5s 5.05s infinite;
}
.glitch::after, .glow::after {
content: attr(data-text);
position: absolute;
background: transparent;
overflow: hidden;
top: 0;
animation: noise-2 3s linear infinite alternate-reverse, glitch 5s 5s infinite;
}
@keyframes glitch {
1% {
transform: rotateX(10deg) skewX(90deg);
}
2% {
transform: rotateX(0deg) skewX(0deg);
}
}
@keyframes noise-1 {
3.3333333333% {
clip-path: inset(66px 0 27px 0);
}
6.6666666667% {
clip-path: inset(47px 0 49px 0);
}
10% {
clip-path: inset(39px 0 58px 0);
}
13.3333333333% {
clip-path: inset(12px 0 28px 0);
}
16.6666666667% {
clip-path: inset(92px 0 1px 0);
}
20% {
clip-path: inset(77px 0 18px 0);
}
23.3333333333% {
clip-path: inset(8px 0 59px 0);
}
26.6666666667% {
clip-path: inset(57px 0 34px 0);
}
30% {
clip-path: inset(35px 0 45px 0);
}
33.3333333333% {
clip-path: inset(99px 0 2px 0);
}
36.6666666667% {
clip-path: inset(54px 0 28px 0);
}
40% {
clip-path: inset(11px 0 2px 0);
}
43.3333333333% {
clip-path: inset(9px 0 67px 0);
}
46.6666666667% {
clip-path: inset(2px 0 22px 0);
}
50% {
clip-path: inset(75px 0 22px 0);
}
53.3333333333% {
clip-path: inset(87px 0 5px 0);
}
56.6666666667% {
clip-path: inset(10px 0 37px 0);
}
60% {
clip-path: inset(95px 0 3px 0);
}
63.3333333333% {
clip-path: inset(88px 0 2px 0);
}
66.6666666667% {
clip-path: inset(10px 0 46px 0);
}
70% {
clip-path: inset(64px 0 17px 0);
}
73.3333333333% {
clip-path: inset(22px 0 1px 0);
}
76.6666666667% {
clip-path: inset(42px 0 19px 0);
}
80% {
clip-path: inset(23px 0 20px 0);
}
83.3333333333% {
clip-path: inset(10px 0 45px 0);
}
86.6666666667% {
clip-path: inset(96px 0 3px 0);
}
90% {
clip-path: inset(82px 0 18px 0);
}
93.3333333333% {
clip-path: inset(55px 0 45px 0);
}
96.6666666667% {
clip-path: inset(59px 0 28px 0);
}
100% {
clip-path: inset(31px 0 47px 0);
}
}
@keyframes noise-2 {
0% {
clip-path: inset(82px 0 14px 0);
}
3.3333333333% {
clip-path: inset(95px 0 3px 0);
}
6.6666666667% {
clip-path: inset(12px 0 51px 0);
}
10% {
clip-path: inset(45px 0 48px 0);
}
13.3333333333% {
clip-path: inset(22px 0 5px 0);
}
16.6666666667% {
clip-path: inset(93px 0 8px 0);
}
20% {
clip-path: inset(34px 0 15px 0);
}
23.3333333333% {
clip-path: inset(36px 0 27px 0);
}
26.6666666667% {
clip-path: inset(70px 0 13px 0);
}
30% {
clip-path: inset(99px 0 1px 0);
}
33.3333333333% {
clip-path: inset(73px 0 11px 0);
}
36.6666666667% {
clip-path: inset(47px 0 31px 0);
}
40% {
clip-path: inset(39px 0 45px 0);
}
43.3333333333% {
clip-path: inset(23px 0 20px 0);
}
46.6666666667% {
clip-path: inset(34px 0 49px 0);
}
50% {
clip-path: inset(39px 0 7px 0);
}
53.3333333333% {
clip-path: inset(58px 0 16px 0);
}
56.6666666667% {
clip-path: inset(97px 0 2px 0);
}
60% {
clip-path: inset(71px 0 10px 0);
}
63.3333333333% {
clip-path: inset(50px 0 3px 0);
}
66.6666666667% {
clip-path: inset(55px 0 41px 0);
}
70% {
clip-path: inset(14px 0 44px 0);
}
73.3333333333% {
clip-path: inset(77px 0 3px 0);
}
76.6666666667% {
clip-path: inset(99px 0 1px 0);
}
80% {
clip-path: inset(50px 0 15px 0);
}
83.3333333333% {
clip-path: inset(68px 0 19px 0);
}
86.6666666667% {
clip-path: inset(43px 0 6px 0);
}
90% {
clip-path: inset(58px 0 30px 0);
}
93.3333333333% {
clip-path: inset(70px 0 9px 0);
}
96.6666666667% {
clip-path: inset(89px 0 5px 0);
}
100% {
clip-path: inset(51px 0 41px 0);
}
}
.scanlines {
overflow: hidden;
mix-blend-mode: difference;
}
.scanlines::before {
content: "";
position: absolute;
width: 100%;
height: 120%;
top: -30px;
left: 0;
z-index: 9999;
background: repeating-linear-gradient(to bottom, transparent 0%, rgba(255, 255, 255, 0.05) 0.5%, transparent 1%);
animation: fudge 17s ease-in-out alternate infinite;
}
@keyframes fudge {
from {
transform: translate(0px, 0px);
}
to {
transform: translate(0px, 2%);
}
}

@keyframes glitch-2 {
1% {
transform: rotateX(10deg) skewX(70deg);
}
2% {
transform: rotateX(0deg) skewX(0deg);
}
}
.form-control2 {
  display: block;
  width: 100%;
  height: calc(1.5em + 0.75rem + 2px);
  padding: 0.375rem 0.75rem;
  font-size: 1rem;
  font-weight: 400;
  line-height: 1.5;
  color: #fff;
  background-color: #151720;
  background-clip: padding-box;
  border: 1px solid #a3ff12;
  border-radius: 0.25rem;
  -webkit-transition: border-color 0.15s ease-in-out, -webkit-box-shadow 0.15s ease-in-out;
  transition: border-color 0.15s ease-in-out, -webkit-box-shadow 0.15s ease-in-out;
  transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
  transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out, -webkit-box-shadow 0.15s ease-in-out;
}
  </style>
</head>
<body id="welcome-section" class="site-layout--landing preloader-is--active preloader--no-transform">
<div class="scanlines"></div>
<div class="forest"></div>
<div class="silhouette"></div>
<div class="moon"></div>
	<div class="site-wrapper site-layout--default">
		<main class="site-content text-center" id="wrapper">
		<div class="site-content__center">
		      <header id="header" class="site-header site-header--landing">
			<div class="header-logo header-logo--img">
						<div class="header-logo header-logo--img">
						<div class="glitch" data-text=""><a href="index.html"><img src="/assets_general/img/logo.png" srcset="/assets_general/img/logo.png 2x" alt="Necromancers"></a></div>
			</div>
			</div>
		</header>
		<h1 class="text-white landing-title mb-0" style="font-weight: 800; font-style: normal; font-size: 2.1rem;">
		<div class="checkout-redeem-popup__tiny">Привет, что-то потерял?</div></h1>
		
		</div>
		   </main>

<div id="overlay">
<div class="popup" style="background-color: transparent;">
<p> 
<div class="page-heading page-heading--default text-small text-center w-100">
<form method="post" class="form login-form needs-validation" novalidate>
		<div class="page-heading__subtitle h5">
<span class="color-warning" style="font-style: normal; font-size: 0.9rem;">
		<?=$err[0]?>
		<?=$err[1]?>
		<?=$err[2]?>
		</span>
		<div class="spacer-sm"></div>
		<?=$token?>
	<div class="col-md-12">
	 <input type="text" class="form-control2" id="validationCustom01" placeholder="Логин" name="login" required>
	 <div id="validationCustom01" class="invalid-feedback" style="font-style: normal; font-size: 0.8rem;">Введи логин</div>
	 </div>
	 <div class="spacer-sm"></div>
	 <div class="col-md-12">
	 <input type="password" class="form-control2" id="validationCustom02" placeholder="Пароль" name="password" required>
	 <div id="validationCustom02" class="invalid-feedback" style="font-style: normal; font-size: 0.8rem;">Введи пароль</div>
	 <div class="spacer-sm"></div>
	 <input type="submit" class="btn btn-block login-form__button" value="Войти в панель управления" />
	</div>
</form>
</div>
</div>
</p>
</div>
</div> 
		<div class="checkout-redeem-popup" style="background-color: transparent;">
			<div class="checkout-redeem-popup__header">
				<!-- <div class="checkout-redeem-popup__title h4"><span style="font-style: normal; font-size: 1.5rem;">ГОСТЕВОЙ АККАУНТ<br/> </span>УСПЕШНО СОЗДАН</div>
				<div class="checkout-redeem-popup__tiny">сейчас ты будешь перенаправлен</div>-->
			</div>
		</div>

		<div class="site-overlay"></div>
  
	</div>

	<div class="preloader-overlay">
		<div id="js-preloader" class="preloader">
			<div class="preloader-inner fadeInUp">
<span class="subtitle landing-subtitle" style="font-style: normal; color: #a2ff13; font-size: 0.8rem; margin-top: 15px;">wait bro<span id="qwe"></span></span>	
		</div>
	</div>
   </div>

	<!-- Javascript Files
	================================================== -->
	<!-- Core JS -->
	<script src="/assets_general/vendor/jquery/jquery.min.js"></script>
	<script src="/assets_general/vendor/jquery/jquery-migrate.min.js"></script>
	<script src="/assets_general/js/core.js"></script>
	<script src="/assets_general/js/qwe.js"></script>
	<script src="/assets_general/js/init.js"></script>
	<script>
      // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function () {
          'use strict'
    
          // Fetch all the forms we want to apply custom Bootstrap validation styles to
          var forms = document.querySelectorAll('.needs-validation')
    
          // Loop over them and prevent submission
          Array.prototype.slice.call(forms)
          .forEach(function (form) {
            form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
              event.preventDefault()
              event.stopPropagation()
            }
    
            form.classList.add('was-validated')
            }, false)
          })
        })()
    </script>

    <!-- Main JS-->
    <script src="/stat/js/main.js"></script>

	<script>
       	  
	       
	            var auth_key = $(this).data("key");
	            var timerId = setInterval(function () {
	                $.ajax({
	                    type: "GET",
	                    dataType: "json",
	                    url: "/checkbro.php",
	                    data: {
	                        key: auth_key
	                    },
	                    success: function (data) {
	                        if (data.result == "success") {
	                            clearInterval(timerId);
	                            setTimeout(function () {
	                                document.getElementById('overlay').style.display='block'
	                            }, 500);
	                        }
	                    }
	                });
	            }, 1000);
	       
            
	</script>
	<!-- Duotone SVG color filter -->
	<svg xmlns="http://www.w3.org/2000/svg" class="svg-filters">
		<filter id="duotone_base">
			<feColorMatrix type="matrix" result="grayscale"
				values="1 0 0 0 0
								1 0 0 0 0
								1 0 0 0 0
								0 0 0 1 0" />
			<feComponentTransfer color-interpolation-filters="sRGB" result="duotone_base_filter">
				<feFuncR type="table" tableValues="0.082352941176471 0.419607843137255"></feFuncR>
				<feFuncG type="table" tableValues="0.090196078431373 0.443137254901961"></feFuncG>
				<feFuncB type="table" tableValues="0.125490196078431 0.6"></feFuncB>
				<feFuncA type="table" tableValues="0 1"></feFuncA>
			</feComponentTransfer>
		</filter>
	</svg>

</body>

</html>

