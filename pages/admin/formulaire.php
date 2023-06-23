<main class="login-wrapper grid">
    <div class="login-container grid">
        <h1><?= $title_page ?></h1>
        <div class="error-container" style="<?= !empty($_SESSION['message']) ? "display: block;" : "display: none;"  ?>"><?= isset($_SESSION['message']) ? $_SESSION['message'] : ""  ?></div>
        <?= $form ?>
    </div>
</main>