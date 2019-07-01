<?php
/*! tncode 1.2 author:weiyingbin email:277612909@qq.com
//@ object webiste: http://www.39gs.com/archive/259.html
//@ https://github.com/binwind8/tncode
*/
include_once 'spyc.php';
global $yml;
$yml= spyc_load_file('spyc.yml');

if(array_key_exists('website',$_ENV)){
    $yml['website'] = $_ENV['code_website'];
    $yml['name'] = $_ENV['code_name'];
    $yml['img_href'] = $_ENV['code_img_href'];
    $yml['bucket'] = $_ENV['code_bucket'];
    $yml['folder_name'] = $_ENV['code_folder_name'];
}

require_once './vendor/Oss.class.php';



class TnCode
{


    var $im = null;
    var $im_fullbg = null;
    var $im_bg = null;
    var $im_slide = null;
    var $bg_width = 298;
    var $bg_height = 150;
    var $mark_width = 60;
    var $mark_height = 60;
    var $bg_num = 10;
    var $_x = 0;
    var $_y = 0;
    //容错象素 越大体验越好，越小破解难道越高
    var $_fault = 8;
    function __construct(){
        ini_set('display_errors','On');
        //
        error_reporting(0);
        error_reporting(7) ;
        if(!isset($_SESSION)){
            session_start();
        }
    }
    function make(){
        $this->_init();
        $this->_createSlide();
        $this->_createBg();
        $this->_merge();
        $this->_imgout();
        $this->_destroy();
    }

    function check($offset=''){
        if(!$_SESSION['tncode_r']){
            return false;
        }
        if(!$offset){
            $offset = $_REQUEST['tn_r'];
        }
        $ret = abs($_SESSION['tncode_r']-$offset)<=$this->_fault;
        if($ret){
            unset($_SESSION['tncode_r']);
        }else{
            $_SESSION['tncode_err']++;
            if($_SESSION['tncode_err']>10){//错误10次必须刷新
                unset($_SESSION['tncode_r']);
            }
        }
        return $ret;
    }

    private function _init(){

        $list = Oss::getList();
        //产生随机数
        $bg = mt_rand(0, count($list)-1);
        //生成图路径
        $src = $GLOBALS['yml']['img_href']."".$list[$bg];
        //构建图片
        $this->im_fullbg = @imagecreatefrompng($src);
        $this->im_bg = imagecreatetruecolor($this->bg_width, $this->bg_height);
        imagecopy($this->im_bg,$this->im_fullbg,0,0,0,0,$this->bg_width, $this->bg_height);
        $this->im_slide = imagecreatetruecolor($this->mark_width, $this->bg_height);
        $this->im_fullbg = $this->im_bg;
        $_SESSION['tncode_r'] = $this->_x = mt_rand(60,$this->bg_width-$this->mark_width-1);
        $_SESSION['tncode_err'] = 0;
        $this->_y = mt_rand(0,$this->bg_height-$this->mark_height-1);
    }

    private function _destroy(){
        imagedestroy($this->im);
        imagedestroy($this->im_fullbg);
        imagedestroy($this->im_bg);
        imagedestroy($this->im_slide);
    }
    private function _imgout(){
        if(!$_GET['nowebp']&&function_exists('imagewebp')){//优先webp格式，超高压缩率
            $type = 'webp';
            $quality = 100;//图片质量 0-100
        }else{
            $type = 'png';
            $quality = 9;//图片质量 0-9
        }
        header('Content-Type: image/'.$type);
        $func = "image".$type;
        $func($this->im,null,$quality);
    }
    private function _merge(){
        $this->im = imagecreatetruecolor($this->bg_width, $this->bg_height*3);
        imagecopy($this->im, $this->im_bg,0, 0 , 0, 0, $this->bg_width, $this->bg_height);
        imagecopy($this->im, $this->im_slide,0, $this->bg_height , 0, 0, $this->mark_width, $this->bg_height);
        imagecopy($this->im, $this->im_fullbg,0, $this->bg_height*2 , 0, 0, $this->bg_width, $this->bg_height);
        imagecolortransparent($this->im,0);//16777215
    }

    private function _createBg(){
        $file_mark = dirname(__FILE__).'/img/mark.png';
        $im = imagecreatefrompng($file_mark);
        header('Content-Type: image/png');
        imagealphablending( $im, true);
        imagecolortransparent($im,0);//16777215
//        imagepng($im);exit;
        imagecopy($this->im_bg, $im, $this->_x, $this->_y  , 0  , 0 , $this->mark_width, $this->mark_height);
        imagedestroy($im);
    }

    private function _createSlide(){
        $file_mark = dirname(__FILE__).'/img/mark2.png';
        $img_mark = imagecreatefrompng($file_mark);
        imagecopy($this->im_slide, $this->im_fullbg,0, $this->_y , $this->_x, $this->_y, $this->mark_width, $this->mark_height);
        imagecopy($this->im_slide, $img_mark,0, $this->_y , 0, 0, $this->mark_width, $this->mark_height);
        imagecolortransparent($this->im_slide,0);//16777215
        header('Content-Type: image/png');
        //imagepng($this->im_slide);exit;
        imagedestroy($img_mark);
    }



}
?>
