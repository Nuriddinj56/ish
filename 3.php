<style>
code, pre {
    border-radius: 3px 3px 3px 3px;
    color: #e6db61;
    font-family: Monaco,Menlo,Consolas,"Courier New",monospace;
    font-size: 12px;
    padding: 0 3px 2px;
}
code {
    background-color: #191e3a;
    border: 1px solid #E1E1E8;
    color: #DD1144;
    padding: 2px 4px;
    white-space: nowrap;
}
pre {
    background-color: #191e3a;
    border: 1px solid rgba(0, 0, 0, 0.15);
    border-radius: 4px 4px 4px 4px;
    display: block;
    font-size: 13px;
    line-height: 20px;
    margin: 0 0 10px;
    padding: 9.5px;
    white-space: pre-wrap;
    word-break: break-all;
    word-wrap: break-word;
}
</style>
<?php
$text = $_POST['text'];
$array = explode(' ', $text);

echo $array[$a]; // ещё
echo $array[$b]; // ещё

$a = $_POST['summas'];
$b = $_POST['balances'];

$str = $array[$a];
$str2 = $array[$b];
$sum = explode( '.', $str )[0];
$bal = explode( '.', $str2 )[0];


$sum = mb_eregi_replace('[^0-9 ]', '', $sum);
echo '<pre>';
if (!$_POST['summas'] == '') {
echo 'Сумма: '.$sum;	
}
if (!$_POST['balances'] == '') {
echo '<br>Баланс: '.$bal;	
}
echo '</pre>';
?>
                                  