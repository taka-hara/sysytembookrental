<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>System Book Rental</title>

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
    <!-- <link rel="stylesheet" href="bootstrap/css/bootstrap.css"> -->
    <link rel="stylesheet" href="css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <!-- <script src="js/vender/jquery-3.1.1.js"></script> -->
    <!-- <script src="bootstrap/js/bootstrap.js"></script> -->
</head>

<body>
    <header class="header">
        <div class="content">
            <h1>System Book Rental</h1>
            このページは、un-T Systemで所有している書籍（技術書など）の共有を目的としています。
        </div>
    </header>
    <div class="content">
        <hr class="hr">
    </div>

    <div class="content">
        {% if message != '' %}
            <div class="alert alert-success" role="alert">
            <span class="glyphicon glyphicon-check" aria-hidden="true"></span>
            <span class="sr-only">Message:</span>
                &nbsp;&nbsp;{{ message }}
            </div>
        {% endif %}
    </div>

    <div class="content">
        <a href="#book_add" class="btn btn-primary" role="button">書籍追加へ</a>
        <!-- <a href="#book_delete" class="btn btn-info" role="button">書籍削除へ</a> -->
    </div>

    <div class="content">
        <h2>■&nbsp;書籍一覧・レンタル</h2>
        <div class='description'>
            書籍を借りたい場合、借りたい書籍の行で自分の名前を選択し、「借りる」ボタン押下で借りることができます。
            貸出日・返却予定日は、現時点から1週間の日付が自動的に設定されます。<br>
            書籍を返す場合、返す書籍の行にある「返す」ボタンを押下で返すことができます。<mark>（書籍は責任をもって所有者に返すこと）</mark><br>
        </div>
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
                {% for book in book_list %}
                    <tr>
                        <td class="text-center td_v_ali_mid">{{ book.id }}</th>
                        <td class="text-center td_v_ali_mid{% if book.rental_status == 1 %} bg_red{% endif %}">
                            {% if book.rental_status == 0 %}
                                貸出可
                            {% elseif book.rental_status == 1 %}
                                貸出中
                            {% endif %}
                        </th>
                        <td class="td_v_ali_mid">{{ book.book_name }}</th>
                        <td class="td_v_ali_mid">{{ book.writer }}</th>
                        <td class="td_v_ali_mid">{{ book.genre }}</th>
                        <td class="td_v_ali_mid">{{ book.version }}</th>
                        <td class="td_v_ali_mid">{{ book.issued_years }}</th>
                        <td class="text-center td_v_ali_mid">{{ book.owner }}</th>
                        <td class="text-center td_v_ali_mid">{{ book.user }}</th>
                        <td class="text-center td_v_ali_mid">{{ book.rent_date }}</th>
                        <td class="text-center td_v_ali_mid">{{ book.return_date }}</th>
                        <td class="text-center td_v_ali_mid">
                            <form action="" method="post" class="form-horizontal">
                                {% if book.rental_status == 0 %}
                                    <div class="form-inline">
                                        <select class="form-control" name="row_user" >
                                            {% for user in user_list %}
                                                <option value="{{ user }}">{{ user }}</option>
                                            {% endfor %}
                                        </select>
                                        <button class="btn btn-primary" name="action" value="rent">
                                            借りる
                                        </button>
                                    </div>
                                {% elseif book.rental_status == 1 %}
                                    <button class="btn btn-danger" name="action" value="return">
                                        返す
                                    </button>
                                {% endif %}
                                <input type="hidden" name="row_id" value="{{ book.id }}" />
                                <input type="hidden" name="book_isbn_" value="{{ book.isbn }}" />
                                <input type="hidden" name="book_owner" value="{{ book.owner }}" />
                                <input type="hidden" name="book_name" value="{{ book.book_name }}" />
                            </form>
                        </td>
                    </tr>
                {% endfor %}
            </tbody>
        </table>
    </div>
    <br>
    <div class="content">
        <h2 id="book_add">■&nbsp;書籍追加</h2>
        <div class='description'>
            追加したい書籍の情報と所有者を入力し、「追加」ボタン押下でリストに書籍が追加されます。(*)の項目は必須です。<br>
            ISBN(書籍のバーコードの下10桁か13桁の数字、ハイフン無し)を入力し「ISBN検索」ボタン押下で、書籍の情報が自動的に入力されます。
        </div>
