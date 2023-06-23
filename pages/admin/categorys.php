<main class="grid">
    <div class="error-container" style="<?= !empty($_SESSION['message']) ? "display: block;" : "display: none;"  ?>"><?= isset($_SESSION['message']) ? $_SESSION['message'] : ""  ?></div>
    <table class="table my-5">
        <thead>
            <tr>
                <th scope="col">id</th>
                <th scope="col">name</th>
                <th scope="col">image</th>
                <th scope="col" colspan="2">action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categorys as $category) : ?>
                <tr>
                    <td><?= $category->getCategory_id() ?></td>
                    <td><?= $category->getCategory_name() ?></td>
                    <td class="img_table"><img src="<?= BASE_PUBLIC ?>/assets/img/<?= $category->getCategory_img() ?>" alt="<?= $category->getCategory_name() ?>" /></td>
                    <td class="action_table">
                        <a href="<?= URL ?>/admin/categorys/update/<?= $category->getCategory_id() ?>" class="btn btn-primary">modifier</a>
                    </td>
                    <td class="action_table">
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
</main>