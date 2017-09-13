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
        $validate_params = array(
            'method#string'    => 'baidu.ting.billboard.billList',
            'type#int|required',
            'size#int' => 10,
            'offset#int'=> 0,
        );
        $validate_data = $this->validate->check($validate_params, $data);
        $data = http($this->listUrl,$validate_data);
        echo $data;die;
    }
    //搜索关键字
    public function searchAction() {
        $data = $_POST;
        $validate_params = array(
            'method#string' => 'baidu.ting.search.catalogSug',
            'query#string|required',
        );
        $validate_data = $this->validate->check($validate_params, $data);
        $data = http($this->listUrl,$validate_data);
        echo $data;die;
    }
    //LRC歌词
    public function lrcAction() {
        $data = $_GET;
        $validate_params = array(
            'method#string'    => 'baidu.ting.song.lry',
            'songid#int|required',
        );
        $validate_data = $this->validate->check($validate_params, $data);
        $data = http($this->listUrl,$validate_data);
        echo $data;die;
    }
    //推荐列表
    public function recommendAction() {
        $data = $_GET;
        $validate_params = array(
            'method#string'    => 'baidu.ting.song.getRecommandSongList',
            'song_id#int|required',
            'num#int' => 10,
        );
        $validate_data = $this->validate->check($validate_params, $data);
        $data = http($this->listUrl,$validate_data);
        echo $data;die;
    }
    //获取歌手信息
    public function singerInfoAction() {
        $data = $_GET;
        $validate_params = array(
            'method#string'    => 'baidu.ting.artist.getInfo',
            'tinguid#int|required',
        );
        $validate_data = $this->validate->check($validate_params, $data);
        $data = http($this->listUrl,$validate_data);
        echo $data;die;
    }
    //获取歌手信息
    public function singerSongAction() {
        $data = $_GET;
        $validate_params = array(
            'method#string'    => 'baidu.ting.artist.getSongList',
            'tinguid#int|required',
            'limits#int' => 10,
            'use_cluster#int' => 1,
            'order#int' => 2
        );
        $validate_data = $this->validate->check($validate_params, $data);
        $data = http($this->listUrl,$validate_data);
        echo $data;die;
    }
    //歌曲url
    public function downloadAction() {
        $data = $_GET;
        $validate_params = array(
            'rate#int|required',
            'songIds#int|required',
        );
        $validate_data = $this->validate->check($validate_params, $data);
        $data = http($this->downloadUrl,$validate_data);
        echo $data;die;
    }
}
?>
