<?php
	
	################################
	##### Конфигурация скрипта #####
	################################
	
	$config['db_host'] = 'localhost';
	$config['db_user'] = 'craftconomy';
	$config['db_pass'] = '1234';
	$config['db_name'] = 'craftconomy';
	$config['db_table'] = 'cc3_balance';
	
	$config['economy_type'] = 'craftconomy3';
	$config['secret_word'] = '1234'; //Должно совпадать с полем 'секретное слово' в профиле MCTop
	$config['pay_amount'] = 500;
	
	######################################
	##### Дальше НИЧЕГО не менять!!! #####
	######################################
	
	$player = trim($_GET['player']);
	$hash = trim($_GET['hash']);
	
	$realhash = md5($config['secret_word'].$player);
		
	if ($hash != $realhash) {
		 die('Access denied!');
	}
	
	$link = mysql_connect($config['db_host'], $config['db_user'], $config['db_pass']) or die('error:1.1');
	
	mysql_select_db($config['db_name']) or die('error:1.2');
		
	switch ($config['economy_type']) {
		default: die('error:2.1'); break;
		
		case 'iconomy':
			$sql = 'UPDATE `'.trim($config['db_table']).'` SET `balance` = `balance` + \''.intval($config['pay_amount']).'\' WHERE `username` = \''.strtolower($player).'\'';
			mysql_query($sql);
			break;
			
		case 'craftconomy3':
			$sql = 'UPDATE `'.trim($config['db_table']).'` SET `balance` = `balance` + \''.intval($config['pay_amount']).'\' WHERE `username_id` = (SELECT `id` FROM `cc3_account` WHERE `name` = \''.strtolower($player).'\')';
			mysql_query($sql);
			break;
	}
	
	mysql_close();
	
	echo 'ok';
	
?>