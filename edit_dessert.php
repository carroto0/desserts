<?php
include 'db_connect.php';

$id = $_GET['id'];
$query = "SELECT * FROM desserts WHERE id = ?";
$statement = $pdo->prepare($query);
$statement->execute([$id]);
$dessert = $statement->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category'];

    // Handling image upload
    $image_url = $dessert['image_url'];
    if (!empty($_FILES['image']['name'])) {
        $target_dir = "images/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
        $image_url = basename($_FILES["image"]["name"]);
    }

    $query = "UPDATE desserts SET name = ?, description = ?, price = ?, category = ?, image_url = ? WHERE id = ?";
    $statement = $pdo->prepare($query);
    $statement->execute([$name, $description, $price, $category, $image_url, $id]);

    header('Location: index.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Dessert</title>
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
            <li><a href="all_menu.php">All Desserts</a></li>.
        </ul>
    </nav>
    <div class="container">
        <h1>Edit menu</h1>
        
        <?php if (!empty($error)): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php elseif (!empty($success)): ?>
            <p style="color: green;"><?php echo $success; ?></p>
        <?php endif; ?>

    <form action="edit_dessert.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data">
        <label>Name: </label><input type="text" name="name" value="<?php echo $dessert['name']; ?>" required><br>
        <label>Description: </label><textarea name="description" required><?php echo $dessert['description']; ?></textarea><br>
        <label>Price: </label><input type="number" step="0.01" name="price" value="<?php echo $dessert['price']; ?>" required><br>
        <label>Category: </label><input type="text" name="category" value="<?php echo $dessert['category']; ?>" required><br>
        <label>Image: </label><input type="file" name="image" accept="image/*"><br>
        <img src="images/<?php echo $dessert['image_url']; ?>" alt="<?php echo $dessert['name']; ?>" style="width: 100px;"><br>
        <button type="submit">Save Changes</button>
    </form>
</body>
</html>
