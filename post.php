<?php
require_once 'config/database.php';
require_once 'includes/functions.php';

$conn = getConnection();
$post_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Get post details
$query = "SELECT p.*, u.username
          FROM posts p
          JOIN users u ON p.user_id = u.id
          WHERE p.id = $post_id AND p.status = 'published'";

$result = mysqli_query($conn, $query);
$post = mysqli_fetch_assoc($result);

if (!$post) {
    header('Location: index.php');
    exit();
}

// Get comments
$comments_query = "SELECT c.*, u.username
                   FROM comments c
                   LEFT JOIN users u ON c.user_id = u.id
                   WHERE c.post_id = $post_id AND c.status = 'approved'
                   ORDER BY c.created_at DESC";
$comments = mysqli_query($conn, $comments_query);
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo htmlspecialchars($post['title']); ?> - My Blog</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <article>
            <h1><?php echo htmlspecialchars($post['title']); ?></h1>
            <p class="meta">
                By <?php echo htmlspecialchars($post['username']); ?> on
                <?php echo date('F j, Y', strtotime($post['created_at'])); ?>
            </p>
            <div class="content">
                <?php echo nl2br(htmlspecialchars($post['content'])); ?>
            </div>
        </article>

        <hr>

        <h3>Comments (<?php echo mysqli_num_rows($comments); ?>)</h3>
        <?php while ($comment = mysqli_fetch_assoc($comments)): ?>
            <div class="comment">
                <strong><?php echo htmlspecialchars($comment['author_name']); ?></strong>
                <p><?php echo nl2br(htmlspecialchars($comment['content'])); ?></p>
                <small><?php echo date('F j, Y', strtotime($comment['created_at'])); ?></small>
            </div>
        <?php endwhile; ?>
    </div>
</body>
</html>
<?php closeConnection($conn); ?>
