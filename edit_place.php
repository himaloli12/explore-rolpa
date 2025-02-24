<?php
// edit_place.php
require_once 'config.php';

if (!isset($_GET['id'])) {
    header("Location: manage_places.php");
    exit();
}

$id = $_GET['id'];

// Handle form submission for update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_place'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    
    if ($_FILES['image']['size'] > 0) {
        // New image uploaded
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $sql = "UPDATE places SET title = ?, description = ?, image_path = ? WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$title, $description, $target_file, $id]);
        }
    } else {
        // No new image
        $sql = "UPDATE places SET title = ?, description = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$title, $description, $id]);
    }
    
    header("Location: manage_places.php");
    exit();
}

// Fetch existing place data
$sql = "SELECT * FROM places WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$place = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Place - Explore Rolpa</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="admin-panel">
        <h2>Edit Place</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Title:</label>
                <input type="text" name="title" value="<?php echo htmlspecialchars($place['title']); ?>" required>
            </div>
            
            <div class="form-group">
                <label>Description:</label>
                <textarea name="description" required><?php echo htmlspecialchars($place['description']); ?></textarea>
            </div>
            
            <div class="form-group">
                <label>Current Image:</label>
                <img src="<?php echo htmlspecialchars($place['image_path']); ?>" alt="Current Image" style="max-width: 200px;">
            </div>
            
            <div class="form-group">
                <label>New Image (optional):</label>
                <input type="file" name="image" accept="image/*">
            </div>
            
            <button type="submit" name="update_place">Update Place</button>
            <a href="manage_places.php" class="cancel-btn">Cancel</a>
        </form>
    </div>
</body>
</html>