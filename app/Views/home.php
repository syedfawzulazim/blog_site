<?php require_once __DIR__ . '/templates/header.php'; ?>

    <div class="col-8 offset-2 mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Welcome, To website <?php echo htmlspecialchars($_SESSION['user_name'] ?? ''); ?></h2>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="/blog/create" class="btn btn-primary">Create New Post</a>
            <?php endif; ?>
        </div>

        <?php if (!empty($posts)): ?>
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
                                        <a href="/blog/delete/<?php echo $post['id']; ?>"
                                           class="btn btn-sm btn-outline-danger"
                                           onclick="return confirm('Are you sure you want to delete this post?')">Delete</a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-primary bg-primary-subtle rounded">No Post Found...!</p>
        <?php endif; ?>
    </div>

<?php require_once __DIR__ . '/templates/footer.php'; ?>
