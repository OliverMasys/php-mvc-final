<?php
// setup connection details
$dsn = "mysql:
        host=localhost;
        dbname=sherd_JimBelushi;
        charset=utf8;
        port=3306";
        

// create new PDO connection object with error messaging turned on
try {
  $pdo = new PDO($dsn, "sherd_JimBelushi", "adpujdB734kf3", [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
  echo " Database connection successful!";
} catch (PDOException $e) {
  die (" Database connection failed: " . $e->getMessage());
}
// create the db query in the PDO and assign it to a variable
$stmt = $pdo->query("SELECT * FROM `products`");

// run the query using the PDO connection and return the result to a variable
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Products</title>
</head>
<body>
  <h1>Products</h1>

  <?php foreach ($products as $product) : ?>
    <h2><?= htmlspecialchars($product["name"]) ?></h2>
    <p><?= htmlspecialchars($product["description"]) ?></p>
  <?php endforeach; ?>
  
</body>
</html>
