DROP TABLE IF EXISTS `thinkcms_link`;{}
CREATE TABLE `thinkcms_link` (
  `lid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(20) NOT NULL DEFAULT '' COMMENT '链接名称',
  `url` varchar(500) NOT NULL DEFAULT '' COMMENT '链接地址',
  `logo` varchar(200) NOT NULL DEFAULT '' COMMENT '链接logo',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `verifystate` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '1审核中，2审核通过，3失败',
  `people` char(20) NOT NULL DEFAULT '' COMMENT '申请人姓名',
  `email` char(60) NOT NULL DEFAULT '' COMMENT '申请人邮箱',
  `phone` char(11) NOT NULL DEFAULT '' COMMENT '申请人联系手机',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `user_uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户表关联',
  PRIMARY KEY (`lid`),
  KEY `fk_rb_link_rb_user_idx` (`user_uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='友情链接表';