<main class="grid">
    <section class="add_comment grid">
        <h1>Ajouter un commentaire</h1>
        <div class="error-container"><?= isset($_SESSION['message']) ? $_SESSION['message'] : "" ?></div>
        <?= $form ?>
    </section>
</main>