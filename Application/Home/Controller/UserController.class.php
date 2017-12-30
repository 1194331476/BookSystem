<?php
namespace Home\Controller;
use Think\Controller;
class UserController extends Controller {
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
        if(isset($_GET["truename"])){
            $truename = $_GET['truename'];
        }
        // 获得总记录数
        $User = M("User"); // 实例化User对象
        $count = $User->where("truename like'%".$truename."%'")->count();
        // 获得数据集合
        $Model = new \Think\Model(); // 实例化一个model对象 没有对应任何数据表
        $start = ($page - 1) * $limit;
        $list = $Model->query("select * from User where trueName like '%".$truename."%' order by id limit " . $start . "," . $limit);
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
        $list = $Model->query("select * from User order by id");
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
        $roleList = M("role")->order("id desc")->select();
        $this->assign("roleList",$roleList);
        $this->display();
    }
    /**
     * 新增
     * */
    public function add(){
        $User = M("User"); // 实例化User对象
        $data = file_get_contents("php://input");
        $data = json_decode($data,true);
        //根据用户名查询
        $list = M("User")->where('username = "'.$data['userName'].'"')->select();
        $result = array("success"=>"true","msg"=>"新增成功");
        if(count($list)>0){
            //用户名重复
            $result['success'] = 'false';
            $result['msg'] = '用户名已存在';
        }else{
            $userId = $User->add($data);
            //遍历提交的表单，取出角色字段，新增映射关系
            foreach ($data as $key => $value) {
                if(strpos($key, "roleId") === 0){
                    //是角色字段，新增用户角色映射关系
                    M("userandrole")->add(array("userId"=>$userId,"roleId"=>$value));
                }
            }
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
        $User = M("User"); // 实例化User对象
        $res = $User->delete(rtrim($_POST['id'],',')); // 删除主键为1,2和5的用户数据
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
        $roleList = M()->query('select r.*,ur.userId from role r LEFT JOIN userandrole ur on ur.roleId = r.id and ur.userId = '.$_GET["id"]." order by id asc");
        $this->assign("roleList",$roleList);
        $user = M("user")->where("id = ".$_GET["id"])->select();
        $this->assign('user',$user[0]);
        $this->display();
    }
    /**
     * 修改
     * */
    public function edit(){
        $result = array("success"=>"true","msg"=>"修改成功");
        $User = M("User"); // 实例化User对象
        $data = file_get_contents("php://input");
        $data = json_decode($data,true);
        $User->where('id = "'.$data['id'].'"')->save($data);
        //删除原本的角色，换成刚刚修改的角色
        M("userandrole")->where("userId = ".$data['id'])->delete();
        //遍历提交的表单，取出角色字段，新增映射关系
        foreach ($data as $key => $value) {
            if(strpos($key, "roleId") === 0){
                //是角色字段，新增用户角色映射关系
                M("userandrole")->add(array("userId"=>$data['id'],"roleId"=>$value));
            }
        }
        echo json_encode($result);
    }
}