<div class="error-container"><?= isset($_SESSION['message']) ?  $_SESSION['message'] : "" ?></div>
<table class="table my-5">
    <thead>
        <tr>
            <th scope="col">id</th>
            <th scope="col">name</th>
            <th scope="col">description</th>
            <th scope="col">price</th>
            <th scope="col">images</th>
            <th scope="col">category</th>
            <th scope="col">visibility</th>
            <th scope="col">update</th>
            <th scope="col">delete</th>
        </tr>
    </thead>
    <tbody>
        <?php

        use App\Table\Carousel;

        foreach ($products as $product) : ?>
            <tr>
                <td><?= $product->getId() ?></td>
                <td><?= $product->getName() ?></td>
                <td><?= $product->getDescription() ?></td>
                <td><?= $product->getPrice() ?></td>
                <td>
                    <img src="<?= URL ?>/assets/img/<?= $product->getJoin(Carousel::class)->getImg() ?>" alt="<?= $product->getJoin(Carousel::class)->getAlt() ?>" />
                </td>
                <td><?= $product->getVisibility() ?></td>
                <td><a href="<?= URL ?>/admin/products/update/<?= $product->getId() ?>" class="btn btn-primary">modifier</a></td>
                <td>
                    <?=

                    $form_delete
                        ->change("id", ['value' => $product->getId()])
                        ->createView()

                    ?>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>