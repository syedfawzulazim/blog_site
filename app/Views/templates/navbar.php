<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">Blog-Site</a>
        <div class="" id="navbar">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <?php if (isset($_SESSION['user_name'])): ?>
                        <a class="nav-link" href="/logout">Logout</a>
                    <?php else: ?>
                        <a class="nav-link" href="/signin">Sign In</a>
                    <?php endif; ?>

                </li>
            </ul>
        </div>
    </div>
</nav>