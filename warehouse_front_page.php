<!DOCTYPE html>
<<head>
  <title>Warehouse Front Page</title>

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

      <!-- My Custom Styles -->
        <link href="styles.css" rel="stylesheet" type="text/css">

</head>


<body id="master">

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


<form action="front_page.php" id="myform" method="post" style="padding-top:50px;">
<fieldset>
<?php
//table with links to pages
echo '<table class="nav_bar" align="left" cellspacing="0" cellpadding="5" width="75%">
<tr>
<td align="left"><b><a href="display_products.php?">Display Products/Edit Inventory</a></b></td>
</tr>
<tr>
<td align="left"><b><a href="add_product.php?">Add New Product</a></b></td>
</tr>
<tr>
';

?>
</fieldset>
</form>


</body>

</html>