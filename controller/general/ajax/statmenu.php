<?php
$home = $_SERVER['DOCUMENT_ROOT'].'/';
require_once $home . "classes/Db.php";
$db = new Db();
$this->pdo = $db->connect();
$total_users = $this->pdo->query("SELECT * FROM dle_users");
$total_users = $total_users->fetchAll();
$total_shop = $this->pdo->query("SELECT * FROM shop");
$total_shop = $total_shop->fetchAll();
$total_order = $this->pdo->query("SELECT * FROM transactions");
$total_order = $total_order->fetchAll();
$total_order_pay = $this->pdo->query("SELECT * FROM transactions WHERE status_payclient = 'Оплата получена'");
$total_order_pay = $total_order_pay->fetchAll();
$total_order_nopay = $this->pdo->query("SELECT * FROM transactions WHERE status_payclient = 'В ожидании'");
$total_order_nopay = $total_order_nopay->fetchAll();

$banners[] = '<h1 class="s-counter6 s-counter" style="font-weight:800;font-size:0.9rem;">'.count($total_shop).'</h1><p style="font-weight:800;font-size:0.5rem;">
МАГАЗИНОВ
</p>';

$banners[] = '<h1 class="s-counter6 s-counter" style="font-weight:800;font-size:0.9rem;">'.count($total_users).'</h1><p style="font-weight:800;font-size:0.5rem;">
КЛИЕНТОВ
</p>';
 
         shuffle($banners);
?>
<div class="simple--counter-container" style="margin-top:11px;" >
<div class="counter-content" style="padding-left:7px;padding-right:7px;">
<h1 class="s-counter6 s-counter" style="font-weight:800;font-size:0.9rem;"><? echo count($total_order);?></h1><p style="font-weight:800;font-size:0.5rem;">
ЗАЯВОК
</p>
</div>
										
<div class="counter-content" style="padding-left:7px;padding-right:7px;">
<h1 class="s-counter6 s-counter" style="font-weight:800;font-size:0.9rem;"><? echo count($total_order_pay);?></h1><p style="font-weight:800;font-size:0.5rem;">
ОПЛАЧЕНО
</p>
</div>

<div class="counter-content" style="padding-left:7px;padding-right:7px;">
<h1 class="s-counter6 s-counter" style="font-weight:800;font-size:0.9rem;"><? echo count($total_order_nopay);?></h1><p style="font-weight:800;font-size:0.5rem;">
В ОЖИДАНИИ
</p>
</div>

<div class="counter-content" style="padding-left:7px;padding-right:7px;">
<? echo $banners[1];?>
</div>

<div class="counter-content hidemobile" style="padding-left:7px;padding-right:7px;">
<? echo $banners[0];?>
</div></div>
<?
