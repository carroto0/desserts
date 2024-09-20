<?php
include 'db_connect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the dessert image so that it can also be deleted from the directory
    $query = "SELECT image_url FROM desserts WHERE id = ?";
    $statement = $pdo->prepare($query);
    $statement->execute([$id]);
    $dessert = $statement->fetch(PDO::FETCH_ASSOC);

    // If a dessert was found, delete the image file and the database record
    if ($dessert) {
        $image_path = 'images/' . $dessert['image_url'];

        // Delete the image file if it exists
        if (file_exists($image_path)) {
            unlink($image_path);
        }

        // Delete the dessert from the database
        $query = "DELETE FROM desserts WHERE id = ?";
        $statement = $pdo->prepare($query);
        $statement->execute([$id]);

        // Redirect back to the index page
        header('Location: index.php');
        exit();
    }
}
?>
