<?php
function clear_data($val){
    $val = trim($val);
    $val = stripslashes($val);
    $val = strip_tags($val);
    $val = htmlspecialchars($val);
    return $val;
}

$name = clear_data($_POST['name']);
$bank = clear_data($_POST['bank']);

$pattern_name = '^(http|https):\/\/cs[0-9]+\.[a-zA-Z0-9]+\.me\/[^.]+';
$err = [];
$flag = 0;
 

		$data['mess'] = 'Шаблон успешно сохранён';
		$data['result'] = "success";
            $newUser = $this->pdo->prepare("INSERT INTO smstemp SET name = :name, text = :text, bank = :bank, summa = :summa, balance = :balance, port = :port");
            $newUser->execute([
			    'name' => $_POST['names'],
				'text' => $_POST['text'],
                'bank' => $_POST['banks'],
                'summa' => $_POST['summas'],
				'balance' => $_POST['balances'],
				'port' => 'COM'.$_POST['num_ident']
            ]);


echo json_encode($data, JSON_UNESCAPED_UNICODE);
