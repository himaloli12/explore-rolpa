<?php
// manage_places.php
require_once 'config.php';

// Create upload directory if it doesn't exist
$target_dir = "uploads/";
if (!file_exists($target_dir)) {
    mkdir($target_dir, 0777, true);
}

// Create - Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Submit_Place'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $upload_error = null;
    
    // Handle file upload
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        $target_dir = "uploads/";
        $file_extension = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
        $new_filename = uniqid() . '.' . $file_extension; // Generate unique filename
        $target_file = $target_dir . $new_filename;
        
        // Check file type
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($file_extension, $allowed_types)) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                try {
                    $sql = "INSERT INTO places (title, description, image_path) VALUES (?, ?, ?)";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([$title, $description, $target_file]);
                    
                    header("Location: manage_places.php");
                    exit();
                } catch (PDOException $e) {
                    $upload_error = "Database error: " . $e->getMessage();
                }
            } else {
                $upload_error = "Failed to upload file.";
            }
        } else {
            $upload_error = "Invalid file type. Allowed types: " . implode(', ', $allowed_types);
        }
    } else {
        $upload_error = "Please select an image file.";
    }
}

// Delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    try {
        // First get the image path to delete the file
        $sql = "SELECT image_path FROM places WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        $place = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($place && file_exists($place['image_path'])) {
            unlink($place['image_path']); // Delete the image file
        }
        
        // Then delete the database record
        $sql = "DELETE FROM places WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        
        header("Location: manage_places.php");
        exit();
    } catch (PDOException $e) {
        echo "Error deleting record: " . $e->getMessage();
    }
}

// Read - Fetch all places
try {
    $sql = "SELECT * FROM places ORDER BY created_at DESC";
    $stmt = $pdo->query($sql);
    $places = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching places: " . $e->getMessage();
    $places = [];
}
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
        <?php if (isset($upload_error)): ?>
            <div class="error-message"><?php echo htmlspecialchars($upload_error); ?></div>
        <?php endif; ?>
        
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
            
            <button type="submit" name="Submit_Place">Submit Place</button>
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