<div class="error-container"><?= isset($_SESSION['message']) ?  $_SESSION['message'] : "" ?></div>
<table class="table my-5">
    <thead>
        <tr>
            <th scope="col">id</th>
            <th scope="col">first name</th>
            <th scope="col">last name</th>
            <th scope="col">email</th>
            <th scope="col">tel number</th>
            <th scope="col">adress</th>
            <th scope="col">type</th>
            <th scope="col">date de création</th>
            <th scope="col">action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user) : ?>
            <tr>
                <td><?= $user->getId() ?></td>
                <td><?= $user->getFirst_name() ?></td>
                <td><?= $user->getLast_name() ?></td>
                <td><?= $user->getEmail() ?></td>
                <td><?= $user->getNum() ?></td>
                <td><?= $user->getAdress() ?></td>
                <td>
                    <?php if ($user->getType() == 1) {
                        echo "user";
                    } else {
                        echo "admin";
                    } ?>
                </td>
                <td><?= $user->getCreation_date() ?></td>
                <td class="action_table"><a href="<?= URL ?>/admin/users/update/<?= $user->getId() ?>" class="btn btn-primary">modifier</a>
                    <?=

                    $form_delete
                        ->change("id", ['value' => $user->getId()])
                        ->createView()

                    ?>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>