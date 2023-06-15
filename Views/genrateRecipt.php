<?php
session_start();
if(!isset($_SESSION['isSuccess'])){
echo"<h1>Something Went Wrong Redirecting To Login Page In Few Seconds<h1>";
header("refresh:3;url=http://localhost:/cafeBackendMaster/login.php");
return;
}
ob_start();
require('menu.php');
ob_get_clean();

?>
<!DOCTYPE html>
<html>

<head>
  <title>Food Order Receipt</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      text-align: center;
    }

    .container {
      max-width: 500px;
      margin: 0 auto;
      padding: 20px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    h1 {
      margin-top: 0;
    }

    .order-details {
      text-align: left;
      margin-bottom: 20px;
    }

    .order-details p {
      margin: 0;
    }

    .total {
      font-weight: bold;
    }
    /* Print-specific CSS */
  
    input[type="button"] {
      padding: 10px 20px;
      background-color: #4CAF50;
      color: white;
      border: none;
      cursor: pointer;
    }
    button[type="button"] {
      padding: 10px 20px;
      background-color: #4CAF50;
      color: white;
      border: none;
      cursor: pointer;
    }

    .button {
      text-align: center;
    }

  </style>
  <script>
    function printReceipt() {
      // Hide the print button before printing
      document.querySelector('.button').style.display = 'none';

      // Print the receipt
      window.print();

      // Show the print button again after printing is done
      document.querySelector('.button').style.display = 'block';
    }
  </script>
</head>

<body>
  <div class="container">
    <h1>Food Order Receipt</h1>

    <div class="order-details">
      <p><strong>Order Number:</strong>
        <?php
    $conn = new PDO("mysql:host=$host;dbname=$dbName", $user, $password);
    $query = "SELECT MAX(orderID) AS max_order_id FROM orders";
    $stmt = $conn->query($query);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $maxOrderId = $result['max_order_id'];
    echo  ($maxOrderId);
    ?>
      </p>
      <p><strong>Date:</strong>
        <?php echo date("Y/m/d")?>
      </p>
      <p><strong>Customer Name:</strong>
        <?php echo$_POST['customername']?>
      </p>
      <p><strong>Items Ordered:</strong></p>
      <ul>
        <?php
     $order = $_POST['order'];
    foreach ($order as $orderList) {
    $quantity = (int)$_POST['quantity' . $orderList];
    $query = "SELECT itemName FROM items WHERE itemID = :itemID";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':itemID', $orderList);
    $stmt->execute();

    // Fetch the item name
    $item = $stmt->fetch(PDO::FETCH_ASSOC);
    $itemName = $item['itemName'];
    echo "<li>$itemName x $quantity </li>";
}

       ?>
      </ul>
    </div>

    <div class="total">
      <p><strong>Total Amount:</strong>
        <?php echo"$totalBill ₹"; ?>
      </p>
    </div>
    <div class="button">
      <!-- Button to trigger printing -->
      <input type ="button" value = "Print Recipt"onclick="printReceipt()"><br><br>
    </div>
    <div class="button">
<input type="button" value="Go Back To Dashboard" onclick="changePage()">
</div>
  </div>
</body>

</html>
<script>
    function changePage() {
      // Redirect the user to a different page
      window.location.href = 'http://localhost:/cafeBackendMaster/login.php';
    }
  </script>