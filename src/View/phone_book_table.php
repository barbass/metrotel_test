<?php
use Metrotel\View;
?>

<table class="table table-hover table-responsive phonebook">
    <thead>
        <tr>
            <th>
                <a href="javascript:void(0);"
                   class="btn-sort"
                   data-field="name"
                   data-sort="<?php if (!empty($order['name']) && $order['name'] == 'asc') {
                       echo 'desc';
                   } elseif (!empty($order['name']) && $order['name'] == 'desc') {
                       echo 'asc';
                   } else {
                       echo 'asc';
                   }
                   ?>"
                >Имя</a>
                <?php if (!empty($order['name'])) {
                    if (isset($order['name']) && $order['name'] === 'asc') {
                        echo "<i class='fa fa-arrow-down' aria-hidden='true'></i>";
                    } else {
                        echo "<i class='fa fa-arrow-up' aria-hidden='true'></i>";
                    }
                }
                ?>
            </th>
            <th>
                <a href="javascript:void(0);"
                   class="btn-sort"
                   data-field="lastname"
                   data-sort="<?php if (!empty($order['lastname']) && $order['lastname'] == 'asc') {
                       echo 'desc';
                   } elseif (!empty($order['lastname']) && $order['lastname'] == 'desc') {
                       echo 'asc';
                   } else {
                       echo 'asc';
                   }
                   ?>"
                >Фамилия</a>
                <?php if (!empty($order['lastname'])) {
                    if (isset($order['lastname']) && $order['lastname'] === 'asc') {
                        echo "<i class='fa fa-arrow-down' aria-hidden='true'></i>";
                    } else {
                        echo "<i class='fa fa-arrow-up' aria-hidden='true'></i>";
                    }
                }
                ?>
            </th>
            <th>
                <a href="javascript:void(0);"
                   class="btn-sort"
                   data-field="phone"
                   data-sort="<?php if (!empty($order['phone']) && $order['phone'] == 'asc') {
                       echo 'desc';
                   } elseif (!empty($order['phone']) && $order['phone'] == 'desc') {
                       echo 'asc';
                   } else {
                       echo 'asc';
                   }
                   ?>"
                >Телефон</a>
                <?php if (!empty($order['phone'])) {
                    if (isset($order['phone']) && $order['phone'] === 'asc') {
                        echo "<i class='fa fa-arrow-down' aria-hidden='true'></i>";
                    } else {
                        echo "<i class='fa fa-arrow-up' aria-hidden='true'></i>";
                    }
                }
                ?>
            </th>
           <th>
                <a href="javascript:void(0);"
                   class="btn-sort"
                   data-field="email"
                   data-sort="<?php if (!empty($order['email']) && $order['email'] == 'asc') {
                       echo 'desc';
                   } elseif (!empty($order['email']) && $order['email'] == 'desc') {
                       echo 'asc';
                   } else {
                       echo 'asc';
                   }
                   ?>"
                >Email</a>
                <?php if (!empty($order['email'])) {
                    if (isset($order['email']) && $order['email'] === 'asc') {
                        echo "<i class='fa fa-arrow-down' aria-hidden='true'></i>";
                    } else {
                        echo "<i class='fa fa-arrow-up' aria-hidden='true'></i>";
                    }
                }
                ?>
            </th>
            <th>Изображение</th>
            <th>Дата создания</th>
            <th>Дата изменения</th>
            <th>Действие</th>
        </tr>
        <tr>
            <td><input type="text" class="filter_name form-control form-control-sm" value="<?php if (!empty($filter['name'])) {echo $filter['name'];}?>" maxlength="50"></td>
            <td><input type="text" class="filter_lastname form-control form-control-sm" value="<?php if (!empty($filter['lastname'])) {echo $filter['lastname'];}?>" maxlength="50"></td>
            <td><input type="text" class="filter_phone form-control form-control-sm" value="<?php if (!empty($filter['phone'])) {echo $filter['phone'];}?>" maxlength="16"></td>
            <td><input type="text" class="filter_email form-control form-control-sm" value="<?php if (!empty($filter['email'])) {echo $filter['email'];}?>" maxlength="50"></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="d-flex">
                <button class="btn btn-secondary btn-filter-reset mr-1">Сбросить</button>
                <button class="btn btn-primary btn-filter">Фильтр</button>
            </td>
        </tr>
    </thead>

    <tbody>
        <?php if (!empty($phone_list)) {
            foreach($phone_list as $phone) {?>
                <tr data-id="<?php echo $phone['id'];?>">
                    <td class="name"><?php echo $phone['name'];?></td>
                    <td class="lastname"><?php echo $phone['lastname'];?></td>
                    <td class="phone"><?php echo $phone['phone'];?></td>
                    <td class="email"><?php echo $phone['email'];?></td>
                    <td class="image">
                        <?php if (!empty($phone['image'])) { ?>
                            <img width="40" height="40" src="<?php echo View::base_url('public/image/'.$phone['image']);?>">
                        <?php } ?>
                    </td>
                    <td><?php echo $phone['created_at'];?></td>
                    <td><?php echo $phone['updated_at'];?></td>
                    <td class="d-flex">
                        <button class="btn btn-warning btn-phone-edit mr-1" data-id="<?php echo $phone['id'];?>">Редактировать</button>
                        <button class="btn btn-danger btn-phone-delete" data-id="<?php echo $phone['id'];?>">Удалить</button>
                    </td>
                </tr>
            <?php }
        } ?>
    </tbody>

    <tfoot>
        <tr>
            <td colspan="8">
                <button class="btn btn-primary btn-phone-add">Добавить</button>
            </td>
        </tr>
    </tfoot>
</table>
