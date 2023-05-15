<div class="error-container"><?= isset($_SESSION['message']) ?  $_SESSION['message'] : "" ?></div>
<table class="table my-5">
    <thead>
        <tr>
            <th scope="col">id</th>
            <th scope="col">name</th>
            <th scope="col">image</th>
            <th scope="col">action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($categorys as $category) : ?>
            <tr>
                <td><?= $category->getCategory_id() ?></td>
                <td><?= $category->getCategory_name() ?></td>
                <td><img src="<?= URL ?>/assets/img/<?= $category->getCategory_img() ?>" alt="<?= $category->getCategory_name() ?>" /></td>
                <td class="action_table"><a href="<?= URL ?>/admin/categorys/update/<?= $category->getCategory_id() ?>" class="btn btn-primary">modifier</a>
                    <?=

                    $form_delete
                        ->change("id", ['value' => $category->getCategory_id()])
                        ->createView()

                    ?>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>