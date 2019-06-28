<?php

if (is_file(__DIR__ . '/../autoload.php')) {
    require_once __DIR__ . '/../autoload.php';
}
if (is_file(__DIR__ . '/../vendor/autoload.php')) {
    require_once __DIR__ . '/../vendor/autoload.php';
}

use OSS\OssClient;
use OSS\Core\OssException;

class Oss
{


    public static function getList(){

        // 阿里云主账号AccessKey拥有所有API的访问权限，风险很高。强烈建议您创建并使用RAM账号进行API访问或日常运维，请登录 https://ram.console.aliyun.com 创建RAM账号。
        $accessKeyId = "LTAIgmqIRwN88G7p";
        $accessKeySecret = "6f8AXwZC8BSHpnfTUpmLPA31Z7oi07";
        // Endpoint以杭州为例，其它Region请按实际情况填写。
        $endpoint = "oss-cn-shenzhen.aliyuncs.com";
        $bucket = $GLOBALS['yml']['BUCKET'];

        $ossClient = new OssClient($accessKeyId, $accessKeySecret, $endpoint);
        $prefix =  $GLOBALS['yml']['FOLDER_NAME'].'/';
        $delimiter = '/';
        $nextMarker = '';
        $maxkeys = '';
        $options = array(
            'delimiter' => $delimiter,
            'prefix' => $prefix,
            'max-keys' => $maxkeys,
            'marker' => $nextMarker,
        );
        try {
            $listObjectInfo = $ossClient->listObjects($bucket, $options);
        } catch (OssException $e) {
            printf(__FUNCTION__ . ": FAILED\n");
            printf($e->getMessage() . "\n");
            return;
        }
        $objectList = $listObjectInfo->getObjectList(); // object list
//        $prefixList = $listObjectInfo->getPrefixList(); // directory list

        $list = array();

        foreach ($objectList as $obj){
            $zz = stripos($obj->getKey(),'png');
            if($zz){
                array_push($list,$obj->getKey());
            }

        }
        return $list;

    }

}
