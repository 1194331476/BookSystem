<?php
namespace Home\Controller;
use Think\Controller;
class BookTypeController extends Controller {
    /**
     * 跳转列表页
     * */
    public function listPage(){
      $this->display();
    }
    /**
     * 分页
     * */
    public function getPageList(){
        $page = $_GET['page']; // 获取get变量
        $limit = $_GET['limit']; // 获取get变量
        $truename = "";
        if(isset($_GET["bookTypeName"])){
            $bookTypeName = $_GET['bookTypeName'];
        }
        // 获得总记录数
        $bookType = M("booktype"); // 实例化BookType对象
        $count = $bookType->where("bookTypeName like'%".$bookTypeName."%'")->count();
        // 获得数据集合
        $Model = new \Think\Model(); // 实例化一个model对象 没有对应任何数据表
        $start = ($page - 1) * $limit;
        $list = $Model->query("select * from bookType where BookTypename like '%".$bookTypeName."%' order by id limit " . $start . "," . $limit);
        $json_string = json_encode($list, JSON_UNESCAPED_UNICODE);
        $res = '{
            "code": 0,
            "msg": "",
            "count": ' . $count . ',
            "data": ' . $json_string . '
        }';
        echo $res;
    }
    /**
     * 获得全部集合
     * */
    public function getAllList(){
        $Model = new \Think\Model(); // 实例化一个model对象 没有对应任何数据表
        $list = $Model->query("select * from BookType order by id");
        $json_string = json_encode($list, JSON_UNESCAPED_UNICODE);
        $res = '{
            "code": 0,
            "msg": "",
            "data": ' . $json_string . '
        }';
        echo $res;
    }
    /**
     * 跳转新增页面
     * */
    /* public function toAdd(){
        $BookTypeTypeList = M("BookTypetype")->order("id asc")->select();
        $this->assign("BookTypeTypeList",$BookTypeTypeList);
        $this->display();
    } */
    /**
     * 新增
     * */
    public function add(){
        $bookType = M("booktype"); // 实例化BookType对象
        $data = file_get_contents("php://input");
        $data = json_decode($data,true);
        //根据用户名查询
        $list = M("booktype")->where('bookTypeName = "'.$_POST['bookTypeName'].'"')->select();
        $result = array("success"=>"true","msg"=>"新增成功");
        if(count($list)>0){
            //用户名重复
            $result['success'] = 'false';
            $result['msg'] = '类名已存在';
        }else{
            $data['bookTypeName'] = $_POST['bookTypeName'];
            $bookTypeId = $bookType->add($data);
        }
        echo json_encode($result);
    }
    /**
     * 删除
     * */
    public function del(){
        $data = file_get_contents("php://input");
        $data = json_decode($data,true);
        //根据用户名查询
        $bookType = M("booktype"); // 实例化BookType对象
        $res = $bookType->delete(rtrim($_POST['id'],',')); // 删除主键为1,2和5的用户数据
        trace($res,'$res');
        $result = array("success"=>"true","msg"=>"删除成功");
        if($res>0){
            //用户名重复
            $result = array("success"=>"true","msg"=>"删除成功！");
        }else{
            $result = array("success"=>"false","msg"=>"删除失败！");
        }
        echo json_encode($result);
    }
    /**
     * 跳转编辑页面
     * */
    public function toEdit(){
       $BookTypeTypeList = M()->query("select bt.*,case when b.id IS NOT null then 'selected' else '' end as isType 
                                    from BookTypetype bt 
                                    LEFT JOIN BookType b on bt.id=b.BookTypeType and b.id=".$_GET["id"]." 
                                    order by id asc");
        $this->assign("BookTypeTypeList",$BookTypeTypeList);
        $BookType = M("BookType")->where("id = ".$_GET["id"])->select();
        $this->assign('BookType',$BookType[0]);
        $this->display();
    }
    /**
     * 修改
     * */
    public function edit(){
        $result = array("success"=>"true","msg"=>"修改成功");
        $BookType = M("BookType"); // 实例化BookType对象
        $data = file_get_contents("php://input");
        $data = json_decode($data,true);
        $BookType->where('id = "'.$data['id'].'"')->save($data);
        echo json_encode($result);
    }
}