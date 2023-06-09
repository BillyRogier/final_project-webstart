<main class="grid">
    <div class="error-container" style="<?= !empty($_SESSION['message']) ? "display: block;" : "display: none;"  ?>"><?= isset($_SESSION['message']) ? $_SESSION['message'] : ""  ?></div>
    <table class="table my-5">
        <thead>
            <tr>
                <th scope="col">id</th>
                <th scope="col">user</th>
                <th scope="col">products</th>
                <th scope="col">order_num</th>
                <th scope="col">order_date</th>
                <th scope="col" colspan="3">action</th>
            </tr>
        </thead>
        <tbody>
            <?php

            use App\Table\Users;

            $n = 1;
            for ($i = 0; $i < count($orders); $i++) :
                $table =  "<tr>
                    <td>" . $orders[$i]->getOrder_id() . "</td>
                    <td>
                    " . (!is_null($orders[0]->getUser_id()) ? $orders[$i]->getJoin(Users::class)->getEmail() : "") . "
                    </td>
                    <td>$n</td>
                    <td>" . $orders[$i]->getOrder_num() . "</td>
                    <td>" . $orders[$i]->getOrder_date() . "</td>
                    <td class=\"action_table\"><a href=\"" . URL . "/admin/orders/view/" . $orders[$i]->getOrder_num() . "\" class=\"btn add_color\">Détails</a></td>
                    </td>
                </tr>";
                if (isset($orders[$i + 1]) && ($orders[$i]->getOrder_num() == $orders[$i + 1]->getOrder_num()) && ($orders[$i]->getProduct_id() != $orders[$i + 1]->getProduct_id())) {
                    $n += 1;
                } else if (isset($orders[$i + 1]) && ($orders[$i]->getOrder_num() == $orders[$i + 1]->getOrder_num())) {
                    $n = 1;
                } else {
                    echo $table;
                    $n = 1;
                }
            endfor ?>
        </tbody>
    </table>
</main>