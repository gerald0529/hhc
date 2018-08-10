DROP TABLE IF EXISTS `thinkcms_third`;{}
CREATE TABLE `thinkcms_third` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户表关联外键',
  `openid` varchar(100) NOT NULL DEFAULT '' COMMENT '开放id',
  `type` varchar(45) NOT NULL DEFAULT '' COMMENT '登录类型 qq,sina等',
  PRIMARY KEY (`id`),
  KEY `key_user_uid` (`user_uid`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='第三方登录';{}

DROP TABLE IF EXISTS `thinkcms_thirdlogin`;{}
CREATE TABLE `thinkcms_thirdlogin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL DEFAULT '' COMMENT '登录方式',
  `description` varchar(500) NOT NULL DEFAULT '' COMMENT '说明',
  `remark` varchar(45) NOT NULL DEFAULT '' COMMENT '第三方登录简码 qq sina 等',
  `partnerid` varchar(100) NOT NULL DEFAULT '' COMMENT '合作id',
  `secret` varchar(100) NOT NULL DEFAULT '' COMMENT '密钥',
  `verifystate` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '1不启用 2 启用',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='第三方登录设置';{}

-- ----------------------------
-- Records of thinkcms_thirdlogin
-- ----------------------------
INSERT INTO `thinkcms_thirdlogin` VALUES ('1', 'QQ登录', '会员使用QQ账号登录', 'qq', '', '', '1');{}
INSERT INTO `thinkcms_thirdlogin` VALUES ('2', '新浪微博', '会员使用新浪微博账号登录', 'sina', '', '', '1');{}