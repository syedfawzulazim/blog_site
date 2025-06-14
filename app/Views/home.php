<?php
include('templates/header.php');

?>

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach ($errors as $field => $message): ?>
                <li><?= htmlspecialchars($message) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success">
        <ul>
            <li><?= htmlspecialchars($_SESSION['success']) ?></li>
            <?php unset($_SESSION['success']); ?>
        </ul>
    </div>
<?php endif; ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Welcome, <?php echo htmlspecialchars($_SESSION['user_name'] ?? 'Guest'); ?></h2>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="/blog/create" class="btn btn-primary">Create New Post</a>
                <?php endif; ?>
            </div>

            <?php if (isset($posts) && !empty($posts)): ?>
                <div class="blog-posts">
                    <?php foreach ($posts as $post): ?>
                        <div class="card mb-4">
                            <div class="card-body">
                                <h3 class="card-title"><?php echo htmlspecialchars($post['title']); ?></h3>
                                <p class="card-text"><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        Posted by <?php echo htmlspecialchars($post['author_name']); ?> 
                                        on <?php echo date('F j, Y', strtotime($post['created_at'])); ?>
                                    </small>
                                    <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] === $post['user_id']): ?>
                                        <div class="btn-group">
                                            <a href="/blog/edit/<?php echo $post['id']; ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                                            <a href="/blog/delete/<?php echo $post['id']; ?>" class="btn btn-sm btn-outline-danger" 
                                               onclick="return confirm('Are you sure you want to delete this post?')">Delete</a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="alert alert-info">
                    No blog posts found. 
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="/blog/create">Create your first post</a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include('templates/footer.php'); ?>
