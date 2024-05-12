<?php

if (!empty($_COOKIE['sid'])) {
    // check session id in cookies
    session_id($_COOKIE['sid']);
}

session_start();
require_once 'classes/Auth.class.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>CORK Admin Template - Login Cover Page</title>
    <link rel="icon" type="image/x-icon" href="/assets/img/favicon.ico"/>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&display=swap" rel="stylesheet">
    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/css/plugins.css" rel="stylesheet" type="text/css" />
    <link href="/assets/css/authentication/form-1.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <link rel="stylesheet" type="text/css" href="/assets/css/forms/theme-checkbox-radio.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/forms/switches.css">
</head>
<body class="form">
 <?php if (Auth\User::isAuthorized()): ?>   
 <h1>Авторизация прошла успешно</h1>
<? echo "<meta http-equiv=\"refresh\" content=\"0;URL=/shops/\">";?>
      <form class="ajax" method="post" action="/ajax.php">
          <input type="hidden" name="act" value="logout">
          <div class="form-actions">
              <button class="btn btn-large btn-primary" type="submit">Logout</button>
          </div>
      </form>

      <?php else: ?>
    <div class="form-container">
        <div class="form-form">
            <div class="form-form-wrap">
                <div class="form-container">
                    <div class="form-content">

                        <h1 class="">Log In to <a href="index.html"><span class="brand-name">ADMIN</span></a></h1>
                        <form class="text-left ajax" method="post" action="/ajax.php">
                            <div class="form">

                                <div id="username-field" class="field-wrapper input">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                    <input id="username" name="username" type="text" class="form-control" placeholder="Логин">
                                </div>

                                <div id="password-field" class="field-wrapper input mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                                    <input id="password" name="password" type="password" class="form-control" placeholder="Пароль">
                                </div>
                                <div class="d-sm-flex justify-content-between">
                                    <div class="field-wrapper toggle-pass">
                                        <p class="d-inline-block">Показать пароль</p>
                                        <label class="switch s-primary">
                                            <input type="checkbox" id="toggle-password" class="d-none">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <div class="field-wrapper">
									    <input type="hidden" name="act" value="login">
                                        <button type="submit" class="btn btn-primary" value="">Войти в панель</button>
                                    </div>
                                    
                                </div>

                                <div class="field-wrapper text-center keep-logged-in">
                                    <div class="n-chk new-checkbox checkbox-outline-primary">
                                        <label class="new-control new-checkbox checkbox-outline-primary">
                                          <input type="checkbox" name="remember-me" value="remember-me" checked class="new-control-input">
										  
                                          <span class="new-control-indicator"></span>Запомнить меня
                                        </label>
                                    </div>
                                </div>
								</div>
                        </form>                        
<p class="terms-conditions">© 2022 Все права нарушены. <a href="https://necro.codes">NECRO.CODES</a>. CODING BY <a href="javascript:void(0);">NECRO.CODES</a></p>
                    </div>                    
                </div>
            </div>
        </div>
        <div class="form-image">
            <div class="l-image">
            </div>
        </div>
    </div>

      <?php endif; ?>
    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="/assets/js/libs/jquery-3.1.1.min.js"></script>
    <script src="/bootstrap/js/popper.min.js"></script>
    <script src="/bootstrap/js/bootstrap.min.js"></script>
    
    <!-- END GLOBAL MANDATORY SCRIPTS -->
    <script src="/assets/js/authentication/form-1.js"></script>
    <script src="/js/ajax-form.js"></script>
</body>
</html>