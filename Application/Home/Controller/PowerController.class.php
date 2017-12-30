<?php
namespace Home\Controller;
use Think\Controller;
class PowerController extends Controller {
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
        $powername = "";
        if(isset($_GET["powername"])){
            $powername = $_GET['powername'];
        }
        // 获得总记录数
        $power = M("power"); // 实例化power对象
        $count = $power->where("powername like'%".$powername."%'")->count();
        // 获得数据集合
        $Model = new \Think\Model(); // 实例化一个model对象 没有对应任何数据表
        $start = ($page - 1) * $limit;
        $list = $Model->query("select p1.*,p2.powername parentname from power p1 left join power p2 on p1.parentid = p2.id where p1.powername like '%".$powername."%' order by p1.id limit " . $start . "," . $limit);
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
        $list = $Model->query("select * from power order by id");
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
        $powerList = M("power")->where("parentid = 0")->select();
        $this->assign("powerList",$powerList);
        $this->display();
    }
    /**
     * 新增
     * */
    public function add(){
        $power = M("power"); // 实例化power对象
        $data = file_get_contents("php://input");
        $data = json_decode($data,true);
        //根据用户名查询
        $power->add($data);
        $result = array("success"=>"true","msg"=>"新增成功");
        echo json_encode($result);
    }
    /**
     * 删除
     * */
    public function del(){
        $data = file_get_contents("php://input");
        $data = json_decode($data,true);
        //根据用户名查询
        $power = M("power"); // 实例化power对象
        $res = $power->delete(rtrim($_POST['id'],',')); // 删除主键为1,2和5的用户数据
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
        $power = M("power")->where("id = ".$_GET["id"])->select();
        $this->assign('power',$power[0]);
        $powerList = M("power")->where("parentid = 0")->select();
        $this->assign("powerList",$powerList);
        $this->display();
    }
    /**
     * 修改
     * */
    public function edit(){
        $power = M("power"); // 实例化power对象
        $data = file_get_contents("php://input");
        $data = json_decode($data,true);
        $res = $power->where('id = "'.$data['id'].'"')->save($data);
        $result = array("success"=>"true","msg"=>"修改成功");
        if($res==0){
            $result = array("success"=>"false","msg"=>"修改失败");
        }
        echo json_encode($result);
    }
}