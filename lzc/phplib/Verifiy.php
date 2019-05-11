<?php

namespace phplib;

class Verifiy
{

/*
      定义验证码属性   
     */
    //图片的宽度
    public  $width;
    //图片的高度
    public  $height;
    //私有化验证码字符串，避免生成后被修改    
    private $verifyCode;
    //存储验证码字符的个数
    public  $verifyNums;
    //存储验证码的字符类型 1->纯数字 2->纯字母 3->混合类
    public  $verifyType;
    //背景颜色
    public  $bgColor;
    //文字颜色
    public  $fontColor;
    //验证码的图片类型jpg,png,bmp……
    public  $imgType;
  
    //图片资源
    private  $res;

    /*
        功能
    */
    //功能函数，初始化一些可以被初始化的参数
    public function __construct($width = 100,$height = 50,$imgType = 'jpg',$verifyNums = 4,$verifyType = 1)
      {
        $this->width      = $width;
        $this->height     = $height;
        $this->imgType    = $imgType;
        $this->verifyNums = $verifyNums;
        $this->verifyType = $verifyType;
      
      //初始化一个可以随机生成验证码的函数,将生成的验证码春初到verifyCode属性里
        $this->verifyCode = $this->createVerifyCode(); 
      }
    
    //随机生成验证码的函数，因为不对外公布，设置为私有的
    private function createVerifyCode()
      {
        //通过判断验证的类型来确定生成哪一种验证码
        //verifyType=1生成纯数字，为2生成纯字母，为3生成混合
        switch ($this->verifyType) {
          case 1:
              /*生成纯数字，首先使用range(0,9)生成数组
               *通过$this->verifyNums确定字符串的个数
               *使用array_rand()从数组中随机获取相应个数
               *使用join将数字拼接成字符串，存储到$str中
               */
                $str = join('',array_rand(range(0,9),$this->verifyNums));
            break;
          case 2:
              /*生成纯字母，
               *小写字母数组range('a','z')
               *大写字母数组range('A','Z')
               *合并两个数组array_merge()
               *更换键和值  array_filp()
               *随机获取数组中的特定个数的元素 array_rand()
               *拼接成字符串 implode()
               */
                $str = implode(array_rand(array_filp(array_merge(range('a','z'),range('A','Z'))),$this->verifyNums));
            break;
          case 3:
            //混合类型
            $words = str_shuffle('abcdefghjkmpopqrstuvwxyABCDEFGHIJKLMNPQRSTUVWXY3456789');
            $str = substr($words,0,$this->verifyNums);
            break;
        }
      return $str;
      }
  
  
    //开始准备生成图片
    /*方法名：show()
     *功能  ：调用生成图片的所有方法
     */
    public function show()
      {
        $this->createImg();//创建图片资源
        $this->fillBg();   //填充背景颜色
        $this->fillPix();  //填充干扰点
        $this->fillArc();  //填充干扰弧线
        $this->writeFont();//写字
        $this->outPutImg();//输出图片
      }
  
    //创建图片资源:imagecreatetruecolor($width,$height)
    private function createImg()
      {
      $this->res = imagecreatetruecolor($this->width,$this->height);
      }
  
    //填充背景颜色:imagefill($res,$x,$y,$color)
    //随机生成深色--->imagecolorallocate($res,$r,$g,$b)
    private function setDarkColor()
      {
        return imagecolorallocate($this->res,mt_rand(130,255),mt_rand(130,255),mt_rand(130,255));
      } 
    //随机生成浅色
    private function setLightColor()
      {
        return imagecolorallocate($this->res,mt_rand(0,130),mt_rand(0,130),mt_rand(0,130));
      }
    //开始填充
    private function fillBg()
      {
        imagefill($this->res,0,0,$this->setDarkColor());
      }
  
    //随机生成干扰点-->imagesetpixel
    private function fillPix()
      {
        //计算产生多少个干扰点，这里设置每20个像素产生一个
        $num = ceil(($this->width * $this->height) / 20);
        for($i = 0; $i < $num; $i++){
          imagesetpixel($this->res,mt_rand(0,$this->width),mt_rand(0,$this->height),$this->setDarkColor());
        }
      }
  
    //随机画10条弧线->imagearc()
    private function fillArc()
      {
        for($i = 0;$i < 10;$i++){
          imagearc($this->res,
                   mt_rand(10,$this->width-10),
                   mt_rand(5,$this->height-5),
                   mt_rand(0,$this->width),
                   mt_rand(0,$this->height),
                   mt_rand(0,180),
                   mt_rand(181,360),
                   $this->setDarkColor());
        }
      }
  
    /*在画布上写文字
     *根据字符的个数，将画布横向分成相应的块
      $every = ceil($this->width/$this->verifyNums);
     *每一个小块的随机位置画上对应的字符
      imagechar();
     */
    
    private function writeFont()
      {
        $every = ceil($this->width / $this->verifyNums);
        for($i = 0;$i < $this->verifyNums;$i++){
          $x = mt_rand(($every * $i) + 5,$every * ($i + 1) - 5);
          $y = mt_rand(5,$this->height - 10);
          
          imagechar($this->res,5,$x,$y,$this->verifyCode[$i],$this->setLightColor());
        }
      }
  
    //输出图片资源
    private function outPutImg()
      {
        //header('Content-type:image/图片类型')
        header('Content-type:image/'.$this->imgType);
      
        //根据图片类型，调用不同的方法输出图片            
        //imagepng($img)/imagejpg($img)
        $func = 'image'.$this->imgType;
        $func($this->res);
      }
  
    //设置验证码字符只能调用，不能修改，用来验证验证码书否输入正确
    public function __get($name){
      if($name = 'verifyCode'){
        return $this->verifyCode;
      }
    }
    
    //析构方法，自动销毁图片资源
    public function __destruct()
      {
        imagedestroy($this->res);
      }
}