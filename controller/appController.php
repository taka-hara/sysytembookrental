<?php

require_once 'application.php';

require_once '/model/isbnSearch.php';
require_once '/model/validator.php';
require_once '/model/database.php';

class appController extends Application{

	private $default_template = 'index';
	private $db;

	private $user_list = array(
		'今村',
		'曽根',
		'加藤',
		'尾崎',
		'山中',
		'小野塚',
		'本望',
		'東',
		'中原',
		'関根',
		'前原',
		'服部',
		'平澤',
		'大形',
		'口石',
		'原',
		'吉田',
		'永野',
		'その他',
	);


	private $list_column = array(
		'id' => '',
		'rental_status' => '',
		'book_name' => '',
		'writer' => '',
		'genre' => '',
		'version' => '',
		'issued_years' => '',
		'owner' => '',
		'user' => '',
		'rent_date' => '',
		'retun_date' => ''
	);

	public function __construct() {
		parent::__construct();
		$this->template = $this->default_template;
		$this->db = Database::getInstance();
		$this->listLoad();
	}

	protected function indexAction() {
		// 書籍一覧取得
		//$this->data['book_list'] = $this->db->getListAll();

		$this->template = 'index';
	}

	protected function searchAction() {
		$isbn = isset($_POST['isbn']) ? $_POST['isbn'] : '';

		$isbn_search = new isbnSearch();
		$result = $isbn_search->search($isbn);

		$this->data['post_data'] = $result;
		$this->data['post_data']['isbn'] = $isbn;
		$this->template = 'index';
	}

	protected function addAction() {
		// フォームの入力内容確認
		// isbn一致確認
		$post = isset($_POST) ? $_POST : array();
		$this->data['post_data'] = $post;
		$this->db->addBook($post);
		$this->listLoad();
		$this->template = 'index';
	}

	protected function deleteAction() {
		// 指定された書籍のIDの本を本当に削除してい良いか確認
		// 状態によって場合分け（貸出中など）
		$id = isset($_POST['delete_id']) ? $_POST['delete_id'] : NULL;

		if(!is_null($id)){
			$this->db->deleteBook($id);
		}

		$this->listLoad();
		$this->template = 'index';
	}

	protected function rentAction() {
		$id = isset($_POST['row_id']) ? $_POST['row_id'] : NULL;
		$status = '1';
		$user = isset($_POST['row_user']) ? $_POST['row_user'] : NULL;
		$this->db->bookRental($id, $status, $user);

		$this->listLoad();
		$this->template = 'index';
	}

	protected function returnAction() {
		$id = isset($_POST['row_id']) ? $_POST['row_id'] : NULL;
		$status = '0';
		$this->db->bookRental($id, $status);

		$this->listLoad();
		$this->template = 'index';
	}

	private function getBookList() {
		$book_list;

		return $book_list;
	}

	private function validate() {
		$validator = new Validator();
	}

	private function listLoad() {
		$id_list = array();

		$this->data['book_list'] = $this->db->getListAll();

		foreach ($this->data['book_list'] as $book) {
			$id_list[] = $book['id'];
		}
		$this->data['id_list'] = $id_list;
		$this->data['user_list'] = $this->user_list;
	}
}
