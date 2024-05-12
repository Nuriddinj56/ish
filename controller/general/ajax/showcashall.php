<?php
$home = $_SERVER['DOCUMENT_ROOT'].'/';


$get_set = $this->pdo->query("SELECT * FROM `necro_setting` WHERE id = '1' ");
$get_set = $get_set->fetch(PDO::FETCH_ASSOC);

$category = $this->pdo->query("SELECT * FROM card order by proshlo DESC LIMIT 4");
while ($row = $category->fetch()) {
	$curs = $row['bank'];
	$cur = ucfirst($curs);
	$card = substr($row['number'],15);
	$proshlo = number_format($row['proshlo']);
?>
<div class="wallet-balance" style="margin-top:0;">
<p style="font-size:0.8rem;">
<?=$cur;?> <span style="color:#62B1D0;">*<?=$card;?></span>
</p>
<p style="font-size:0.8rem;"><?=$proshlo;?> ₽</p>
</div>
<?
}
?>