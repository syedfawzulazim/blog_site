<?php include('templates/header.php'); ?>

    <div class="col-6 offset-3 border p-5 mt-5">
        <div class="text-center">
            <h2>Sign-In</h2>
        </div>
        <form method="POST">
            <div class="mb-3">
                <input type="email" class="form-control" id="email-input" name="email" placeholder="Enter your email address" required>
            </div>
            <div class="mb-3">
                <input type="password" class="form-control" id="password-input" name="password" placeholder="Enter your password" required>
            </div>
            <div class="mb-3 d-flex justify-content-around">
                <button type="submit" class="btn btn-outline-primary">Sign In</button>
                <a href="/register" class="btn btn-outline-success">Register</a>
            </div>
        </form>
    </div>

<?php include('templates/footer.php'); ?>