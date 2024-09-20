<?php
include 'db_connect.php';

// Query to get desserts by category
$query = "SELECT * FROM desserts ORDER BY category";
$statement = $pdo->prepare($query);
$statement->execute();
$desserts = $statement->fetchAll(PDO::FETCH_ASSOC);

// Grouping desserts by category
$categories = [];
foreach ($desserts as $dessert) {
    $categories[$dessert['category']][] = $dessert;
}
// Handle search query if submitted
$searchQuery = '';
if (isset($_GET['search'])) {
    $searchQuery = $_GET['search'];
    $query = "SELECT * FROM desserts WHERE name LIKE :search";
    $statement = $pdo->prepare($query);
    $statement->execute(['search' => '%' . $searchQuery . '%']);
    $desserts = $statement->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Desserts</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Schoolbell&display=swap" rel="stylesheet">
</head>
<body>
    <nav class="navbar">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="contact_us.php">Contact Us</a></li>
            <li><a href="all-menu.php">All Desserts</a></li>
        </ul>
        <!-- Search form -->
        <form class="search-form" action="index.php" method="GET">
            <input type="text" name="search" placeholder="Search desserts..." value="<?php echo htmlspecialchars($searchQuery); ?>">
            <button type="submit">Search</button>
        </form>
    </nav>
    <div class="container">
        <h1>All Menu</h1>
        <div class="categories">
            <?php foreach ($categories as $category => $desserts): ?>
                <h2 class="category-title"><?php echo ucfirst($category); ?></h2>
                <div class="dessert-list">
                    <?php foreach ($desserts as $dessert): ?>
                        <div class="dessert-item">
                            <img src="images/<?php echo $dessert['image_url']; ?>" alt="<?php echo $dessert['name']; ?>">
                            <h3><?php echo $dessert['name']; ?></h3>
                            <p><?php echo $dessert['description']; ?></p>
                            <p class="price">$<?php echo $dessert['price']; ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
