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
            <th scope="col">action</th>
        </tr>
    </thead>
    <tbody>
        <?php

        use App\Table\Carousel;
        use App\Table\Categorys;

        $img = "";
        for ($i = 0; $i < count($products); $i++) :
            if (isset($products[$i + 1]) && ($products[$i]->getId() == $products[$i + 1]->getId())) {
                $img .= " <img src=\"" . URL . "/assets/img/" . $products[$i]->getJoin(Carousel::class)->getImg() . "\" alt=\" " . $products[$i]->getJoin(Carousel::class)->getAlt() . "\" />";
                continue;
            } else { ?>
                <tr>
                    <td><?= $products[$i]->getId() ?></td>
                    <td><?= $products[$i]->getName() ?></td>
                    <td><?= $products[$i]->getDescription() ?></td>
                    <td><?= $products[$i]->getPrice() ?></td>
                    <td class="img_table">
                        <?=
                        $img .= " <img src=\"" . URL . "/assets/img/" . $products[$i]->getJoin(Carousel::class)->getImg() . "\" alt=\" " . $products[$i]->getJoin(Carousel::class)->getAlt() . "\" />";
                        ?>
                    </td>
                    <td><?= $products[$i]->getJoin(Categorys::class)->getCategory_name() ?></td>
                    <td>
                        <?php if ($products[$i]->getVisibility() == 1) {
                            echo "visible";
                        } else if ($products[$i]->getVisibility() == 2) {
                            echo "hidden";
                        } else {
                            echo "no stock";
                        } ?>
                    </td>
                    <td class="action_table"><a href="<?= URL ?>/admin/products/update/<?= $products[$i]->getId() ?>" class="btn btn-primary">modifier</a>
                        <?=

                        $form_delete
                            ->change("id", ['value' => $products[$i]->getId()])
                            ->createView()

                        ?>
                    </td>
                </tr>
        <?php $img = "";
            }
        endfor ?>
    </tbody>
</table>