<!--         <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                    <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            書籍追加フォーム(ここをクリックで開閉します)
                        </a>
                    </h4>
                </div>
                <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                    <div class="panel-body"> -->

                        {% if error_messages  %}
                            <div class="alert alert-danger" role="alert">
                                <span class="sr-only">Error:</span>
                                {% for error_message in error_messages %}
                                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                    &nbsp;&nbsp;{{ error_message }}<br>
                                {% endfor %}
                            </div>
                        {% endif %}
                        <form action="" method="post" class="form-horizontal">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-xs-1 text-right">
                                        <label class="control-label">ISBN(*)</label>
                                    </div>
                                    <div class="col-xs-2">
                                        <input type="text" name="isbn" class="form-control" value="{{ post_data.isbn }}" />
                                    </div>
                                    <button class="btn btn-primary" name="action" value="search">
                                        <span class="glyphicon glyphicon-search"></span> &nbsp;ISBN検索
                                    </button>
                                    <label>(ハイフン無し)</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-xs-1 text-right">
                                        <label class="control-label">書籍名(*)</label>
                                    </div>
                                    <div class="col-xs-4">
                                        <input type="text" name="bookname" class="form-control" value="{{ post_data.bookname }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-xs-1 text-right">
                                        <label class="control-label">著者(*)</label>
                                    </div>
                                    <div class="col-xs-4">
                                        <input type="text" name="writer" class="form-control" value="{{ post_data.writer }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-xs-1 text-right">
                                        <label class="control-label">ジャンル</label>
                                    </div>
                                    <div class="col-xs-4">
                                        <input type="text" name="genre" class="form-control" value="{{ post_data.genre }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-xs-1 text-right">
                                        <label class="control-label">版数</label>
                                    </div>
                                    <div class="col-xs-4">
                                        <input type="text" name="version" class="form-control" value="{{ post_data.version }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-xs-1 text-right">
                                        <label class="control-label">発行年</label>
                                    </div>
                                    <div class="col-xs-4">
                                        <input type="text" name="issued_years" class="form-control " value="{{ post_data.issued_years }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-xs-1 text-right">
                                        <label class="control-label">所有者(*)</label>
                                    </div>
                                    <div class="col-xs-1">
                                        <select class="form-control" name="owner" >
                                            {% for user in user_list %}
                                                <option value="{{ user }}">{{ user }}</option>
                                            {% endfor %}
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="add">
                                <button class="btn btn-primary" name="action" value="add">
                                    <span class="glyphicon glyphicon-plus"></span> &nbsp;追加
                                </button>
                            </div>
                        </form>
                    </div>
                <!-- </div>
            </div>
        </div> -->
    </div>
    <br>
    <div class="content">
        <h2 id="book_delete">■&nbsp;書籍削除</h2>
        <div class='description'>
            リストから書籍を削除する場合は、削除したい書籍のIDを選択し、「削除」ボタンを押下で削除できます。<mark>削除は取り消せず、確認もされないので注意してください。</mark><br>
        </div>
        <form action="" method="post" class="form-horizontal">
            <div class="form-inline delete">

                <select class="form-control" name="delete_id" >
                    {% for id in id_list %}
                        <option value="{{id}}">{{ id }}</option>
                    {% endfor %}
                </select>
                <button class="btn btn-danger" name="action" value="delete">
                    <span class="glyphicon glyphicon-trash"></span>&nbsp;削除
                </button>
            </div>
        </form>
    </div>
    <div class="content">
        <hr class="hr">
    </div>
    <footer class="footer">
        <div class="content">
            <p class="text-muted">Copyright &copy;2017 un-T System Co.Ltd All Rights Reserved.</p>
        </div>
    </footer>
</body>
</html>