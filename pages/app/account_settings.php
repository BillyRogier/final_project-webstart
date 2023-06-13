<main class="account_settings grid">
    <h1 style="display: none;">Account</h1>
    <section class="account_order grid">
        <ul class="account_links grid">
            <h3>Menu</h3>
            <div class="line"></div>
            <?php if ($app->isAdmin()) : ?>
                <li><a href="<?= URL ?>/admin">Admin</a></li>
                <div class="line"></div>
            <?php endif ?>
            <li><a href="<?= URL ?>/account">Commandes</a></li>
            <div class="line"></div>
            <li><a href="<?= URL ?>/account/settings">Paramètres</a></li>
        </ul>
        <div class="orders-container grid">
            <div class="order"><?= $form ?></div>
        </div>
    </section>
</main>