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

<body id="master">
<?php
 // db connection
$user = 'root';
$pass = '';
$db = 'legwarmers';

$dbConnection = mysqli_connect('localhost',$user, $pass, $db) or die("Unable to connect to the database");

// Check for form submission:
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		$color = mysqli_real_escape_string($dbConnection, trim($_POST['color']));
		$cost = mysqli_real_escape_string($dbConnection, trim($_POST['cost']));
		$quantity = mysqli_real_escape_string($dbConnection, trim($_POST['quantity']));

			// make the add query
			$q = "INSERT INTO inventory
			(color, cost, quantity)
			VALUES
			('$color', '$cost', '$quantity')";
			$r = @mysqli_query ($dbConnection, $q);
			if ($r) {
				echo'<p><h2>New product added.</h2></p>';
			} else {
				echo'<p><h2>Product cannot be added due to a system error.</h2></p>';
			}
		}

	?>

<form action="add_product.php" id="myform" method="post">
<fieldset>
</br>
</br>
</br>
</br>
<p>Color: <input type="text" id="color" name="color" size="20" value=""/></p>
<p id="colorError" class="errorMsg"></p>
<p>Cost: <input type="text" id="cost" name="cost" size="20" value=""/></p>
<p id="costError" class="errorMsg"></p>
<p>Quantity: <input type="text" id="quantity" name="quantity" size="20" value=""/></p>
<p id="quantityError" class="errorMsg"></p>
<p><input type="submit" name="submit" value="Submit"/></p>
<br/>
</fieldset>
<div class="home">
<!--<a href="front_page.php">Home</a>-->
<a href="front_page.php" type="button" class="btn btn-primary" >Home</a>
<a href="warehouse_front_page.php" type="button" class="btn btn-primary" >Back</a>
</div>
</form>

<script>
//checks to see if values are entered in all fields

var formValidity = true;

function validateColor(){
	var colorInput = document.getElementById("color");
	var errorDiv = document.getElementById("colorError");
	try{
		if (colorInput.value == ""){
			throw "Please enter the color.";
		}
	colorInput.style.background = "";
	errorDiv.style.display = "none";
	errorDiv.innerHTML = "";
	}
	catch(msg){
		errorDiv.style = "block";
		errorDiv.style.color = "DarkRed";
		errorDiv.innerHTML = msg;
		colorInput.style.background = "rgb(255,233,233)";
		formValidity = false;
	}
}


function validateCost(){
	var costInput = document.getElementById("cost");
	var errorDiv = document.getElementById("costError");
	 	try {
		if (costInput.value == ""){
			throw "Please enter a cost.";
		} else if (/^[0-9]+$/.test(costInput.value)=== false){
			throw "The cost must be numeric."
		}
	costInput.style.background = "";
	errorDiv.style.display = "none";
	errorDiv.innerHTML = "";
	}
	catch(msg){
		errorDiv.style = "block";
		errorDiv.style.color = "DarkRed";
		errorDiv.innerHTML = msg;
		costInput.style.background = "rgb(255,233,233)";
		formValidity = false;
	}
}

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
	var color = document.getElementById("color")
	var cost = document.getElementById("cost")
	var quantity = document.getElementById("quantity")
	if (color.addEventListener){
		color.addEventListener("change", validateColor, false);
		cost.addEventListener("change", validateCost, false);
		quantity.addEventListener("change", validateQuantity, false);
	} else if (color.attachEvent){
		color.attachEvent("onchange", validateColor);
		cost.attachEvent("onchange", validateCost);
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
	validateColor();
	validateCost();
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

</body>
</html>
