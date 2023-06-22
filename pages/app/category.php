<main class="grid">
    <div class="category-container grid">
        <section class="home grid">
            <div class="home-data grid">
                <h1><?= $title ?></h1>
                <div class="grid">
                    <h2>Découvrez tous nos produits <?= !empty($subtitle) && $subtitle != "all-products" ? "dans la categorie " . $subtitle : "" ?></h2>
                    <a href="#" class="btn">Achetez maintenant</a>
                </div>
            </div>
            <img src="<?= BASE_PUBLIC ?>/assets/img/<?= $category_img ?>" alt="extraction de café avec outils Espresso Tools" class="home-image">
            <img src="<?= BASE_PUBLIC ?>/assets/icon/arrow_scroll.svg" alt="scroll down" class="arrow_scroll">
        </section>
        <section class="products-container grid">
            <div class="page_path grid">
                <a href="<?= URL ?>" class="path_link">Accueil</a>
                <svg width="14" height="21" viewBox="0 0 14 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M2.00098 18.9624L12.001 10.9624L2.00098 2.9624" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" class="arrow-svg" />
                </svg>
                <p><?= $title ?></p>
            </div>
            <div class="products grid">
                <?php

                use App\Table\Carousel;
                use App\Table\Products;

                foreach ($products as $product) : ?>
                    <a href="<?= URL ?>/product/<?= $product->getJoin(Products::class)->getId() ?>" class="product grid">
                        <img src="<?= BASE_PUBLIC ?>/assets/img/<?= $product->getJoin(Carousel::class)->getImg() ?>" />
                        <div class="product-data grid">
                            <h3><?= $product->getJoin(Products::class)->getName() ?></h3>
                            <p><?= $product->getJoin(Products::class)->getPrice() ?> €</p>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </section>
    </div>
</main>