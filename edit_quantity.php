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
</head>

<h1>Edit Quantity</h1>
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
		//DELETE THE RECORD

		//GET INFO
		$prod_id = mysqli_real_escape_string($dbConnection, trim($_POST['prod_id']));
		$color = mysqli_real_escape_string($dbConnection, trim($_POST['color']));
		$cost = mysqli_real_escape_string($dbConnection, trim($_POST['cost']));
		$quantity = mysqli_real_escape_string($dbConnection, trim($_POST['quantity']));
		
		//MAKE THE QUERY
		$q = "UPDATE inventory
			SET prod_id = '$prod_id', color = '$color', cost = '$cost', quantity = '$quantity'
			WHERE
			prod_id=$id;";
		$r = @mysqli_query($dbConnection, $q);
		if (mysqli_affected_rows($dbConnection) == 1){
			echo '<p>The quantity has been updated</p>';
		}
		else {
			echo '<p>The quantity could not be updated due to a system error.';
		}
	}
	else{
		echo '<p>The quantity was not be updated.</p>';
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
	echo '<form action="edit_quantity.php" id="myform" method="post">
	<fieldset><legend><b>Edit Quantity</b></legend>
	<p><b>Product ID:  </b> <input type="text" readonly="readonly" id="prod_id" name="prod_id" size="10" value='. $row[0] . '></p>
	<p><b>Color:  </b> <input type="text" readonly="readyonly" id="color" name="color" size="20" value=' . $row[1] . '></p>
	<p><b>Cost:  </b> <input type="text" readonly="readonly" id="cost" name="cost" size="20" value=' . $row[2] . '></p>
	<p><b>Quantity:  </b> <input type="text" id="quantity" name="quantity" size="20" value=' . $row[3] . '></p>
	<p id="quantityError" class="errorMsg"></p>
	<input type="radio" name="sure" value="Yes" /> <b>Yes</b>
	<input type="radio" name="sure" value="No" checked="checked" /> <b>No</b>
	<p><input type="submit" name="submit" value="UPDATE" /></p>
	<input type="hidden" name="id" value="' . $id . '" />
	</fieldset>
	</form>';
	}
	else{   //NOT A VALID PRODUCT ID
		echo '<p>This page has been accessed in error.</p>';
	}

}

mysqli_close($dbConnection);
echo '<div class="home">';
echo '<a href="front_page.php" type="button" class="btn btn-primary" >Back</a>';
echo '</div>';
?>

<script>
//checks to see if value entered in field

var formValidity = true;


function validateQuantity(){
	var quantityInput = document.getElementById("quantity");
	var errorDiv = document.getElementById("quantityError");
	 	try {
		if (quantityInput.value == ""){
			throw "Please enter a quantity.";
		} else if (/^[0-9]+$/.test(quantityInput.value)=== false){
			throw "The quantity must be numeric."
		}
	quantityInput.style.background = "";
	errorDiv.style.display = "none";
	errorDiv.innerHTML = "";
	}
	catch(msg){
		errorDiv.style = "block";
		errorDiv.style.color = "DarkRed";
		errorDiv.innerHTML = msg;
		quantityInput.style.background = "rgb(255,233,233)";
		formValidity = false;
	}
}


// create event listeners
function createEventListeners(){
	var quantity = document.getElementById("quantity")
	if (quantity.addEventListener){
		quantity.addEventListener("change", validateQuantity, false);
	} else if (quantity.attachEvent){
		quantity.attachEvent("onchange", validateQuantity);
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
