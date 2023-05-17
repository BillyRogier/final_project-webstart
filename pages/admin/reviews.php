<div class="error-container"><?= isset($_SESSION['message']) ?  $_SESSION['message'] : "" ?></div>
<table class="table my-5">
    <thead>
        <tr>
            <th scope="col">id</th>
            <th scope="col">product</th>
            <th scope="col">user</th>
            <th scope="col">description</th>
            <th scope="col">grade</th>
            <th scope="col">action</th>
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
                <td><?= $review->getDescription() ?></td>
                <td><?= $review->getGrade() ?></td>
                <td class="action_table"><a href="<?= URL ?>/admin/reviews/update/<?= $review->getReview_id() ?>" class="btn btn-primary">modifier</a>
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