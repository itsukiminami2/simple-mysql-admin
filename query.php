<?php
	ini_set('display_errors', 'off');
?>

<!DOCTYPE html>
<html>
<head>
	<style>
		table {
			width: 100%;
			border-collapse: collapse;
			border: 1px solid black;
			padding: 5px;
		}

		td, th {
			border: 1px solid black;
			padding: 5px;
		}

		th {text-align: left;}
	</style>
</head>
<body>

<?php

session_start();

$sql = $_GET['q'];

$con = mysqli_connect('localhost', $_SESSION['user'], $_SESSION['pass']);
mysqli_select_db($con, $_GET['db']);

if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}

$result = mysqli_query($con, $sql);

if(stripos($sql, 'SELECT') === 0 or stripos($sql, 'SHOW') === 0) {
$header='';
    $rows='';
    while ($row = mysqli_fetch_array($result)) { 
        if($header==''){
            $header.='<tr>';
            $rows.='<tr>'; 
            foreach($row as $key => $value){ 
                $header.='<th>'.$key.'</th>'; 
                $rows.='<td>'.$value.'</td>'; 
            } 
            $header.='</tr>'; 
            $rows.='</tr>'; 
        }else{
            $rows.='<tr>'; 
            foreach($row as $value){ 
                $rows .= "<td>".$value."</td>"; 
            } 
            $rows.='</tr>'; 
        }
    }
	echo '<table>'.$header.$rows.'</table>';
}

mysqli_close($con);
?>

</body>
</html>