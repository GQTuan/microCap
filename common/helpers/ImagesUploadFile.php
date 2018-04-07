<?php
/**
 * Created by PhpStorm.
 * User: bruce <376394074@qq.com>
 * Date: 2018/3/26 0026
 * Time: 11:33
 * DESCRIPTION: desc
 */

namespace common\helpers;
use yii\web\UploadedFile;

class ImagesUploadFile
{
    /***
     * @param $name
     * @getInstancesByName 返回对应于指定的文件输入名称上传的文件的数组。
     */
    public static function uploadFiles($name){

        $uploadedFile = UploadedFile::getInstanceByName($name);

        if($uploadedFile === null || $uploadedFile->hasError){
            return json_encode(['code' => -1, 'msg' => '文件不存在']);
        }

        //创建时间
        $ymd = date("Ymd");

        //存储到本地的路径
        $save_path = \Yii::getAlias('@webroot/uploadfile/avatar').'/'.$ymd.'/';

        //存储到数据库的地址
        $save_url='/uploadfile/avatar'.'/'.$ymd.'/';

        //file_exists() 函数检查文件或目录是否存在
        //mkdir() 函数创建目录

        if(!file_exists($save_path)){
            mkdir($save_path);
        }

        //图片名称
        $file_name = $uploadedFile->getBaseName();

        //图片格式
        $file_ext = $uploadedFile->getExtension();
        if(!in_array($file_ext, ['jpeg', 'jpg', 'png',])) return json_encode(['code' => -1, 'msg' => '请上传正确的图片格式']);

        //新文件名
        $new_file_name = date("YmdHis").'_'.rand(10000,99999).'.'.$file_ext;

        //图片信息
        $uploadedFile->saveAs($save_path.$new_file_name);
        $param = [
            'path'      => $save_path,
            'url'       => $save_url,
            'name'      => $file_name,
            'new_name'  => $new_file_name,
            'ext'       => $file_ext
        ];

        return json_encode(['code' => 0, 'msg' => '上传成功', 'data' => $param]);

    }

}