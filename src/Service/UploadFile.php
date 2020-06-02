<?php

namespace Service;

class UploadFile {
	protected $path = '';

	public function __construct(string $path) {
		$this->path = strtolower($path);
		if (!is_dir($this->path)) {
			$result = mkdir($this->path, 0777, true);
			if (!$result) {
				throw new \Exception('Не удалось создать папку: '.$this->path);
			}
		}
	}

	/**
	 * Удаление файлов от предыдущей загрузки в папке
	 */
	public function deleteFile($file) {
        $file = $this->path.'/'.$file;
		if (is_file($file)) {
            unlink($file);
        }
	}

	/**
	 * Получение расширения файла
	 * @param string $file Файл
	 * @return string Расширение
	 */
	public function getExtension($file) {
		$file_name_part = explode('.', $file);
		$extension = 'none';

		if (count($file_name_part) > 1) {
			$extension = end($file_name_part);
		}

		return $extension;
	}

	/**
	 * Возвращает рандом-название для файла расширения файла
	 * @param string $file Файл
	 * @return string Расширение
	 */
	public function getRandonName() {
		return time().uniqid('', true);
	}

	/**
	 * Загрузка файлов
	 */
	public function upload($key): string
    {
		if (empty($_FILES[$key])) {
			throw new \Exception('Не найдены файлы для загрузки.');
		}

		$file = $_FILES[$key];

        $mime = mime_content_type($file['tmp_name']);
        if (!in_array($mime, ['image/png', 'image/jpeg'])) {
             throw new \Exception('Допустимы изображения только в формате png и jpg/jpeg.');
        }

        $size = ($file['size'] / 1024) / 1024;
        if ($size > 2) {
            throw new \Exception('Файл не должен быть больше 2МБ.');
        }

		$result_uploaded = 0;

        if (!is_uploaded_file($file['tmp_name'])) {
            throw new \Exception('Файл не удалось загрузить.');
        }

        $file_name_new = $this->getRandonName().'.'.$this->getExtension($file['name']);
        $result_uploaded += (int)move_uploaded_file($file['tmp_name'], $this->path.'/'.$file_name_new);

		if ($result_uploaded < 1) {
			throw new \Exception('Файл не удалось загрузить.');
		}

		return $file_name_new;
	}

}
