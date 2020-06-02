<?php
use Metrotel\View;
?>

<div class="row justify-content-md-center">
    <div class="col-md-auto">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Имя</th>
                    <th>Фамилия</th>
                    <th>Телефон</th>
                    <th>Email</th>
                    <th>Изображение</th>
                    <th>Дата создания</th>
                    <th>Дата изменения</th>
                    <th>Действие</th>
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
                            <td>
                                <button class="btn btn-warning btn-phone-edit" data-id="<?php echo $phone['id'];?>">Редактировать</button>
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
    </div>
</div>

<div class="modal fade modalAddPhone" id="modalAddPhone" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
                <table>
                    <tr>
                        <td>Имя <span class="text-danger">*</span></td>
                        <td>
                            <input type="text" maxlength="50" class="form-control name" placeholder="Имя">
                            <input type="hidden" class="id">
                        </td>
                    </tr>
                    <tr>
                        <td>Фамилия <span class="text-danger">*</span></td>
                        <td><input type="text" maxlength="50" class="form-control lastname" placeholder="Фамилия"></td>
                    </tr>
                    <tr>
                        <td>Телефон <span class="text-danger">*</span></td>
                        <td><input type="text" maxlength="16" class="form-control phone" placeholder="Телефон"></td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td><input type="email" maxlength="50" class="form-control email" placeholder="Email"></td>
                    </tr>
                    <tr>
                        <td>Изображение</td>
                        <td class="form-inline">
                            <img width="40" height="40" src="" class="mr-2">
                            <input type="file" class="form-control image" accept=".png,.jpg,.jpeg" placeholder="Изображение">
                        </td>
                    </tr>
                </table>
			</div>
			<div class="modal-footer justify-content-around">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
				<button type="button" class="btn btn-primary btn-phone-modal-save">Save</button>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
    // Delete record
    $('body').on('click', '.btn-phone-delete', function() {
        if (!confirm('Вы точно хотите удалить запись??')) {
            return;
        }

        let self = $(this);

        let data = {
            'id': $(self).data('id')
        };
        let phone = $(self).parents('tr').eq(0).find('.phone').text();

        $.ajax({
			url: "<?php echo View::base_url('default/delete');?>",
			type: "POST",
			dataType: 'json',
			data: data
		})
			.done(function(result) {
                if (result && result['success']) {
                    $(self).parents('tr').eq(0).remove();
                    alert('Запись ' + phone + ' успешно удалена!');
                } else {
                    alert(result['message']);
                }
			})
			.fail(function() {
                alert('Ошибка. Повторите запрос.');
			});
    });

    // Add new record. Show modal
    $('.btn-phone-add').on('click', function() {
        $('.modalAddPhone h5').text('Добавление нового контакта');
        $('.modalAddPhone table input').val('');
        $('.modalAddPhone table img').attr('src', '');
        $('.modalAddPhone').modal('show');
    });

    // Edit record. Show modal with input
    $('body').on('click', '.btn-phone-edit', function() {
        $('.modalAddPhone table input').val('');
        $('.modalAddPhone table img').attr('src', '');

        let fields = ['name', 'lastname', 'phone', 'email'];
        let record  = $(this).parents('tr').eq(0);
        let id = $(record).data('id');
        let image = $(record).find('.image img').attr('src');
        let phone = $(record).find('.phone').text().trim();

        $('.modalAddPhone').find('input.id').val(id);
        for (let key in fields) {
            $('.modalAddPhone').find('input.'+fields[key]).val(
                $(record).find('.'+fields[key]).text().trim()
            );
        }

        if (image) {
             $('.modalAddPhone').find('img').attr('src', image);
        }

        $('.modalAddPhone h5').text('Редактирование контакта ' + phone);
        $('.modalAddPhone').modal('show');
    });

    // Save record.
    $('.btn-phone-modal-save').on('click', function() {
        $('.modalAddPhone button').attr('disabled', 'disabled');

        let data = new FormData();
        let fields = ['id', 'name', 'lastname', 'phone', 'email'];
        for (let key in fields) {
            data.append(fields[key], $('.modalAddPhone').find('input.'+fields[key]).eq(0).val());
        }

        let image = $('.modalAddPhone').find('.image').eq(0);
        if ($(image)[0].files.length !== 0) {
            data.append('image', $(image)[0].files[0]);
        }
        let phone = $('.modalAddPhone').find('.phone').text();

        $.ajax({
			url: "<?php echo View::base_url('default/save');?>",
			data: data,
			processData: false,
			contentType: false,
			enctype: 'multipart/form-data',
			type: 'POST',
			dataType: 'json'
		})
			.done(function(result) {
                if (result && result['success']) {
                    // TODO: Перезагрузка страницы
                    $('.modalAddPhone').modal('hide');
                    alert('Запись ' + phone + ' успешно добавлена!');
                } else {
                    alert(result['message']);
                }
			})
			.fail(function() {
				// Выводим ошибку
                alert('Ошибка. Повторите запрос.');
			})
            .always(function() {
                $('.modalAddPhone button').removeAttr('disabled');
            });
    });

</script>
