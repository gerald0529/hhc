<?php
/**函数库
 * @Author: happy
 * @Email:  976123967@qq.com
 * @Date:   2015-07-15 22:07:21
 * @Last Modified by:   cl
 * @Last Modified time: 2015-10-11 17:51:15
 */
const TPCMS_ADDON_PATH = './Core/Addons/';
use Third\PHPMailer;
use Third\SMTP;
//将下划线命名转换为驼峰式命名
function convertUnderline1 ( $str , $ucfirst = true)
{
    while(($pos = strpos($str , '_'))!==false)
        $str = substr($str , 0 , $pos).ucfirst(substr($str , $pos+1));
 
    return $ucfirst ? ucfirst($str) : $str;
}

/**
 * flash上传初始化
 * 初始化swfupload上传中需要的参数
 * @param $args 传递参数
 */
function initupload($args) 
{


	$fileSizeLimit = 20000;
	$arrAllowext = explode('|', $args['ext']);
    foreach ($arr_allowext as $k => $v) {
        $v = '*.' . $v;
        $array[$k] = $v;
    }
    $uploadAllowext = implode(';', $array);
    //上传处理地址
    $uploadUrl = U('Admin/Upload/do_upload');
    $fileUploadLimit = $args['num'];
    $flashUrl  =  __ROOT__.'/Data/Public/org/swfupload/swfupload.swf';
 	  $init = 'var swfu_'.$args['controller'].'_'.$args['textareaid'].'= \'\';
    $(document).ready(function(){
        Wind.use("swfupload",ROOT+"/Data/Public/org/swfupload/handlers.js",function(){
            swfu_'.$args['controller'].'_'.$args['textareaid'].' = new SWFUpload({
                flash_url:"'  . $flashUrl  . '?"+Math.random(),
                upload_url:"' . $uploadUrl . '",
                file_post_name : "Filedata",
                post_params:{
                     is_pic:"'.$args['is_pic'].'",
                     ext :"'.$args['ext'].'",
                     SSID:"'.session_id().'"
                },
               file_size_limit:"' . $fileSizeLimit . 'KB",
               file_types:"' . $uploadAllowext . '",
               file_types_description:"All Files",
               file_upload_limit:"' . $fileUploadLimit . '",
               custom_settings : {progressTarget : "fsUploadProgress",cancelButtonId : "btnCancel"},
               button_image_url: "",
               button_width: 75,
               button_height: 28,
               button_placeholder_id: "buttonPlaceHolder",
               button_text_style: "",
               button_text_top_padding: 3,
               button_text_left_padding: 12,
               button_window_mode: SWFUpload.WINDOW_MODE.TRANSPARENT,
               button_cursor: SWFUpload.CURSOR.HAND,
               file_dialog_start_handler : fileDialogStart,
               file_queued_handler : fileQueued,
               file_queue_error_handler:fileQueueError,
               file_dialog_complete_handler:fileDialogComplete,
               upload_progress_handler:uploadProgress,
               upload_error_handler:uploadError,
               upload_success_handler:uploadSuccess,
               upload_complete_handler:uploadComplete
        });
    });
})
';
    return $init;
}

/**
 * [format_date 格式化时间]
 * @param  [type] $date [description]
 * @return [type]       [description]
 */
function format_date($date,$second=1)
{
  if($second)
    return date('Y-m-d H:i:s',$date);
  else
    return date('Y-m-d',$date);
}

/**
 * [keditor 编辑器]
 * @param  [type] $param [description]
 * @return [type]        [description]
 */
