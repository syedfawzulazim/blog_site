<?php
require_once __DIR__ . '/../templates/header.php';
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h2>Create New Blog Post</h2>
            
            <?php if (isset($errors) && !empty($errors)): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="POST" class="mt-4">
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" 
                           class="form-control" 
                           id="title" 
                           name="title" 
                           value="<?php echo htmlspecialchars($old['title'] ?? ''); ?>" 
                           required>
                </div>

                <div class="mb-3">
                    <label for="content" class="form-label">Content</label>
                    <textarea class="form-control" 
                              id="content" 
                              name="content" 
                              rows="6" 
                              required><?php echo htmlspecialchars($old['content'] ?? ''); ?></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Create Post</button>
            </form>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>