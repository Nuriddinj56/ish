<?PHP
$coinbase = $_POST['coin'];
$coin = $this->pdo->query("SELECT * FROM exchanges WHERE id = '".$coinbase."'");
$coin = $coin->fetch(PDO::FETCH_ASSOC);
?>

<ul class="list-group list-group-icons-meta">
<li class="list-group-item list-group-item-action active">
<div class="media">
<div class="media-body">
<h6 class="tx-inverse"><span style="color:#009688;font-weight:600;font-size:0.8rem;"><? echo $coin['bir']; ?>: <? echo $coin['name']; ?> </span></h6>
<p class="mg-b-0">
<span style="font-weight:600;font-size:0.7rem;color:#607d8b;">Баланс BTC:</span> <span style="color:#bfc9d4;font-weight:600;"><?php echo $coin['balance_btc'];?></span><br>
<span style="font-weight:600;font-size:0.7rem;color:#607d8b;">Баланс LTC:</span> <span style="color:#bfc9d4;font-weight:600;"><?php echo $coin['balance_ltc'];?></span><br>
<span style="font-weight:600;font-size:0.7rem;color:#607d8b;">Баланс ETH:</span> <span style="color:#bfc9d4;font-weight:600;"><?php echo $coin['balance_eth'];?></span><br>
<span style="font-weight:600;font-size:0.7rem;color:#607d8b;">Баланс USDT:</span> <span style="color:#bfc9d4;font-weight:600;"><?php echo $coin['balance_usdt'];?></span><br>

</p>
</div>
</div>
</li>
</ul>