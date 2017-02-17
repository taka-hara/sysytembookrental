<?php

require_once 'application.php';

require_once MDL_DIR . '/isbnSearch.php';
require_once MDL_DIR . '/validator.php';
require_once MDL_DIR . '/database.php';

class SystemBookRental extends Application{

    private $default_template = 'index';
    private $db;

    private $rules = array(
        'isbn' => array('require' => true, 'number' => true),
        'bookname' => array('require' => true),
        'writer' => array('require' => true),
        // 'genre' => array(),
        // 'version' => array(),
        // 'issued_years' => array(),
        'owner' => array('require' => true),
    );

    private $error_messages = array(
        'isbn' => array(
            'require' => '※ISBNを入力してください。',
            'number' => '※ISBNは数値で入力してください。'
        ),
        'bookname' => array('require' => '※書籍名を入力してください。'),
        'writer' => array('require' => '※著者を入力してください。'),
        // 'genre' => array(),
        // 'version' => array(),
        // 'issued_years' => array(),
        'owner' => array('require' => '※所有者を選択してください。'),
    );

    private $user_list = array(
        '',
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

    public function __construct()
    {
        parent::__construct();
        $this->template = $this->default_template;
        $this->db = Database::getInstance();
        $this->listLoad();
    }

    protected function indexAction()
    {
        $this->template = 'index';
    }

    protected function searchAction()
    {
        $isbn = isset($_POST['isbn']) ? $this->h($_POST['isbn']) : '';

        $isbn_search = new isbnSearch();
        $result = $isbn_search->search($isbn);
        $this->data['post_data'] = $result;
        if($result['error_message'] != ''){
            $this->data['error_messages'] = array($result['error_message']);
        }
        $this->data['post_data']['isbn'] = $isbn;
        $this->template = 'index';
    }

    protected function addAction()
    {
        // フォームの入力内容確認
        // isbn一致確認
        $post = isset($_POST) ? $this->h($_POST) : array();

        $this->data['post_data'] = $post;

        if ($this->validate('post_data')) {
            $this->db->addBook($post);
            $this->data['message'] = $post['bookname'] .'を追加しました。';
        }
        $this->listLoad();
        $this->template = 'index';
    }

    protected function deleteAction()
    {
        // 指定された書籍のIDの本を本当に削除してい良いか確認
        // 状態によって場合分け（貸出中など）
        $id = isset($_POST['delete_id']) ? $this->h($_POST['delete_id']) : NULL;

        if(!is_null($id)){
            $this->db->deleteBook($id);
        }
        $this->data['message'] = '[ID:' . $id .']の本を削除しました。';
        $this->listLoad();
        $this->template = 'index';
    }

    protected function rentAction()
    {
        $id = isset($_POST['row_id']) ? $this->h($_POST['row_id']) : NULL;
        $status = '1';
        $user = isset($_POST['row_user']) ? $this->h($_POST['row_user']) : NULL;

        $this->db->bookRental($id, $status, $user);

        $bookname = isset($_POST['book_name']) ? $this->h($_POST['book_name']) : NULL;
        $owner = isset($_POST['book_owner']) ? $this->h($_POST['book_owner']) : NULL;
        $this->data['message'] = $owner . 'さんの本「' . $bookname . '」を借りました。';

        $this->listLoad();
        $this->template = 'index';
    }

    protected function returnAction()
    {
        $id = isset($_POST['row_id']) ? $this->h($_POST['row_id']) : NULL;
        $status = '0';

        $this->db->bookRental($id, $status);

        $owner = isset($_POST['book_owner']) ? $this->h($_POST['book_owner']) : NULL;
        $bookname = isset($_POST['book_name']) ? $this->h($_POST['book_name']) : NULL;
        $this->data['message'] = $owner . 'さんの本 「' . $bookname . '」 を返しました。';

        $this->listLoad();
        $this->template = 'index';
    }

    private function getBookList()
    {
        $book_list;
        return $book_list;
    }

    private function listLoad()
    {
        $id_list = array();

        $this->data['book_list'] = $this->db->getListAll();

        foreach ($this->data['book_list'] as $book) {
            $id_list[] = $book['id'];
        }
        $this->data['id_list'] = $id_list;
        $this->data['user_list'] = $this->user_list;
    }

    private function validate($key)
    {
        $errors = array();
        $error_messages = array();
        $class_attributes = array();

        $validator = new Validator();

        $validator->validate($this->data[$key], $this->rules, $this->error_messages);

        $errors = $validator->getErrors();
        $error_messages = $validator->getErrorMessages();

        $this->data['errors'] = $errors;
        $this->data['error_messages'] = $error_messages;

        return empty($errors);
    }
}
