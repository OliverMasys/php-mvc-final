
<label for="name">Name
    <?php if (isset($errors["name"])) : ?>
        <span style="color: red;"><?= $errors["name"] ?></span>
    <?php endif; ?>
</label>
<input type="text" name="name" id="name"
       value="<?= htmlspecialchars($product['name'] ?? '') ?>">

<label for="description">Description</label>
<textarea name="description" id="description" cols="30" rows="10"><?= htmlspecialchars($product['description'] ?? '') ?></textarea>

<button>Save</button>
