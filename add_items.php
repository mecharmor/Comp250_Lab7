<!DOCTYPE html>
<head>
<title>The Funny Farm</title>
<!--Load jQuery3 & Bootstrap-->
  <script
      src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha256-/SIrNqv8h6QGKDuNoLGA4iret+kyesCkHGzVUUV0shc="
      crossorigin="anonymous">
    </script>
    <script
      src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous">
    </script>

    <!--Load Bootstrap-->
    <link
      href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
      crossorigin="anonymous">
	  
	    <!--My Javascript file-->
	  <script type="text/javascript" src="index.js"></script>
	  
</head>

<h1>Catalog</h1>
<body id="master">

<a type="button" class="btn btn-default" id="item1" >item 1</a>
<a type="button" class="btn btn-default" id="item2">item 2</a>

<?php
//table called cart
//columns item, title, cost
//each row is a new item to cart
 // db connection
$user = 'root';
$pass = '';
$db = 'farm';

$dbConnection = mysqli_connect('localhost',$user, $pass, $db) or die("Unable to connect to the database");

// Check for form submission:
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		$item = mysqli_real_escape_string($dbConnection, trim($_POST['item'])); //number - integer
		$title = mysqli_real_escape_string($dbConnection, trim($_POST['title']));//string
		$cost = mysqli_real_escape_string($dbConnection, trim($_POST['cost']));//double or float
		
			// Add item to database
			$q = "INSERT INTO cart
			(item, title, cost)
			VALUES
			('$item', '$title', '$cost')";
	}

	?>

<form action="add_employee.php" id="myform" method="post">
<fieldset><legend><b>New Employee</b></legend>
<p>item: <input type="text" id="emp_id" name="emp_id" size="10" value=""/></p>
<p id="empError" class="errorMsg"></p>
<p>First Name: <input type="text" id="first_name" name="first_name" size="20" value=""/></p>
<p id="firstNameError" class="errorMsg"></p>
<p>Last Name: <input type="text" id="last_name" name="last_name" size="20" value=""/></p>
<p id="lastNameError" class="errorMsg"></p>
<p><input type="submit" name="submit" value="Submit"/></p>
<br/>
</fieldset>
<div class="home">
<!--<a href="farm_front_page.php">Home</a>-->
<a href="farm_front_page.php" type="button" class="btn btn-primary" >Home</a>
</div>
</form>


</body>
</html>
