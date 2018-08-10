<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>检查环境-欢迎使用thinkcms</title>
		<script src="/hanqun/Data/Public/org/Jquery/jquery-1.11.2.min.js" type="text/javascript"></script>
	<link href='/hanqun/Data/Public/org/hdjs/hdjs.css' rel='stylesheet' media='screen'>
	<script type='text/javascript' src='/hanqun/Data/Public/org/hdjs/hdjs.min.js'></script>
	<script type='text/javascript' src='/hanqun/Data/Public/org/hdjs/org/cal/lhgcalendar.min.js'></script>
	<script type='text/javascript'>
		MODULE='/hanqun/install.php/Home'; //当前模块
		CONTROLLER='/hanqun/install.php/Home/Index'; //当前控制器)
		ACTION='/hanqun/install.php/Home/Index/step1';//当前方法(方法)
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
		<h3>第一步：检查目录权限、环境</h3>
		<div class="panel panel-primary">
			<div class="panel-heading">检查目录权限</div>
				<div class="panel-body alert alert-warning" role="alert">
   					<strong>请保证以下目录可以读写，否则安装会出现错误</strong>
  				</div>
				<table class="table table-bordered table-striped">	
					<tr>
						<th  width="20%">目录名称</th>
						<th>说明</th>
						<th  width="20%">可读可写</th>
					</tr>
					<?php if(is_array($dir)): foreach($dir as $key=>$v): ?><tr>
						<td><?php echo ($v["name"]); ?></td>
						<td><?php echo ($v["text"]); ?></td>
						<td><span class=' glyphicon <?php if($v['status']): ?>glyphicon-ok green<?php else: ?>glyphicon-remove red<?php endif; ?>'></span></td>
					</tr><?php endforeach; endif; ?>
				</table>
		</div>

		<div class="panel panel-primary">
			<div class="panel-heading">检查环境</div>
				<div class="panel-body alert alert-warning"  role="alert">
   					<strong>请保证开启以下环境，否则运行程序会出现错误</strong>
  				</div>
				<table class="table table-bordered table-striped">	
					<tr>
						<th width="20%">环境</th>
						<th >说明</th>
						<th width="20%">是否支持</th>
					</tr>
					<?php if(is_array($method)): foreach($method as $key=>$v): ?><tr>
						<td><?php echo ($v["name"]); ?></td>
						<td><?php echo ($v["text"]); ?></td>
						<td><span class=' glyphicon <?php if($v['status']): ?>glyphicon-ok green <?php else: ?>glyphicon-remove red<?php endif; ?>'></span></td>
					</tr><?php endforeach; endif; ?>
				</table>
		</div>

		<div>
			<a href="javascript:;" onclick="window.history.back()" class=" btn btn-primary btn-lg">上一步</a>

			<a href="<?php echo U('Index/step2');?>" onclick="return checkstatus()" class=" btn btn-primary btn-lg">下一步</a>
		</div>
		
		</div>
    </body>
</html>