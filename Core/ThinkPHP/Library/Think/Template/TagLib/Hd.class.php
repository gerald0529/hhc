<?php
//自定义标签库
namespace Think\Template\TagLib;
use Think\Template\TagLib;
class Hd extends TagLib
{
	protected $tags=array(
		'jsconst'=>array('attr'=>'','close'=>0),
		'jquery' =>array('attr'=>'type','close'=>0),
 		'validate'=>array('attr'=>'','close'=>0),
		'keditor'=>array('attr'=>'name,content','close'=>0),
		'hdjs'=>array('attr'=>'jquery','close'=>0),
		'airlines'=>array('attr'=>'lang','close'=>0),
		'channel'=>array('attr'=>'cid,type,row','close'=>1,'level'=>4),
		'pagelist'=>array('attr'=>'order,lang','close'=>1),
		'page'=>array('attr'=>'','close'=>0),
		'typename'=>array('attr'=>'cid','close'=>1),
		'debris'=>array('attr'=>'id','close'=>1),
		'artlist'=>array('attr'=>'cid,flag,row,order','close'=>1),
		'showad'=>array('attr'=>'cid,row','close'=>1),
		'bootstrap'=>array('attr'=>'','close'=>0),
		'pintuer'=>array('attr'=>'','close'=>0),
		'next'=>array('attr'=>'flag,lang','close'=>0),

		
	);



	public function _airlines($attr,$content){

		$lang = $attr['lang'];

		$php =<<<str
			<?php
				\$_Htmlstring = D('Airlines','Service')->get_airlines($lang);
			?>
			<link rel=stylesheet type=text/css href="__ROOT__/Data/Public/css/lanrenzhijia.css">
			<script type=text/javascript src="__ROOT__/Data/Public/js/kefu.js"></script>
			<div id='floatTools' class='float0831'>
			<div class='floatL'>
			<a style="display:none" id='aFloatTools_Show' class='btnOpen' title='查看在线客服' href="javascript:void(0);">展开</a> 
			<a id='aFloatTools_Hide' class='btnCtn' title='关闭在线客服' href="javascript:void(0);">收缩</a>
			</div>
			<div id='divFloatToolsView' class='floatR'>
			<div class='tp'></div>
			<div class='cn'>
			<ul>
			<li class='qqtop'><H3 class='titZx'>QQ咨询</H3></li>
			<?php echo \$_Htmlstring; ?>
			</ul>
			</div>
			<div class="qr"></div>
			</div>
			</div>
			</div>

str;

	return $php;

	}


	public function _jquery($attr,$content)
	{
		$type = isset($attr['type'])? $attr['type'] : '1.8.2'; 
		if($type =='1.8.2')
			return '<script src="__ROOT__/Data/Public/org/Jquery/jquery-1.8.2.min.js" type="text/javascript"></script>';
		if ($type =='1.11.2') {
			return '<script src="__ROOT__/Data/Public/org/Jquery/jquery-1.11.2.min.js" type="text/javascript"></script>';
		}
	}
	/**
	 * [validate 拼图框架]
	 * @param  [type] $attr    [description]
	 * @param  [type] $content [description]
	 * @return [type]          [description]
	 */
	public function _validate($attr,$content)
	{
		$php =<<<str
			<script src="__ROOT__/Data/Public/org/Validate/jquery.validate.js" type="text/javascript"></script>
			<script src="__ROOT__/Data/Public/org/Validate/jquery.validate.unobtrusive.js" type="text/javascript"></script>
str;
		return $php;
	}


	/**
	 * [pintuer 拼图框架]
	 * @param  [type] $attr    [description]
	 * @param  [type] $content [description]
	 * @return [type]          [description]
	 */
	public function _pintuer($attr,$content)
	{
		$php =<<<str
			<link href='__ROOT__/Data/Public/org/pintuer/pintuer.css' rel='stylesheet' media='screen'>
			<script src="__ROOT__/Data/Public/org/pintuer/pintuer.js"></script>
			<script src="__ROOT__/Data/Public/org/pintuer/respond.js"></script>
str;
		return $php;
	}

	/**
	 * [_next 上一篇\下一篇]
	 * @param  [type] $attr    [description]
	 * @param  [type] $content [description]
	 * @return [type]          [description]
	 */
	public function _next($attr,$content)
	{

		$flag = isset($attr['flag'])? $attr['flag'] : 1; //1 上一篇：有链接文档标题，下一篇：有里链接文档标题；2 上一篇：有链接文档标题; 3 下一篇：有链接文档标题
		$lang = isset($attr['lang'])? $attr['lang'] : 'cn'; //语言
		$php =<<<str
<?php
	echo D('Article','Service')->next($flag,'$lang');
?>
str;
		
		return $php;
	}



