<?php
namespace Home\Controller;
use Think\Controller;
class RoleController extends Controller {
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
        $rolename = "";
        if(isset($_GET["rolename"])){
            $rolename = $_GET['rolename'];
        }
        // 获得总记录数
        $Role = M("Role"); // 实例化Role对象
        $count = $Role->where("rolename like'%".$rolename."%'")->count();
        // 获得数据集合
        $Model = new \Think\Model(); // 实例化一个model对象 没有对应任何数据表
        $start = ($page - 1) * $limit;
        $list = $Model->query("select * from Role where rolename like '%".$rolename."%' order by id limit " . $start . "," . $limit);
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
        $list = $Model->query("select * from Role order by id");
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
        $this->display();
    }
    /**
     * 新增
     * */
    public function add(){
        $role = M("Role"); // 实例化Role对象
        $data = file_get_contents("php://input");
        $data = json_decode($data,true);
        //根据用户名查询
        $role->add($data);
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
        $Role = M("Role"); // 实例化Role对象
        $res = $Role->delete(rtrim($_POST['id'],',')); // 删除主键为1,2和5的用户数据
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
        $Role = M("Role")->where("id = ".$_GET["id"])->select();
        $this->assign('role',$Role[0]);
        $this->display();
    }
    /**
     * 修改
     * */
    public function edit(){
        $role = M("role"); // 实例化Role对象
        $data = file_get_contents("php://input");
        $data = json_decode($data,true);
        $res = $role->where('id = "'.$data['id'].'"')->save($data);
        $result = array("success"=>"true","msg"=>"修改成功");
        if($res==0){
            $result = array("success"=>"false","msg"=>"修改失败");
        }
        echo json_encode($result);
    }
    
    /**
     * 弹出权限的页面
     * */
    public function powerTable(){
        $this->assign("roleId",$_GET['roleId']);
        $this->display();
    }
    /**
     * 返回导航集合，如果该角色拥有，标记出来
     * */
    public function powerTreeList(){
        $powerList = M("")->query("select rp.roleId,p.*,case when p.parentId=0 then p.id ELSE CONCAT(p.parentId,'-',p.id) end treeCode from power p LEFT JOIN roleandpower rp on p.id = rp.powerId and rp.roleId = ".$_GET['roleId']." ORDER BY treeCode");
        echo json_encode($powerList);
    }
    /**
     * 修改权限
     * */
    public function changePower(){
        $data = file_get_contents("php://input");
        $data = json_decode($data,true);
        //删除原本的权限
        M("roleandpower")->where("roleId = ".$data['roleId'])->delete();
        //遍历提交的表单，取出权限字段，新增映射关系
        foreach ($data as $key => $value) {
            if(strpos($key, "powerId") === 0){
                //是角色字段，新增用户角色映射关系
                M("roleandpower")->add(array("roleId"=>$data['roleId'],"powerId"=>$value));
            }
        }
        $result = array("success"=>"true","msg"=>"配置权限成功");
        echo json_encode($result);
    }
}