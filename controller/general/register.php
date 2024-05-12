<?php
$this->title = 'Регистрация';


if (!empty($_SESSION['auth'])):
	header('Location: /shops/');
	exit;
endif;

$tk = new token();

$pw = new password();
$check_values = new filter();

$err[0] = '';
$err[1] = '';
$err[2] = '';
$err[3] = '';
$err[4] = '';
$err[5] = '';
$err[6] = '';
$err[7] = '';

if (!empty($_POST['token']) and $check_values->check('login','post','regexp','~^[A-Za-z0-9]{3,20}$~') and $check_values->check('password','post','regexp','~^[A-Za-z0-9]{6,20}$~') and $check_values->check('email','post','email') and !empty($_POST['password']) and !empty($_POST['password2']) and $_POST['password'] == $_POST['password2'] and !empty($_POST['agree']) and $_POST['agree'] == 'on'):

	$get_user = $db->row("SELECT login FROM dle_users WHERE login = ?", array($_POST['login']));
	$get_email = $db->row("SELECT login FROM dle_users WHERE email = ?", array($_POST['email']));


	if (!$get_user and !$get_email):
		$insertrow = $db->insert("INSERT INTO user (login, password, email) VALUES (?, ?, ?)", array($_POST['login'], $pw->gen($_POST['password']), $_POST['email']));

		$err[8] = 'reg_ok'; // Регистрация пройдена, выводим сообщение об этом
	elseif ($get_user):
		$err[6] = '<div class="input-error error">Такой логин уже используется</div>';
	endif;

	if ($get_email):
		$err[7] = '<div class="input-error error">Такой email уже используется</div>';
	endif;

endif;



if (!empty($_POST['token'])):

	if (empty($_POST['login']) or strlen($_POST['login']) < 3):
		$err[0] = '<div class="input-error error">Логин не может быть менее 3 символов</div>';
	endif;
	
	if (empty($_POST['email'])):
		$err[1] = '<div class="input-error error">Неверно указан Email адрес</div>';
	endif;

	if (empty($_POST['password']) or strlen($_POST['password']) < 6):
		$err[2] = '<div class="input-error error">Пароль должен содержать минимум 6 символов</div>';
	elseif ($_POST['password'] != $_POST['password2']):
		$err[3] = '<div class="input-error error">Пароли не совпадают</div>';
	endif;

	if (empty($_POST['agree'])):
		$err[4] = '<div class="input-error error">Вы должны принять соглашение</div>';
	endif;

foreach ($err as $key => $value) {
	if (!empty($value) and $key != 3 and $key != 6 and $key != 7):
		$err[5] = '<div class="input-error error">Заполните обязательные поля</div>';
		break;
	endif;
}


endif;

$token = $tk->input();
?>

	<article class="content page_register">
		<h1>Регистрация</h1>


<?php if (empty($err[8])): ?>
<form method="post" autocomplete="off">
	<?=$token?>

	<table>
	<tr>
		<td><label for="login">Логин:</label></td>
		<td>
			<input type="text" id="login" name="login" value=""/>
			<?=$err[0]?><?=$err[6]?>
		</td>
	</tr>
	<tr>
		<td><label for="email">Email:</label></td>
		<td>
			<input type="email" id="email" name="email" value="" autocomplete="off"/>
			<?=$err[1]?><?=$err[7]?>
		</td>
	</tr>
	<tr>
		<td><label for="password">Пароль:</label></td>
		<td>
			<input type="password" id="password" name="password" autocomplete="off"/>
			<?=$err[2]?>
		</td>
	</tr>
	<tr>
		<td><label for="password2">Повторите пароль:</label></td>
		<td>
			<input type="password" id="password2" name="password2" autocomplete="off"/>
			<?=$err[3]?>
		</td>
	</tr>
		<tr>
			<td></td>
			<td>
				<input type="checkbox" id="checkbox" name="agree" /> <label for="checkbox">С <a href="/agreement/" target="_blank">соглашением</a> согласен</label>
				<?=$err[4]?>
			</td>
		</tr>
	<tr>
		<td></td>
		<td>
			<input type="submit" value="Продолжить" />
			<?=$err[5]?>
		</td>
	</tr>
	</table>
</form>
<?php else: ?>
	<div class="success">Спасибо за регистрацию! Теперь вы можете <a href="/auth/">войти</a> в свой аккаунт.</div>
<?php endif; ?>
	</article>