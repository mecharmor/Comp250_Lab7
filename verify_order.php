<!DOCTYPE html>
<head>
<title>Legwarmer Store</title>
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
      <li><a href="http://localhost/legwarmers/display_products_retail.php">Retail Store</a></li>
    </ul>
  </div>
</nav>
<!--End Navbar-->

</head>

<?php


if  ((isset($_GET['id'])) && (is_numeric($_GET['id'])) ) {
	$id = $_GET['id'];
}
elseif ( (isset($_POST['id'])) && (is_numeric($_POST['id'])) ) {
	$id = $_POST['id'];
}
else{
	echo '<p>This page has been accessed in error.</p>';
	exit();
}

// db connection
$user = 'root';
$pass = '';
$db = 'legwarmers';

$dbConnection = mysqli_connect('localhost',$user, $pass, $db) or die("Unable to connect to the database");

//CHECK IF FORM HAS BEEN SUBMITTED
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	if ($_POST['sure'] == 'Yes'){

		//GET INFO
		$prod_id = mysqli_real_escape_string($dbConnection, trim($_POST['prod_id']));
		$color = mysqli_real_escape_string($dbConnection, trim($_POST['color']));
		$cost = mysqli_real_escape_string($dbConnection, trim($_POST['cost']));
		$quantity = mysqli_real_escape_string($dbConnection, trim($_POST['quantity']));
		$updatedQuantity = mysqli_real_escape_string($dbConnection, trim($_POST['updatedQuantity']));
		
		//MAKE THE QUERY
		$q = "UPDATE inventory
			SET prod_id = '$prod_id', color = '$color', cost = '$cost', 
			quantity = '$updatedQuantity'
			WHERE
			prod_id=$id;";
		$r = @mysqli_query($dbConnection, $q);
		if (mysqli_affected_rows($dbConnection) == 1){
			echo '<p>The order has been placed</p>';
		}
		else {
			echo '<p>The order could not be placed due to a system error.';
		}
	}
	else{
		echo '<p>The order was not placed.</p>';
	}
}
else{  //SHOW THE FORM

	$q = "SELECT prod_id, color, cost, quantity
	FROM inventory
	WHERE prod_id = $id";
	$r = @mysqli_query ($dbConnection, $q);

	if (mysqli_num_rows($r) == 1){
	$row = mysqli_fetch_array ($r, MYSQLI_NUM);

	// create the form
	echo '<form action="verify_order.php" id="myform" method="post">
	<fieldset><legend><b>Verify Order</b></legend>
	<p><b>Product ID:  </b> <input type="text" readonly="readonly" id="prod_id" name="prod_id" size="10" value='. $row[0] . '></p>
	<p><b>Color:  </b> <input type="text" readonly="readyonly" id="color" name="color" size="20" value=' . $row[1] . '></p>
	<p><b>Cost:  </b> <input type="text" readonly="readonly" id="cost" name="cost" size="20" value=' . $row[2] . '></p>
	<p><b>Quantity In Stock:  </b> <input type="text" readonly="readonly" id="quantity" name="quantity" size="20" value=' . $row[3] . '></p>
	<p><b>Order:  </b> <input type="text" id="order" name="order" size="20"></p>
	<p id="orderError" class="errorMsg"></p>
	<input type="radio" name="sure" value="Yes" /> <b>Yes</b>
	<input type="radio" name="sure" value="No" checked="checked" /> <b>No</b>
	<p><input type="submit" name="submit" value="SUBMIT ORDER" /></p>
	<input type="hidden" name="id" value="' . $id . '" />
	<input type="hidden" id="updatedQuantity" name="updatedQuantity" value="updatedQuantity" size="20">

	</fieldset>
	</form>';
	}
	else{   //NOT A VALID PRODUCT ID
		echo '<p>This page has been accessed in error.</p>';
	}

}

mysqli_close($dbConnection);
echo '<div class="home">';
echo '<a href="display_products_retail.php" type="button" class="btn btn-primary" >Back</a>';
echo '</div>';
?>

<script>
//checks to see if value entered in field
var updatedQuantity;
var formValidity = true;


function validateQuantity(){
	var orderInput = document.getElementById("order");
	var quantityInput = document.getElementById("quantity");
	var errorDiv = document.getElementById("orderError");
	 	try {
		if (orderInput.value == ""){
			throw "Please enter an order quantity.";
		} else if (/^[0-9]+$/.test(orderInput.value)=== false){
			throw "The order quantity must be numeric."
		} else if (orderInput.value > quantityInput.value){
			throw "The order quantity may not be more than the quantity in stock."
		} else if (orderInput.value == "0"){
			throw "The order quantity may not be zero."
		}
		
	orderInput.style.background = "";
	errorDiv.style.display = "none";
	errorDiv.innerHTML = "";
	}
	catch(msg){
		errorDiv.style = "block";
		errorDiv.style.color = "DarkRed";
		errorDiv.innerHTML = msg;
		orderInput.style.background = "rgb(255,233,233)";
		formValidity = false;
	}
}

function changeQuantity(){
	var oldQuantity = document.getElementById("quantity").value;
	var orderQuantity = document.getElementById("order").value;
	updatedQuantity = oldQuantity - orderQuantity;
	$updatedQuantity = updatedQuantity;
	document.getElementById("updatedQuantity").value = updatedQuantity;
}


// create event listeners
function createEventListeners(){
	var order = document.getElementById("order")
	if (order.addEventListener){
		order.addEventListener("change", validateQuantity, false);
		order.addEventListener("change", changeQuantity, false);
	} else if (order.attachEvent){
		order.attachEvent("onchange", validateQuantity);
		order.attachEvent("onchange", changeQuantity);
	}
	var myform = document.getElementById("myform");
	if (myform.addEventListener){
		myform.addEventListener("submit", validateForm, false);
	} else if (myform.attachEvent){
		myform.attachEvent("onsubmit", validateForm);
	}
}


//final form validation and prevent submission
function validateForm(evt){
	formValidity = true;
	validateQuantity();
	changeQuantity();
	if (formValidity === false){
		if (evt.preventDefault){
			evt.preventDefault();
		} else {
			evt.returnValue = false;
		}
	}
}
// form load
if (window.addEventListener){
	window.addEventListener("load", createEventListeners, false);
} else if (window.attachEvent){
	window.attachEvent("onload", createEventListeners);
}
</script>
</html>
