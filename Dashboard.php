<!DOCTYPE html>
<html>
<head>
<title>DASHBOARD TICKETSYSTEEM</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Rubik">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
body {
	background-color: #151514;
	font-family: 'Rubik', sans-serif;
	text-transform: uppercase;
	color: #ffffff;
	font-size: 2.8vh;
	font-weight: 600;
	justify-content: center;
	padding: 10px;
}
table {
	border-spacing: 2rem 1rem;
	margin-left: auto;
	margin-right: auto;
}
th {
	padding: 0;
	height: 2vh;
}
td {
	background-color: #272726;
	padding: 1rem;
	border-radius: 0.5rem;
	width: 20vw;
	height: 2vh;
	text-align: center;
	font-weight: 800;
	font-size: 8vh;
	color: #f2f4f8;
	box-shadow: rgba(0, 0, 0, 0.4) 0px 2px 4px, rgba(0, 0, 0, 0.3) 0px 7px 13px -3px, rgba(0, 0, 0, 0.2) 0px -3px 0px inset;
}
.green {
	display: inline-block;
	float: left;
	background-color: #272726;
	padding: 1rem;
	text-align: center/left;
	width: 1vw;
	font-weight: 800;
	font-size: 5vh;
	color: #999abc;
	opacity: 0.6;
}
.icon {
	color: #53c3c3;
	opacity: 0.5;
	white-space: pre;
	text-align: left;
}
.plus {
	color: #53c3c3;
}
.test {
	background-color: #ccc;
	padding: 1rem;
	border-radius: 0.5rem;
	width: 20vw;
	white-space: pre;
	height: 10vh;
	text-align: center;
	font-weight: 800;
	font-size: 8vh;
	color: #8caa09;
}
</style>
</head>
<body>
<?php

//CONNECTION CREDS
$servername = "localhost";
$username = "helpdesk_ro";
$password = "hEo6WctbW4H!%IrYQliI";
$dbname = "servicedesk";

//CREATE CONNECTION
$conn = new mysqli($servername, $username, $password, $dbname);

//CHECK CONNECTION
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
<?php 
$sqlOpenTickets = "SELECT count(status_id) AS Status FROM servicedesk.ost2019_ticket WHERE status_id IN (1, 2, 6, 7)";	
$sqlOpenYEAR = "SELECT count(created) FROM servicedesk.ost2019_ticket WHERE YEAR(created) = YEAR(NOW())";
$sqlOpenEX = "SELECT count(status_id) AS OpenEX FROM servicedesk.ost2019_ticket WHERE status_id IN (1, 2, 6, 7) AND topic_id NOT IN (54, 55, 71)";
$sqlTotalTickets = "SELECT FORMAT(ticket_id, 0, 'de_DE') ticket_id FROM servicedesk.ost2019_ticket order by number desc LIMIT 0, 1";
$sqlNotAssignedTickets = "select count(staff_id) AS Staff FROM servicedesk.ost2019_ticket where staff_id = '0' and status_id = '1'";
$sqlClosedToday = "SELECT count(closed) FROM servicedesk.ost2019_ticket WHERE date(closed) = current_date";
$sqlClosedThisWeek = "SELECT count(closed) FROM servicedesk.ost2019_ticket WHERE YEARWEEK(closed) = YEARWEEK(NOW())";
$sqlOpenedThisMonth = "SELECT count(created) FROM servicedesk.ost2019_ticket WHERE MONTH(created) = MONTH(NOW()) AND YEAR(created) = YEAR(NOW())";
$sqlClosedThisMonth = "SELECT count(closed) FROM servicedesk.ost2019_ticket WHERE MONTH(closed) = MONTH(NOW()) AND YEAR(closed) = YEAR(NOW())";
$sqlOpenedToday = "SELECT count(created) FROM servicedesk.ost2019_ticket WHERE date(created) = current_date()";
$sqlAverageOpenedDay = "SELECT FORMAT(AVG(created),2,'de_DE') AS Average FROM (SELECT date(created), COUNT(DISTINCT ticket_id ) created FROM servicedesk.ost2019_ticket GROUP BY CAST(created AS DATE)) orders_per_day";
$sqlDifference = "SELECT 
	(SELECT count(closed) FROM servicedesk.ost2019_ticket WHERE date(closed) = current_date())
    - (SELECT count(created) FROM servicedesk.ost2019_ticket WHERE date(created) = current_date()) AS verschil";
