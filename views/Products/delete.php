<h1>Delete Product</h1>

<form action="<?= $base_url ?>/products/<?= $product["id"] ?>/delete" method="post">

<p>Are you sure you want to delete this product?</p>

<button>Yes</button>

</form>

<p><a href="<?= $base_url ?>/products/<?= $product["id"] ?>/show">Cancel</a></p>

</body>
</html>