	/**
	 * [_bootstrap bootstrap框架]
	 * @param  [type] $attr    [description]
	 * @param  [type] $content [description]
	 * @return [type]          [description]
	 */
	public function _bootstrap($attr,$content)
	{
		$php =<<<str
			<link href='__ROOT__/Data/Public/org/bootstrap/css/bootstrap.min.css' rel='stylesheet' media='screen'>
			<script src='__ROOT__/Data/Public/org/bootstrap/js/bootstrap.min.js'></script>
			<!--[if lte IE 6]>
			<link rel="stylesheet" type="text/css" href="__ROOT__/Data/Public/org/bootstrap/ie6/css/bootstrap-ie6.css">
			<![endif]-->
			<!--[if lt IE 9]>
			<script src="__ROOT__/Data/Public/org/bootstrap/js/html5shiv.min.js"></script>
			<script src="__ROOT__/Data/Public/org/bootstrap/js/respond.min.js"></script>
			<![endif]-->

str;
		return $php;
	}




	/**
	 * [_showad 广告]
	 * @param  [type] $attr    [description]
	 * @param  [type] $content [description]
	 * @return [type]          [description]
	 */
	public function _showad($attr,$content)
	{

		$cid = isset($attr['cid'])? $attr['cid'] : 0; //广告位置的psid
		$row = isset($attr['row'])? $attr['row'] : 0; //读取几条数据
		$php=<<<str
			<?php
				\$_lists = D('Ad','Service')->show_ad($cid,$row);
				if(\$_lists):
					foreach(\$_lists as \$k=>\$field):
			?>	
					{$content}
			<?php 
					endforeach;
				endif;
			?>
str;
		return $php;
	}

	/**
	 * [_artlist 获取有属性的内容列表]
	 * @param  [type] $attr    [description]
	 * @param  [type] $content [description]
	 * @return [type]          [description]
	 */
	public function _artlist($attr,$content)
	{

		$cid = isset($attr['cid'])? $attr['cid'] : '';  		//栏目cid
		$flag = isset($attr['flag'])? $attr['flag'] : '';	//文档属性是推荐(c)、头条(t)、图文(p)
		$row = isset($attr['row'])? $attr['row'] : 0;	//读取几条文档记录
		$order = isset($attr['order'])? $attr['order'] : ''; //排序 order 后面的东西

		$php=<<<str
			<?php
				\$_lists = D('Article','Service')->get_flag("$cid","$flag",$row,"$order");

				if(\$_lists):
					foreach(\$_lists as \$k=>\$field):	
			?>	
					{$content}
			<?php 
					endforeach;
				endif;
			?>
str;
		return $php;
	
	}

	/**
	 * [_typename 获取指定栏目的信息]
	 * @param  [type] $attr    [description]
	 * @param  [type] $content [description]
	 * @return [type]          [description]
	 */
	public function _typename($attr,$content)
	{

		$cid = isset($attr['cid'])? $attr['cid'] : 0;
		$php=<<<str
			<?php
				\$categoryModel = D('Category','Service');
				\$field = \$categoryModel->get_one($cid);
				if(\$field):
							
			?>	
					{$content}
			<?php 
				endif;
			?>
str;
		return $php;
	
	}


	public function _debris($attr,$content){

		$id = isset($attr['id'])? $attr['id'] : 0;
		$php=<<<str
			<?php
				\$debrisModel = D('Debris','Service');
				\$field = \$debrisModel->get_one($id);
				if(\$field):
							
			?>	
					{$content}
			<?php 
				endif;
			?>
str;
		return $php;

	}