$sqlOpenFocusAreaRAD = "SELECT count(number) FROM servicedesk.ost2019_ticket INNER JOIN servicedesk.ost2019_department ON servicedesk.ost2019_ticket.dept_id = servicedesk.ost2019_department.id
where dept_id ='4'
and status_id IN (1, 2, 6, 7)";
$sqlOpenFocusAreaMDL = "SELECT count(number) FROM servicedesk.ost2019_ticket INNER JOIN servicedesk.ost2019_department ON servicedesk.ost2019_ticket.dept_id = servicedesk.ost2019_department.id
where dept_id ='5'
and status_id IN (1, 2, 6, 7)";
$sqlOpenFocusAreaPIJN = "SELECT count(number) FROM servicedesk.ost2019_ticket INNER JOIN servicedesk.ost2019_department ON servicedesk.ost2019_ticket.dept_id = servicedesk.ost2019_department.id
where dept_id ='6'
and status_id IN (1, 2, 6, 7)";
$sqlOpenFocusAreaDERM = "SELECT count(number) FROM servicedesk.ost2019_ticket INNER JOIN servicedesk.ost2019_department ON servicedesk.ost2019_ticket.dept_id = servicedesk.ost2019_department.id
where dept_id ='7'
and status_id IN (1, 2, 6, 7)";
$sqlOpenService = "SELECT count(status_id) AS OpenService FROM servicedesk.ost2019_ticket WHERE status_id IN (1, 2, 6, 7) AND staff_id IN (29, 30, 31, 35)";
$sqlOpenBeheer = "SELECT count(status_id) AS OpenBeheer FROM servicedesk.ost2019_ticket WHERE status_id IN (1, 2, 6, 7) AND staff_id IN (10, 13, 22, 28)";
$sqlOpenProject = "SELECT count(status_id) AS OpenProject FROM servicedesk.ost2019_ticket WHERE status_id IN (1, 2, 6, 7) AND staff_id IN (1, 20, 21)";
$dataPoints = array();

?>

