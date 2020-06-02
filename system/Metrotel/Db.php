<?php

namespace Metrotel;

class Db {
    /**
     *
     * @var Metrotel\Db
     */
    protected static $instance;
	protected $connection = null;
	protected $config = array(
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
	public function __construct() {
		require_once(CONFIGPATH.'/db.php');
		$this->config = (!empty($config['db'])) ? $config['db'] : [];

		$this->connect($this->config['host'], $this->config['database'], $this->config['username'], $this->config['password']);
	}

    // Singletone
    protected function __clone() {
        // pass
    }

    // Singletone
    protected function __wakeup() {}

    public static function getInstance(): Db {
        if (!isset(self::$instance)) {
            self::$instance = new self();
       }

        return self::$instance;
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

			$result = $this->smtp->fetchAll(\PDO::FETCH_ASSOC);
			$this->result_query = $result;

			$this->connection->commit();

			$this->smtp = null;
		} catch(\PDOException $e) {
			$this->connection->rollback();
			throw $e;
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

			$result = $this->smtp->fetchAll(\PDO::FETCH_ASSOC);
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
