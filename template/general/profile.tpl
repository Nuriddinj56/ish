
<!DOCTYPE html>
<html lang="zxx">
<head>

	<!-- Basic Page Needs
	================================================== -->
	<title>Necromancers - eSports Team &amp; Gaming HTML Template</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="description" content="eSports Team &amp; Gaming HTML Template">
	<meta name="author" content="Dan Fisher">
	<meta name="keywords" content="esports team news HTML template">

	<!-- Favicons
	================================================== -->
	<link rel="shortcut icon" href="/assets_general/img/favicons/favicon.ico">
	<link rel="apple-touch-icon" sizes="120x120" href="/assets_general/img/favicons/favicon-120.png">
	<link rel="apple-touch-icon" sizes="152x152" href="/assets_general/img/favicons/favicon-152.png">

	<!-- Mobile Specific Metas
	================================================== -->
	<meta name="viewport" content="width=device-width,initial-scale=1.0">

	<!-- Google Web Fonts
	================================================== -->
	<link href="https://fonts.googleapis.com/css?family=Rajdhani:300,400,500,600,700" rel="stylesheet">

	<!-- CSS
	================================================== -->
	<!-- Vendor CSS -->
	<link href="/assets_general/vendor/magnific-popup/css/magnific-popup.css" rel="stylesheet">
	<link href="/assets_general/vendor/slick/css/slick.css" rel="stylesheet">
	<link href="/assets_general/vendor/nanoscroller/css/nanoscroller.css" rel="stylesheet">
	<link href="/assets_general/vendor/fontawesome/css/brands.css" rel="stylesheet">

	<!-- Template CSS-->
	<link href="/assets_general/css/style.css" rel="stylesheet">

	<!-- Custom CSS-->
	<link href="/assets_general/css/custom.css" rel="stylesheet">

</head>

<body class="preloader-is--active ">

	<div class="site-wrapper site-layout--default">

		<!-- Content
		================================================== -->
		<main class="site-content account-page" id="wrapper">
			<div class="account-navigation">
				<div class="account-navigation__header">
					<a class="account-navigation__logout" href="./">
						<svg role="img" class="df-icon df-icon--logout-circle">
							<use xlink:href="/assets_general/img/necromancers.svg#logout-circle"/>
						</svg>
						<svg role="img" class="df-icon df-icon--logout-arrow">
							<use xlink:href="/assets_general/img/necromancers.svg#logout-arrow"/>
						</svg>
					</a>
					<div class="account-navigation__subtitle">Приветствую!</div>
					<div class="account-navigation__name h5"><?=$get_user['login']?></div>
				</div>
				<ul class="account-navigation__menu">
					<li><a class="/profile/">Настройки аккаунта</a></li>
					<li><a href="/settingbot/">Настройки бота</a></li>
					<li><a href="shop-account-billing.html">Общие настройки</a></li>
					<li><a href="shop-account-orders.html">Управление информацией</a></li>
				</ul>
			</div>
			<div class="account-content">
				<h2 class="h4">01. Настройки аккаунта</h2>
				<?=$err[0]?>
				<form method="post" action="" class="form">
				<?=$token?>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<input type="password" class="form-control" name="password" id="password" placeholder="Текущий пароль">
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<input type="password" class="form-control" name="newpassword" id="newpassword" placeholder="Новый пароль">
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<input type="password" class="form-control" name="newpassword2" id="newpassword2" placeholder="Новый пароль ещё раз">
							</div>
						</div>
					</div>
					<div class="form-group d-sm-flex justify-content-sm-between align-items-sm-center">
						<input type="submit" value="Сменить пароль" class="btn btn-secondary" />
					</div>
				</form>
			</div>
		</main>
		

		<!-- Overlay -->
		<div class="site-overlay"></div>
		<!-- Overlay / End -->


	</div>

	<div class="preloader-overlay">
		<div id="js-preloader" class="preloader">
			<div class="preloader-inner fadeInUp">
				<div class="pong-loader"></div>
				<svg role="img" class="df-icon df-icon--preloader-arcade">
					<use xlink:href="/assets_general/img/necromancers.svg#preloader-arcade"/>
				</svg>
			</div>
		</div>
	</div>

	<!-- The cursor elements -->
	<div class="df-custom-cursor-wrap">
		<div id="df-custom-cursor"></div>
	</div>

	<!-- Javascript Files
	================================================== -->
	<!-- Core JS -->
	<script src="/assets_general/vendor/jquery/jquery.min.js"></script>
	<script src="/assets_general/vendor/jquery/jquery-migrate.min.js"></script>
	<script src="/assets_general/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="/assets_general/js/core.js"></script>
	
	<!-- Vendor JS -->
	
	<!-- Template JS -->
	<script src="/assets_general/js/init.js"></script>
	<script src="/assets_general/js/custom.js"></script>
	
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
