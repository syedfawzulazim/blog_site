<?php
require_once __DIR__ . '/../templates/header.php';
?>

    <div class="col-6 offset-3">
        <div class="card">
            <div class="card-header">
                <h3 class="text-center">Create New Blog Post</h3>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="form-group mb-3">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="content">Content</label>
                        <textarea class="form-control" id="content" name="content" rows="10" required></textarea>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Create Post</button>
                        <a href="/" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>