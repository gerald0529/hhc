<?php
/**[**********]
 * @Author: happy
 * @Email:  976123967@qq.com
 * @Date:   2015-05-02 12:11:31
 * @Last Modified by:   happy
 * @Last Modified time: 2015-05-02 12:17:54
 */
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