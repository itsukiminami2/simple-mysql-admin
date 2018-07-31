<?php
	ini_set('display_errors', 'off');
	if(empty($_GET['u'])) {
		exit(header('Location: login.php'));
	}
	else {
		session_start();
		$_SESSION['user'] = $_GET['u'];
		$_SESSION['pass'] = $_GET['p'];
	}
	
?>

<!DOCTYPE html>
<html>
<head>
	<title>Simple MySQL administrator</title>
	<script>
		function getData(str) {
			var db = document.getElementById("dblist");
			if (str == "") {
				document.getElementById("query").value = "";
				return;
			} else {
				if (window.XMLHttpRequest) {
					// code for IE7+, Firefox, Chrome, Opera, Safari
					xmlhttp = new XMLHttpRequest();
				} else {
					// code for IE6, IE5
					xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
				}
				xmlhttp.onreadystatechange = function() {
					if (this.readyState == 4 && this.status == 200) {
						document.getElementById("output").innerHTML = this.responseText;
					}
				};
				xmlhttp.open("GET", "query.php?q="+str+"&db="+db.options[db.selectedIndex].value , true);
				xmlhttp.send();
			}
		}
		
		function cleartext() {
			document.getElementById("query").value = "";
			document.getElementById("newdb_name").value = "";
			document.getElementById("output").innerHTML = "";
		}
	</script>
	<style>
		body {
			font-family: Open Sans;
			margin-left : 300px;
		}
		
		.heading {
			text-shadow : 1px 1px 1px gray;
		}

		.sidenav {
			height: 100%;
			width: 250px;
			position: fixed;
			z-index: 1;
			top: 0;
			left: 0;
			background-color: #111;
			overflow-x: hidden;
			transition: 0.5s;
			padding-top: 60px;
		}

		.sidenav a {
			padding: 8px 8px 8px 32px;
			text-decoration: none;
			font-size: 25px;
			color: #818181;
			display: block;
			transition: 0.3s;
		}

		.sidenav a:hover, .offcanvas a:focus{
			color: #f1f1f1;
		}

		.sidenav .closebtn {
			position: absolute;
			top: 0;
			right: 25px;
			font-size: 36px;
			margin-left: 50px;
		}

		@media screen and (max-height: 450px) {
		  .sidenav {padding-top: 15px;}
		  .sidenav a {font-size: 18px;}
		}
		
		
		textarea {
			width : 600px;
			height: 150px;
			padding: 12px 20px;
			box-sizing: border-box;
			border: 2px solid #ccc;
			border-radius: 4px;
			background-color: #f8f8f8;
			resize: none;
		}
		
		textarea:focus {
			border-color: #719ECE;
			box-shadow: 0 0 10px #719ECE;
		}
		
		button {
			background-color: #111;
			border: none;
			border-radius : 4px;
			color: white;
			padding: 15px 32px;
			text-align: center;
			text-decoration: none;
			display: inline-block;
			font-size: 16px;
			margin: 14px 2px;
			cursor: pointer;
			transition-duration: 0.4s;
		}
		
		button:hover {
			box-shadow: 0 8px 12px 0 rgba(0,0,0,0.24),0 12px 40px 0 rgba(0,0,0,0.19);
		}
		
		select {
			width: 50%;
			padding: 16px 20px;
			border: none;
			border-radius: 4px;
			background-color: #f1f1f1;
		}
		
		input[type=text] {
			box-sizing: border-box;
			border: 2px solid #ccc;
			border-radius: 4px;
			background-color: #f8f8f8;
			width: 30%;
			padding: 12px 20px;
			margin: 8px 0;
			display: inline-block;
		}
		
		input[type=text]:focus {
			border-color: #719ECE;
			box-shadow: 0 0 10px #719ECE;
		}
	</style>
</head>
<body>
		<div id="mySidenav" class="sidenav">
		  <a href="logout.php">Log off</a>
		  <a href="#" onclick="getData('SHOW DATABASES')">List databases</a>
		  <a href="#" onclick="getData('SHOW TABLES')">List tables</a>
		  <a href="#" onclick="getData('SELECT User, Host FROM mysql.user GROUP  BY User')">List users</a>
		  <a href="#" onclick="getData('SHOW FULL PROCESSLIST')">List processes</a>
		</div>

		<h2 class="heading">MySQL administrator</h2><br />
		
				<span id="dbname">Create new database :&nbsp;</span>
				<input type="text" id="newdb_name" placeholder="New database name..."/>&nbsp;&nbsp;
				<button onclick="getData('CREATE DATABASE ' + document.getElementById('newdb_name').value)">Create!</button>
			
			<br /><br />
		

			<select id="dblist">
				<option value="">--Select database--</option>
					<?php

						$con = mysqli_connect('localhost', $_SESSION['user'], $_SESSION['pass']);

						$sql = 'SHOW DATABASES';
						$result = mysqli_query($con, $sql);

						while ($row = mysqli_fetch_array($result)) {
								echo "<option value='".$row[0]."'>".$row[0] . "</option>";
						}
						echo "</div>";
					?>
				
		</select><br /><br /><br /><br />
		
		<textarea placeholder="Enter your MySQL query here...." id="query"></textarea><br />
		<button id="btn1" onclick="getData(document.getElementById('query').value)">Submit</button>
		<button id="btn2" onclick="cleartext()">Clear</button>
		
		<p><b>Output :</b></p><br /><br />
		<div id="output"></div>
</body>
</html>
