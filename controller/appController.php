<?php

require_once 'application.php';

require_once '/model/isbnSearch.php';
require_once '/model/validator.php';

class appController extends Application{

	private $default_template = 'index';


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
	}

	protected function indexAction() {
		// 書籍一覧取得
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
		$this->template = 'index';
	}

	protected function deleteAction() {
		// 指定された書籍のIDの本を本当に削除してい良いか確認
		// 状態によって場合分け（貸出中など）
		$this->template = 'index';
	}

	protected function rentAction() {
		$this->template = 'index';
	}

	protected function returnAction() {
		$this->template = 'index';
	}

	private function getBookList() {
		$book_list;

		return $book_list;
	}

	private function validate() {
		$validator = new Validator();
	}
}
