<?php
class Data {

	private $user = array(
		1 => '原',
		2 => 'hoge',
		3 => 'fuga',
		4 => 'piyo',
		5 => 'foo',
	);

	private $list_column = array(
		'id' => 'ID',
		'rental_status' => 'ステータス',
		'book_name' => '書籍名',
		'writer' => '著者',
		'genre' => 'ジャンル',
		'version' => '版数',
		'issued_years' => '発行年',
		'owner' => '所有者',
		'user' => '利用者',
		'rent_date' => '貸出日',
		'retun_date' => '返却予定日',
		'rental' => 'レンタル',
	);

	public function getUser(){
		return $user;
	}

	public function getListColum() {
		return $list_column;
	}

}