<nav>
    <ul>
        <li><a href="<?= $base_url ?>/">Home</a></li>
        <li><a href="<?= $base_url ?>/products">Products</a></li>
    </ul>
</nav>

<h1>New Product</h1>

<form action="<?= $base_url ?>/products/create" method="post">

<!-- include the form contents from the new form.php -->
<?php require "form.php" ?>

</form>

</body>
</html>