function keditor($param)
{
    $name = $param['name'];
    $content = $param['content'];
    $style = isset($param['style'])?$param['style']:1;
    $str='';
    if (!defined("DJ_KEDITOR")) 
    {
        $str .="<script type='text/javascript' src='".__ROOT__."/Data/Public/org/Keditor/kindeditor-all-min.js'></script>
        ";
        define("DJ_KEDITOR", true);
    }
    $uploadScript=U('keditor_upload',array('SSID'=>session_id()));

    $toolbar = '';
    if($style==2)
    {

        $toolbar = '
            items :["source","code","fullscreen","|","forecolor", "bold", "italic", "underline",
        "removeformat", "|", "justifyleft", "justifycenter", "justifyright", "insertorderedlist",
        "insertunorderedlist", "|", "emoticons", "link"],'; 
        
    }   
            
    $root=__ROOT__;
    $str .=<<<php
        <script type="text/javascript">
        var optionVar ='{$name}';
        KindEditor.ready(function(K) {
                var optionVar= "editor"+optionVar;
                optionVar = K.create('#{$name}', {
                    //cssPath : '../plugins/code/prettify.css',
                    //uploadJson : '{$root}/Data/Public/org/Keditor/php/upload_json.php',
                    uploadJson : '{$uploadScript}',
                    fileManagerJson : '{$root}/Data/Public/org/Keditor/php/file_manager_json.php',
                    {$toolbar}
                    width:'100%',
                    height:'300px',
                    allowFileManager : true,
                    afterCreate : function() {
                        var self = this;
                        K.ctrl(document, 13, function() {
                            self.sync();
                            K('form[name=example]')[0].submit();
                        });
                        K.ctrl(self.edit.doc, 13, function() {
                            self.sync();
                            K('form[name=example]')[0].submit();
                        });
                    },
                    //langType:'en',
                    afterBlur: function(){this.sync();}
            });
        });
        </script>
        <textarea name="{$name}" id="{$name}" >{$content}</textarea>
php;
    return $str;

}

/**
 * 用户定义常量
 * @param bool $view 是否显示
 * @param bool $tplConst 是否只获取__WEB__这样的常量
 * @return array
 */

function print_const($view = true, $tplConst = false) {
    $define = get_defined_constants(true);
    $const = $define['user'];
    if ($tplConst) {
        $const = array();
        foreach ($define['user'] as $k => $d) {
            if (preg_match('/^__/', $k)) {
                $const[$k] = $d;
            }
        }
    }
    if ($view) {
        p($const);
    } else {
        return $const;
    }
}



/**
 * 打印输出数据|show的别名
 * @param void $var
 */
function p($var) {
    show($var);
}



/**
 * 打印输出数据
 * @param void $var
 */
function show($var) {
    if (is_bool($var)) {
        var_dump($var);
    } else if (is_null($var)) {
        var_dump(NULL);
    } else {
        echo "<pre style='padding:10px;border-radius:5px;background:#F5F5F5;border:1px solid #aaa;font-size:14px;line-height:18px;'>" . print_r($var, true) . "</pre>";
    }
}


/**
 * 获得随机字符串
 * @param int $len 长度
 * @return string
 */
function rand_str($len = 6) 
{
    $data = 'abcdefghijklmnopqrstuvwxyz0123456789';
    $str = '';
    while (strlen($str) < $len)
        $str .= substr($data, mt_rand(0, strlen($data) - 1), 1);
    return $str;
}

/**
 * 截取长度
 * 使用自定义标签时截取字符串
 * @param $string 字符串
 * @param int $len 长度
 * @param string $end 结尾符
 * @return string
 */
function cms_substr($string, $len = 20, $end = '...')
{
    if(mb_strlen($string,'utf-8')<$len)
        return $string;
    else
        return mb_substr($string, 0, $len, 'utf-8') . $end;
}


/**
 * 根据大小返回标准单位 KB  MB GB等
 */
function get_size($size, $decimals = 2)
{
    switch (true) {
        case $size >= pow(1024, 3):
            return round($size / pow(1024, 3), $decimals) . " GB";
        case $size >= pow(1024, 2):
            return round($size / pow(1024, 2), $decimals) . " MB";
        case $size >= pow(1024, 1):
            return round($size / pow(1024, 1), $decimals) . " KB";
        default:
            return $size . 'B';
    }
}


/**
 * [postmail 使用phpmailer发送邮件]
 * @param  [type] $to       [收件箱]
 * @param  string $subject  [邮件主题]
 * @param  string $body     [邮件内容]
 * @param  [type] $consignee[收件人描述]
 * @return [type]           [description]
 */
