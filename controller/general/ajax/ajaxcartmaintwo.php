<?php


$summ = $this->pdo->query("SELECT * FROM `live` WHERE id = '2' ");
$summ = $summ->fetch(PDO::FETCH_ASSOC);

$card = $this->pdo->query("SELECT * FROM `card` WHERE id = '".$_GET['id_cardtwo']."' ");
$card = $card->fetch(PDO::FETCH_ASSOC);

if ($summ['old_summ'] == $summ['new_summ']) {
$class = '';
} else {
$class = 'highlight';	
$this->pdo->prepare("UPDATE live SET old_summ=? WHERE id = '2'")->execute(array($summ['new_summ']));
}
?>
<p class="inv-balance"><?=$card['balance']?> ₽</p>
<span class="inv-stats balance-credited <?=$class?>">+ <?=$summ['new_summ']?></span>
<?

?>