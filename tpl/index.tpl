<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>System Book Rental</title>

	<link rel="stylesheet" href="bootstrap/css/bootstrap.css">
	<link rel="stylesheet" href="css/style.css">
	<script src="js/vender/jquery-3.1.1.js"></script>
	<script src="bootstrap/js/bootstrap.js"></script>
</head>

<body>
	<header class="header">
		<div class="container">
			<h1>System Book Rental</h1>
			このページは、un-T Systemで所有している技術書の共有を目的としています。
			会社・個人所有の書籍の所在、貸し借りの可否含めて共有して行ければよいと思います！
		</div>
	</header>
	<div class="container">
		<hr class="hr">
	</div>
	<div class="container">
		<h2>書籍一覧</h2>
		<!-- 書籍一覧表 -->
		<table class="table table-striped table-bordered">
			<thead>
				<tr>
					<th class="text-center">ID</th>
					<th class="text-center">ステータス</th>
					<th class="text-center">書籍名</th>
					<th class="text-center">著者</th>
					<th class="text-center">ジャンル</th>
					<th class="text-center">版数</th>
					<th class="text-center">発行年</th>
					<th class="text-center">所有者</th>
					<th class="text-center">利用者</th>
					<th class="text-center">貸出日</th>
					<th class="text-center">返却予定日</th>
					<th class="text-center">レンタル</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="text-center td_v_ali_mid">1</th>
					<td class="text-center td_v_ali_mid">貸出可</th>
					<td class="td_v_ali_mid">MySQL徹底入門 : 5.5新機能対応</th>
					<td class="td_v_ali_mid">日本MySQLユーザ会</th>
					<td class="td_v_ali_mid">データベース</th>
					<td class="td_v_ali_mid">第3版</th>
					<td class="td_v_ali_mid">2011</th>
					<td class="text-center td_v_ali_mid">原</th>
					<td class="text-center td_v_ali_mid"></th>
					<td class="text-center td_v_ali_mid">2017/2/3</th>
					<td class="text-center td_v_ali_mid">2017/2/10</th>
					<td class="text-center td_v_ali_mid">
						<form action="" method="post" class="form-inline">
							<button class="btn btn-default" name="action" value="rent">
								借りる
							</button>
							<!-- <button class="btn btn-default" name="action" value="return">
								返す
							</button> -->
							<input type="hidden" name="col_val" value="1" />
						</form>
					</td>
				</tr>
			</tbody>
		</table>
	</div>

	<div class="container">
		<h2>書籍追加</h2>
		{% if post_data.error_mes != '' %}
			<div class="alert alert-danger" role="alert">
				<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
				<span class="sr-only">Error:</span>
				{{ post_data.error_mes }}
			</div>
		{% endif %}
		<form action="" method="post" class="form-horizontal">
			<div class="form-inline">
				<input type="text" name="isbn" class="form-control" value="{{ post_data.isbn }}" />
				<button class="btn btn-default" name="action" value="search">
					<span class="glyphicon glyphicon-search"></span> ISBN検索
				</button>

			</div>
			<br>
			<div class="form-group">
				<div class="row">
					<div class="col-xs-1 text-right">
						<label class="control-label">書籍名</label>
					</div>
					<div class="col-xs-4">
						<input type="text" name="bookname" class="form-control input-sm" value="{{ post_data.bookname }}">
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<div class="col-xs-1 text-right">
						<label class="control-label">著者</label>
					</div>
					<div class="col-xs-4">
						<input type="text" name="writer" class="form-control input-sm" value="{{ post_data.writer }}">
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<div class="col-xs-1 text-right">
						<label class="control-label">ジャンル</label>
					</div>
					<div class="col-xs-4">
						<input type="text" name="genre" class="form-control input-sm" value="{{ post_data.genre }}">
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<div class="col-xs-1 text-right">
						<label class="control-label">版数</label>
					</div>
					<div class="col-xs-4">
						<input type="text" name="version" class="form-control input-sm" value="{{ post_data.version }}">
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<div class="col-xs-1 text-right">
						<label class="control-label">発行年</label>
					</div>
					<div class="col-xs-4">
						<input type="text" name="issued_years" class="form-control input-sm" value="{{ post_data.issued_years }}">
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<div class="col-xs-1 text-right">
						<label class="control-label">所有者</label>
					</div>
					<div class="col-xs-2">
						<select class="form-control" name="delete_id" >
							<option value="1">原</option>
							<option value="2">hoge</option>
							<option value="3">fuga</option>
						</select>
					</div>
				</div>
			</div>
			<button class="btn btn-default" name="action" value="add">
				<span class="glyphicon glyphicon-plus"></span> 書籍追加
			</button>

		</form>
	</div>

	<div class="container">
		<h2>書籍削除</h2>
		削除したい書籍のIDを選択してください。
		<form action="" method="post" class="form-horizontal">
			<div class="form-inline">
				<select class="form-control" name="delete_id" >
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
				</select>
				<button class="btn btn-default" name="action" value="delete">
					<span class="glyphicon glyphicon-trash"></span> 削除
				</button>
			</div>
		</form>
	</div>
	<div class="container">
		<hr class="hr">
	</div>
	<footer class="footer">
		<div class="container">
			<p class="text-muted">Copyright &copy;2017 un-T System Co.Ltd All Rights Reserved.</p>
		</div>
	</footer>
</body>
</html>