<!DOCTYPE html>
<html>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Cafe Management Admin Dashboard</title>
  <style>
    /* CSS styling for the dashboard */
    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      font-family: Arial, Helvetica, sans-serif;
    }

    .header {
      overflow: hidden;
      background-color: #f1f1f1;
      padding: 20px 10px;
    }

    .header a {
      float: left;
      color: black;
      text-align: center;
      padding: 12px;
      text-decoration: none;
      font-size: 18px;
      line-height: 25px;
      border-radius: 4px;
    }

    .header msg {
      float: left;
      color: black;
      text-align: center;
      padding: 12px;
      text-decoration: none;
      font-size: 18px;
      line-height: 25px;
    }


    .header a.logo {
      width: 128px;
      height: 128px;
    }

    img {
      width: 10%;
    }

    .header a:hover {
      background-color: #ddd;
      color: black;
    }

    .header a.active {
      background-color: dodgerblue;
      color: white;
    }

    .header-right {
      float: right;
    }

    @media screen and (max-width: 500px) {
      .header a {
        float: none;
        display: block;
        text-align: left;
      }

      .header-right {
        float: none;
      }
    }

    body {
      font-family: Arial, sans-serif;
    }

    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 20px;
    }

    .dashboard-heading {
      text-align: center;
      margin-bottom: 20px;
    }

    .dashboard-menu {
      display: flex;
      justify-content: center;
      margin-bottom: 20px;
    }

    .dashboard-menu a {
      margin: 0 10px;
      padding: 10px 20px;
      background-color: #f5f5f5;
      text-decoration: none;
      color: #333;
      border-radius: 4px;
    }


    .dashboard-content {
      padding: 20px;
      border-style: solid;
      border-color: black;
    }


    table {
      width: 100%;
      border-collapse: collapse;
    }

    th, td {
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

    /* Additional CSS styling for specific elements or sections */
  </style>
</head>

<body>
  <?php
    session_start();
    if(!isset($_SESSION['isSuccess'])){
       echo"<h1>Something Went Wrong Redirecting To Login Page In Few Seconds<h1>";
       header("refresh:3;url=login.php");
       return;
    }
    ?>
  <div class="header">
    <a href="#default"><img src="assest/icon.png" alt="HTML5 Icon" style="width:128px;height:38px;>"> </a>
    <msg>Welcome,
      <?php $name = $_SESSION['uname'];echo" $name "?>!
    </msg>
    <div class="header-right">
      <a class="active" href="#home">Home</a>
      <a href="https://t.me/ImxSage">Contact</a>
      <a href="#about">About</a>
    </div>
  </div>

  <div class="container">
    <h1 class="dashboard-heading">Cafe Management Admin Dashboard</h1>
    <div class="dashboard-menu">
      <a href="dashboard.php">Dashboard</a>
      <a href="Views/manageitems.php">Add Items To List</a>
      <a href="Views/menu.php">Process Order</a>

      <!-- Add more menu links as needed -->
    </div>
    <div class="dashboard-content">
      <oa><h1>Recent Orders</h1></oa><br>
      <table>
        <thead>
          <tr>
            <th>Order ID</th>
            <th>Customer Name</th>
            <th>Order Date</th>
            <th>Order Total</th>
          </tr>
        </thead>
        <tbody id="orderTableBody">
      <?php
        // Connect to your database
        require('db.php');
        $conn = new PDO("mysql:host=$host;dbname=$dbName", $user, $password);//PHP database object
        // Fetch customer data from the database
        $query = "SELECT * FROM orders";//query
        $stmt = $conn->query($query);
        $row = null;//deafault null
        // Loop through the query results and create table rows
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
          echo '<tr>';
          echo '<td>'.$row['orderID'].'</td>';
          echo '<td>'.$row['customerName'].'</td>';
          echo '<td>'.$row['orderDate'].'</td>';
          echo '<td>'.$row['orderTotal'].'</td>';
          // echo '<td>'.$row['status'].'</td>';
          echo '</tr>';
        }

        // Close the database connection
        $conn = null;
      ?>
        </tbody>
      </table>
    </div>
  </div>
</body>

</html>