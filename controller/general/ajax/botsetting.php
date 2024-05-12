<?PHP

 $text = $_POST["name"];
 $descr = $_POST["descr"];
 $page_one = $_POST["page_one"];
 $page_two = $_POST["page_two"];
 $contacts = $_POST["contacts"];
 $time_zakaz = $_POST["time_zakaz"];
 $on_off = $_POST["on_off"];
 $domainobmen = $_POST["domainobmen"];
 $home = $_SERVER['DOCUMENT_ROOT'].'/';
require_once $home . "classes/PDO.php";
 if(ISSET($text)){
 $pdo->prepare("UPDATE necro_setting SET name=? WHERE id = '1'")->execute(array($text));
 }
 if(ISSET($descr)){
 $pdo->prepare("UPDATE necro_setting SET descr=? WHERE id = '1'")->execute(array($descr));
 }
  if(ISSET($page_one)){
 $pdo->prepare("UPDATE necro_setting SET page_one=? WHERE id = '1'")->execute(array($page_one));
 }
  if(ISSET($page_two)){
 $pdo->prepare("UPDATE necro_setting SET page_two=? WHERE id = '1'")->execute(array($page_two));
 }
  if(ISSET($contacts)){
 $pdo->prepare("UPDATE necro_setting SET contacts=? WHERE id = '1'")->execute(array($contacts));
 }
  if(ISSET($time_zakaz)){
 $pdo->prepare("UPDATE necro_setting SET time_zakaz=? WHERE id = '1'")->execute(array($time_zakaz));
 }
  if(ISSET($on_off)){
 $pdo->prepare("UPDATE necro_setting SET on_off=? WHERE id = '1'")->execute(array($on_off));
 }
  if(ISSET($domainobmen)){
 $pdo->prepare("UPDATE necro_setting SET domain=? WHERE id = '1'")->execute(array($domainobmen));
 }

?>