	/**
	 * [_page 获取有分页内容列表 分页信息]
	 * @param  [type] $attr    [description]
	 * @param  [type] $content [description]
	 * @return [type]          [description]
	 */
	public function _page($attr,$content)
	{
		return "<div class='page' >
	<style>
        .page{text-align: center;}
        .page a{padding:4px 10px;border:1px solid hsl(240, 7%, 74%);margin-left: 10px;}
        .page .current{padding:4px 10px;border:1px solid hsl(240, 7%, 74%);background: #ccc;margin-left: 10px;}
    </style>\n\r{\$_page}</div>";
	}

	/**
	 * [_pagelist 获取有分页内容列表]
	 * @param  [type] $attr    [description]
	 * @param  [type] $content [description]
	 * @return [type]          [description]
	 */
	public function _pagelist($attr,$content)
	{

		$order = isset($attr['order'])? $attr['order'] : ''; //排序 order 后面的东西
		$lang  = isset($attr['lang'])? $attr['lang'] : 'cn'; //语言
		$php=<<<str
			<?php
				\$_lists = D('Article','Service')->get_list("$order","$lang");
				\$_page = '';
				if(\$_lists):
					\$_page=\$_lists['page'];
					unset(\$_lists['page']);

					foreach(\$_lists as \$k=>\$field):
						
			?>
						{$content}
			<?php 
					endforeach;
			    else:
			    	echo "$lang"=="cn"?"没有找到符合的记录":"no record";
				endif;
			?>
str;
		return $php;
	}

	/**
	 * [_channel 导航、栏目分类]
	 * @param  [type] $attr    [description]
	 * @param  [type] $content [description]
	 * @return [type]          [description]
	 */
	public function _channel($attr,$content)
	{

		$type = isset($attr['type'])? $attr['type'] : 'top'; //top顶级栏目 son 子集栏目 self 同级栏目
		$cid = isset($attr['cid'])? $attr['cid'] : 0;  //cid栏目信息
		$row = isset($attr['row'])? $attr['row'] : 20; //读取几条记录
		$php=<<<str
			<?php
				switch ('$type') 
				{
					case 'top':
						\$_nav = D('Category','Service')->get_nav(0);
						break;
					case 'son':
						\$_nav = D('Category','Service')->get_nav($cid);
						break;
				}
				\$k=0;
				foreach(\$_nav as \$field):
				if(\$k>$row-1)
					break;	

			?>
				{$content}
			<?php
				\$k++; 
			endforeach;?>
str;
		return $php;
	}
	

	
	/**
	 * [_jsconst js常量]
	 * @param  [type] $attr    [description]
	 * @param  [type] $content [description]
	 * @return [type]          [description]
	 */
	public function _jsconst($attr,$content)
	{
		$php .=<<<str
<script type='text/javascript'>
MODULE='__MODULE__'; //当前模块
CONTROLLER='__CONTROLLER__'; //当前控制器)
ACTION='__ACTION__';//当前方法(方法)
ROOT='__ROOT__'; //当前项目根路径
PUBLIC= '__PUBLIC__';//当前定义的Public目录
</script>
str;
		return $php;
	}

	/**
	 * [_hdjs 使用hdjs]
	 * @param  [type] $attr    [description]
	 * @param  [type] $content [description]
	 * @return [type]          [description]
	 */
	public function _hdjs($attr,$content)
	{

		$jquery = isset($attr['jquery'])?$attr['jquery']:true;
		$php = '';
		if($jquery)
			$php="<script type='text/javascript' src='__ROOT__/Core/Org/Jquery/jquery-1.8.2.min.js'></script>\n";
		$php .=<<<str
	<link href='__ROOT__/Data/Public/org/hdjs/hdjs.css' rel='stylesheet' media='screen'>
	<script type='text/javascript' src='__ROOT__/Data/Public/org/hdjs/hdjs.min.js'></script>
	<script type='text/javascript' src='__ROOT__/Data/Public/org/hdjs/org/cal/lhgcalendar.min.js'></script>
	<script type='text/javascript'>
		MODULE='__MODULE__'; //当前模块
		CONTROLLER='__CONTROLLER__'; //当前控制器)
		ACTION='__ACTION__';//当前方法(方法)
		ROOT='__ROOT__'; //当前项目根路径
		PUBLIC= '__PUBLIC__';//当前定义的Public目录
	</script>
str;
		return $php;
	}

	/**
	 * [_keditor 编辑器kindeditor]
	 * @param  [type] $attr    [description]
	 * @param  [type] $content [description]
	 * @return [type]          [description]
	 */
	public function _keditor($attr,$content)
	{

		$name=isset($attr['name'])?$attr['name']:'';
		$content=isset($attr['content'])?$attr['content']:'';
		$str='';
		if (!defined("DJ_KEDITOR")) 
		{
			$str .="<script type='text/javascript' src='".__ROOT__."/Data/Public/org/Keditor/kindeditor-all-min.js'></script>
			";
			define("DJ_KEDITOR", true);
		}
		$uploadScript=U('keditor_upload',array('SSID'=>session_id()));
		$str .=<<<php
			<script type="text/javascript">
			var optionVar ='{$name}'
			KindEditor.ready(function(K) {
					var optionVar= "editor"+optionVar;
					optionVar = K.create('#{$name}', {
						//cssPath : '../plugins/code/prettify.css',
						//uploadJson : '__ROOT__/Data/Public/org/Keditor/php/upload_json.php',
						uploadJson : '{$uploadScript}',
						fileManagerJson : '__ROOT__/Data/Public/org/Keditor/php/file_manager_json.php',
						width:'99%',
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
}
?>