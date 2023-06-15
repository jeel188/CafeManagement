<?php
require('../db.php');
session_start();
if(!isset($_SESSION['isSuccess'])){
  echo"<h1>Something Went Wrong Redirecting To Login Page In Few Seconds<h1>";
  header("refresh:3;url=http://localhost:/cafeBackendMaster/login.php");
  return;
  }
if (isset($_POST['submit'])) {
  $totalBill = 0;
  $order = $_POST['order'];
 
  // Connect to your database
  $conn = new PDO("mysql:host=$host;dbname=$dbName", $user, $password);

  // Loop through the selected items and calculate the total bill
  foreach ($order as $itemID) {
    $quantity = (int)$_POST['quantity'.$itemID];
    // Fetch item details from the database
    $query = "SELECT * FROM items WHERE itemID = :itemID";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':itemID', $itemID);
    $stmt->execute();
    $item = $stmt->fetch(PDO::FETCH_ASSOC);
    $price = $item['price'];
    $totalBill += $quantity * $price;
  }
$cname = $_POST['customername'];
$date = date("Y/m/d");
$query = "INSERT INTO `orders`( `customerName`, `orderDate`, `orderTotal`) VALUES ('$cname',' $date','$totalBill')";
$stmt = $conn->prepare($query);
$stmt->execute();
  
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Food Order</title>
  <style>
  body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 20px;
    }

    h1 {
      text-align: center;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    th,
    td {
      padding: 10px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }

    th {
      background-color: #f2f2f2;
    }

    tr:hover {
      background-color: #f5f5f5;
    }

    input[type="number"] {
      width: 60px;
    }

    input[type="submit"] {
      padding: 10px 20px;
      background-color: #4CAF50;
      color: white;
      border: none;
      cursor: pointer;
    }

    .button {
      text-align: center;
    }

    h2 {
      margin-top: 20px;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Food Order</h1>
    <form method="post" action="genrateRecipt.php">
      <a><h4>Enter Customer Name:</a>
      <input type="text" name="customername" require></h4>
      <table>
        <tr>
          <th>Item</th>
          <th>Price</th>
          <th>Quantity</th>
          <th>Add to Order</th>
        </tr>

        <?php
        // Connect to your database
        $conn = new PDO("mysql:host=$host;dbname=$dbName", $user, $password);
        
        // Fetch item list from the database
        $query = "SELECT * FROM items";
        $stmt = $conn->query($query);
        $row = null;
        // Loop through the query results and create table rows
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
          echo '<tr>';
          echo '<td>'.$row['itemName'].'</td>';
          echo '<td>₹'.$row['price'].'</td>';
          echo '<td><input type="number" name="quantity'.$row['itemID'].'" min="0" value="0"></td>';
          echo '<td><input type="checkbox" name="order[]" value="'.$row['itemID'].'"></td>';
          echo '</tr>';
        }
        
        // Close the database connection
        $conn = null;
        ?>

      </table>

      <br>
      <div class="button">
        <input type="submit" name="submit" value="Place Order">
      </div>
    </form>
  </div>
</body>
</html>
<script>
    function changePage() {
      // Redirect the user to a different page
      window.location.href = 'http://localhost:/cafeBackendMaster/login.php';
    }
  </script>