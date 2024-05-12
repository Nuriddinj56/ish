<?php
$coinbase = $this->pdo->query("SELECT * FROM exchanges WHERE what = 'Магазины' and active = '1'");
$coinbase = $coinbase->fetch(PDO::FETCH_ASSOC);
$start = date("Y-m-d H:i", strtotime($_POST['start']));
$end = date("Y-m-d H:i", strtotime($_POST['end']));
$idshop = $_POST['id'];


        //----------------------------------------//
		$all_trans = $this->pdo->query("SELECT COUNT(*) AS count FROM transactions WHERE id_shop = '".$idshop."' and datetime BETWEEN '".$start."' AND '". $end."'");
		$all_trans =  $all_trans->fetch(PDO::FETCH_ASSOC);
		if (!$all_trans['count']):
		$all_trans['count'] = 0;
		endif;
		
		$all_trans_summ = $this->pdo->query("SELECT SUM(sum_rub) AS sum_rub FROM transactions WHERE id_shop = '".$idshop."' and datetime BETWEEN '".$start."' AND '". $end."'");
		$all_trans_summ =  $all_trans_summ->fetch(PDO::FETCH_ASSOC);
		if (!$all_trans_summ['sum_rub']):
		$all_trans_summ['sum_rub'] = 0;
		endif;
		
		$all_trans_summ = num_word($all_trans_summ['sum_rub'], array('рубль', 'рубля', 'рублей'));
		$all_trans = num_word($all_trans['count'], array('транзакция', 'транзакции', 'транзакций'));
		//----------------------------------------//
		
		
		
		//----------------------------------------//
	    $all_trans_pay = $this->pdo->query("SELECT COUNT(*) AS count FROM transactions WHERE id_shop = '".$idshop."' AND status_payclient = 'Оплата получена' AND datetime BETWEEN '".$start."' AND '". $end."'");
		$all_trans_pay =  $all_trans_pay->fetch(PDO::FETCH_ASSOC);
		if (!$all_trans_pay['count']):
		$all_trans_pay['count'] = 0;
		endif;
		
		$all_trans_pay_summ = $this->pdo->query("SELECT SUM(sum_rub) AS sum_rub FROM transactions WHERE id_shop = '".$idshop."' AND status_payclient = 'Оплата получена' AND datetime BETWEEN '".$start."' AND '". $end."'");
		$all_trans_pay_summ =  $all_trans_pay_summ->fetch(PDO::FETCH_ASSOC);
		if (!$all_trans_pay_summ['sum_rub']):
		$all_trans_pay_summ['sum_rub'] = 0;
		endif;
		//----------------------------------------//
		
		
		$all_trans_pay_summ = num_word($all_trans_pay_summ['sum_rub'], array('рубль', 'рубля', 'рублей'));
		$all_trans_pay = num_word($all_trans_pay['count'], array('транзакция', 'транзакции', 'транзакций'));
		
		
		//----------------------------------------//
		$all_trans_pay_summ_rub = $this->pdo->query("SELECT SUM(out_summ) AS out_summ FROM transactions WHERE id_shop = '".$idshop."' AND status_payclient = 'Оплата получена' AND datetime BETWEEN '".$start."' AND '". $end."'");
		$all_trans_pay_summ_rub =  $all_trans_pay_summ_rub->fetch(PDO::FETCH_ASSOC);
		if (!$all_trans_pay_summ_rub['out_summ']):
		$all_trans_pay_summ_rub['out_summ'] = 0;
		endif;
		
		$all_trans_pay_summ_btc = $this->pdo->query("SELECT SUM(sendclient_crypto) AS sendclient_crypto FROM transactions WHERE id_shop = '".$idshop."' AND na_chto = 'BTC' AND status_payclient = 'Оплата получена' AND datetime BETWEEN '".$start."' AND '". $end."'");
		$all_trans_pay_summ_btc =  $all_trans_pay_summ_btc->fetch(PDO::FETCH_ASSOC);
		if (!$all_trans_pay_summ_btc['sendclient_crypto']):
		$all_trans_pay_summ_btc['sendclient_crypto'] = 0;
		endif;
				$all_trans_pay_summ_ltc = $this->pdo->query("SELECT SUM(sendclient_crypto) AS sendclient_crypto FROM transactions WHERE id_shop = '".$idshop."' AND na_chto = 'LTC' AND status_payclient = 'Оплата получена' AND datetime BETWEEN '".$start."' AND '". $end."'");
		$all_trans_pay_summ_ltc =  $all_trans_pay_summ_ltc->fetch(PDO::FETCH_ASSOC);
		if (!$all_trans_pay_summ_ltc['sendclient_crypto']):
		$all_trans_pay_summ_ltc['sendclient_crypto'] = 0;
		endif;
				$all_trans_pay_summ_eth = $this->pdo->query("SELECT SUM(sendclient_crypto) AS sendclient_crypto FROM transactions WHERE id_shop = '".$idshop."' AND na_chto = 'ETH' AND status_payclient = 'Оплата получена' AND datetime BETWEEN '".$start."' AND '". $end."'");
		$all_trans_pay_summ_eth =  $all_trans_pay_summ_eth->fetch(PDO::FETCH_ASSOC);
		if (!$all_trans_pay_summ_eth['sendclient_crypto']):
		$all_trans_pay_summ_eth['sendclient_crypto'] = 0;
		endif;
				$all_trans_pay_summ_usdt = $this->pdo->query("SELECT SUM(sendclient_crypto) AS sendclient_crypto FROM transactions WHERE id_shop = '".$idshop."' AND na_chto = 'USDT' AND status_payclient = 'Оплата получена' AND datetime BETWEEN '".$start."' AND '". $end."'");
		$all_trans_pay_summ_usdt =  $all_trans_pay_summ_usdt->fetch(PDO::FETCH_ASSOC);
		if (!$all_trans_pay_summ_usdt['sendclient_crypto']):
		$all_trans_pay_summ_usdt['sendclient_crypto'] = 0;
		endif;
		//----------------------------------------//
		$all_trans_pay_summ_rub = num_word($all_trans_pay_summ_rub['out_summ'], array('рубль', 'рубля', 'рублей'));
		
		
		
		
		
		$all_trans_vivod_summ_rub = $this->pdo->query("SELECT SUM(out_summ) AS out_summ FROM transactions WHERE id_shop = '".$idshop."' AND status_payclient = 'Оплата получена' AND datetime BETWEEN '".$start."' AND '". $end."'");
		$all_trans_vivod_summ_rub =  $all_trans_vivod_summ_rub->fetch(PDO::FETCH_ASSOC);
		if (!$all_trans_vivod_summ_rub['out_summ']):
		$all_trans_vivod_summ_rub['out_summ'] = 0;
		endif;
		
		$all_trans_vivod_summ_btc = $this->pdo->query("SELECT SUM(sendclient_crypto) AS sendclient_crypto FROM transactions WHERE id_shop = '".$idshop."' AND status = 'Выплачено' AND na_chto = 'BTC' AND status_payclient = 'Оплата получена' AND datetime BETWEEN '".$start."' AND '". $end."'");
		$all_trans_vivod_summ_btc =  $all_trans_vivod_summ_btc->fetch(PDO::FETCH_ASSOC);
		if (!$all_trans_vivod_summ_btc['sendclient_crypto']):
		$all_trans_vivod_summ_btc['sendclient_crypto'] = 0;
		endif;
				$all_trans_vivod_summ_ltc = $this->pdo->query("SELECT SUM(sendclient_crypto) AS sendclient_crypto FROM transactions WHERE id_shop = '".$idshop."' AND status = 'Выплачено' AND na_chto = 'LTC' AND status_payclient = 'Оплата получена' AND datetime BETWEEN '".$start."' AND '". $end."'");
		$all_trans_vivod_summ_ltc =  $all_trans_vivod_summ_ltc->fetch(PDO::FETCH_ASSOC);
		if (!$all_trans_vivod_summ_ltc['sendclient_crypto']):
		$all_trans_vivod_summ_ltc['sendclient_crypto'] = 0;
		endif;
				$all_trans_vivod_summ_eth = $this->pdo->query("SELECT SUM(sendclient_crypto) AS sendclient_crypto FROM transactions WHERE id_shop = '".$idshop."' AND status = 'Выплачено' AND na_chto = 'ETH' AND status_payclient = 'Оплата получена' AND datetime BETWEEN '".$start."' AND '". $end."'");
		$all_trans_vivod_summ_eth =  $all_trans_vivod_summ_eth->fetch(PDO::FETCH_ASSOC);
		if (!$all_trans_vivod_summ_eth['sendclient_crypto']):
		$all_trans_vivod_summ_eth['sendclient_crypto'] = 0;
		endif;
				$all_trans_vivod_summ_usdt = $this->pdo->query("SELECT SUM(sendclient_crypto) AS sendclient_crypto FROM transactions WHERE id_shop = '".$idshop."' AND status = 'Выплачено' AND na_chto = 'USDT' AND status_payclient = 'Оплата получена' AND datetime BETWEEN '".$start."' AND '". $end."'");
		$all_trans_vivod_summ_usdt =  $all_trans_vivod_summ_usdt->fetch(PDO::FETCH_ASSOC);
		if (!$all_trans_vivod_summ_usdt['sendclient_crypto']):
		$all_trans_vivod_summ_usdt['sendclient_crypto'] = 0;
		endif;
		
		$all_trans_vivod_summ_rub = num_word($all_trans_vivod_summ_rub['out_summ'], array('рубль', 'рубля', 'рублей'));
		
				$all_trans_vivod_lk_summ_rub = $this->pdo->query("SELECT SUM(out_summ) AS out_summ FROM transactions WHERE id_shop = '".$idshop."' AND status_payclient = 'Оплата получена' AND datetime BETWEEN '".$start."' AND '". $end."'");
		$all_trans_vivod_lk_summ_rub =  $all_trans_vivod_lk_summ_rub->fetch(PDO::FETCH_ASSOC);
		if (!$all_trans_vivod_lk_summ_rub['out_summ']):
		$all_trans_vivod_lk_summ_rub['out_summ'] = 0;
		endif;
		
		$all_trans_vivod_lk_summ_btc = $this->pdo->query("SELECT SUM(sendclient_crypto) AS sendclient_crypto FROM transactions WHERE id_shop = '".$idshop."' AND status = 'Зачислено на счёт' AND na_chto = 'BTC' AND status_payclient = 'Оплата получена' AND datetime BETWEEN '".$start."' AND '". $end."'");
		$all_trans_vivod_lk_summ_btc =  $all_trans_vivod_lk_summ_btc->fetch(PDO::FETCH_ASSOC);
		if (!$all_trans_vivod_lk_summ_btc['sendclient_crypto']):
		$all_trans_vivod_lk_summ_btc['sendclient_crypto'] = 0;
		endif;
				$all_trans_vivod_lk_summ_ltc = $this->pdo->query("SELECT SUM(sendclient_crypto) AS sendclient_crypto FROM transactions WHERE id_shop = '".$idshop."' AND status = 'Зачислено на счёт' AND na_chto = 'LTC' AND status_payclient = 'Оплата получена' AND datetime BETWEEN '".$start."' AND '". $end."'");
		$all_trans_vivod_lk_summ_ltc =  $all_trans_vivod_lk_summ_ltc->fetch(PDO::FETCH_ASSOC);
		if (!$all_trans_vivod_lk_summ_ltc['sendclient_crypto']):
		$all_trans_vivod_lk_summ_ltc['sendclient_crypto'] = 0;
		endif;
				$all_trans_vivod_lk_summ_eth = $this->pdo->query("SELECT SUM(sendclient_crypto) AS sendclient_crypto FROM transactions WHERE id_shop = '".$idshop."' AND status = 'Зачислено на счёт' AND na_chto = 'ETH' AND status_payclient = 'Оплата получена' AND datetime BETWEEN '".$start."' AND '". $end."'");
		$all_trans_vivod_lk_summ_eth =  $all_trans_vivod_lk_summ_eth->fetch(PDO::FETCH_ASSOC);
		if (!$all_trans_vivod_lk_summ_eth['sendclient_crypto']):
		$all_trans_vivod_lk_summ_eth['sendclient_crypto'] = 0;
		endif;
				$all_trans_vivod_lk_summ_usdt = $this->pdo->query("SELECT SUM(sendclient_crypto) AS sendclient_crypto FROM transactions WHERE id_shop = '".$idshop."' AND status = 'Зачислено на счёт' AND na_chto = 'USDT' AND status_payclient = 'Оплата получена' AND datetime BETWEEN '".$start."' AND '". $end."'");
		$all_trans_vivod_lk_summ_usdt =  $all_trans_vivod_lk_summ_usdt->fetch(PDO::FETCH_ASSOC);
		if (!$all_trans_vivod_lk_summ_usdt['sendclient_crypto']):
		$all_trans_vivod_lk_summ_usdt['sendclient_crypto'] = 0;
		endif;
		
		$all_trans_vivod_lk_summ_rub = num_word($all_trans_vivod_lk_summ_rub['out_summ'], array('рубль', 'рубля', 'рублей'));
		
		
		
		$all_trans_ref_summ_rub = $this->pdo->query("SELECT SUM(ref_sum) AS ref_sum FROM transactions WHERE id_shop = '".$idshop."' AND status_payclient = 'Оплата получена' AND datetime BETWEEN '".$start."' AND '". $end."'");
		$all_trans_ref_summ_rub =  $all_trans_ref_summ_rub->fetch(PDO::FETCH_ASSOC);
		if (!$all_trans_ref_summ_rub['ref_sum']):
		$all_trans_ref_summ_rub['ref_sum'] = 0;
		endif;
		
		$all_trans_ref_summ_rub = num_word($all_trans_ref_summ_rub['ref_sum'], array('рубль', 'рубля', 'рублей'));
		
		
