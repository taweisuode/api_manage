<?php
/**
 *   控制器基类Controller
 *   所有的控制器都继承于他
 *   构造方法中需要实例化View类，并加载所有的该module下面的model.php文件
 */
class Controller
{
    private $loadException  = "FrameException";
    protected $validate;
    private $hasException   = false;
    protected $view;
    public static $session = array();
    public function __CONSTRUCT()
    {

        //默认导入异常类,验证类以及公共方法
        $loadArr = array('Exception/'.$this->loadException,'Common/Validate','Common/Function','Common/ErrorCode');
        $this->load($loadArr);
        $this->validate = new Validate();
        //设置异常处理函数
        restore_exception_handler();
        set_exception_handler(array($this,"setExceptionHandler"));

        session_start();
        if(!empty($_SESSION)) {
            self::$session = $_SESSION;

        }

        $this->view = new View();

    }
    public function setExceptionHandler(Throwable $e = null) {
        $this->hasException = true;
        if(strpos($_SERVER['HTTP_HOST'],'api') !== false) {
            $this->showExceptionApi($e);
        }
        $this->ShowExceptionHtml($e);

    }

    /**
     * @desc 显示错误信息
     */
    private function ShowExceptionHtml(Throwable $e = null) {
        $html = <<< HTML
        <pre class="alert alert-danger" style="color:#a94442;background-color: #f2dede;border-color: #ebccd1;font-size: 15px">
        <h2 class="error-danger" style="text-align:center">出错了</h2>
        错误描述: {$e->getMessage()}<br>
        文件位置: {$e->getFile()}第{$e->getLine()}行<br>
        信息栈:<br><br><div style="padding-left: 72px">{$e->getTraceAsString()}</div>
HTML;
        echo $html;die;
    }
    public function showError($msg, $code = -1) {
        $code   = $msg->getCode();
        $desc   = $msg->getMessage();
        $return = array(
            'e' =>  array(
                'code'  => $code,
                'desc'  => $desc
            )
        );
        echo json_encode($return);die;

    }
    public function showExceptionApi(Throwable $e = null) {
        $code   = $e->getCode();
        $desc   = $e->getMessage();
        $return = array(
            'e' =>  array(
                'code'  => $code,
                'desc'  => $desc
            )
        );
        echo json_encode($return);die;

    }
    public function showApiResult($data = array(),$code = 0,$desc = "") {
        $return = array(
            'e' =>  array(
                'code'  => $code,
                'desc'  => $desc
            ),
            'data' => $data
        );
        echo json_encode($return);die;

    }
    public function load($path) {
        if(is_array($path)) {
            foreach($path as $key => $val) {
                $this->load($val);
            }
        }else {
            require_once(PPF_PATH.'/Library/'.$path.".php");
        }
    }
    public function connectDb($type) {
        $db = "";
        switch ($type) {
            case 'redis':
                $this->load("Database/Redis_Abstract");
                $db = Redis_Abstract::Db_init();
                break;
        }
        return $db;
    }
}
?>
