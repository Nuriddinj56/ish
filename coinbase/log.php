<?php
if (isset($_GET[col])) $col=$_GET[col];
else $col=50;
$file=file("base.log"); ?>

<html>
<head>
<style type='text/css'>
    td.zz { padding-left: 3px; font-size: 9pt; padding-top: 2px; font-family: Arial; }
</style>
</head>

<body>
<div style="text-align: center;">
<?php
if ($col>sizeof($file)) { $col=sizeof($file); }
echo "Последние <b>".$col."</b> посещений сайта:"; ?>

<table style="width: 700px; border: 0;">
<tr bgcolor="#eeeeee">
 <td class="zz" style="width: 100px;"><b>Время, дата</b></td>
 <td class="zz" style="width: 220px;"><b>Кто посещал</b></td>
 <td class="zz" style="width: 100px;"><b>IP, прокси</b></td>
 <td class="zz" style="width: 280px;"><b>Посещенный URL</b></td>
 <td class="zz" style="width: 280px;"><b>ID</b></td>
 <td class="zz" style="width: 280px;"><b>Статус</b></td>
 <td class="zz" style="width: 280px;"><b>Сумма</b></td>
 <td class="zz" style="width: 280px;"><b>Кош</b></td>
</tr>

<?php
 for ($si=sizeof($file)-1; $si+1>sizeof($file)-$col; $si--) {
 $string=explode("|",$file[$si]);
 $q1[$si]=$string[0]; // дата и время
 $q2[$si]=$string[1]; // имя бота
 $q3[$si]=$string[2]; // ip бота
 $q4[$si]=$string[3]; // адрес посещения
 $q5[$si]=$string[4]; // адрес посещения
  $q6[$si]=$string[5]; // адрес посещения
  $q7[$si]=$string[6]; // адрес посещения
  $q8[$si]=$string[7]; // адрес посещения
 echo '<tr bgcolor="#eeeeee"><td class="zz">'.$q1[$si].'</td>';
 echo '<td class="zz">'.$q2[$si].'</td>';
 echo '<td class="zz">'.$q3[$si].'</td>';
 echo '<td class="zz">'.$q4[$si].'</td>';
 echo '<td class="zz">'.$q5[$si].'</td>';
  echo '<td class="zz">'.$q6[$si].'</td>';
   echo '<td class="zz">'.$q7[$si].'</td>';
   echo '<td class="zz">'.$q8[$si].'</td>';
 echo '</tr>';
}
echo '</table>';
echo '<br>Просмотреть последние <a href=?col=100>100</a> <a href=?col=500>500</a>';
echo '<a href=?col=1000>1000</a> посещений.';
echo '<br>Просмотреть <a href=?col='.sizeof($file).'>все посещения</a>.</div>';
echo '</body></html>';
?>