<?PHP
    $date_now = date('Y-m-d');
    $crypto_pre_ltc_rub = $this->pdo->query("SELECT SUM(original_crypto) AS original_crypto FROM transactions WHERE  status_payclient = 'Оплата получена' and na_chto = 'LTC' and date = '".$date_now."' ");
	$crypto_pre_ltc_rub =  $crypto_pre_ltc_rub->fetch(PDO::FETCH_ASSOC);
	if (!$crypto_pre_ltc_rub['original_crypto']):
	$crypto_pre_ltc_rub['original_crypto'] = 0;
	endif;
	$crypto_pre_btc = $this->pdo->query("SELECT SUM(sum_rub) AS sum_rub FROM transactions WHERE  status_payclient = 'Оплата получена' and na_chto = 'BTC' and date = '".$date_now."' ");
	$crypto_pre_btc =  $crypto_pre_btc->fetch(PDO::FETCH_ASSOC);
	if (!$crypto_pre_btc['sum_rub']):
	$crypto_pre_btc['sum_rub'] = 0;
	endif;
	$crypto_pre_ltc = $this->pdo->query("SELECT SUM(sum_rub) AS sum_rub FROM transactions WHERE  status_payclient = 'Оплата получена' and na_chto = 'lTC' and date = '".$date_now."' ");
	$crypto_pre_ltc =  $crypto_pre_ltc->fetch(PDO::FETCH_ASSOC);
	if (!$crypto_pre_ltc['sum_rub']):
	$crypto_pre_ltc['sum_rub'] = 0;
	endif;
	$crypto_pre_eth = $this->pdo->query("SELECT SUM(sum_rub) AS sum_rub FROM transactions WHERE  status_payclient = 'Оплата получена' and na_chto = 'ETH' and date = '".$date_now."' ");
	$crypto_pre_eth =  $crypto_pre_eth->fetch(PDO::FETCH_ASSOC);
	if (!$crypto_pre_eth['sum_rub']):
	$crypto_pre_eth['sum_rub'] = 0;
	endif;
	$crypto_pre_usdt = $this->pdo->query("SELECT SUM(sum_rub) AS sum_rub FROM transactions WHERE  status_payclient = 'Оплата получена' and na_chto = 'USDT' and date = '".$date_now."' ");
	$crypto_pre_usdt =  $crypto_pre_usdt->fetch(PDO::FETCH_ASSOC);
	if (!$crypto_pre_usdt['sum_rub']):
	$crypto_pre_usdt['sum_rub'] = 0;
	endif;

$a = $crypto_pre_btc['sum_rub'];
$b = $crypto_pre_ltc['sum_rub'];
$c = $crypto_pre_eth['sum_rub'];
$d = $crypto_pre_usdt['sum_rub'];
$total = $a+$b+$c+$d;
 
$apercent = (100*$a)/$total;
$bpercent = (100*$b)/$total;
$cpercent = (100*$c)/$total;
$dpercent = (100*$d)/$total;

$apercent = number_format($apercent, 2, '.', '');
$bpercent = number_format($bpercent, 2, '.', '');
$cpercent = number_format($cpercent, 2, '.', '');
$dpercent = number_format($dpercent, 2, '.', '');
?>

<div class="w-browser-info">
                                                <h6><span style="font-size:0.7rem;font-weight:600;">Litecoin: <?=$crypto_pre_ltc_rub['original_crypto']?> (<font color="#2A798C"><?=$crypto_pre_ltc['sum_rub']?>₽</font>)</span></h6>
                                                <p class="browser-count"><?=$bpercent?>%</p>
                                            </div>
<div class="w-browser-stats">
                                                <div class="progress">
<div class="progress-bar bg-gradient-danger" role="progressbar" style="width: <?=$bpercent?>%" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