<table>
	<tr>
		<th>Tickets dit jaar</th>
		<th>Gemiddeld geopend / dag</th>
		<th>Servicedesk</th>
		<th>Radiologie</th>
	</tr>
	<tr>
	<?php $result = $conn->query($sqlOpenYEAR);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			echo "<td class='test'>" . $row["count(created)"] . "</td>";
	}
	} else {
		echo "<td>Geen resultaat</td>";
	}
		?>
	<?php $result = $conn->query($sqlAverageOpenedDay);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			echo "<td>" . $row["Average"] . "</td>";
	}	
	} else {
		echo "<td>Geen resultaat</td>";
	}
		?>
		<?php $result = $conn->query($sqlOpenService);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			echo "<td>" . $row["OpenService"] . "</td>";
	}	
	} else {
		echo "<td>Geen resultaat</td>";
	}
		?>
		<?php $result = $conn->query($sqlOpenFocusAreaRAD);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			echo "<td><i class='table-icon green fa-solid fa-x-ray'></i>" . $row["count(number)"] . "</td>";
	}	
	} else {
		echo "<td>Geen resultaat</td>";
	}
		?>
	</tr>
	<tr>
		<th>Vandaag aangemaakt</th>
		<th>Vandaag gesloten</th>
		<th>Beheer</th>
		<th>Maag en Darm</th>
	</tr>
	<tr>
		<?php $result = $conn->query($sqlOpenedToday);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			echo "<td>" . $row["count(created)"] . "</td>";
	}	
	} else {
		echo "<td>Geen resultaat</td>";
	}
		?>
		<?php $result = $conn->query($sqlClosedToday);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			echo "<td>" . $row["count(closed)"] . "</td>";
	}	
	} else {
		echo "<td>Geen resultaat</td>";
	}
		?>
		<?php $result = $conn->query($sqlOpenBeheer);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			echo "<td>" . $row["OpenBeheer"] . "</td>";
	}	
	} else {
		echo "<td>Geen resultaat</td>";
	}
		?>
		<?php $result = $conn->query($sqlOpenFocusAreaMDL);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			echo "<td><i class='table-icon green fa-solid fa-disease'></i>" . $row["count(number)"] . "</td>";
	}	
	} else {
		echo "<td>Geen resultaat</td>";
	}
		?>
	</tr>
	<tr>
		<th>deze maand aangemaakt</th>
		<th>Deze maand gesloten</th>
		<th>Project</th>
		<th>Pijn</th>
	</tr>
	<tr>
		<?php $result = $conn->query($sqlOpenedThisMonth);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			echo "<td>" . $row["count(created)"] . "</td>";
	}	
	} else {
		echo "<td>Geen resultaat</td>";
	}
		?>
		<?php $result = $conn->query($sqlClosedThisMonth);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			echo "<td>" . $row["count(closed)"] . "</td>";
	}	
	} else {
		echo "<td>Geen resultaat</td>";
	}
		?>
		<?php $result = $conn->query($sqlOpenProject);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			echo "<td>" . $row["OpenProject"] . "</td>";
	}	
	} else {
		echo "<td>Geen resultaat</td>";
	}
		?>
		<?php $result = $conn->query($sqlOpenFocusAreaPIJN);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			echo "<td><i class='table-icon green fa-solid fa-syringe'></i>" . $row["count(number)"] . "</td>";
	}	
	} else {
		echo "<td>Geen resultaat</td>";
	}
		?>
	</tr>
	<tr>
		<th>Verschil OPEN/DICHT</th>
		<th>Open ex. IN/UIT/PROJ</th>
		<th>Totaal Open</th>
		<th>Derma en Aller</th>
	</tr>
	<tr>	
			
		<td class="testdiff" style="<?php echo($product['verschil'] < 1 ? 'color:#aa0909' : 'color:#8caa09'); ?>">
		<?php $result = $conn->query($sqlDifference);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			echo $row["verschil"]; 
	}	
	}?>
		</td>
		<?php $result = $conn->query($sqlOpenEX);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			echo "<td>" . $row["OpenEX"] . "</td>";
	}	
	} else {
		echo "<td>Geen resultaat</td>";
	}
		?>
		<?php $result = $conn->query($sqlOpenTickets);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			echo "<td>" . $row["Status"] . "</td>";
	}	
	} else {
		echo "<td>Geen resultaat</td>";
	}
		?>
		<?php $result = $conn->query($sqlOpenFocusAreaDERM);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			echo "<td><i class='table-icon green fa-solid fa-hand-dots'></i>" . $row["count(number)"] . "</td>";
	}	
	} else {
		echo "<td>Geen resultaat</td>";
	}
		?>
	</tr>
	<tr>
	<th>Mailbox/Restanten</th>
	</tr>
	<tr>
	<td>
	<?php
date_default_timezone_set('Europe/Amsterdam');

$Wieisverantwoordelijk  = verantwoordelijk (date('l'), date('G'), date('i'));

if($Wieisverantwoordelijk ) {
echo '';
} else {
echo '';
}

function verantwoordelijk ($day, $hour, $minute) {
switch($day) {
    case 'Monday':
        if($hour >= 6 && $hour < 12) {
            echo 'Thymo';
        }
        else {
            echo 'Quintin';
        }
        break;
    case 'Tuesday':
        if($hour >= 6 && $hour < 12) {
            echo 'Thomas';
        }
        else {
            echo 'Quintin';
        }
        break;
    case 'Wednesday':
        if($hour >= 6 && $hour < 12) {
            echo 'Quintin';
        }
        else {
            echo 'Thomas';
        }
        break;
    case 'Thursday':
        if($hour >= 6 && $hour < 12) {
            echo 'Thymo';
        }
        else {
            echo 'Thomas';
        }
        break;
    case 'Friday':
        if($hour >= 6 && $hour < 12) {
            echo 'Thomas';
        }
        else {
            echo 'Quintin';
        }
        break;
}
return false;
}

?>
</td>
	</tr>
<?php 
	//refresh pagina elke 10 sec
    header("refresh: 10;");
?>
</table>
</body>
</html>
