<?php include('templates/header.php'); ?>

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach ($errors as $field => $message): ?>
                <li><?= htmlspecialchars($message) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<div class="col-4 offset-4 border p-5 mt-5">
    <div class="text-center">
        <h2>Register</h2>
    </div>
    <form method="POST">
        <div class="mb-3">
            <label for="name-input" class="form-label">Name</label>
            <input type="text" class="form-control" id="name-input" name="name" placeholder="Enter your name" required>
        </div>
        <div class="mb-3">
            <label for="email-input" class="form-label">Email address</label>
            <input type="email" class="form-control" id="email-input" name="email" placeholder="Enter your email address" required>
        </div>
        <div class="mb-3">
            <label for="password-input" class="form-label">Password</label>
            <input type="password" class="form-control" id="password-input" name="password" placeholder="Enter your password" required>
        </div>
        <div class="mb-3 d-flex justify-content-around">
            <button type="submit" class="btn btn-outline-primary">Register</button>
            <a href="/signin" class="btn btn-outline-success">Sign In</a>
        </div>
    </form>
</div>

<?php include('templates/footer.php'); ?>