<main class="about-container grid">
    <h1><?= $title ?></h1>
    <div class="error-container"><?= isset($_SESSION['message']) ? $_SESSION['message'] : ""  ?></div>
    <?= $form ?>
</main>