/**
 * Склонение существительных после числительных.
 * 
 * @param string $value Значение
 * @param array $words Массив вариантов, например: array('товар', 'товара', 'товаров')
 * @param bool $show Включает значение $value в результирующею строку
 * @return string
 */
function num_word($value, $words, $show = true) 
{
	$num = $value % 100;
	if ($num > 19) { 
		$num = $num % 10; 
	}
	
	$out = ($show) ?  $value . ' ' : '';
	switch ($num) {
		case 1:  $out .= $words[0]; break;
		case 2: 
		case 3: 
		case 4:  $out .= $words[1]; break;
		default: $out .= $words[2]; break;
	}
	
	return $out;
}
		
		
?>

                                <div class="widget-content widget-content-area">
                                    <ul class="list-group list-group-icons-meta">

                     				 <li class="list-group-item list-group-item-action active">
                                            <div class="media">
                                                <div class="media-body">
                                                    <h6 class="tx-inverse"><span style="color:#009688;font-weight:600;font-size:0.8rem;">Всего транзакций</span></h6>
                                                    <p class="mg-b-0">
													<span style="font-weight:600;font-size:0.7rem;color:#607d8b;">Количество: <span style="color:#bfc9d4;font-weight:600;"><?php echo $all_trans;?>, </span>
													<span style="font-weight:600;font-size:0.7rem;color:#607d8b;">на сумму: <span style="color:#bfc9d4;font-weight:600;"><?php echo $all_trans_summ;?></span>
													</p>
                                                </div>
                                            </div>
                                        </li>
										
										 <li class="list-group-item list-group-item-action active">
                                            <div class="media">
                                                <div class="media-body">
                                                    <h6 class="tx-inverse"><span style="color:#009688;font-weight:600;font-size:0.8rem;">Оплаченных транзакций</span></h6>
                                                    <p class="mg-b-0">
													<span style="font-weight:600;font-size:0.7rem;color:#607d8b;">Количество: <span style="color:#bfc9d4;font-weight:600;"><?php echo $all_trans_pay;?>, </span>
													<span style="font-weight:600;font-size:0.7rem;color:#607d8b;">на сумму: <span style="color:#bfc9d4;font-weight:600;"><?php echo $all_trans_pay_summ;?></span>
													</p>
                                                </div>
                                            </div>
                                        </li>
										 <li class="list-group-item list-group-item-action active">
                                            <div class="media">
                                                <div class="media-body">
                                                    <h6 class="tx-inverse"><span style="color:#009688;font-weight:600;font-size:0.8rem;">Заработано средств</span></h6>
                                                    <p class="mg-b-0">
													<span style="font-weight:600;font-size:0.7rem;color:#607d8b;">На сумму:
													<span style="color:#bfc9d4;font-weight:600;"><?php echo $all_trans_pay_summ_rub;?></span>, 
													<span style="color:#bfc9d4;font-weight:600;"><?php echo $all_trans_pay_summ_btc['sendclient_crypto'];?></span> <span style="font-weight:600;font-size:0.7rem;color:#607d8b;">BTC</span>, 
													<span style="color:#bfc9d4;font-weight:600;"><?php echo $all_trans_pay_summ_ltc['sendclient_crypto'];?></span> <span style="font-weight:600;font-size:0.7rem;color:#607d8b;">LTC</span>, 
													<span style="color:#bfc9d4;font-weight:600;"><?php echo $all_trans_pay_summ_eth['sendclient_crypto'];?></span> <span style="font-weight:600;font-size:0.7rem;color:#607d8b;">ETH</span>, 
													<span style="color:#bfc9d4;font-weight:600;"><?php echo $all_trans_pay_summ_usdt['sendclient_crypto'];?></span> <span style="font-weight:600;font-size:0.7rem;color:#607d8b;">USDT</span> 
													
													</p>
                                                </div>
                                            </div>
                                        </li>
										
										<li class="list-group-item list-group-item-action active">
                                            <div class="media">
                                                <div class="media-body">
                                                    <h6 class="tx-inverse"><span style="color:#009688;font-weight:600;font-size:0.8rem;">Выплачено средств</span></h6>
                                                    <p class="mg-b-0">
													<span style="font-weight:600;font-size:0.7rem;color:#607d8b;">На сумму:
													<span style="color:#bfc9d4;font-weight:600;"><?php echo $all_trans_vivod_summ_rub;?></span>, 
													<span style="color:#bfc9d4;font-weight:600;"><?php echo $all_trans_vivod_summ_btc['sendclient_crypto'];?></span> <span style="font-weight:600;font-size:0.7rem;color:#607d8b;">BTC</span>, 
													<span style="color:#bfc9d4;font-weight:600;"><?php echo $all_trans_vivod_summ_ltc['sendclient_crypto'];?></span> <span style="font-weight:600;font-size:0.7rem;color:#607d8b;">LTC</span>, 
													<span style="color:#bfc9d4;font-weight:600;"><?php echo $all_trans_vivod_summ_eth['sendclient_crypto'];?></span> <span style="font-weight:600;font-size:0.7rem;color:#607d8b;">ETH</span>, 
													<span style="color:#bfc9d4;font-weight:600;"><?php echo $all_trans_vivod_summ_usdt['sendclient_crypto'];?></span> <span style="font-weight:600;font-size:0.7rem;color:#607d8b;">USDT</span> 
													
													</p>
                                                </div>
                                            </div>
                                        </li>
										
										<li class="list-group-item list-group-item-action active">
                                            <div class="media">
                                                <div class="media-body">
                                                    <h6 class="tx-inverse"><span style="color:#009688;font-weight:600;font-size:0.8rem;">Зачислено на личные счета</span></h6>
                                                    <p class="mg-b-0">
													<span style="font-weight:600;font-size:0.7rem;color:#607d8b;">
													<span style="color:#bfc9d4;font-weight:600;"><?php echo $all_trans_vivod_lk_summ_btc['sendclient_crypto'];?></span> <span style="font-weight:600;font-size:0.7rem;color:#607d8b;">BTC</span>, 
													<span style="color:#bfc9d4;font-weight:600;"><?php echo $all_trans_vivod_lk_summ_ltc['sendclient_crypto'];?></span> <span style="font-weight:600;font-size:0.7rem;color:#607d8b;">LTC</span>, 
													<span style="color:#bfc9d4;font-weight:600;"><?php echo $all_trans_vivod_lk_summ_eth['sendclient_crypto'];?></span> <span style="font-weight:600;font-size:0.7rem;color:#607d8b;">ETH</span>, 
													<span style="color:#bfc9d4;font-weight:600;"><?php echo $all_trans_vivod_lk_summ_usdt['sendclient_crypto'];?></span> <span style="font-weight:600;font-size:0.7rem;color:#607d8b;">USDT</span> 
													
													</p>
                                                </div>
                                            </div>
                                        </li>
										
										<li class="list-group-item list-group-item-action active">
                                            <div class="media">
                                                <div class="media-body">
                                                    <h6 class="tx-inverse"><span style="color:#009688;font-weight:600;font-size:0.8rem;">Зачислено рефералу средств</span></h6>
                                                    <p class="mg-b-0">
													<span style="font-weight:600;font-size:0.7rem;color:#607d8b;">На сумму: <span style="color:#bfc9d4;font-weight:600;"><?php echo $all_trans_ref_summ_rub;?></span>, 
							
													
													</p>
                                                </div>
                                            </div>
                                        </li>
                                       
                                    </ul>

                                    

                                </div>

