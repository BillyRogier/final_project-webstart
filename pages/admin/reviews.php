<main class="grid">
    <div class="error-container"><?= isset($_SESSION['message']) ?  $_SESSION['message'] : "" ?></div>
    <table class="table my-5">
        <thead>
            <tr>
                <th scope="col">id</th>
                <th scope="col">product</th>
                <th scope="col">user</th>
                <th scope="col">title</th>
                <th scope="col">description</th>
                <th scope="col">grade</th>
                <th scope="col">image</th>
                <th scope="col" colspan="2">action</th>
            </tr>
        </thead>
        <tbody>
            <?php

            use App\Table\Products;
            use App\Table\Users;

            foreach ($reviews as $review) : ?>
                <tr>
                    <td><?= $review->getReview_id() ?></td>
                    <td><?= $review->getjoin(Products::class)->getName() ?></td>
                    <td><?= $review->getjoin(Users::class)->getEmail() ?></td>
                    <td><?= $review->getReview_title() ?></td>
                    <td><?= $review->getDescription() ?></td>
                    <td><?= $review->getGrade() ?></td>
                    <td>
                        <?php if (!empty($review->getReview_img())) : ?>
                            <img src="<?= BASE_PUBLIC ?>/assets/img/<?= $review->getReview_img() ?>" alt="<?= $review->getReview_title() ?>" />
                        <?php endif ?>
                    </td>
                    <td class="action_table"><a href="<?= URL ?>/admin/reviews/update/<?= $review->getReview_id() ?>" class="btn">modifier</a></td>
                    <td>
                        <?=

                        $form_delete
                            ->change("id", ['value' => $review->getReview_id()])
                            ->createView()

                        ?>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</main>