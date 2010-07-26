<?php 

function print_array($array)
{
	echo '<pre>';
	var_dump($array);
	echo '</pre>';
}

function list_array($array)
{
	$list = implode(', ', $array);
	echo $list;
}

function list_membertypes($membertypes)
{
	$i = 0;
	$k = count($membertypes);
	for($i; $i < $k; $i++)
	{
		echo $membertypes[$i]['membertype_name'];		
		if($i < ($k - 1)) echo ', ';
	}
}
?>