function postmail($to,$subject = '',$body = '',$consignee='')
{
    // 导入类

    # Create object of PHPMailer
    $mail = new PHPMailer();
    $body            = eregi_replace("[\]",'',$body); //对邮件内容进行必要的过滤
    $mail->CharSet ="utf8";//设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置，否则乱码
     
    // Inform class to use SMTP
    $mail->IsSMTP();
     
    // Enable this for Testing
    $mail->SMTPDebug  = 0;
     
    // Enable SMTP Authentication
    $mail->SMTPAuth   = true;
     
    // Host of the SMTP Server
    $mail->Host = C('cfg_smtp');            //smtp地址 更改
     
    // Port of the SMTP Server
    $mail->Port = 25;
     
    // SMTP User Name
    $mail->Username   = C('cfg_email_account');   //邮箱账号更改
     
    // SMTP User Password
    $mail->Password = C('cfg_email_password'); //邮箱密码更改
     
    // Set From Email Address
    $mail->SetFrom("1094846662@qq.com", C('cfg_name')); //邮箱账号和发件人描述更改
     
    // Add Subject
    $mail->Subject    = $subject;
     
    // Add the body for mail
    $mail->MsgHTML($body);
     
    // Add To Address
    //$consignee ='收件人描述';
    $mail->AddAddress($to, $consignee); //收件人描述更改
     
     
    // Finally Send the Mail
    if(!$mail->Send())
    {
        return array('status'=>false,error=>"Mailer Error: " . $mail->ErrorInfo);
    }
    else
    {
     return array('status'=>true);
    }
}

/**
 * [set_url 筛选]
 * @param [type] $key    [description]
 * @param [type] $attr   [description]
 * @param string $suffix [description]
 */
function set_url($key,$attr,$suffix='')
{
    $s = I('get.s');
    $sArr = explode('-', $s); 

    // 当前高亮
    $cur = '';
    if($sArr[$key] == $attr['attr_value_attr_value_id'])
        $cur = 'class="on"';

    // 更改属性值
    $sArr[$key]=$attr['attr_value_attr_value_id'];  

    // url
    $url = __ACTION__.'/s/'.implode('-', $sArr);

    // 组合a链接
    echo "<a href='{$url}' {$cur}>
         {$attr['attr_value'.$suffix]}
        </a>";
 
}


/**
 * [build_article_url 文档链接]
 * @param  [type] $data [description]
 * @return [type]       [description]
 */
function build_article_url($data)
{

    if($data["jump_url"])
       $url = $data["jump_url"];
    else if($data['file_url'])
       $url = __APP__.'/'.$data["file_url"];
    else if($data['aid'])
       $url = U('/'.$data['remark'].'_v_'.$data['category_cid'].'_'.$data['aid']);    
    else
         $url = U('/'.$data['remark'].'_v_'.$data['category_cid']);    
    return $url;
}

/**
 * 获取插件类的类名
 * @param strng $name 插件名
 */
function get_addon_class($name)
{
    $class = "Addons\\{$name}\\{$name}Addon";
    return $class;
}

/**
 * 插件显示内容里生成访问插件的url
 * @param string $url url
 * @param array $param 参数
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function addons_url($url, $param = array()){
    $url        = parse_url($url);
    $case       = C('URL_CASE_INSENSITIVE');
    $addons     = $case ? parse_name($url['scheme']) : $url['scheme'];
    $controller = $case ? parse_name($url['host']) : $url['host'];
    $action     = trim($case ? strtolower($url['path']) : $url['path'], '/');

    /* 解析URL带的参数 */
    if(isset($url['query'])){
        parse_str($url['query'], $query);
        $param = array_merge($query, $param);
    }

    /* 基础参数 */
    $params = array(
        '_addons'     => $addons,
        '_controller' => $controller,
        '_action'     => $action,
    );
    $params = array_merge($params, $param); //添加额外参数

    return U('Addons/execute', $params,'',true);
}

/**
 * 处理插件钩子
 * @param string $hook   钩子名称
 * @param mixed $params 传入参数
 * @return void
 */
function hook($hook,$params=array())
{
    \Think\Hook::listen($hook,$params);
}



