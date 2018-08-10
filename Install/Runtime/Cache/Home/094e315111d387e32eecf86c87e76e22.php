<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>设置数据库连接和后台用户-欢迎使用thinkcms</title>
		<script src="/hanqun/Data/Public/org/Jquery/jquery-1.11.2.min.js" type="text/javascript"></script>
	<link href='/hanqun/Data/Public/org/hdjs/hdjs.css' rel='stylesheet' media='screen'>
	<script type='text/javascript' src='/hanqun/Data/Public/org/hdjs/hdjs.min.js'></script>
	<script type='text/javascript' src='/hanqun/Data/Public/org/hdjs/org/cal/lhgcalendar.min.js'></script>
	<script type='text/javascript'>
		MODULE='/hanqun/install.php/Home'; //当前模块
		CONTROLLER='/hanqun/install.php/Home/Index'; //当前控制器)
		ACTION='/hanqun/install.php/Home/Index/step2';//当前方法(方法)
		ROOT='/hanqun'; //当前项目根路径
		PUBLIC= '/hanqun/Install/Home/View/Public';//当前定义的Public目录
	</script>
			<link href='/hanqun/Data/Public/org/bootstrap/css/bootstrap.min.css' rel='stylesheet' media='screen'>
			<script src='/hanqun/Data/Public/org/bootstrap/js/bootstrap.min.js'></script>
			<!--[if lte IE 6]>
			<link rel="stylesheet" type="text/css" href="/hanqun/Data/Public/org/bootstrap/ie6/css/bootstrap-ie6.css">
			<![endif]-->
			<!--[if lt IE 9]>
			<script src="/hanqun/Data/Public/org/bootstrap/js/html5shiv.min.js"></script>
			<script src="/hanqun/Data/Public/org/bootstrap/js/respond.min.js"></script>
			<![endif]-->

<link rel="stylesheet" type="text/css" href="/hanqun/Install/Home/View/Public/Css/base.css" />
<script type="text/javascript" src="/hanqun/Install/Home/View/Public/Js/base.js"></script>
</head>
<body>
<div class="container">
	<div class="container-title">
		<h1>欢迎使用TPCMS<small> 版本:<?php echo (C("tpcms_version")); ?></small></h1>

	</div>
		<h3>第二步：设置数据库连接和后台用户</h3>
		<script>
		var dbUrl = "<?php echo U('ajaxcheck');?>";
		</script>
		<form action="" method="post" class="hd-form">
		<div class="panel panel-primary">
			<div class="panel-heading">设置数据库连接</div>
				
				<table class="table table-bordered table-striped">	
			
					
					<tr>
						<td width="15%">链接地址</td>
						<td><input type="text" name='dblink' id='dblink'  value="localhost"  class='w200'/></td>
					</tr>

					<tr>
						<td>数据库名称</td>
						<td><input type="text" name='dbname' id='dbname' value="thinkcms" class='w200'/></td>
					</tr>
					<tr>
						<td>数据库表前缀</td>
						<td><input type="text" name='dbprefix' value="thinkcms_" class='w200'/></td>
					</tr>

						
					<tr>
						<td>数据库用户</td>
						<td><input type="text" name='dbuser' id='dbuser' value="root" class='w200'/></td>
					</tr>

					<tr>
						<td>数据库密码</td>
						<td><input type="password" name='dbpassword' id='dbpassword' class='w200'/></td>
					</tr>

					<tr>
						<td>是否安装测试数据</td>
						<td>

							<label class="radio-inline" >
							<input type="radio" name="installdata" value="1">是
							</label>
							<label  class="radio-inline">
							<input type="radio" name="installdata" value="0" checked="checked">否
							</label>
						</td>
					</tr>

				</table>
		
		</div>

		<div class="panel panel-primary">
			<div class="panel-heading">设置管理员</div>
				
				<table class="table table-bordered table-striped">	
			
					
					<tr>
						<td width="15%">账号</td>
						<td><input type="text" name='username' value="admin" class='w200'/></td>
					</tr>

					<tr>
						<td >昵称</td>
						<td><input type="text" name='nickname' value="点击未来" class='w200'/></td>
					</tr>
					
					<tr>
						<td>密码：</td>
						<td><input type="text" name='password' value="admin888" class='w200' /></td>
					</tr>

					<tr>
						<td >邮箱</td>
						<td><input type="text" name='email'  class='w200'/></td>
					</tr>

				</table>
		
		</div>


 		<div>
 			<a href="javascript:;" onclick="window.history.back()" class=" btn btn-primary btn-lg">上一步</a>
 			<a id='install' href="javascript:;"  class=" btn btn-primary btn-lg">执行安装</a>
 			
 		</div>
 		</form>
		</div>
    </body>
</html>