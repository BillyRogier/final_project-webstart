    <main class="login-wrapper grid">
        <div class="login-container grid">
            <h1>Se connecter</h1>
            <div class="error-container"><?= isset($_SESSION['message']) ? $_SESSION['message'] : ""  ?></div>
            <?= $form ?>
        </div>
    </main>