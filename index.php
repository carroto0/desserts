<?php
include 'db_connect.php';

// Fetch all desserts for display
$query = "SELECT * FROM desserts";
$statement = $pdo->prepare($query);
$statement->execute();
$desserts = $statement->fetchAll(PDO::FETCH_ASSOC);

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
    <title>Dessert Shop</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Schoolbell&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Navigation bar -->
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
        <h1>♡ Welcome to Our Dessert Shop ♡ </h1>
        <a href="add_dessert.php" class="btn" name="add">Add New Menu</a>

        <!-- Show search results if search query exists -->
        <?php if (!empty($searchQuery)): ?>
            <h2>Search results for "<?php echo htmlspecialchars($searchQuery); ?>"</h2>
        <?php endif; ?>

        <div class="dessert-list">
            <?php if (count($desserts) > 0): ?>
                <?php foreach ($desserts as $dessert): ?>
                    <div class="dessert-item">
                        <img src="images/<?php echo $dessert['image_url']; ?>" alt="<?php echo $dessert['name']; ?>">
                        <h2><?php echo $dessert['name']; ?></h2>
                        <p><?php echo $dessert['description']; ?></p>
                        <p class="price">฿<?php echo $dessert['price']; ?></p>
                        <a href="edit_dessert.php?id=<?php echo $dessert['id']; ?>" class="btn">Edit</a>
                        <a href="delete_dessert.php?id=<?php echo $dessert['id']; ?>" class="btn" onclick="return confirm('Are you sure to delete this menu');">Delete</a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No desserts found.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
