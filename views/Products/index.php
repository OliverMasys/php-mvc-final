<nav>
    <ul>
        <li><a href="<?= $base_url ?>/">Home</a></li>
    </ul>
</nav>

<h1>Products</h1>

<?php foreach ($products as $product) : ?>
    <p>
        <a href="<?= $base_url ?>/products/<?= htmlspecialchars($product['id']) ?>/show">
            <?= htmlspecialchars($product["name"]) ?>
        </a>
    </p>

<?php endforeach; ?>

<a href="<?= $base_url ?>/products/new">New Product</a>