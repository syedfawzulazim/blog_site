<?php
include('templates/header.php');

?>
<div class="container text-center">
    <h2>Welcome to Home Page</h2>
    <h1><?php echo $_SESSION['user_name'] ?? '' ?></h1>

</div>

<?php include('templates/footer.php'); ?>
