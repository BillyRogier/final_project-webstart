<main class="grid" style="gap: 40px;">
    <h1>Admin page</h1>
    <div class="error-container" style="<?= !empty($_SESSION['message']) ? "display: block;" : "display: none;"  ?>"><?= isset($_SESSION['message']) ? $_SESSION['message'] : ""  ?></div>
    <div class="stats-container grid">
        <div class="stat grid">
            <h2>Total utitlisateurs</h2>
            <div class="grid count_stat">
                <h3><?= count($users) ?></h3><a href="<?= URL ?>/admin/users">Voir tous</a>
            </div>
        </div>
        <div class="stat grid">
            <h2>Total categories</h2>
            <div class="grid count_stat">
                <h3><?= count($categorys) ?></h3><a href="<?= URL ?>/admin/categorys">Voir tous</a>
            </div>
        </div>
        <div class="stat grid">
            <h2>Total produits</h2>
            <div class="grid count_stat">
                <h3><?= count($products) ?></h3><a href="<?= URL ?>/admin/products">Voir tous</a>
            </div>
        </div>
        <div class="stat grid">
            <h2>Total commandes</h2>
            <div class="grid count_stat">
                <h3><?= count($orders) ?></h3><a href="<?= URL ?>/admin/orders">Voir tous</a>
            </div>
        </div>
        <div class="stat grid">
            <h2>Total commentaires</h2>
            <div class="grid count_stat">
                <h3><?= count($reviews) ?></h3><a href="<?= URL ?>/admin/reviews">Voir tous</a>
            </div>
        </div>
    </div>
</main>