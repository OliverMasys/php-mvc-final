<h1>Edit Product Page</h1>

<form action="<?= $base_url ?>/products/<?= $product["id"] ?>/update" method="post">
<!-- include the form contents from the new form.php -->
<?php require "form.php" ?>

</form>

<p><a href="<?= $base_url ?>/products/<?= $product["id"] ?>/show">Cancel</a></p>

</body>
</html>