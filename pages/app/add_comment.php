<main class="grid">
    <section class="add_comment grid">
        <h1>Ajouter un commentaire</h1>
        <div class="error-container" style="<?= !empty($_SESSION['message']) ? "display: block;" : "display: none;"  ?>"><?= isset($_SESSION['message']) ? $_SESSION['message'] : ""  ?></div>
        <?= $form ?>
    </section>
</main>