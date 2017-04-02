<!DOCTYPE html>
<head>
<title>Legwarmer store</title>
<!--Load Bootstrap-->
    <link
      href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
      crossorigin="anonymous">
	  
	  <!-- My Custom Styles-->
    <link href="styles.css" rel="stylesheet" type="text/css">

	<!--Navbar-->
  <nav class="navbar navbar-default navbar-fixed-top BoxShadow">
  <div class="container">
        <a class="navbar-brand"><img style="width:20px; height:20px;" src="img/Logo_employee.png" alt="Logo"></a>
    <ul class="nav navbar-nav">
      <li><a href="http://localhost/legwarmers/front_page.php">HOME</a></li>
      <li><a href="http://localhost/legwarmers/warehouse_front_page.php">Warehouse</a></li>
      <li><a href="http://localhost/legwarmers/retail_front_page.php">Retail Store</a></li>
    </ul>
  </div>
</nav>
<!--End Navbar-->

</head>



<?php
echo '<fieldset><legend><b>Inventory</b></legend>';

$user = 'root';
$pass = '';
$db = 'legwarmers';

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
  $q = "SELECT COUNT(*) FROM inventory";
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
	case 'prod_id':
	$order_by = 'prod_id';
	break;
	case 'color':
	$order_by = 'color';
	break;
	case 'cost':
	$order_by = 'cost';
	break;
	case 'quantity':
	$order_by = 'quantity';
	break;
	default:
	$order_by = 'prod_id';
}
// query
// Define the query:
$q = "SELECT prod_id, color, cost, quantity
FROM inventory ORDER BY $order_by LIMIT $start, $display;";
$r = @mysqli_query ($dbConnection, $q);

// table header
echo '<table align="center" cellspacing="0" cellpadding="5" width="75%">
<tr>
<td align="left"><b><a href="display_products.php?sort=prod_id">Product ID</a></b></td>
<td align="left"><b><a href="display_products.php?sort=color">Color</a></b></td>
<td align="left"><b><a href="display_products.php?sort=cost">Cost</a></b></td>
<td align="left"><b><a href="display_products.php?sort=quantity">Quantity</a></b></td>
<td align="left"><b>Order</b></td>
</td>
';

// fetch and print the records
$bg = '#eeeee';
while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
	$bg = ($bg=='#eeeeee' ? '#ffffff' : '#eeeeee');
	echo '<tr bgcolor="' . $bg . '">
	<td align="left">' . $row['prod_id'] . '</td>
	<td align="left">' . $row['color'] . '</td>
	<td align="left">' . $row['cost'] . '</td>
	<td align="left">' . $row['quantity'] . '</td>
	<td align="left"><a href="verify_order.php?id=' . $row['prod_id'] . '">Order</a></td>
</tr>
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
		echo '<a href="display_products.php?s=' . ($start - $display) . '&p=' . $pages . '&sort=' . $sort . '">Previous</a> ';
	}
	for ($i = 1; $i <= $pages; $i++){
		if ($i != $current_page){
			echo '<a href="display_products.php?s=' . (($display * ($i - 1))) . '&p=' . $pages . '&sort=' . $sort . '">' . $i . '</a> ';
		} else {
			echo $i . ' ';
		}
	}
	if ($current_page != $pages) {
		echo '<a href="display_products.php?s=' . ($start + $display) . '&p=' . $pages . '&sort=' . $sort . '">Next</a>';
	}
	echo '</p>';
	echo '</div>';
}

echo '</fieldset>';
echo '<div class="home">';
echo '<a href="front_page.php" type="button" class="btn btn-primary" >Home</a>';
echo '<a href="front_page.php" type="button" class="btn btn-primary" >Back</a>';
echo '</div>';
?>


</body>
</html>