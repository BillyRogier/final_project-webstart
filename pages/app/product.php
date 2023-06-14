<?php

use App\Table\Carousel;
use App\Table\Categorys;
use App\Table\Users;
?>

<main class="grid">
    <section class="home-container grid">
        <div class="product-wrapper grid">
            <div class="page_path grid">
                <a href="<?= URL ?>" class="path_link">Accueil</a>
                <svg width="14" height="21" viewBox="0 0 14 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M2.00098 18.9624L12.001 10.9624L2.00098 2.9624" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" class="arrow-svg" />
                </svg>
                <a href="<?= URL ?>/category/<?= $products[0]->getJoin(Categorys::class)->getCategory_name() ?>" class="path_link"><?= ucfirst($products[0]->getJoin(Categorys::class)->getCategory_name()) ?></a>
            </div>
            <div class="product-container grid">
                <div class="slider-container grid" id="slider_products-img">
                    <div class="slider">
                        <?php
                        foreach ($products as $product) : ?>
                            <img src="<?= URL ?>/assets/img/<?= $product->getJoin(Carousel::class)->getImg() ?>" class="slider-item product_img" />
                        <?php endforeach; ?>
                    </div>
                    <?php if (count($products) > 1) : ?>
                        <div class="slider-arrows">
                            <div class="arrow prev"> <img src="<?= URL ?>/assets/icon/arrow_white.svg" alt="arrow left" class="arrow-image left"></div>
                            <div class="arrow next"><img src="<?= URL ?>/assets/icon/arrow_white.svg" alt="arrow right" class="arrow-image right"></div>
                        </div>
                        <div class="indicators">
                            <?php foreach ($products as $product) : ?>
                                <div class="indicator"></div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif ?>
                </div>
                <div class="product-data grid">
                    <h1><?= ucfirst($product->getName()) ?></h1>
                    <p><?= ucfirst($product->getDescription()) ?></p>
                    <p class="product-price"><?= $product->getPrice() ?> €</p>
                    <div class="grade">
                        <?php if (count($reviews) >= 1) : ?>
                            <?php

                            $grade_average = 0;
                            $i = 0;
                            foreach ($reviews as $review) {
                                $i++;
                                $grade_average += $review->getGrade();
                            }
                            $average = $grade_average / $i;

                            for ($i = 0; $i < 5; $i++) :
                                if ($i < $average) : ?>
                                    <div class="grade_ball active"></div>
                                <?php else : ?>
                                    <div class="grade_ball"></div>
                            <?php endif;
                            endfor ?>
                        <?php endif ?>
                    </div>
                    <div class="error-container"><?= isset($_SESSION['message']) ? $_SESSION['message'] : ""  ?></div>
                    <?php if ($product->getVisibility() == 3) { ?>
                        <p>Épuisé</p>
                    <?php } else if ($product->getVisibility() == 2) { ?>
                        <p>Produit non disponible</p>
                    <?php } else {
                        echo $form;
                    } ?>
                </div>
            </div>
        </div>
    </section>
    <?php if (count($reviews) >= 1) : ?>
        <section class="review-wrapper grid">
            <div class="drop_review grid">
                <h2>Avis</h2>
                <img src="<?= URL ?>/assets/icon/arrow.svg" alt="arrow">
            </div>
            <div class="reviews-container grid">
                <?php foreach ($reviews as $review) : ?>
                    <div class="review grid">
                        <div class="head_review grid">
                            <h3><?= (!empty($review->getJoin(Users::class)->getFirst_name()) || !empty($review->getJoin(Users::class)->getLast_name())) ? $review->getJoin(Users::class)->getFirst_name() . " " . $review->getJoin(Users::class)->getLast_name() : "Anonyme" ?></h3>
                            <p><?= str_replace("-", " / ", substr($review->getReview_date(), 0, -8)) ?></p>
                        </div>
                        <div class="review_data grid">
                            <div class="grade">
                                <?php for ($i = 0; $i < 5; $i++) :
                                    if ($i < $review->getGrade()) : ?>
                                        <div class="grade_ball active"></div>
                                    <?php else : ?>
                                        <div class="grade_ball"></div>
                                <?php endif;
                                endfor ?>
                            </div>
                            <h3><?= $review->getReview_title() ?></h3>
                            <p><?= $review->getDescription() ?></p>
                            <?php if (!empty($review->getReview_img())) : ?>
                                <img src="<?= URL ?>/assets/img/<?= $review->getReview_img() ?>" alt="avis produit image">
                            <?php endif ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endif; ?>
    <section class="products-trends grid">
        <div class="header-slider grid">
            <h2>Produits tendances</h2>
            <div class="line"></div>
            <div class="slider-arrows">
                <div class="arrow prev"> <img src="<?= URL ?>/assets/icon/arrow_white.svg" alt="arrow left" class="arrow-image left"></div>
                <div class="arrow next"><img src="<?= URL ?>/assets/icon/arrow_white.svg" alt="arrow right" class="arrow-image right"></div>
            </div>
        </div>
        <div class="slider-container" id="slider_products-trends">
            <div class="slider">
                <?php foreach ($products_trends as $products_trend) : ?>
                    <a href="<?= URL ?>/product/<?= $products_trend->getId() ?>" class="slider-item product grid">
                        <img src="<?= URL ?>/assets/img/<?= $products_trend->getJoin(Carousel::class)->getImg() ?>" />
                        <div class="product-data grid">
                            <h3><?= $products_trend->getName() ?></h3>
                            <p><?= $products_trend->getPrice() ?> €</p>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</main>