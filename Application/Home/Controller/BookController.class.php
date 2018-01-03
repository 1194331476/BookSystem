<?php
namespace Home\Controller;
use Think\Controller;
class BookController extends Controller {
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
        if(isset($_GET["bookname"])){
            $bookname = $_GET['bookname'];
        }
        // 获得总记录数
        $book = M("Book"); // 实例化Book对象
        $count = $book->where("bookname like'%".$bookname."%'")->count();
        // 获得数据集合
        $Model = new \Think\Model(); // 实例化一个model对象 没有对应任何数据表
        $start = ($page - 1) * $limit;
        $list = $Model->query("select * from Book where bookname like '%".$bookname."%' order by id limit " . $start . "," . $limit);
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
        $list = $Model->query("select * from Book order by id");
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
    public function toAdd(){
        $bookTypeList = M("booktype")->order("id asc")->select();
        $this->assign("bookTypeList",$bookTypeList);
        $this->display();
    }
    /**
     * 新增
     * */
    public function add(){
        $Book = M("Book"); // 实例化Book对象
        $data = file_get_contents("php://input");
        $data = json_decode($data,true);
        //根据用户名查询
        $list = M("Book")->where('barcode = "'.$data['barcode'].'"')->select();
        $result = array("success"=>"true","msg"=>"新增成功");
        if(count($list)>0){
            //用户名重复
            $result['success'] = 'false';
            $result['msg'] = '该书已存在';
        }else{
            $bookId = $Book->add($data);
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
        $Book = M("Book"); // 实例化Book对象
        $res = $Book->delete(rtrim($_POST['id'],',')); // 删除主键为1,2和5的用户数据
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
       $bookTypeList = M()->query("select bt.*,case when b.id IS NOT null then 'selected' else '' end as isType 
                                    from booktype bt 
                                    LEFT JOIN book b on bt.id=b.bookType and b.id=".$_GET["id"]." 
                                    order by id asc");
        $this->assign("bookTypeList",$bookTypeList);
        $book = M("Book")->where("id = ".$_GET["id"])->select();
        $this->assign('book',$book[0]);
        $this->display();
    }
    /**
     * 修改
     * */
    public function edit(){
        $result = array("success"=>"true","msg"=>"修改成功");
        $book = M("Book"); // 实例化Book对象
        $data = file_get_contents("php://input");
        $data = json_decode($data,true);
        $book->where('id = "'.$data['id'].'"')->save($data);
        echo json_encode($result);
    }
}