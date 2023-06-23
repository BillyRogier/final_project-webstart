<main class="grid">
    <div class="home-container grid">
        <section class="home grid">
            <div class="home-data grid">
                <h1>Espresso Tools</h1>
                <div class="grid">
                    <h2>La perfection dans chaque goutte</h2>
                    <a href="<?= URL ?>/category/all-products" class="btn">Achetez maintenant</a>
                </div>
            </div>
            <img src="<?= BASE_PUBLIC ?>/assets/img/home_image.jpg" alt="extraction de café avec outils Espresso Tools" class="home-image">
            <img src="<?= BASE_PUBLIC ?>/assets/icon/arrow_scroll.svg" alt="scroll down" class="arrow_scroll">
        </section>
        <section class="about grid">
            <img src="<?= BASE_PUBLIC ?>/assets/icon/logo_big.jpg" alt="logo Espresso Tools" class="logo_about">
            <div class="about-data grid">
                <h2>À propos</h2>
                <p>Chez Espresso Tools, nous sommes passionnés par l'art de préparer le café parfait. Nous croyons fermement que chaque tasse de café devrait être une expérience exceptionnelle, et c'est pourquoi nous nous sommes engagés à fournir les meilleurs accessoires conçus pour améliorer la précision et la répartition de la mouture. Notre objectif est de vous aider à atteindre la perfection dans chaque tasse que vous préparez. Nous comprenons que chaque détail compte, et c'est pourquoi nous avons soigneusement sélectionné une gamme d'accessoires de haute qualité, conçus pour répondre aux besoins des amateurs de café exigeants.
                </p>
                <a href="<?= URL ?>/about" class="btn">Plus sur Espresso Tools</a>
            </div>
        </section>
    </div>
    <section class="categorys">
        <?php foreach ($categorys as $category) : ?>
            <a class="category" href="<?= URL ?>/category/<?= strtolower($category->getCategory_name()) ?>">
                <img src="<?= BASE_PUBLIC ?>/assets/img/<?= $category->getCategory_img() ?>" alt="category" class="category-image">
                <p class="link"><?= ucfirst($category->getCategory_name()) ?></p>
            </a>
        <?php endforeach; ?>
    </section>
    <section class="products-trends grid">
        <div class="header-slider grid">
            <h2>Produits tendances</h2>
            <div class="line"></div>
            <div class="slider-arrows">
                <div class="arrow prev"> <img src="<?= BASE_PUBLIC ?>/assets/icon/arrow_white.svg" alt="arrow left" class="arrow-image left"></div>
                <div class="arrow next"><img src="<?= BASE_PUBLIC ?>/assets/icon/arrow_white.svg" alt="arrow right" class="arrow-image right"></div>
            </div>
        </div>
        <div class="slider-container" id="slider_products-trends">
            <div class="slider">
                <?php

                use App\Table\Carousel;

                foreach ($products as $product) : ?>
                    <a href="<?= URL ?>/product/<?= $product->getId() ?>" class="slider-item product grid">
                        <img src="<?= BASE_PUBLIC ?>/assets/img/<?= $product->getJoin(Carousel::class)->getImg() ?>" />
                        <div class="product-data grid">
                            <h3><?= ucfirst($product->getName()) ?></h3>
                            <p><?= $product->getPrice() ?> €</p>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</main>