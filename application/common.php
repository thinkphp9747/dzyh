<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
/**
 * TODO 上传文件方法
 * @param $fileid form表单file的name值
 * @param $dir 上传到uploads目录的$dir文件夹里
 * @param int $maxsize 最大上传限制，默认1024000 byte
 * @param array $exts 允许上传文件类型 默认array('gif','jpg','jpeg','bmp','png')
 * @return array 返回array,失败status=0 成功status=1,filepath=newspost/2014-9-9/a.jpg
 */
function uploadfile($fileid,$dir,$maxsize=5242880,$exts=array('xls','xlsx'),$maxwidth=430){
    $upload = new \Think\Upload();// 实例化上传类
    $upload->maxSize   =     $maxsize;// 设置附件上传大小，单位字节(微信图片限制1M
    $upload->exts      =     $exts;// 设置附件上传类型
    $upload->rootPath  =     '/public/uploads/'; // 设置附件上传根目录
    $upload->savePath  =     $dir.'/'; // 设置附件上传（子）目录
    // 上传文件
    $info   =   $upload->upload();

    if(!$info) {// 上传错误提示错误信息
        return array(status=>0,msg=>$upload->getError());
    }else{// 上传成功
        return array(status=>1,msg=>'上传成功',filepath=>$info[$fileid]['savepath'].$info[$fileid]['savename']);
    }
}