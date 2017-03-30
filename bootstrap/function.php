<?php

function priceIntToFloat($price){
    return sprintf("%.2f", ($price / 100));
}

function isMobile(){
    $useragent=isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
    $useragent_commentsblock=preg_match('/.∗?/',$useragent,$matches) > 0 ? $matches[0]:'';


    $mobile_os_list=array('Google Wireless Transcoder','Windows CE','WindowsCE','Symbian','Android','armv6l','armv5','Mobile','CentOS','mowser','AvantGo','Opera Mobi','J2ME/MIDP','Smartphone','Go.Web','Palm','iPAQ');
    $mobile_token_list=array('Profile/MIDP','Configuration/CLDC-','160×160','176×220','240×240','240×320','320×240','UP.Browser','UP.Link','SymbianOS','PalmOS','PocketPC','SonyEricsson','Nokia','BlackBerry','Vodafone','BenQ','Novarra-Vision','Iris','NetFront','HTC_','Xda_','SAMSUNG-SGH','Wapaka','DoCoMo','iPhone','iPod' , 'iPad');

    $found_mobile = checkSubstrs($mobile_os_list,$useragent) || checkSubstrs($mobile_token_list,$useragent_commentsblock);

    if ($found_mobile){
        return true;
    }else{
        return false;
    }
}

function checkSubstrs($substrs,$text){

    foreach($substrs as $substr){
        if(false !== strpos($text , $substr)){
            return true;
        }
    }
    return false;
}


/**
 * 获取随机值
 * @param int $len
 * @return string
 */
function getSalt($len = 8 , $num = 0){
    $salt	= '';
    if($num == 0) {
        $str = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
    }else{
        $str = "0123456789";
    }
    $max	= strlen($str)-1;

    for($i=0 ; $i<$len ; $i++ ){
        $salt .= $str[rand(0,$max)];
    }

    return $salt;
}

/**
 * 获取加密串
 * @param $str
 * @param $salt
 * @return string
 */
function encrypt_sha_md5( $str  , $salt ){
    return sha1( md5($str . $salt) );
}

/**
 * @param $url
 * @return mixed
 * curl get
 */
function curlGet($url){
    $ch = curl_init();
    $user_agent = 'Mozilla/5.0 (Windows NT 6.1; rv:17.0) Gecko/20100101 Firefox/17.0 FirePHP/0.7.1';
    curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
    // 2. 设置选项，包括URL
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-FORWARDED-FOR:192.168.2.11', 'CLIENT-IP:192.168.2.11'));  //构造IP
    curl_setopt($ch, CURLOPT_REFERER, "http://www.jisxu.com/");   //构造来路

    // 3. 执行并获取HTML文档内容
    $output = curl_exec($ch);
    curl_close($ch);

    return $output;
}

/**
 * @param $url
 * @return mixed
 * curl post
 */
function curlPost($url , $data){
    $ch = curl_init();
    $user_agent = 'Mozilla/5.0 (Windows NT 6.1; rv:17.0) Gecko/20100101 Firefox/17.0 FirePHP/0.7.1';
    curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
    // 2. 设置选项，包括URL
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-FORWARDED-FOR:192.168.2.11', 'CLIENT-IP:192.168.2.11'));  //构造IP
    curl_setopt($ch, CURLOPT_REFERER, "http://www.jisxu.com/");   //构造来路

    // 3. 执行并获取HTML文档内容
    $output = curl_exec($ch);
    curl_close($ch);

    return $output;
}


