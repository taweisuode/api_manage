<?php
//本api才用百度音乐api
//可以查看Public/readme.md
class IndexController extends Controller {

    private $listUrl = "http://tingapi.ting.baidu.com/v1/restserver/ting";
    public function indexAction() {
        $this->view->show();
    }
    //获取列表
    public function listAction() {
        $data = $_GET;
        $this->load('Common/Function');
        $data = http($this->listUrl,$data);
        echo $data;die;
    }
}
?>
