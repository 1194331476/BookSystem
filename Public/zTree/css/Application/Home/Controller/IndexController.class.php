<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    
    /**
     *  跳转登录页面 
     *  */
    public function index(){
      session("user",null);
      $this->display('login');
    }
    /**
     *  跳转注册页面
     *  */
    public function toRegister(){
        $this->display("register");
    }
    
    /**
    * 登陆验证
    * @date: 2017年12月20日 上午9:15:54
    * @author: hd
    * @param: variable
    * @return:
    */
    public function checkLogin(){
        $data = file_get_contents("php://input");
        $data = json_decode($data,true);
        $list = M("user")->where("username = '".$data['userName']."' and password = '".$data['password']."'")->select();
        $result = array("success"=>"false","msg"=>"登陆失败");
        if(count($list) == 1){
            session('user',$list[0]);  //设置session
            $result = array("success"=>"true","msg"=>"登陆成功");
            //获得该用户的导航
            $userPowerList = M()->query("select distinct p.* from userandrole ur 
                                        RIGHT JOIN roleandpower rp on ur.roleId = rp.roleId
                                        LEFT JOIN power p on rp.powerId = p.id
                                        where ur.userId = ".$list[0]['id']." 
                                        order by parentid asc");
            $arr = array();
            for ($i= 0;$i< count($userPowerList); $i++){
                if($userPowerList[$i]['parentid'] == 0){
                    $userPowerList[$i]['children'] = array();
                    array_push($arr, $userPowerList[$i]);
                }else{
                    for($j= 0;$j< count($arr); $j++){
                        if($arr[$j]['id'] === $userPowerList[$i]['parentid']){
                            array_push($arr[$j]['children'],$userPowerList[$i]);
                        }
                    }
                }
            }
            session("userPowerList",$arr);
        }
        echo json_encode($result);
    }
    
    /**
    * 注册用户
    * @date: 2017年12月20日 上午9:16:34
    * @author: hd
    * @param: variable
    * @return:
    */
    public function register(){
        $data = file_get_contents("php://input");
        $data = json_decode($data,true);
        trace($data,"$data");
        $res = 0;
        $result = array("success"=>"false","msg"=>"注册失败");
        $list = M("user")->where('username = "'.$data['userName'].'"')->select();
        if(count($list) == 1){
            $result = array("success"=>"false","msg"=>"用户名重复");
        }else{
            $res = M("user")-> data($data)->add();
            $result = array("success"=>"true","msg"=>"注册成功");
        }
        echo json_encode($result);
    }
    
    /**
    * 跳转后台首页
    * @date: 2017年12月20日 上午9:16:57
    * @author: hd
    * @param: variable
    * @return:
    */
    public function admin(){
        $this->display();
    }
}