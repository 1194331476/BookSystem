<?php
namespace Home\Controller;
use Think\Controller;
class FileController extends Controller {
    
    /**
     *  跳转登录页面 
     *  */
    public function uploadOne(){
        $file = $_FILES["file"];
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     3145728 ;// 设置附件上传大小
        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->rootPath  =      './Uploads/'; // 设置附件上传根目录
        // 上传单个文件 
        $info   =   $upload->uploadOne($file);
        if(!$info) {
            // 上传错误提示错误信息
            $this->error($upload->getError());
        }else{
            // 上传成功 获取上传文件信息
             echo json_encode($info);
        }
    }
}