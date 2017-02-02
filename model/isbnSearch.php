<?php

class isbnSearch {

	private $isbn;
	private $item;
	private $result = array(
		'bookname' => '',
		'writer' => '',
		'genre' => '',
		'version' => '',
		'issued_years' => '',
		'error_mes' => ''
	);

	public function __construct() {
	}

	public function search($isbn) {

		$this->isbn = $isbn;

		$url = 'http://iss.ndl.go.jp/api/opensearch?isbn=';
		$search_url = $url . $this->isbn;

		if($this->isbnCheck()){
			$result_rss = simplexml_load_file($search_url);
			if(!is_null($result_rss->channel->item[0])) {
				//検索結果に書籍情報が含まれている時書籍情報を表示
				$this->item = $result_rss->channel->item[0];
				$this->setResult();
			} else {
				$this->result['error_mes'] = '検索結果がありません。';
				return $this->result;
			}
		}
		return $this->result;
	}

	private function isbnCheck() {

		//ISBNが空でないか
		if($this->isbn === '') {
			$this->result['error_mes'] = 'ISBNを入力してください。';
			return false;
		}
		//ISBNが数値か
		if(!preg_match("/^[0-9]+$/",$this->isbn)) {
			$this->result['error_mes'] = 'ISBNは半角数字で入力してください。';
			return false;
		}
		//入力されたISBNの長さを取得
		$isbn_length = strlen($this->isbn);
		//ISBNが10桁、13桁か
		if((($isbn_length != 13) && ($isbn_length != 10))) {
			$this->result['error_mes'] = 'ISBNは10桁もしくは13桁で入力してください。';
			return false;
		}
		return true;
	}

	private function setResult() {

		$this->result['bookname'] = (string)$this->item->children('dc', true)->title;			//書籍名
		$this->result['writer'] = (string)$this->item->children('dc', true)->creator;		//著者
		$this->result['genre'] = (string)$this->item->children('dc', true)->subject;		//大ジャンル
		$this->result['version'] = (string)$this->item->children('dcndl', true)->edition;	//版数（検索結果に含まれていない場合初版）
		$this->result['issued_years'] = (string)$this->item->children('dcterms', true)->issued;	//初版の発行年
	}

	public function getIsbn() {

		return $this->isbn;
	}
}
