<?php
//本api才用百度音乐api
//可以查看Public/readme.md
class IndexController extends Controller {

    private $listUrl = "http://tingapi.ting.baidu.com/v1/restserver/ting";
    private $downloadUrl = "http://music.baidu.com/data/music/fmlink";

    public function __construct(){

        parent::__construct();
    }
    public function indexAction() {
        $this->view->show();
    }
    //获取列表
    public function listAction() {
        $data = $_GET;
        $data = http($this->listUrl,$data);
        echo $data;die;
    }
    //歌曲url
    public function downloadAction() {
        $data = $_GET;
        $validate_params = array(
            'rate#int',
            'songIds#int',
        );
        $validate_data = $this->validate->check($validate_params, $data);
        $data = http($this->downloadUrl,$validate_data);
        echo $data;die;
    }
}
?>
