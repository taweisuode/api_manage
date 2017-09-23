<?php
error_reporting(E_ALL ^ E_NOTICE);
class RecommendImageModel extends Model
{
    protected $_tablename = 'img_recommend';

    public function __CONSTRUCT() {
        $config = $this->loadDataConfig('music_api');
        parent::__CONSTRUCT($config);
    }

    public function getList() {
        $this->db->select("*");
        $this->db->from($this->_tablename);
        $select  = $this->db->orderby("sort","desc")->limit(6);
        $result = $select->fetchAll();
        return $result;

    }
    //详细
    public function get_detail($id) {
        $this->db->select("*");
        $this->db->from($this->_tablename);
        $select = $this->db->where(array("id"=>$id));
        $result = $select->fetchRow();
        return $result;
    }
}
?>
