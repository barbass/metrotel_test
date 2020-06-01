<?php

namespace Metrotel;

class Db {
	protected $connection = null;
	protected $options = array(
		'host' => 'localhost',
		'database' => '',
		'user' => '',
		'password' => '',
	);
	protected $result_query = null;
	protected $error = null;
	protected $smtp = null;

	/**
	 * Конструктор
	 * @param array
	 */
	public function __construct(string $host, string $database, string $username, string $password) {
		$this->connect($host, $database, $username, $password);
	}

	/**
	 * Создание соединения с базой
	 */
	public function connect(string $host, string $database, string $username, string $password) {
		$dsn = "mysql:host=".$host.";dbname=".$database.";charset=utf8";
		$this->connection = new \PDO($dsn, $username, $password);
	}

	/**
	 * Подготовка запроса
	 * @param string $sql
	 */
	public function prepare($sql) {
		try {
			$this->smtp = $this->connection->prepare($sql);
		} catch(\PDOException $e) {
			throw $e;
			return false;
		}
	}

	/**
	 * Выполнение подготовленного запроса с параметрами
	 * @param array
	 */
	public function execute($params) {
		try{
			$this->connection->beginTransaction();

			$this->smtp->execute($params);

			$error = $this->smtp->errorInfo();
			if (!empty($error) && $error[0] !== '00000') {
				throw new \PDOException($error[2]);
			}

			$result = $this->smtp->fetchAll(PDO::FETCH_ASSOC);
			$this->result_query = $result;

			$this->connection->commit();

			$this->smtp = null;
		} catch(\PDOException $e) {
			$this->connection->rollback();
			throw $e;
			return false;
		}
	}

	/**
	 * Мульти-вставка
	 * @param string $table Таблица
	 * @param array $data_list Список данных с ключами
	 * @param int $limit Кол-во данных для вставки
	 */
	public function multiInsert($table, $data_list, $limit = 150) {
		$collection = array();
		foreach($data_list as $i=>$d) {
			$collection[] = $d;

			if (($i == count($data_list) - 1) || count($collection) == $limit) {
				$sql_data = array();
				$sql_insert_list = array();

				foreach($collection as $j=>$model) {
					$keys = array();

					foreach($model as $key=>$value) {
						$sql_data[$key.$j] = $value;
						$keys[] = $key.$j;
					}

					$sql_insert_list[] = "(".implode(',', $keys).")";
				}

				$sql_insert = "INSERT INTO `".$table."` VALUES ".implode(', ', $sql_insert_list);

				try {
					$this->prepare($sql_insert);
					$this->execute($sql_data);
				} catch(\PDOException $e) {
					throw $e;
				}

				$collection = array();
			}
		}
	}

	/**
	 * Выполнение запроса
	 * @param string Запрос
	 */
	public function query($sql, $params = array()) {
		if ($params) {
			$this->prepare($sql);
			$this->smtp->execute($params);

			$error = $this->smtp->errorInfo();
			if (!empty($error) && $error[0] !== '00000') {
				throw new \PDOException($error[2]);
			}

			$result = $this->smtp->fetchAll(PDO::FETCH_ASSOC);
		} else {
			$result = $this->connection->query($sql);

			$error = $this->connection->errorInfo();
			if (!empty($error) && $error[0] !== '00000') {
				throw new \PDOException($error[2]);
			}

			if ($result) {
				$result = $result->fetchAll(\PDO::FETCH_ASSOC);
			}
		}

		$this->result_query = $result;

		return true;
	}

	/**
	 * Получение всех данных
	 * @return mixed (array|null)
	 */
	public function getRows() {
		if (!$this->result_query) {
			return null;
		}
		$data = $this->result_query;
		$this->result_query = null;

		return $data;
	}

	/**
	 * Получение строки
	 * @return mixed (array|null)
	 */
	public function getRow() {
		$data = $this->getRows();
		if ($data) {
			return $data[0];
		}

		return null;
	}

	/**
	 * Разрыв соединения с базой
	 */
	public function disconnect() {}

	public function getError() {
		return $this->error;
	}
}
