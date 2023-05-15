<div class="error-container"><?= isset($_SESSION['message']) ?  $_SESSION['message'] : "" ?></div>
<table class="table my-5">
    <thead>
        <tr>
            <th scope="col">id</th>
            <th scope="col">user</th>
            <th scope="col">products</th>
            <th scope="col">order_num</th>
            <th scope="col">order_date</th>
            <th scope="col">action</th>
        </tr>
    </thead>
    <tbody>
        <?php

        use App\Table\Users;

        $n = 1;
        for ($i = 0; $i < count($orders); $i++) :
            $table = "<tr>
                <td>" . $orders[$i]->getOrder_id() . "</td>
                <td>" . $orders[$i]->getJoin(Users::class)->getEmail() . "</td>
                <td>$n</td>
                <td>" . $orders[$i]->getOrder_num() . "</td>
                <td>" . $orders[$i]->getOrder_date() . "</td>
                <td class=\"action_table\"><a href=\"" . URL . "/admin/orders/view/" . $orders[$i]->getOrder_num() . "\" class=\"btn btn-primary\">view</a>
                <a href=\"" . URL . "/admin/orders/update/" . $orders[$i]->getOrder_num() . "\" class=\"btn btn-primary\">modifier</a>
                    " .

                $form_delete
                ->change("id", ['value' => $orders[$i]->getOrder_num()])
                ->createView()

                . "
                </td>
            </tr>";
            if (isset($orders[$i + 1]) && ($orders[$i]->getOrder_num() == $orders[$i + 1]->getOrder_num()) && ($orders[$i]->getProduct_id() != $orders[$i + 1]->getProduct_id())) {
                $n += 1;
            } else {
                echo $table;
                $n = 1;
            }
        endfor ?>
    </tbody>
</table>