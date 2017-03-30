<!DOCTYPE html>
<head>
<title>The Funny Farm</title>
<!--Load Bootstrap-->
    <link
      href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
      crossorigin="anonymous">
</head>

<h1>Display Employee</h1>



<?php
echo '<fieldset><legend><b>Employee Directory</b></legend>';

$user = 'root';
$pass = '';
$db = 'farm';

//db connection
$dbConnection = mysqli_connect('localhost',$user, $pass, $db) or die("Unable to connect to the database");

//number of records to display per page
$display = 10;

//determine how many pages there will be
//if the number of pages is already known
if (isset($GET['p']) && is_numeric($_GET['p'])){
	$pages = $_GET['p'];
} else { //determine the number of pages
  // count the number of records
  $q = "SELECT COUNT(*) FROM employees";
  $r = mysqli_query($dbConnection, $q);
  $row = mysqli_fetch_array($r, MYSQLI_NUM);
  $records = $row[0];
  // calculate the number of pages
  if ($records > $display) {
	  $pages = ceil ($records/$display);
  } else {
	  $pages = 1;
  }
}

// determine where to start for the current page
if (isset($_GET['s']) && is_numeric ($_GET['s'])){
	$start = $_GET['s'];
} else {
	$start = 0;
}

// determine the sort, default will be last name
$sort = (isset($_GET['sort'])) ? $_GET['sort'] : 'pn';

// set the selected sort
switch ($sort) {
	case 'ssn':
	$order_by = 'ssn';
	break;
	case 'first_name':
	$order_by = 'first_name';
	break;
	case 'last_name':
	$order_by = 'last_name';
	break;
	case 'street':
	$order_by = 'street';
	case 'city':
	$order_by = 'city';
	case 'zip':
	$order_by = 'zip';
	case 'phone':
	$order_by = 'phone';
	case 'salary':
	$order_by = 'salary';
	case 'job':
	$order_by = 'job';
	case 'state':
	$order_by = 'state';
	break;
	default:
	$order_by = 'ssn';
}
// query
// Define the query:
$q = "SELECT ssn, first_name, last_name, street, city, state, zip, phone, salary, job
FROM employees ORDER BY $order_by LIMIT $start, $display;";
$r = @mysqli_query ($dbConnection, $q);

// table header
echo '<table align="center" cellspacing="0" cellpadding="5" width="75%">
<tr>
<td align="left"><b><a href="display_employee.php?sort=ssn">Employee ID/SSN</a></b></td>
<td align="left"><b><a href="display_employee.php?sort=first_name">First Name</a></b></td>
<td align="left"><b><a href="display_employee.php?sort=last_name">Last Name</a></b></td>
<td align="left"><b><a href="display_employee.php?sort=street">Street Address</a></b></td>
<td align="left"><b><a href="display_employee.php?sort=city">City</a></b></td>
<td align="left"><b><a href="display_employee.php?sort=state">State</a></b></td>
<td align="left"><b><a href="display_employee.php?sort=zip">Zip</a></b></td>
<td align="left"><b><a href="display_employee.php?sort=phone">Phone Number</a></b></td>
<td align="left"><b><a href="display_employee.php?sort=job">Job Title</a></b></td>
<td align="left"><b><a href="display_employee.php?sort=salary">Salary</a></b></td>
<td align="left"><b>Delete Employee</b></td>
<td align="left"><b>Edit Employee</b></td>
</td>
';

// fetch and print the records
$bg = '#eeeee';
while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
	$bg = ($bg=='#eeeeee' ? '#ffffff' : '#eeeeee');
	echo '<tr bgcolor="' . $bg . '">
	<td align="left">' . $row['ssn'] . '</td>
	<td align="left">' . $row['first_name'] . '</td>
	<td align="left">' . $row['last_name'] . '</td>
	<td align="left">' . $row['street'] . '</td>
	<td align="left">' . $row['city'] . '</td>
	<td align="left">' . $row['state'] . '</td>
	<td align="left">' . $row['zip'] . '</td>
	<td align="left">' . $row['phone'] . '</td>
	<td align="left">' . $row['job'] . '</td>
	<td align="left">' . $row['salary'] . '</td>
	<td align="left"><a href="delete_employee.php?id=' . $row['ssn'] . '">Delete</a></td>
	<td align="left"><a href="edit_employee.php?id=' . $row['ssn'] . '">Edit</a></td>
	<td align="left"><a href="edit_time_card.php?id=' . $row['ssn'] . '">Edit Time Card</a></td>
	</tr>
	';
}

echo '</table>';
mysqli_free_result ($r);
mysqli_close($dbConnection);

// make pagination
if ($pages > 1) {
	
	echo '<br /><div class="pagination"><p align="center">';
	$current_page = ($start/$display) + 1;
	if ($current_page !=1) {
		echo '<a href="display_employee.php?s=' . ($start - $display) . '&p=' . $pages . '&sort=' . $sort . '">Previous</a> ';
	}
	for ($i = 1; $i <= $pages; $i++){
		if ($i != $current_page){
			echo '<a href="display_employee.php?s=' . (($display * ($i - 1))) . '&p=' . $pages . '&sort=' . $sort . '">' . $i . '</a> ';
		} else {
			echo $i . ' ';
		}
	}
	if ($current_page != $pages) {
		echo '<a href="display_employee.php?s=' . ($start + $display) . '&p=' . $pages . '&sort=' . $sort . '">Next</a>';
	}
	echo '</p>';
	echo '</div>';
}

echo '</fieldset>';
echo '<div class="home">';
echo '<a href="farm_front_page.php" type="button" class="btn btn-primary" >Back</a>';
echo '</div>';
?>


</body>
</html>