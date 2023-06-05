<main class="grid">
    <div class="home-container grid">
        <section class="home grid">
            <div class="home-data grid">
                <h1>Espresso Tools</h1>
                <div class="grid">
                    <h2>La perfection dans chaque goutte</h2>
                    <a href="#" class="btn">Achetez maintenant</a>
                </div>
            </div>
            <img src="<?= URL ?>/assets/img/home_image.jpg" alt="extraction de café avec outils Espresso Tools" class="home-image">
            <img src="<?= URL ?>/assets/icon/arrow_scroll.svg" alt="scroll down" class="arrow_scroll">
        </section>
        <section class="about grid">
            <img src="<?= URL ?>/assets/icon/logo_big.jpg" alt="logo Espresso Tools" class="logo_about">
            <div class="about-data grid">
                <h2>À propos</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                <a href="#" class="btn">Plus sur Espresso Tools</a>
            </div>
        </section>
    </div>
    <?php

    use App\Table\Carousel;

    foreach ($products as $product) : ?>
        <a href="<?= URL ?>/product/<?= $product->getId() ?>">
            <img src="<?= URL ?>/assets/img/<?= $product->getJoin(Carousel::class)->getImg() ?>" />
            <h3><?= $product->getName() ?></h3>
            <p><?= $product->getDescription() ?></p>
            <p><?= $product->getPrice() ?></p>
        </a>
    <?php endforeach; ?>
</main>