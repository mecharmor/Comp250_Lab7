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
 // db connection
$user = 'root';
$pass = '';
$db = 'farm';

$dbConnection = mysqli_connect('localhost',$user, $pass, $db) or die("Unable to connect to the database");

// Check for form submission:
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		$ssn = mysqli_real_escape_string($dbConnection, trim($_POST['emp_id']));
		$first_name = mysqli_real_escape_string($dbConnection, trim($_POST['first_name']));
		$last_name = mysqli_real_escape_string($dbConnection, trim($_POST['last_name']));
		$street = mysqli_real_escape_string($dbConnection, trim($_POST['street']));
		$city = mysqli_real_escape_string($dbConnection, trim($_POST['city']));
		$state = mysqli_real_escape_string($dbConnection, trim($_POST['state']));
		$zip = mysqli_real_escape_string($dbConnection, trim($_POST['zip']));
		$phone = mysqli_real_escape_string($dbConnection, trim($_POST['phone']));
		$salary = mysqli_real_escape_string($dbConnection, trim($_POST['salary']));
		$job = mysqli_real_escape_string($dbConnection, trim($_POST['job']));

		// check for unique SSN
		$q = "SELECT ssn FROM employees WHERE ssn = '$ssn'";
		$r = @mysqli_query($dbConnection, $q);
		if (mysqli_num_rows($r) == 0){
			// make the add query
			$q = "INSERT INTO employees
			(ssn, first_name, last_name, street, city, state, zip, phone, salary, job)
			VALUES
			('$ssn', '$first_name', '$last_name', '$street', '$city', '$state', '$zip', '$phone', '$salary', '$job')";
			$r = @mysqli_query ($dbConnection, $q);
			if ($r) {
				echo'<p><h2>New employee added.</h2></p>';
			} else {
				echo'<p><h2>Employee cannot be added due to a system error.</h2></p>';
			}
		} else {
			echo'<p><h2>Sorry, the employee already exists.</h2></p>';
		}
	}

	?>

<form action="add_employee.php" id="myform" method="post">
<fieldset><legend><b>New Employee</b></legend>
<p>SSN: <input type="text" id="emp_id" name="emp_id" size="10" value=""/></p>
<p id="empError" class="errorMsg"></p>
<p>First Name: <input type="text" id="first_name" name="first_name" size="20" value=""/></p>
<p id="firstNameError" class="errorMsg"></p>
<p>Last Name: <input type="text" id="last_name" name="last_name" size="20" value=""/></p>
<p id="lastNameError" class="errorMsg"></p>
<p>Street: <input type="text" id="street" name="street" size="20" value=""/></p>
<p id="streetError" class="errorMsg"></p>
<p>City: <input type="text" id="city" name="city" size="20" value=""/></p>
<p id="cityError" class="errorMsg"></p>
<p>State: <input type="text" id="state" name="state" size="20" value=""/></p>
<p id="stateError" class="errorMsg"></p>
<p>Zip: <input type="text" id="zip" name="zip" size="20" value=""/></p>
<p id="zipError" class="errorMsg"></p>
<p>Phone: <input type="text" id="phone" name="phone" size="20" value=""/></p>
<p id="phoneError" class="errorMsg"></p>
<p>Salary: <input type="text" id="salary" name="salary" size="20" value=""/></p>
<p id="salaryError" class="errorMsg"></p>
<p>Job: <input type="text" id="job" name="job" size="20" value=""/></p>
<p id="jobError" class="errorMsg"></p>
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
