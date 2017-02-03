<?php

require_once '/lib/config.php';

class Database {

	private static $pdo;
	private $dsn;

	private $db_info = array(
		'host' =>'localhost',
		'db_name' => 'system_book_rental',
		'user_name' => 'root',
		'password' => 'tariton12',
		'table_name' => 'book_list',
	);

	private function __construct() {
		$this->dsn = 'mysql:host=' . $this->db_info['host'] . ';dbname=' . $this->db_info['db_name'] . ';charset=utf8;';
		$this->pdo = new PDO($this->dsn, $this->db_info['user_name'], $this->db_info['password']);
		$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	}

	final public static function getInstance() {
		static $instance;
		if(!isset($instance)){
			$instance = new self;
		}
		return $instance;
	}

	public function fetcchAll($sql) {
		try {
			$stmt = $this->pdo->prepare($sql);
			$stmt->execute();

			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

			return $result;
		} catch (Exception $e) {
			echo 'エラーが発生しました: ', $e->getMessage();
			die();
		}
	}

	public function getListAll() {

		$sql = 'SELECT * FROM ' . $this->db_info['table_name'];

		try {
			$stmt = $this->pdo->prepare($sql);
			$stmt->execute();

			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

			return $result;
		} catch (Exception $e) {
			echo 'エラーが発生しました: ', $e->getMessage();
			die();
		}
	}

	public function addBook($book_data) {

		$sql = 'INSERT INTO '.
			$this->db_info['table_name'] .
			'(`id`, `rental_status`, `book_name`, `writer`, `genre`, `version`, `issued_years`, `owner`, `user`, `rent_date`, `return_date`, `isbn`)' .
			' VALUES (:id, :rental_status, :book_name, :writer, :genre, :version, :issued_years, :owner, :user, :rent_date, :return_date, :isbn)';

		$rental_status = 0;
		$null_val = NULL;

		try {

			$stmt = $this->pdo->prepare($sql);

			$stmt->bindValue(':id', $null_val, PDO::PARAM_INT);
			$stmt->bindValue(':rental_status', $rental_status, PDO::PARAM_INT);
			$stmt->bindParam(':book_name', $book_data['bookname'], PDO::PARAM_STR);
			$stmt->bindParam(':writer', $book_data['writer'], PDO::PARAM_STR);
			$stmt->bindParam(':genre', $book_data['genre'], PDO::PARAM_STR);
			if($book_data['version'] === ''){
				$book_data['version'] = '初版';
			}
			$stmt->bindParam(':version', $book_data['version'], PDO::PARAM_STR);
			$stmt->bindValue(':issued_years', (int)$book_data['issued_years'], PDO::PARAM_INT);
			$stmt->bindParam(':owner', $book_data['owner'], PDO::PARAM_STR);
			if($book_data['isbn'] === ''){
				$book_data['isbn'] = '0';
			}
			$stmt->bindParam(':user', $null_val, PDO::PARAM_STR);
			$stmt->bindParam(':rent_date', $null_val, PDO::PARAM_STR);
			$stmt->bindParam(':return_date', $null_val, PDO::PARAM_STR);
			$stmt->bindValue(':isbn', (int)$book_data['isbn'], PDO::PARAM_INT);

			$stmt->execute();

		} catch (Exception $e) {
			echo 'エラーが発生しました: ', $e->getMessage();
			die();
		}
	}

	public function deleteBook($id) {

		$sql = 'DELETE FROM ' . $this->db_info['table_name'] . ' WHERE `id` = :id';

		try {
			$stmt = $this->pdo->prepare($sql);
			$stmt->bindValue(':id', $id, PDO::PARAM_INT);

			$stmt->execute();
		} catch (Exception $e) {
			echo 'エラーが発生しました: ', $e->getMessage();
			die();
		}
	}

	public function updateStatus($id, $status) {

		$sql = 'UPDATE ' . $this->db_info['table_name'] . ' SET `rental_status` = :rental_status WHERE `id` = :id';

		try {
			$stmt = $this->pdo->prepare($sql);
			$stmt->bindValue(':rental_status', $status, PDO::PARAM_INT);
			$stmt->bindValue(':id', $id, PDO::PARAM_INT);

			$stmt->execute();
		} catch (Exception $e) {
			echo 'エラーが発生しました: ', $e->getMessage();
			die();
		}
	}

	public function bookRental($id, $status, $user = NULL) {

		$rent_date = NULL;
		$return_date = NULL;
		if(!is_null($user)){
			$rent_date = date('Y-m-d');
			$return_date = date('Y-m-d', strtotime("+1 week"));
		}

		$sql = 'UPDATE ' . $this->db_info['table_name'] .
		' SET `rental_status` = :rental_status, `user` = :user, `rent_date` = :rent_date , `return_date` = :return_date' .
		' WHERE `id` = :id';

		try {
			$stmt = $this->pdo->prepare($sql);
			$stmt->bindValue(':rental_status', $status, PDO::PARAM_INT);
			$stmt->bindParam(':user', $user, PDO::PARAM_STR);
			$stmt->bindParam(':rent_date', $rent_date, PDO::PARAM_STR);
			$stmt->bindParam(':return_date', $return_date, PDO::PARAM_STR);
			$stmt->bindValue(':id', $id, PDO::PARAM_INT);

			$stmt->execute();
		} catch (Exception $e) {
			echo 'エラーが発生しました: ', $e->getMessage();
			die();
		}
	}
}