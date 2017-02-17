<?php

require_once VENDOR_DIR . '/Twig/Autoloader.php';

class Application
{
    protected $data = array();
    protected $template;

    private $twig_loader;
    private $twig;

    public function __construct() {
        Twig_Autoloader::register();
        $this->twig_loader = new Twig_Loader_Filesystem(TPL_DIR);
        $this->twig = new Twig_Environment($this->twig_loader, array('cache' => false));
    }

    public function dispatch()
    {
        $action = isset($_POST['action']) ? $_POST['action'] : '';

        // 初期表示
        if($action == ''){
            $action = 'index';
        }

        // アクション実行
        $actionMethod = $action . 'Action';
        $this->$actionMethod();

        // 画面出力
        $this->output();
    }

    /*
     * HTMLエスケープ
     */
    public function h($string)
    {
        if (is_array($string)) {
            return array_map(array($this,'h'), $string);
        } else {
            return htmlspecialchars($string, ENT_QUOTES);
        }
    }

    /*
     * リダイレクト
     */
    private function redirect($url)
    {
        $this->redirect_url = $url;
    }

    private function output()
    {
        $page = $this->template . '.twig.tpl';
        $tmp = $this->twig->load($page);
        echo $tmp->render($this->data);

        if(DEBUG) {
            echo '<br><pre>';
            var_dump($this->data);
            echo '</pre><br>';
        }
    }
}