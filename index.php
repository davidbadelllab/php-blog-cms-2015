<?php
/**
 * Blog Homepage
 * Displays all published blog posts
 */

require_once 'config/database.php';
require_once 'includes/functions.php';

$conn = getConnection();

// Get all published posts
$query = "SELECT p.*, u.username
          FROM posts p
          JOIN users u ON p.user_id = u.id
          WHERE p.status = 'published'
          ORDER BY p.created_at DESC
          LIMIT 10";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Blog - Home</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h1>Latest Posts</h1>

                <?php while ($post = mysqli_fetch_assoc($result)): ?>
                    <article class="post">
                        <h2>
                            <a href="post.php?id=<?php echo $post['id']; ?>">
                                <?php echo htmlspecialchars($post['title']); ?>
                            </a>
                        </h2>
                        <p class="meta">
                            By <?php echo htmlspecialchars($post['username']); ?>
                            on <?php echo date('F j, Y', strtotime($post['created_at'])); ?>
                        </p>
                        <p><?php echo nl2br(htmlspecialchars(substr($post['content'], 0, 200))); ?>...</p>
                        <a href="post.php?id=<?php echo $post['id']; ?>" class="btn btn-primary">Read More</a>
                    </article>
                    <hr>
                <?php endwhile; ?>
            </div>

            <div class="col-md-4">
                <?php include 'includes/sidebar.php'; ?>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>

    <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>
</html>

<?php closeConnection($conn); ?>
