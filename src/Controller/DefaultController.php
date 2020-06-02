<?php

namespace Controller;

use Metrotel\View;
use Metrotel\Src\AbstractController;
use Guard\Authorization;

use Repository\UserPhonebookRepository;
use Validation\Entity\UserPhonebookValidation;
use Entity\UserPhonebookEntity;
use Service\UploadFile;

class DefaultController extends AbstractController {

    public function index() {
        if (!Authorization::isAuth()) {
            View::redirect('login/index');
        }

        $phone_list = UserPhonebookRepository::findAllByUserId(Authorization::getId());
        View::render('template', [
            'content' => View::render('phone_book', ['phone_list' => $phone_list], false),
        ]);
    }

    public function ajax_index() {
        if (!Authorization::isAuth()) {
            return;
        }

        $phone_list = UserPhonebookRepository::findAllByUserId(Authorization::getId());
        View::render('phone_book', ['phone_list' => $phone_list]);
    }

    public function delete() {
        if (!Authorization::isAuth()) {
           echo json_encode([
               'success' => false,
               'message' => 'Вы не авторизованы.',
           ]);
           return;
        }

        $result = [
            'success' => false,
            'message' => null,
        ];

        if (empty($_POST['id'])) {
            echo json_encode([
                'success' => false,
                'message' => 'Пустые данные.',
           ]);
           return;
        }

        $record = UserPhonebookRepository::findByIdAndUserId($_POST['id'], Authorization::getId());
        if (!$record) {
            $result['message'] = 'У вас нет прав на эту запись.';
        } else {
            UserPhonebookRepository::delete((int)$_POST['id']);
            $result['success'] = true;
            $result['message'] = 'Запись успешно удалена.';
        }

        // Warning: В идеале фоновая задача должна проверять, что нет "висячих" картинок
        if (!empty($record['image'])) {
            $uploadFile = new UploadFile(PUBLICPATH.'/image');
            $uploadFile->deleteFile($record);
        }

        echo json_encode($result);
    }

    public function save() {
        if (!Authorization::isAuth()) {
           echo json_encode([
               'success' => false,
               'message' => 'Вы не авторизованы.',
           ]);
           return;
        }

        if (empty($_POST)) {
            echo json_encode([
                'success' => false,
                'message' => 'Нет данных.',
           ]);
           return;
        }

        $result = [
            'success' => false,
            'message' => null,
        ];

        try {
            UserPhonebookValidation::validateName((!empty($_POST['name'])) ? $_POST['name'] : null);
            UserPhonebookValidation::validateLastname((!empty($_POST['lastname'])) ? $_POST['lastname'] : null);
            if (!empty($_POST['email'])) {
                UserPhonebookValidation::validateEmail((!empty($_POST['email'])) ? $_POST['email'] : null);
            }
            UserPhonebookValidation::validatePhone((!empty($_POST['phone'])) ? $_POST['phone'] : null);

            $userPhonebookEntity = new UserPhonebookEntity();
            $userPhonebookEntity->setUpdatedAt(date('Y-m-d H:i:s'));

            if (empty($_POST['id'])) {
                $userPhonebookEntity->setCreatedAt(date('Y-m-d H:i:s'));
            } else {
                $record = UserPhonebookRepository::findByIdAndUserId((int)$_POST['id'], Authorization::getId());
                if (!$record) {
                    throw new \Exception('У вас нет прав на эту запись.');
                }

                $userPhonebookEntity->setId((int)$_POST['id']);
            }

            // Warning: Можно сделать проверку на уникальность телефона и email в базе
            if (!empty($_POST['email'])) {
                $userPhonebookEntity->setEmail($_POST['email']);
            }
            $userPhonebookEntity->setPhone($_POST['phone']);
            $userPhonebookEntity->setName($_POST['name']);
            $userPhonebookEntity->setLastname($_POST['lastname']);
            $userPhonebookEntity->setUserId(Authorization::getId());

            if (!empty($_FILES['image'])) {
                $uploadFile = new UploadFile(PUBLICPATH.'/image');
                $image = $uploadFile->upload('image');
                $userPhonebookEntity->setImage($image);

                if (!empty($record['image'])) {
                    $uploadFile->deleteFile($record['image']);
                }
            }

            if (empty($_POST['id'])) {
                $userPhonebookEntity->insert();
            } else {
                $userPhonebookEntity->update();
            }

            $result['success'] = true;
            $result['message'] = 'Запись успешно добавлена.';
        } catch(\Exception $e) {
            $result['message'] = $e->getMessage();
        }

        echo json_encode($result);
    }
}
