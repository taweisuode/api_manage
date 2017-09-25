<?php
//本api采用百度音乐api
//可以查看Public/readme.md
class MainController extends Controller {

    public function __construct(){

        parent::__construct();
        $this->recommendImageModel = new RecommendImageModel();
    }
    public function indexAction() {
        $this->view->show();
    }
    //获取首页推荐页面轮播图列表
    public function recommendImageAction() {
        $data = $_GET;
        $validate_params = array(
            'type#int|required'    => 1,
        );
        $validate_data = $this->validate->check($validate_params, $data);
        $list = $this->recommendImageModel->getList();
        foreach($list as $key => $val) {
            $list[$key]['img_url'] = WEBSITE_HOST."Public/Files/Upload/".$val['img_url'];
        }
        return $this->showApiResult($list);
    }
    //首页推荐歌单展示页接口
    public function recommendSongAction() {
        $randomKeyArr = ["90后","情歌","午后","摇滚","rap","失恋"];
        shuffle($randomKeyArr);
        $url = "http://music.baidu.com/data/search/playlist";
        $returnResult = array();
        foreach($randomKeyArr as $key => $val) {
            $data = json_decode(http($url,array('tag'=>$randomKeyArr[$key])),true);
            $random = rand(0,5);
            $list = $data['list'][$random];
            $returnResult[$key]['playlist_id']  = $list['playlist_id'];
            $returnResult[$key]['title']        = $list['title'];
            if($list['listen_count'] > 10000) {
                $returnResult[$key]['listen_count'] = intval($list['listen_count']/10000)."万";
            }else {
                $returnResult[$key]['listen_count'] = $list['listen_count'];
            }
            $returnResult[$key]['song_list']    = $list['song_list'];
            $returnResult[$key]['thumb']        = $list['thumb'];
        }
        return $this->showApiResult($returnResult);
    }
    //首页推荐歌单列表页接口
    public function recommendSongListAction() {
        $data = $_GET;
        $validate_params = array(
            'playlist_id#int|required',
        );
        $validate_data = $this->validate->check($validate_params, $data);
        $url = "http://tingapi.ting.baidu.com/v1/restserver/ting?from=android&format=json&method=baidu.ting.diy.gedanInfo&listid=".$validate_data['playlist_id'];
        $data = json_decode(http($url),true);
        $result['listid'] = $data['listid'];
        $result['title'] = $data['title'];
        $result['thumb'] = $data['pic_300'];
        $result['listenum'] = $data['listenum'];
        $result['tag'] = $data['tag'];
        $result['desc'] = $data['desc'];
        foreach($data['content'] as $key => $val) {
            $result['list'][$key]['title'] = $val['title'];
            $result['list'][$key]['song_id'] = $val['song_id'];
            $result['list'][$key]['author'] = $val['author'];
            $result['list'][$key]['album_id'] = $val['album_id'];
            $result['list'][$key]['album_title'] = $val['album_title'];
            $result['list'][$key]['all_artist_id'] = $val['all_artist_id'];
        }
        return $this->showApiResult($result);
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
    //歌曲播放信息
    public function playAction() {
        $data = $_GET;
        $validate_params = array(
            'method#string'    => 'baidu.ting.song.play',
            'songid#int|required',
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
    //歌手专辑信息
    public function albumAction() {
        $data = $_GET;
        $validate_params = array(
            'from#string'       => 'android',
            'version#string'    => '5.6.5.0',
            'method#string'     => 'baidu.ting.album.getAlbumInfo',
            'format#string'     => 'json',
            'album_id#int|required'
        );
        $validate_data = $this->validate->check($validate_params, $data);
        $data = http($this->listUrl,$validate_data);
        echo $data;die;
    }
}
?>
