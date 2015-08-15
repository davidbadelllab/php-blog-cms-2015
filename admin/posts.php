<?php
/**
 * Admin - Manage Posts
 * PHP 5.6
 */

session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../index.php');
    exit();
}

require_once '../config/database.php';

$conn = getConnection();

// Handle post deletion
if (isset($_GET['delete'])) {
    $post_id = intval($_GET['delete']);
    $delete_query = "DELETE FROM posts WHERE id = $post_id";
    mysqli_query($conn, $delete_query);
    header('Location: posts.php');
    exit();
}

// Handle new post
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $user_id = $_SESSION['user_id'];

    $insert_query = "INSERT INTO posts (title, content, status, user_id, created_at)
                     VALUES ('$title', '$content', '$status', $user_id, NOW())";

    if (mysqli_query($conn, $insert_query)) {
        $success = "Post created successfully!";
    } else {
        $error = "Error creating post: " . mysqli_error($conn);
    }
}

// Get all posts
$posts_query = "SELECT p.*, u.username
                FROM posts p
                JOIN users u ON p.user_id = u.id
                ORDER BY p.created_at DESC";
$posts = mysqli_query($conn, $posts_query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Posts - Admin</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Manage Blog Posts</h1>

        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <button class="btn btn-primary" data-toggle="modal" data-target="#newPostModal">
            New Post
        </button>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($post = mysqli_fetch_assoc($posts)): ?>
                    <tr>
                        <td><?php echo $post['id']; ?></td>
                        <td><?php echo htmlspecialchars($post['title']); ?></td>
                        <td><?php echo htmlspecialchars($post['username']); ?></td>
                        <td><?php echo $post['status']; ?></td>
                        <td><?php echo date('Y-m-d', strtotime($post['created_at'])); ?></td>
                        <td>
                            <a href="edit_post.php?id=<?php echo $post['id']; ?>" class="btn btn-sm btn-info">Edit</a>
                            <a href="posts.php?delete=<?php echo $post['id']; ?>"
                               class="btn btn-sm btn-danger"
                               onclick="return confirm('Delete this post?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>
</html>

<?php closeConnection($conn); ?>
