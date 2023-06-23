<main class="about-container grid">
    <h1><?= $title ?></h1>
    <div class="error-container" style="<?= !empty($_SESSION['message']) ? "display: block;" : "display: none;"  ?>"><?= isset($_SESSION['message']) ? $_SESSION['message'] : ""  ?></div>
    <?= $form ?>
</main>