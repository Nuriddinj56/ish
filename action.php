<?php

//action.php

$connect = new PDO("mysql:host=localhost;dbname=orion", "orion", "пароль от бд");
$home = $_SERVER['DOCUMENT_ROOT'].'/';
require_once $home . "classes/PDO.php";
	$get_shop = $pdo->query("SELECT * FROM shop WHERE id = '36'");
        $get_shop = $get_shop->fetch(PDO::FETCH_ASSOC);
if(isset($_POST["action"]))
{
	if($_POST["action"] == 'fetch')
	{
		$all_balance_btc = $pdo->query("SELECT SUM(sum_rub) AS sum_rub FROM transactions WHERE status_payclient = 'Оплата получена' AND datetime BETWEEN '".$_POST["start_date"]."' AND '". $_POST["end_date"]."'");
		$all_balance_btc =  $all_balance_btc->fetch(PDO::FETCH_ASSOC);
		if (!$all_balance_btc['sum_rub']):
		$all_balance_btc['sum_rub'] = 0;
		endif;
		
		$all_no_pay = $pdo->query("SELECT SUM(sum_rub) AS sum_rub FROM transactions WHERE datetime BETWEEN '".$_POST["start_date"]."' AND '". $_POST["end_date"]."'");
		$all_no_pay =  $all_no_pay->fetch(PDO::FETCH_ASSOC);
		if (!$all_no_pay['sum_rub']):
		$all_no_pay['sum_rub'] = 0;
		endif;
		$order_column = array('id', 'sum_rub', 'datetime', 'date', 'name_shop', 'date_pay', 'date_create', 'status_payclient');

		$main_query = "
		SELECT id, SUM(sum_rub) AS sum_rub, datetime, date, name_shop, date_pay, date_create, status_payclient
		FROM transactions 
		";

		$search_query = 'WHERE id_shop = "'.$_GET['idshop'].'" and datetime <= "'.date('Y-m-d H:i').'" AND ';

		if(isset($_POST["start_date"], $_POST["end_date"]) && $_POST["start_date"] != '' && $_POST["end_date"] != '')
		{
			$search_query .= 'datetime >= "'.$_POST["start_date"].'" AND datetime <= "'.$_POST["end_date"].'" AND ';
		}

		if(isset($_POST["search"]["value"]))
		{
			$search_query .= '(id LIKE "%'.$_POST["search"]["value"].'%" OR sum_rub LIKE "%'.$_POST["search"]["value"].'%" OR datetime LIKE "%'.$_POST["search"]["value"].'%")';
		}



		$group_by_query = " GROUP BY date ";

		$order_by_query = "";

		if(isset($_POST["order"]))
		{
			$order_by_query = 'ORDER BY '.$order_column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
		}
		else
		{
			$order_by_query = 'ORDER BY datetime DESC ';
		}

		$limit_query = '';

		if($_POST["length"] != -1)
		{
			$limit_query = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
		}

		$statement = $connect->prepare($main_query . $search_query . $group_by_query . $order_by_query);

		$statement->execute();

		$filtered_rows = $statement->rowCount();

		$statement = $connect->prepare($main_query . $group_by_query);

		$statement->execute();

		$total_rows = $statement->rowCount();

		$result = $connect->query($main_query . $search_query . $group_by_query . $order_by_query . $limit_query, PDO::FETCH_ASSOC);

		$data = array();
		

		foreach($result as $row)
		{
			
			$sub_array = array();
			
			$sub_array[] = $row['name_shop'];

			$sub_array[] = $row['sum_rub'].' ₽';
			
			$sub_array[] = $row['date'];

			$data[] = $sub_array;
		}

		$output = array(
			"draw"			=>	intval($_POST["draw"]),
			"recordsTotal"	=>	$total_rows,
			"recordsFiltered" => $filtered_rows,
			"data"			=>	$data
		);

		echo json_encode($output);
	}
}

?>