<nav>
    <ul>
        <li><a href="<?= $base_url ?>/">Home</a></li>
        <li><a href="<?= $base_url ?>/products">Products</a></li>
    </ul>
</nav>

<h1>Show Product Page</h1>

<h2><?= htmlspecialchars($product["name"]) ?></h2>
<p><?= htmlspecialchars($product["description"]) ?></p>

<!-- Controls -->
<p>
    <a href="<?= $base_url ?>/products/<?= $product["id"] ?>/edit">Edit Product</a> |
    <a href="<?= $base_url ?>/products/<?= $product["id"] ?>/delete">Delete Product</a>
</p>