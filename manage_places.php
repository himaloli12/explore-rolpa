<?php
// manage_places.php
require_once 'config.php';

// Create - Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_place'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    
    // Handle file upload
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $image_path = '';
    
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        $image_path = $target_file;
        
        $sql = "INSERT INTO places (title, description, image_path) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$title, $description, $image_path]);
        
        header("Location: manage_places.php");
        exit();
    }
}

// Delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM places WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    
    header("Location: manage_places.php");
    exit();
}

// Read - Fetch all places
$sql = "SELECT * FROM places ORDER BY created_at DESC";
$stmt = $pdo->query($sql);
$places = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Places - Explore Rolpa</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="admin-panel">
        <h2>Add New Place</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Title:</label>
                <input type="text" name="title" required>
            </div>
            
            <div class="form-group">
                <label>Description:</label>
                <textarea name="description" required></textarea>
            </div>
            
            <div class="form-group">
                <label>Image:</label>
                <input type="file" name="image" required accept="image/*">
            </div>
            
            <button type="submit" name="Submit_Place">Submit_Place</button>
        </form>

        <h2>Existing Places</h2>
        <div class="places-grid">
            <?php foreach ($places as $place): ?>
                <div class="place-card">
                    <img src="<?php echo htmlspecialchars($place['image_path']); ?>" alt="<?php echo htmlspecialchars($place['title']); ?>">
                    <h3><?php echo htmlspecialchars($place['title']); ?></h3>
                    <p><?php echo htmlspecialchars($place['description']); ?></p>
                    <div class="actions">
                        <a href="edit_place.php?id=<?php echo $place['id']; ?>" class="edit-btn">Edit</a>
                        <a href="?delete=<?php echo $place['id']; ?>" class="delete-btn" onclick="return confirm('Are you sure?')">Delete</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>