/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50517
Source Host           : localhost:3306
Source Database       : dwz

Target Server Type    : MYSQL
Target Server Version : 50517
File Encoding         : 65001

Date: 2015-07-27 15:52:33
*/

SET FOREIGN_KEY_CHECKS=0;{}
-- ----------------------------
-- Table structure for thinkcms_ad
-- ----------------------------
DROP TABLE IF EXISTS `thinkcms_ad`;{}
CREATE TABLE `thinkcms_ad` (
  `aid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(50) NOT NULL DEFAULT '' COMMENT '广告名称',
  `name_en` char(50) NOT NULL DEFAULT '' COMMENT '英广告名称',
  `url` varchar(500) NOT NULL DEFAULT '' COMMENT '广告链接',
  `pic` varchar(200) NOT NULL DEFAULT '' COMMENT '广告图片',
  `pic_en` varchar(200) NOT NULL DEFAULT '' COMMENT '英广告图片',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `verifystate` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '1 审核中，2审核通过 ，3不通过',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `position_psid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '广告位置id',
  `user_uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户表关联',
  PRIMARY KEY (`aid`),
  KEY `fk_rb_ad_hd_position1_idx` (`position_psid`),
  KEY `fk_rb_ad_rb_user1_idx` (`user_uid`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 COMMENT='广告表';{}
-- ----------------------------
-- Records of thinkcms_ad
-- ----------------------------
INSERT INTO `thinkcms_ad` VALUES ('27', '首页', '', '', './Data/Uploads/image/2015/08/06/55c371c05e5e8.jpg', '', '1437979061', '2', '100', '1', '1'), ('2', '关于我们', '', '', './Data/Uploads/image/2015/08/06/55c370c2bcee3.jpg', '', '1418138470', '2', '100', '2', '1'), ('3', '产品管理', '', '', './Data/Uploads/image/2015/08/06/55c371889be3e.jpg', '', '1418138481', '2', '100', '3', '1'), ('4', '网站新闻', '', '', './Data/Uploads/image/2015/08/06/55c37193ecbcd.jpg', '1418138493', '0', '2', '100', '4', '1'), ('5', '人才招聘', '', '', './Data/Uploads/image/2015/08/06/55c371a053313.jpg', '', '1418138512', '2', '100', '5', '1'), ('6', '下载专区', '', '', './Data/Uploads/image/2015/08/06/55c371abcb21d.jpg', '', '1418138523', '2', '100', '6', '1'), ('7', '联系我们', '', '', './Data/Uploads/image/2015/08/06/55c371b70f782.jpg', '', '1418138538', '2', '100', '7', '1');{}

-- ----------------------------
-- Table structure for thinkcms_article
-- ----------------------------
DROP TABLE IF EXISTS `thinkcms_article`;{}
CREATE TABLE `thinkcms_article` (
  `aid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `article_title` char(255) NOT NULL DEFAULT '' COMMENT '文档标题',
  `article_title_en` char(255) NOT NULL DEFAULT '' COMMENT '英文档标题',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `click` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '点击次数',
  `flag` set('推荐','头条','图文') DEFAULT NULL COMMENT '属性',
  `is_top` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '0不置顶 ，1置顶',
  `keywords` varchar(500) NOT NULL DEFAULT '' COMMENT '关键字',
  `keywords_en` varchar(500) NOT NULL DEFAULT '' COMMENT '英关键字',
  `description` varchar(500) NOT NULL DEFAULT '' COMMENT '描述',
  `description_en` varchar(500) NOT NULL DEFAULT '' COMMENT '英描述',
  `file` varchar(200) NOT NULL DEFAULT '' COMMENT '下载地址',
  `pic` varchar(200) NOT NULL DEFAULT '' COMMENT '原图',
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `edittime` int(11) NOT NULL DEFAULT '0' COMMENT '编辑时间',
  `resource` char(20) NOT NULL DEFAULT '' COMMENT '来源',
  `verifystate` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '1审核中  2 审核通过  3审核失败',
  `tag` varchar(500) NOT NULL DEFAULT '' COMMENT 'tag标签',
  `seo_title` char(255) NOT NULL DEFAULT '' COMMENT 'seo标题',
  `tpl` varchar(45) NOT NULL DEFAULT '' COMMENT '模板',
  `user_uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户表关联',
  `category_cid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '栏目表关联',
  `file_url` varchar(255) NOT NULL DEFAULT '' COMMENT '文件名称',
  `jump_url` varchar(500) NOT NULL DEFAULT '' COMMENT '跳转地址',
  PRIMARY KEY (`aid`),
  KEY `fk_rb_article_rb_user1_idx` (`user_uid`),
  KEY `fk_rb_article_rb_category1_idx` (`category_cid`)
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=utf8 COMMENT='文档表';{}
-- ----------------------------
-- Records of thinkcms_article
-- ----------------------------
INSERT INTO `thinkcms_article` VALUES ('1', '公司简介', '', '100', '118', '', '0', '', '', '', '', '', '', '1418054400', '1437960184', '', '2', '', '', '', '1', '7', '', '');{}
INSERT INTO `thinkcms_article` VALUES ('2', '公司团队', '', '100', '101', '', '0', '', '', '', '', '', '', '1418054400', '1437382398', '', '2', '', '', '', '1', '8', '', '');{}
INSERT INTO `thinkcms_article` VALUES ('3', '人才理念', '', '100', '122', '', '0', '', '', '', '', '', '', '1418134234', '1418134234', '', '2', '', '', '', '1', '10', '', '');{}
INSERT INTO `thinkcms_article` VALUES ('4', '人才招聘', '', '100', '101', '', '0', '', '', '', '', '', '', '1418134242', '1418134242', '', '2', '', '', '', '1', '11', '', '');{}
INSERT INTO `thinkcms_article` VALUES ('5', '联系地址', '', '100', '113', '', '0', '', '', '', '', '', '', '1418054400', '1437381673', '', '2', '', '', '', '1', '9', '', '');{}
INSERT INTO `thinkcms_article` VALUES ('6', '新闻标题1', '', '100', '100', '推荐', '0', '', '', '', '', '', '', '1418054400', '1418135522', '来源', '2', '', '', '', '1', '12', '', '');{}
INSERT INTO `thinkcms_article` VALUES ('7', '新闻标题2', '', '100', '101', '推荐', '0', '', '', '', '', '', '', '-28800', '1418135409', '来源', '2', '', '', '', '1', '12', '', '');{}
INSERT INTO `thinkcms_article` VALUES ('8', '新闻标题3', '', '100', '101', '推荐', '0', '', '', '', '', '', '', '1418054400', '1418135516', '来源', '2', '', '', '', '1', '12', '', '');{}
INSERT INTO `thinkcms_article` VALUES ('9', '新闻标题4', '', '100', '100', '推荐', '0', '', '', '', '', '', '', '1418054400', '1418135511', '来源', '2', '', '', '', '1', '12', '', '');{}
INSERT INTO `thinkcms_article` VALUES ('10', '新闻标题5', '', '100', '102', '推荐', '0', '', '', '', '', '', '', '1418054400', '1437386448', '来源', '2', '', '', '', '1', '12', '', '');{}
INSERT INTO `thinkcms_article` VALUES ('11', '新闻标题6', '', '100', '103', '', '0', '', '', '', '', '', '', '1418054400', '1418135536', '来源', '2', '', '', '', '1', '13', '', '');{}
INSERT INTO `thinkcms_article` VALUES ('12', '新闻标题7', '', '100', '110', '', '0', '', '', '', '', '', '', '1418054400', '1418135451', '来源', '2', '', '', '', '1', '13', '', '');{}
INSERT INTO `thinkcms_article` VALUES ('13', '手册下载', '', '100', '100', '', '0', '', '', '', '', './Data/Uploads/file/2015/07/27/55b5c68bf16df.jpg', '', '1418054400', '1437977080', '', '2', '', '', '', '1', '14', '', '');{}
INSERT INTO `thinkcms_article` VALUES ('14', '系统下载', '', '100', '100', '', '0', '', '', '', '', './Data/Uploads/file/2015/07/27/55b5c67896ec6.jpg', '', '1418054400', '1437976186', '', '2', '', '', '', '1', '15', '', '');{}
INSERT INTO `thinkcms_article` VALUES ('15', '产品名称1', '', '100', '103', '', '0', '', '', '', '', '', './Data/Uploads/image/2015/08/06/55c3760d324d6.jpg', '1418054400', '1437975204', '', '2', '', '', '', '1', '16', '', '');{}
INSERT INTO `thinkcms_article` VALUES ('16', '产品名称2', '', '100', '100', '推荐', '0', '', '', '', '', '', './Data/Uploads/image/2015/08/06/55c37601d689a.jpg', '1418054400', '1437979845', '', '2', '', '', '', '1', '16', '', '');{}
INSERT INTO `thinkcms_article` VALUES ('17', '首页公司简介', '', '100', '100', '', '0', '', '', '', '', '', '', '1418137500', '1418137500', '', '2', '', '', '', '1', '18', '', '');{}

-- ----------------------------
-- Table structure for thinkcms_debris
-- ----------------------------
DROP TABLE IF EXISTS `thinkcms_debris`;
CREATE TABLE `thinkcms_debris` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(255) NOT NULL DEFAULT '' COMMENT '碎片标题',
  `title_en` char(255) NOT NULL DEFAULT '' COMMENT '英碎片标题',
  `pic_en` varchar(500) NOT NULL DEFAULT '' COMMENT '英图片',
  `pic` varchar(500) NOT NULL DEFAULT '' COMMENT '图片',
  `body` text COMMENT '详细内容',
  `body_en` text COMMENT '英详细内容',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='碎片表';

-- ----------------------------
-- Records of thinkcms_debris
-- ----------------------------


-- ----------------------------
-- Table structure for thinkcms_qq
-- ----------------------------
DROP TABLE IF EXISTS `thinkcms_qq`;
CREATE TABLE `thinkcms_qq` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `account` char(255) NOT NULL DEFAULT '' COMMENT '号码',
  `name` char(255) NOT NULL DEFAULT '' COMMENT '名称',
  `name_en` char(255) NOT NULL DEFAULT '' COMMENT '英名称',
  `type` char(255) NOT NULL DEFAULT '' COMMENT '类型',
  `sort` int(10) NOT NULL DEFAULT '100' COMMENT '排序',
  `url` varchar(500) NOT NULL DEFAULT '' COMMENT '拼凑链接',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='QQ客服表';

-- ----------------------------
-- Records of thinkcms_qq
-- ----------------------------


-- ----------------------------
-- Table structure for thinkcms_article_about
-- ----------------------------
DROP TABLE IF EXISTS `thinkcms_article_about`;{}
CREATE TABLE `thinkcms_article_about` (
  `article_aid` int(10) unsigned NOT NULL COMMENT '主表关联外键',
  `body` text COMMENT '详细内容',
  KEY `fk_rb_article_data_rb_article1_idx` (`article_aid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='公司介绍';{}
-- ----------------------------
-- Records of thinkcms_article_about
-- ----------------------------
INSERT INTO `thinkcms_article_about` VALUES ('1', '<span style=\"line-height:1.5;\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;是一家专业从事互联网视觉营销、创意交互、品牌策划以及优化推广的专业服务机构。作为一家专业的品牌视觉营销公司，在提供优质的网站设计建设与网页设计制作服务的同时，也为企业提供整体的互联网品牌形象改造管理解决方案。\n在以提高企业营销目的基础之上进行个性化的定制服务。意将视觉营销、品牌传播、互动体验、创意设计、策略执行五者有机融合，通过采用多种的传播手段及互动产品，为企业的品牌推广提供优质高效的服务。\n我们认为，一个能够健康发展的品牌就如一颗枝叶繁茂的大树，创意的绿叶是品牌的标志，而以销售为目的功能需求更是根脉扎根市场汲取养分的重要利器。所以我们追求作品在美观和销售功能上的平衡点，美观而不失功能，易用而不失创意，是我们的首要设计守则。&nbsp;</span> \n<p>\n	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;我们旨在为企业的价值寻找突破点，以提供优质的服务及解决方案为企业成就品牌。我们作为一家专业的视觉营销创意设计公司，具有完备且专业的项目流程。\n从需求调研、创意设计、成稿审核、演示讲解都具有专业且规范的流程行为指导，力求在双方互通互信的基础之上，将服务做到最优，以优质的服务铸就品牌的成长。与客户一起创造共同价值，与客户共同发展。\n</p>');{}
INSERT INTO `thinkcms_article_about` VALUES ('2', '公司团队公司团队公司团队公司团队公司团队公司团队公司团队公司团队公司团队公司团队公司团队');{}
INSERT INTO `thinkcms_article_about` VALUES ('17', '物流有限公司通过全体员工的不懈努力，现已成功组建了一支组织健全、经验丰富、设施完善，具有一定影响力的专业物流运输车队。 \r\n我们主要经营南京至全国各地的公路运输线路，同时提供超一流的货物包装及现代化仓储、物流服务。为客户节约开支，安全经营，减少风险。您的满意，我的追求。');{}

-- ----------------------------
-- Table structure for thinkcms_article_attr
-- ----------------------------
DROP TABLE IF EXISTS `thinkcms_article_attr`;{}
CREATE TABLE `thinkcms_article_attr` (
  `article_attr_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `attr_attr_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '文档属性表关联外键',
  `category_cid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '栏目关联外键',
  `article_aid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '文档关联外键',
  `type_typeid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '属性值',
  `attr_value` varchar(100) NOT NULL DEFAULT '' COMMENT '属性值',
  `attr_value_attr_value_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '属性值表关联字段',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '展示类型 1单选 2多选',
  `is_pic` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`article_attr_id`),
  KEY `fk_thinkcms_article_attr_thinkcms_attr1_idx` (`attr_attr_id`),
  KEY `fk_thinkcms_article_attr_thinkcms_category1_idx` (`category_cid`),
  KEY `fk_thinkcms_article_attr_thinkcms_article1_idx` (`article_aid`),
  KEY `fk_thinkcms_article_attr_thinkcms_type1_idx` (`type_typeid`),
  KEY `fk_thinkcms_article_attr_thinkcms_attr_value1_idx` (`attr_value_attr_value_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='文档和属性表关联中间表';{}

-- ----------------------------
-- Records of thinkcms_article_attr
-- ----------------------------

-- ----------------------------
-- Table structure for thinkcms_article_contact
-- ----------------------------
DROP TABLE IF EXISTS `thinkcms_article_contact`;{}
CREATE TABLE `thinkcms_article_contact` (
  `article_aid` int(10) unsigned NOT NULL COMMENT '主表关联外键',
  `body` text COMMENT '详细内容',
  KEY `fk_rb_article_data_rb_article1_idx` (`article_aid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='联系我们';{}
-- ----------------------------
-- Records of thinkcms_article_contact
-- ----------------------------
INSERT INTO `thinkcms_article_contact` VALUES ('5', '联系地址联系地址联系地址联系地址联系地址联系地址联系地址');{}
-- ----------------------------
-- Table structure for thinkcms_article_download
-- ----------------------------
DROP TABLE IF EXISTS `thinkcms_article_download`;{}
CREATE TABLE `thinkcms_article_download` (
  `article_aid` int(10) unsigned NOT NULL COMMENT '主表关联外键',
  `body` text COMMENT '详细内容',
  `testdown` varchar(255) NOT NULL DEFAULT '' COMMENT '下载',
  KEY `fk_rb_article_data_rb_article1_idx` (`article_aid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='下载专区';{}
-- ----------------------------
-- Records of thinkcms_article_download
-- ----------------------------
INSERT INTO `thinkcms_article_download` VALUES ('13', '', './Data/Uploads/file/2015/07/27/55b5c9f5d7305.jpg');{}
INSERT INTO `thinkcms_article_download` VALUES ('14', '', '');{}

-- ----------------------------
-- Table structure for thinkcms_article_news
-- ----------------------------
DROP TABLE IF EXISTS `thinkcms_article_news`;{}
CREATE TABLE `thinkcms_article_news` (
  `article_aid` int(10) unsigned NOT NULL COMMENT '主表关联外键',
  `body` text COMMENT '详细内容',
  `author` varchar(255) NOT NULL DEFAULT '' COMMENT '作者',
  `resource` varchar(255) NOT NULL DEFAULT '' COMMENT '来源',
  KEY `fk_rb_article_data_rb_article1_idx` (`article_aid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='新闻模型';{}
-- ----------------------------
-- Records of thinkcms_article_news
-- ----------------------------
INSERT INTO `thinkcms_article_news` VALUES ('6', '新闻标题1新闻标题1新闻标题1新闻标题1新闻标题1', '作者', '来源');{}
INSERT INTO `thinkcms_article_news` VALUES ('7', '新闻标题2新闻标题2新闻标题2新闻标题2', '作者', '来源');{}
INSERT INTO `thinkcms_article_news` VALUES ('8', '新闻标题3新闻标题3新闻标题3新闻标题3', '作者', '来源');{}
INSERT INTO `thinkcms_article_news` VALUES ('9', '新闻标题4新闻标题4新闻标题4新闻标题4', '作者', '来源');{}
INSERT INTO `thinkcms_article_news` VALUES ('10', '新闻标题5新闻标题5新闻标题5', '作者', '来源');{}
INSERT INTO `thinkcms_article_news` VALUES ('11', '新闻标题6新闻标题6新闻标题6新闻标题6', '作者', '来源');{}
INSERT INTO `thinkcms_article_news` VALUES ('12', '新闻标题7新闻标题7新闻标题7新闻标题7', '作者', '来源');{}

-- ----------------------------
-- Table structure for thinkcms_article_pic
-- ----------------------------
DROP TABLE IF EXISTS `thinkcms_article_pic`;{}
CREATE TABLE `thinkcms_article_pic` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `big` varchar(200) NOT NULL DEFAULT '' COMMENT '大图',
  `medium` varchar(200) NOT NULL DEFAULT '' COMMENT '中图',
  `small` varchar(200) NOT NULL DEFAULT '' COMMENT '小图',
  `article_aid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '文档关联外键',
  `attr_value_attr_value_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '属性值关联外键',
   `sort` int(10) NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`),
  KEY `fk_rb_pic_rb_article1_idx` (`article_aid`),
  KEY `fk_thinkcms_article_pic_thinkcms_attr_value1_attr_value_idx` (`attr_value_attr_value_id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COMMENT='图集';{}

-- ----------------------------
-- Records of thinkcms_article_pic
-- ----------------------------

-- ----------------------------
-- Table structure for thinkcms_article_products
-- ----------------------------
DROP TABLE IF EXISTS `thinkcms_article_products`;{}
CREATE TABLE `thinkcms_article_products` (
  `article_aid` int(10) unsigned NOT NULL COMMENT '主表关联外键',
  `body` text COMMENT '详细内容',
  KEY `fk_rb_article_data_rb_article1_idx` (`article_aid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='产品管理';{}

-- ----------------------------
-- Records of thinkcms_article_products
-- ----------------------------
INSERT INTO `thinkcms_article_products` VALUES ('15', '详细内容详细内容详细内容详细内容详细内容');{}
INSERT INTO `thinkcms_article_products` VALUES ('16', '详细内容详细内容详细内容详细内容');{}

-- ----------------------------
-- Table structure for thinkcms_article_recruitment
-- ----------------------------
DROP TABLE IF EXISTS `thinkcms_article_recruitment`;{}
CREATE TABLE `thinkcms_article_recruitment` (
  `article_aid` int(10) unsigned NOT NULL COMMENT '主表关联外键',
  `body` text COMMENT '详细内容',
  KEY `fk_rb_article_data_rb_article1_idx` (`article_aid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='人才招聘';{}

-- ----------------------------
-- Records of thinkcms_article_recruitment
-- ----------------------------
INSERT INTO `thinkcms_article_recruitment` VALUES ('3', '人才理念人才理念人才理念人才理念人才理念人才理念人才理念人才理念');{}
INSERT INTO `thinkcms_article_recruitment` VALUES ('4', '人才招聘人才招聘人才招聘人才招聘人才招聘人才招聘');{}

-- ----------------------------
-- Table structure for thinkcms_article_test
-- ----------------------------
DROP TABLE IF EXISTS `thinkcms_article_test`;{}
CREATE TABLE `thinkcms_article_test` (
  `article_aid` int(10) unsigned NOT NULL COMMENT '主表关联外键',
  `body` text COMMENT '详细内容',
  `info` varchar(255) NOT NULL DEFAULT '' COMMENT '说明',
  `image_upload` varchar(255) NOT NULL DEFAULT '' COMMENT '附件图片',
  KEY `fk_rb_article_data_rb_article1_idx` (`article_aid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='测试';{}

-- ----------------------------
-- Records of thinkcms_article_test
-- ----------------------------

-- ----------------------------
-- Table structure for thinkcms_attr
-- ----------------------------
DROP TABLE IF EXISTS `thinkcms_attr`;{}
CREATE TABLE `thinkcms_attr` (
  `attr_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `attr_name` varchar(30) NOT NULL DEFAULT '' COMMENT '类型说明',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '1 单选， 2多选',
  `type_typeid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '文档类型关联外键',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `is_pic` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否需要有图集 1需要   0 不需要',
  PRIMARY KEY (`attr_id`),
  KEY `fk_thinkcms_attr_thinkcms_type1_idx` (`type_typeid`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='文档属性，用于筛选';{}

-- ----------------------------
-- Records of thinkcms_attr
-- ----------------------------
INSERT INTO `thinkcms_attr` VALUES ('3', '尺寸', '1', '9', '2', '0');{}
INSERT INTO `thinkcms_attr` VALUES ('5', '颜色', '1', '9', '1', '0');{}

-- ----------------------------
-- Table structure for thinkcms_attr_value
-- ----------------------------
DROP TABLE IF EXISTS `thinkcms_attr_value`;{}
CREATE TABLE `thinkcms_attr_value` (
  `attr_value_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `attr_value` varchar(100) NOT NULL DEFAULT '' COMMENT '属性值',
  `attr_attr_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '文档属性关联外键',
  `attr_value_name` varchar(255) NOT NULL DEFAULT '' COMMENT '名称',
  `attr_value_sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`attr_value_id`),
  KEY `fk_think_attr_value_think_attr1_idx` (`attr_attr_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COMMENT='文档类型默认值';{}
-- ----------------------------
-- Records of thinkcms_attr_value
-- ----------------------------
INSERT INTO `thinkcms_attr_value` VALUES ('8', 'M', '3', '中', '2');{}
INSERT INTO `thinkcms_attr_value` VALUES ('7', 'S', '3', '小', '1');{}
INSERT INTO `thinkcms_attr_value` VALUES ('9', 'L', '3', '大', '3');{}
INSERT INTO `thinkcms_attr_value` VALUES ('10', 'XL', '3', 'XL', '4');{}
INSERT INTO `thinkcms_attr_value` VALUES ('11', 'red', '5', '红色', '0');{}
INSERT INTO `thinkcms_attr_value` VALUES ('12', 'purple', '5', '紫色', '0');{}

-- ----------------------------
-- Table structure for thinkcms_auth_group
-- ----------------------------
DROP TABLE IF EXISTS `thinkcms_auth_group`;{}
CREATE TABLE `thinkcms_auth_group` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `rules` varchar(500) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='用户组表';{}

-- ----------------------------
-- Records of thinkcms_auth_group
-- ----------------------------
INSERT INTO `thinkcms_auth_group` VALUES ('6', '普通管理员', '1', '1,2,20,3,4,19,6,7,8,67,30,31,32,33,34,35,36,37,38,39,40,41,43,44,45,46,47,49,50,51,52,53,54,55,56,57,59,60,61,62,63,64,65,66,87,68,69,70,71,72,73,74,75,76,77,78,112,113,114,115,116,79,80,81,82,83,84,85,86,88,89,90,91,100,101,102,103,104,105,106,107,108,109,110,111,92,93,94,95,96,97,98,99');{}
INSERT INTO `thinkcms_auth_group` VALUES ('7', '客服管理员', '1', '67,30,31,32,33,34,35,36,37,38,39,40,41,43,44,45,46,47,49,50,51,52,53,54,55,56,57,59,60,61,62,63,64,65,66,87,68,69,70,71,72,73,74,75,76,77,78,112,113,114,115,116,79,80,81,82,83,84,85,86,88,89,90,91,100,101,102,103,104,105,106,107,108,109,110,111,96,97,98,99');{}

-- ----------------------------
-- Table structure for thinkcms_auth_group_access
-- ----------------------------
DROP TABLE IF EXISTS `thinkcms_auth_group_access`;{}
CREATE TABLE `thinkcms_auth_group_access` (
  `uid` int(10) unsigned NOT NULL,
  `group_id` int(10) unsigned NOT NULL,
  UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
  KEY `uid` (`uid`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户表明细';{}


-- ----------------------------
-- Table structure for thinkcms_auth_rule
-- ----------------------------
DROP TABLE IF EXISTS `thinkcms_auth_rule`;{}
CREATE TABLE `thinkcms_auth_rule` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(80) NOT NULL DEFAULT '',
  `title` char(20) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `condition` char(100) NOT NULL DEFAULT '',
  `pid` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '父级id',
  `level` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '级别',
  `isnavshow` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否显示导航',
  `sort` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=117 DEFAULT CHARSET=utf8 COMMENT='规则表';{}

-- ----------------------------
-- Records of thinkcms_auth_rule
-- ----------------------------
INSERT INTO `thinkcms_auth_rule` VALUES ('1', 'config', '设置', '1', '', '0', '1', '0', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('2', 'admin-config', '系统设置', '1', '', '1', '2', '1', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('3', 'admin-config-edit', '更新设置', '1', '', '2', '3', '0', '2');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('4', 'admin-config-add', '新增设置', '1', '', '2', '3', '0', '3');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('70', 'admin-usergrade-add', '添加会员等级', '1', '', '68', '3', '0', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('6', 'admin-backup-add', '备份数据库', '1', '', '2', '3', '0', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('7', 'admin-backup-recover', '还原数据库', '1', '', '2', '3', '0', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('8', 'admin-backup-del', '删除备份', '1', '', '2', '3', '0', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('9', 'admin-manager', '管理员设置', '1', '', '1', '2', '1', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('10', 'admin-manager-add', '新增管理员', '1', '', '9', '3', '0', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('11', 'admin-manager-edit', '编辑管理员', '1', '', '9', '3', '0', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('69', 'admin-usergrade-index', '等级管理', '1', '', '68', '3', '1', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('13', 'admin-authgroup-index', '角色管理', '1', '', '9', '3', '1', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('14', 'admin-manager-index', '管理员管理', '1', '', '9', '3', '1', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('15', 'admin-manager-check', '锁定管理员', '1', '', '9', '3', '0', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('16', 'admin-manager-cancel_check', '解锁管理员', '1', '', '9', '3', '0', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('17', 'admin-manager-batch_delete', '批量删除管理员', '1', '', '9', '3', '0', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('18', 'admin-manager-del', '删除管理员', '1', '', '9', '3', '0', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('19', 'admin-backup-index', '数据库备份', '1', '', '2', '3', '1', '4');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('20', 'admin-config-index', '站点配置', '1', '', '2', '3', '1', '1');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('21', 'admin-authgroup-add', '添加角色', '1', '', '9', '3', '0', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('22', 'admin-authgroup-edit', '编辑角色', '1', '', '9', '3', '0', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('23', 'admin-authgroup-del', '删除角色', '1', '', '9', '3', '0', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('24', 'admin-authgroup-rule', '分配权限', '1', '', '9', '3', '0', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('68', 'admin-user', '会员信息管理', '1', '', '67', '2', '1', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('26', 'admin-authrule-index', '规则管理', '1', '', '9', '3', '1', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('27', 'admin-authrule-add', '添加规则', '1', '', '9', '3', '0', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('28', 'admin-authrule-edit', '编辑规则', '1', '', '9', '3', '0', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('29', 'admin-authrule-delete', '删除规则', '1', '', '9', '3', '0', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('30', 'admin-article', '内容信息管理', '1', '', '67', '2', '1', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('31', 'admin-article-welcome', '管理内容', '1', '', '30', '3', '1', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('32', 'admin-article-index', '查看文档', '1', '', '30', '3', '0', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('33', 'admin-article-add', '添加文档', '1', '', '30', '3', '0', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('34', 'admin-article-edit', '编辑文档', '1', '', '30', '3', '0', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('35', 'admin-article-del', '删除文档', '1', '', '30', '3', '0', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('36', 'admin-article-sort', '排序文档', '1', '', '30', '3', '0', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('37', 'admin-article-check', '审核文档', '1', '', '30', '3', '0', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('38', 'admin-article-cancel_check', '取消审核文档', '1', '', '30', '3', '0', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('39', 'admin-article-batch_delete', '批量删除文档', '1', '', '30', '3', '0', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('40', 'admin-article-operation', '设置文档属性', '1', '', '30', '3', '0', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('41', 'admin-article-cancel_opration', '取消设置文档属性', '1', '', '30', '3', '0', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('67', 'content', '内容', '1', '', '0', '1', '0', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('43', 'admin-category-index', '栏目列表', '1', '', '30', '3', '1', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('44', 'admin-category-add', '添加栏目', '1', '', '30', '3', '0', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('45', 'admin-category-edit', '编辑栏目', '1', '', '30', '3', '0', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('46', 'admin-category-del', '删除栏目', '1', '', '30', '3', '0', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('47', 'admin-category-sort', '排序栏目', '1', '', '30', '3', '0', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('66', 'admin-upload-del', '删除附件', '1', '', '30', '3', '0', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('49', 'admin-type-index', '栏目类型', '1', '', '30', '3', '1', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('50', 'admin-type-add', '添加栏目类型', '1', '', '30', '3', '0', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('51', 'admin-type-edit', '编辑栏目类型', '1', '', '30', '3', '0', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('52', 'admin-type-del', '删除栏目类型', '1', '', '30', '3', '0', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('53', 'admin-attr-index', '查看栏目类型属性', '1', '', '30', '3', '0', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('54', 'admin-attr-add', '添加栏目类型属性', '1', '', '30', '3', '0', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('55', 'admin-attr-edit', '编辑栏目类型属性', '1', '', '30', '3', '0', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('56', 'admin-attr-del', '删除栏目类型属性', '1', '', '30', '3', '0', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('57', 'admin-attr-sort', '排序栏目类型属性', '1', '', '30', '3', '0', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('65', 'admin-upload-index', '附件管理', '1', '', '30', '3', '1', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('59', 'admin-feedback-index', '留言管理', '1', '', '30', '3', '1', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('60', 'admin-feedback-edit', '查看留言详细', '1', '', '30', '3', '0', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('61', 'admin-feedback-del', '删除留言', '1', '', '30', '3', '0', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('62', 'admin-feedbac-check', '设置留言已读取', '1', '', '30', '3', '0', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('63', 'admin-feedback-cancel_check', '设置留言未读', '1', '', '30', '3', '0', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('64', 'admin-feedback-batch_delete', '批量删除留言', '1', '', '30', '3', '0', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('71', 'admin-usergrade-edit', '删除会员等级', '1', '', '68', '3', '0', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('72', 'admin-user-index', '会员管理', '1', '', '68', '3', '1', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('73', 'admin-user-add', '新增会员', '1', '', '68', '3', '0', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('74', 'admin-user-edit', '编辑会员', '1', '', '68', '3', '0', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('75', 'admin-user-del', '删除会员', '1', '', '68', '3', '0', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('76', 'admin-user-check', '锁定会员', '1', '', '68', '3', '0', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('77', 'admin-user-cancel_check', '解锁会员', '1', '', '68', '3', '0', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('78', 'admin-user-batch_delete', '批量删除会员', '1', '', '68', '3', '0', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('79', 'admin-ad', '广告信息管理', '1', '', '67', '2', '1', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('80', 'admin-ad-index', '广告列表', '1', '', '79', '3', '0', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('81', 'admin-ad-add', '添加广告', '1', '', '79', '3', '0', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('82', 'admin-add-edit', '编辑广告', '1', '', '79', '3', '0', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('83', 'admin-ad-sort', '排序广告', '1', '', '79', '3', '0', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('84', 'admin-ad-check', '审核广告', '1', '', '79', '3', '0', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('85', 'admin-ad-cancel_check', '取消审核广告', '1', '', '79', '3', '0', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('86', 'admin-ad-batch_delete', '批量删除广告', '1', '', '79', '3', '0', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('87', 'admin-upload-batch_delete', '批量删除附件', '1', '', '30', '3', '0', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('88', 'admin-position-index', '广告位置', '1', '', '67', '2', '0', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('89', 'admin-position-add', '添加广告位置', '1', '', '88', '3', '0', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('90', 'admin-batch-edit', '编辑广告位置', '1', '', '88', '3', '0', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('91', 'admin-position-del', '删除广告位置', '1', '', '88', '3', '0', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('92', 'templates', '界面', '1', '', '0', '1', '1', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('93', 'admin-templates', '模板管理', '1', '', '92', '2', '1', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('94', 'admin-templates-index', '模板风格', '1', '', '93', '3', '1', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('95', 'admin-templates-set_templates', '设置风格', '1', '', '93', '3', '0', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('96', 'pannel', '我的面板', '1', '', '0', '1', '1', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('97', 'pesonal', '个人信息', '1', '', '96', '2', '1', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('98', 'admin-user-info', '修改个人信息', '1', '', '97', '3', '1', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('99', 'admin-user-change', '修改密码', '1', '', '97', '3', '1', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('100', 'other', '内容相关设置', '1', '', '67', '2', '1', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('101', 'admin-flag-index', '推荐属性', '1', '', '100', '3', '1', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('102', 'admin-model-index', '模型管理', '1', '', '100', '3', '1', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('103', 'admin-model-add', '添加模型', '1', '', '100', '3', '0', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('104', 'admin-model-edit', '编辑模型', '1', '', '100', '3', '0', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('105', 'admin-model-del', '删除模型', '1', '', '100', '3', '0', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('106', 'admin-modelfield-index', '查看模型字段', '1', '', '100', '3', '0', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('107', 'admin-modelfield-add', '添加模型字段', '1', '', '100', '3', '0', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('108', 'admin-modelfield-edit', '编辑模型字段', '1', '', '100', '3', '0', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('109', 'admin-modelfield-del', '删除模型字段', '1', '', '100', '3', '0', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('110', 'admin-modelfield-sort', '排序模型字段', '1', '', '100', '3', '0', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('111', 'admin-modelfield-batch_delete', '批量删除模型字段', '1', '', '100', '3', '0', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('112', 'admin-usercomment-index', '评论管理', '1', '', '68', '3', '1', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('113', 'admin-usercomment-check', '审核评论', '1', '', '68', '3', '0', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('114', 'admin-usercomment-del', '删除评论', '1', '', '68', '3', '0', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('115', 'admin-usercomment-cancel_check', '取消审核评论', '1', '', '68', '3', '0', '100');{}
INSERT INTO `thinkcms_auth_rule` VALUES ('116', 'admin-usercomment-batch_del', '批量删除会员评论', '1', '', '68', '3', '0', '100');{}

-- ----------------------------
-- Table structure for thinkcms_category
-- ----------------------------
DROP TABLE IF EXISTS `thinkcms_category`;{}
CREATE TABLE `thinkcms_category` (
  `cid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cname` char(255) NOT NULL DEFAULT '' COMMENT '分类名称',
  `cname_en` char(255) NOT NULL DEFAULT '' COMMENT '英分类名称',
  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '父级id',
  `cat_type` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '1封面 2单一内容 3普通 4跳转',
  `go_url` varchar(500) NOT NULL DEFAULT '' COMMENT '跳转地址',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `pic` varchar(200) NOT NULL DEFAULT '' COMMENT '栏目图片',
  `pic_en` varchar(200) NOT NULL DEFAULT '' COMMENT '栏目英文图片',
  `page` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '每一页记录数',
  `go_child` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '0 不跳转到子分类 1 跳转到子分类',
  `seo_title` varchar(200) NOT NULL DEFAULT '' COMMENT 'seo标题',
  `keywords` varchar(500) NOT NULL DEFAULT '' COMMENT '关键字',
  `keywords_en` varchar(500) NOT NULL DEFAULT '' COMMENT '英关键字',
  `description` varchar(500) NOT NULL DEFAULT '' COMMENT '描述',
  `description_en` varchar(500) NOT NULL DEFAULT '' COMMENT '英描述',
  `default_tpl` char(20) NOT NULL DEFAULT '' COMMENT '封面模板',
  `list_tpl` char(20) NOT NULL DEFAULT '' COMMENT '列表模板',
  `view_tpl` char(20) NOT NULL DEFAULT '' COMMENT '视图模板',
  `model_mid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '模型关联外键',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '控制器',
  `type_typeid` int(10) unsigned NOT NULL COMMENT '文档类型管理外键',
  `target` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '1当前窗口 2 新窗口',
  `is_show` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '是否显示 1 显示 0 不显示',
  `file_url` varchar(60) NOT NULL DEFAULT '' COMMENT '自定义访问文件名称',
  PRIMARY KEY (`cid`),
  KEY `fk_rb_category_rb_model1_idx` (`model_mid`),
  KEY `fk_thinkcms_category_thinkcms_type1_idx` (`type_typeid`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COMMENT='栏目表';{}
-- ----------------------------
-- Records of thinkcms_category
-- ----------------------------
INSERT INTO `thinkcms_category` VALUES ('1', '关于我们', '', '0', '4', '', '100', '', '','20', '1', '', '', '', '', '', 'default', 'lists', 'view', '2', 'About', '0', '1', '1', '');{}
INSERT INTO `thinkcms_category` VALUES ('2', '产品管理', '', '0', '1', '', '100', '', '', '20', '0', '', '', '', '', '', 'default', 'lists', 'view', '3', 'Products', '0', '1', '1', '');{}
INSERT INTO `thinkcms_category` VALUES ('3', '网站新闻', '', '0', '1', '', '100','', '', '20', '0', '', '', '', '', '', 'default', 'lists', 'view', '1', 'News', '0', '1', '1', '');{}
INSERT INTO `thinkcms_category` VALUES ('4', '人才招聘', '', '0', '4', '', '100','', '', '20', '1', '', '', '', '', '', 'default', 'lists', 'view', '4', 'Recruitment', '0', '1', '1', '');{}
INSERT INTO `thinkcms_category` VALUES ('5', '下载专区', '', '0', '1', '', '100', '','', '20', '0', '', '', '', '', '', 'default', 'lists', 'view', '5', 'Download', '0', '1', '1', '');{}
INSERT INTO `thinkcms_category` VALUES ('6', '联系我们', '', '0', '4', '', '100','', '', '20', '1', '', '', '', '', '', 'default', 'lists', 'view', '6', 'Contact', '0', '1', '1', '');{}
INSERT INTO `thinkcms_category` VALUES ('7', '公司简介', '', '1', '4', '', '100','','', '20', '1', '', '', '', '', '', 'default', 'lists', 'view', '2', 'About', '0', '1', '1', '');{}
INSERT INTO `thinkcms_category` VALUES ('8', '公司团队', '', '1', '4', '', '100', '','', '20', '1', '', '', '', '', '', 'default', 'lists', 'view', '2', 'About', '0', '1', '1', '');{}
INSERT INTO `thinkcms_category` VALUES ('9', '联系地址', '', '6', '4', '', '100', '', '', '20', '1', '', '', '', '', '', 'default', 'lists', 'view', '6', 'Contact', '0', '1', '1', '');{}
INSERT INTO `thinkcms_category` VALUES ('10', '人才理念', '', '4', '4', '', '100','', '', '20', '1', '', '', '', '', '', 'default', 'lists', 'view', '4', 'Recruitment', '0', '1', '1', '');{}
INSERT INTO `thinkcms_category` VALUES ('11', '人才招聘', '', '4', '4', '', '100','', '', '20', '1', '', '', '', '', '', 'default', 'lists', 'view', '4', 'Recruitment', '0', '1', '1', '');{}
INSERT INTO `thinkcms_category` VALUES ('12', '公司新闻', '', '3', '1', '', '100','', '', '20', '0', '', '', '', '', '', 'default', 'lists', 'view', '1', 'News', '0', '1', '1', '');{}
INSERT INTO `thinkcms_category` VALUES ('13', '行业新闻', '', '3', '1', '', '100','', '', '20', '0', '', '', '', '', '', 'default', 'lists', 'view', '1', 'News', '0', '1', '1', '');{}
INSERT INTO `thinkcms_category` VALUES ('14', '产品手册', '', '5', '1', '', '100','', '', '20', '0', '', '', '', '', '', 'default', 'lists', 'view', '5', 'Download', '0', '1', '1', '');{}
INSERT INTO `thinkcms_category` VALUES ('15', '产品系统', '', '5', '1', '', '100','', '', '20', '0', '', '', '', '', '', 'default', 'lists', 'view', '5', 'Download', '0', '1', '1', '');{}
INSERT INTO `thinkcms_category` VALUES ('16', '产品分类1', '', '2', '1', '', '100','', '', '20', '0', '', '', '', '', '', 'default', 'lists', 'view', '3', 'Products', '0', '1', '1', '');{}
INSERT INTO `thinkcms_category` VALUES ('17', '产品分类2', '', '2', '1', '', '100','', '', '20', '0', '', '', '', '', '', 'default', 'lists', 'view', '3', 'Products', '0', '1', '1', '');{}
INSERT INTO `thinkcms_category` VALUES ('18', '首页公司简介', '', '0', '4', '', '100','','',  '20', '0', '', '', '', '', '', 'default', 'lists', 'view', '2', 'Index', '0', '1', '1', '');{}

-- ----------------------------
-- Table structure for thinkcms_config
-- ----------------------------
DROP TABLE IF EXISTS `thinkcms_config`;{}
CREATE TABLE `thinkcms_config` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` char(100) NOT NULL DEFAULT '' COMMENT '引用代码',
  `title` char(80) NOT NULL DEFAULT '' COMMENT '中文说明',
  `body` varchar(500) NOT NULL DEFAULT '' COMMENT '具体信息',
  `config_type` tinyint(4) NOT NULL DEFAULT '2' COMMENT '1图片 2单行文本 3 多行文本',
  `group` enum('基本设置','更多设置') NOT NULL DEFAULT '基本设置',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COMMENT='网站配置';{}
-- ----------------------------
-- Records of thinkcms_config
-- ----------------------------
INSERT INTO `thinkcms_config` VALUES ('1', 'cfg_name', '网站标题', '绿黑色物流网站设计G', '2', '基本设置', '0');{}
INSERT INTO `thinkcms_config` VALUES ('2', 'cfg_keywords', '关键字', '关键字', '3', '基本设置', '0');{}
INSERT INTO `thinkcms_config` VALUES ('3', 'cfg_description', '描述', '描述', '3', '基本设置', '0');{}
INSERT INTO `thinkcms_config` VALUES ('4', 'cfg_copyright', '底部信息', 'Copyright@ 2013-2014 \n版权所有：绿黑色物流网站设计G', '3', '基本设置', '0');{}
INSERT INTO `thinkcms_config` VALUES ('11', 'cfg_address', '地址', '软件园二期望海路2号', '2', '基本设置', '0');{}
INSERT INTO `thinkcms_config` VALUES ('9', 'cfg_image', '图片上传格式', 'gif|png|jpg|jpeg', '3', '更多设置', '0');{}
INSERT INTO `thinkcms_config` VALUES ('6', 'cfg_logo', 'LOGO', './Data/Uploads/image/2015/08/06/55c371ec3d5e0.png', '1', '更多设置', '0');{}
INSERT INTO `thinkcms_config` VALUES ('7', 'cfg_icp', '备案号', '备案号', '2', '基本设置', '0');{}
INSERT INTO `thinkcms_config` VALUES ('8', 'cfg_count', '引用', '', '3', '更多设置', '0');{}
INSERT INTO `thinkcms_config` VALUES ('10', 'cfg_file', '文件上传格式', 'doc|docx|ppt|pptx|xls|xlsx|zip|rar|7z|gif|png|jpg|jpeg|pdf', '3', '更多设置', '0');{}
INSERT INTO `thinkcms_config` VALUES ('12', 'cfg_tel', '电话', '0755-88888888', '2', '基本设置', '0');{}
INSERT INTO `thinkcms_config` VALUES ('13', 'cfg_email', '邮箱', 'web@aaaa.com', '2', '基本设置', '0');{}
INSERT INTO `thinkcms_config` VALUES ('14', 'cfg_pic_small_width', '图集小图宽', '55', '2', '更多设置', '0');{}
INSERT INTO `thinkcms_config` VALUES ('15', 'cfg_pic_small_height', '图集小图高', '55', '2', '更多设置', '0');{}
INSERT INTO `thinkcms_config` VALUES ('16', 'cfg_pic_medium_width', '图集中图宽', '300', '2', '更多设置', '0');{}
INSERT INTO `thinkcms_config` VALUES ('17', 'cfg_pic_medium_height', '图集中图高', '300', '2', '更多设置', '0');{}
INSERT INTO `thinkcms_config` VALUES ('18', 'cfg_map', '百度地图地址', '深圳市腾讯大厦', '2', '更多设置', '0');{}
INSERT INTO `thinkcms_config` VALUES ('20', 'cfg_smtp', 'smtp地址', '', '2', '更多设置', '100');{}
INSERT INTO `thinkcms_config` VALUES ('21', 'cfg_email_account', '邮箱账号', '', '2', '更多设置', '100');{}
INSERT INTO `thinkcms_config` VALUES ('22', 'cfg_email_password', '邮箱密码', '', '2', '更多设置', '100');{}
INSERT INTO `thinkcms_config` VALUES ('23', 'cfg_language_en', '开启英文版', '0', '5', '更多设置', '100');{}


-- ----------------------------
-- Table structure for thinkcms_feedback
-- ----------------------------
DROP TABLE IF EXISTS `thinkcms_feedback`;{}
CREATE TABLE `thinkcms_feedback` (
  `fd_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `theme` char(100) NOT NULL DEFAULT '' COMMENT '主题',
  `body` text COMMENT '内容',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '留言时间',
  `people` char(20) NOT NULL DEFAULT '' COMMENT '联系人',
  `email` varchar(60) NOT NULL DEFAULT '' COMMENT '电子邮件',
  `tel` char(10) NOT NULL DEFAULT '' COMMENT '固定电话',
  `phone` char(11) NOT NULL DEFAULT '' COMMENT '手机',
  `lookstate` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '1没有看 2已经阅读',
  `showstate` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '0不显示 1显示',
  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '父级',
  `user_uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '会员表关联外键',
  PRIMARY KEY (`fd_id`),
  KEY `fk_hd_feedback_rb_user1_idx` (`user_uid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='留言表';{}
-- ----------------------------
-- Records of thinkcms_feedback
-- ----------------------------



-- ----------------------------
-- Table structure for thinkcms_model
-- ----------------------------
DROP TABLE IF EXISTS `thinkcms_model`;{}
CREATE TABLE `thinkcms_model` (
  `mid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(50) NOT NULL DEFAULT '' COMMENT '模型名称(英文)',
  `remark` char(50) NOT NULL DEFAULT '' COMMENT '中文说明',
  PRIMARY KEY (`mid`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='模型表';{}
-- ----------------------------
-- Records of thinkcms_model
-- ----------------------------
INSERT INTO `thinkcms_model` VALUES ('1', 'news', '新闻模型');{}
INSERT INTO `thinkcms_model` VALUES ('2', 'about', '公司介绍');{}
INSERT INTO `thinkcms_model` VALUES ('3', 'products', '产品管理');{}
INSERT INTO `thinkcms_model` VALUES ('4', 'recruitment', '人才招聘');{}
INSERT INTO `thinkcms_model` VALUES ('5', 'download', '下载专区');{}
INSERT INTO `thinkcms_model` VALUES ('6', 'contact', '联系我们');{}
INSERT INTO `thinkcms_model` VALUES ('7', 'test', '测试');{}

-- ----------------------------
-- Table structure for thinkcms_model_field
-- ----------------------------
DROP TABLE IF EXISTS `thinkcms_model_field`;{}
CREATE TABLE `thinkcms_model_field` (
  `fid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fname` char(20) NOT NULL DEFAULT '' COMMENT '字段名称英文',
  `title` char(50) NOT NULL DEFAULT '' COMMENT '字段说明',
  `validate` varchar(100) NOT NULL DEFAULT '' COMMENT '正则',
  `require` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '0 选填 1必填',
  `show_type` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '1 文本 ，2多行文本 ，3 html ，4 单选框 ，5下拉框，6多选框 ，7文件上传框，8图片上传框 ， 9地区联动',
  `show_lists` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '0显示列表页 1显示列表页',
  `is_system` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '0 不是系统字段 1 系统字段',
  `is_disabled` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '1禁用 0正常',
  `model_mid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '模型表关联外键',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `error` varchar(100) NOT NULL DEFAULT '' COMMENT '错误提示',
  PRIMARY KEY (`fid`),
  KEY `fk_rb_model_field_rb_model1_idx` (`model_mid`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COMMENT='字段表';{}

-- ----------------------------
-- Records of thinkcms_model_field
-- ----------------------------
INSERT INTO `thinkcms_model_field` VALUES ('1', 'article_aid', '关联字段', '', '1', '1', '0', '1', '0', '1', '100', '');{}
INSERT INTO `thinkcms_model_field` VALUES ('2', 'body', '详细内容', '', '0', '3', '0', '0', '0', '1', '100', '');{}
INSERT INTO `thinkcms_model_field` VALUES ('3', 'article_aid', '关联字段', '', '0', '1', '0', '1', '0', '2', '901', '');{}
INSERT INTO `thinkcms_model_field` VALUES ('4', 'body', '详细内容', '', '0', '3', '1', '0', '0', '2', '900', '');{}
INSERT INTO `thinkcms_model_field` VALUES ('5', 'article_aid', '关联字段', '', '0', '1', '0', '1', '0', '3', '1', '');{}
INSERT INTO `thinkcms_model_field` VALUES ('6', 'body', '详细内容', '', '0', '3', '0', '0', '0', '3', '900', '');{}
INSERT INTO `thinkcms_model_field` VALUES ('7', 'article_aid', '关联字段', '', '0', '1', '0', '1', '0', '4', '1', '');{}
INSERT INTO `thinkcms_model_field` VALUES ('8', 'body', '详细内容', '', '0', '3', '0', '0', '0', '4', '900', '');{}
INSERT INTO `thinkcms_model_field` VALUES ('9', 'article_aid', '关联字段', '', '0', '1', '0', '1', '0', '5', '1', '');{}
INSERT INTO `thinkcms_model_field` VALUES ('10', 'body', '详细内容', '', '0', '3', '0', '0', '0', '5', '900', '');{}
INSERT INTO `thinkcms_model_field` VALUES ('11', 'article_aid', '关联字段', '', '0', '1', '0', '1', '0', '6', '1', '');{}
INSERT INTO `thinkcms_model_field` VALUES ('12', 'body', '详细内容', '', '0', '3', '0', '0', '0', '6', '900', '');{}
INSERT INTO `thinkcms_model_field` VALUES ('13', 'author', '作者', '', '0', '1', '0', '0', '0', '1', '102', '');{}
INSERT INTO `thinkcms_model_field` VALUES ('14', 'resource', '来源', '', '1', '1', '0', '0', '0', '1', '101', '请输入来源');{}
INSERT INTO `thinkcms_model_field` VALUES ('15', 'article_aid', '关联字段', '', '0', '1', '0', '1', '0', '7', '1', '');{}
INSERT INTO `thinkcms_model_field` VALUES ('16', 'body', '详细内容', '', '0', '3', '0', '0', '0', '7', '900', '');{}
INSERT INTO `thinkcms_model_field` VALUES ('19', 'info', '说明', '/^[a-z]+$/i', '1', '1', '0', '0', '0', '7', '100', '只能输入字母');{}
INSERT INTO `thinkcms_model_field` VALUES ('20', 'image_upload', '附件图片', '', '0', '9', '0', '0', '0', '7', '100', '');{}
INSERT INTO `thinkcms_model_field` VALUES ('22', 'testdown', '下载', '', '0', '8', '1', '0', '0', '5', '100', '');{}

-- ----------------------------
-- Table structure for thinkcms_model_field_value
-- ----------------------------
DROP TABLE IF EXISTS `thinkcms_model_field_value`;{}
CREATE TABLE `thinkcms_model_field_value` (
  `fv_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `field_value` varchar(60) NOT NULL DEFAULT '' COMMENT '默认值',
  `field_fid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '字段表关联外键',
  PRIMARY KEY (`fv_id`),
  KEY `fk_rb_model_field_value_rb_model_field1_idx` (`field_fid`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COMMENT='字段默认值表';{}
-- ----------------------------
-- Records of thinkcms_model_field_value
-- ----------------------------
INSERT INTO `thinkcms_model_field_value` VALUES ('1', '', '13');{}
INSERT INTO `thinkcms_model_field_value` VALUES ('2', '', '14');{}
INSERT INTO `thinkcms_model_field_value` VALUES ('3', '', '4');{}
INSERT INTO `thinkcms_model_field_value` VALUES ('5', '', '16');{}
INSERT INTO `thinkcms_model_field_value` VALUES ('6', '', '17');{}
INSERT INTO `thinkcms_model_field_value` VALUES ('7', '', '18');{}
INSERT INTO `thinkcms_model_field_value` VALUES ('8', '', '19');{}
INSERT INTO `thinkcms_model_field_value` VALUES ('9', '', '20');{}
INSERT INTO `thinkcms_model_field_value` VALUES ('11', '', '22');{}

-- ----------------------------
-- Table structure for thinkcms_position
-- ----------------------------
DROP TABLE IF EXISTS `thinkcms_position`;{}
CREATE TABLE `thinkcms_position` (
  `psid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `position_name` char(100) NOT NULL DEFAULT '' COMMENT '位置名称',
  `width` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '宽度',
  `height` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '高度',
  PRIMARY KEY (`psid`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='广告位置';{}
-- ----------------------------
-- Records of thinkcms_position
-- ----------------------------
INSERT INTO `thinkcms_position` VALUES ('1', '首页', '960', '380');{}
INSERT INTO `thinkcms_position` VALUES ('2', '关于我们', '960', '380');{}
INSERT INTO `thinkcms_position` VALUES ('3', '产品管理', '960', '380');{}
INSERT INTO `thinkcms_position` VALUES ('4', '网站新闻', '960', '380');{}
INSERT INTO `thinkcms_position` VALUES ('5', '人才招聘', '960', '380');{}
INSERT INTO `thinkcms_position` VALUES ('6', '下载专区', '960', '380');{}
INSERT INTO `thinkcms_position` VALUES ('7', '联系我们', '960', '380');{}

-- ----------------------------
-- Table structure for thinkcms_type
-- ----------------------------
DROP TABLE IF EXISTS `thinkcms_type`;{}
CREATE TABLE `thinkcms_type` (
  `typeid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `typename` varchar(30) NOT NULL DEFAULT '' COMMENT '类型名称',
  PRIMARY KEY (`typeid`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='文档类型';{}

-- ----------------------------
-- Records of thinkcms_type
-- ----------------------------
INSERT INTO `thinkcms_type` VALUES ('9', '衣服');{}

-- ----------------------------
-- Table structure for thinkcms_upload
-- ----------------------------
DROP TABLE IF EXISTS `thinkcms_upload`;{}
CREATE TABLE `thinkcms_upload` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ext` varchar(45) NOT NULL DEFAULT '' COMMENT '文件扩展名',
  `remark` varchar(200) DEFAULT '' COMMENT '文件原名称',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '文件名称',
  `path` varchar(255) NOT NULL,
  `size` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '文件大小',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `relation` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '附件所属表关联外键',
  `type` varchar(60) NOT NULL DEFAULT '' COMMENT '附件属于类型 ad article articlepic config category等',
  `user_uid` int(10) unsigned NOT NULL COMMENT '用户表关联外键',
  PRIMARY KEY (`id`),
  KEY `fk_thinkcms_upload_thinkcms_user1_idx` (`user_uid`),
  KEY `key_ad_aid` (`relation`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COMMENT='编辑器图片表';{}
-- ----------------------------
-- Records of thinkcms_upload
-- ----------------------------
INSERT INTO `thinkcms_upload` VALUES ('3', 'jpg', '55b5bf8f9edaf.jpg', '55c370c2bcee3.jpg', './Data/Uploads/image/2015/08/06', '187975', '1438871746', '2', 'ad', '1'), ('4', 'jpg', '55b5bf8f9edaf.jpg', '55c371889be3e.jpg', './Data/Uploads/image/2015/08/06', '187975', '1438871944', '3', 'ad', '1'), ('5', 'jpg', '55b5bf8f9edaf.jpg', '55c37193ecbcd.jpg', './Data/Uploads/image/2015/08/06', '187975', '1438871955', '4', 'ad', '1'), ('6', 'jpg', '55b5bf8f9edaf.jpg', '55c371a053313.jpg', './Data/Uploads/image/2015/08/06', '187975', '1438871968', '5', 'ad', '1'), ('7', 'jpg', '55b5bf8f9edaf.jpg', '55c371abcb21d.jpg', './Data/Uploads/image/2015/08/06', '187975', '1438871979', '6', 'ad', '1'), ('8', 'jpg', '55b5bf8f9edaf.jpg', '55c371b70f782.jpg', './Data/Uploads/image/2015/08/06', '187975', '1438871991', '7', 'ad', '1'), ('9', 'jpg', '55b5bf8f9edaf.jpg', '55c371c05e5e8.jpg', './Data/Uploads/image/2015/08/06', '187975', '1438872000', '27', 'ad', '1'), ('11', 'png', '55b5be6961c07.png', '55c371ec3d5e0.png', './Data/Uploads/image/2015/08/06', '7585', '1438872044', '6', 'config', '1'), ('29', 'jpg', '55b5bf8f9edaf.jpg', '55c3760d324d6.jpg', './Data/Uploads/image/2015/08/06', '187975', '1438873101', '15', 'article', '1'), ('28', 'jpg', '55b5bf8f9edaf.jpg', '55c37601d689a.jpg', './Data/Uploads/image/2015/08/06', '187975', '1438873089', '16', 'article', '1');{}
-- ----------------------------

-- ----------------------------
-- Table structure for thinkcms_user
-- ----------------------------
DROP TABLE IF EXISTS `thinkcms_user`;{}
CREATE TABLE `thinkcms_user` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` char(20) NOT NULL DEFAULT '' COMMENT '用户名',
  `password` char(32) NOT NULL DEFAULT '' COMMENT '密码',
  `login_ip` char(20) NOT NULL DEFAULT '' COMMENT '登录IP',
  `login_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '登录时间',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '注册时间',
  `role` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '1管理员2会员',
  `times` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '登录次数',
  `is_lock` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否锁定 0正常,1锁定',
  `grade_gid` int(10) unsigned NOT NULL DEFAULT '1' COMMENT '会员的等级',
  `nickname` varchar(30) NOT NULL DEFAULT '' COMMENT '昵称',
  `email` varchar(60) NOT NULL DEFAULT '' COMMENT '邮箱',
  PRIMARY KEY (`uid`),
  KEY `fk_rb_user_rb_grade1_idx` (`grade_gid`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COMMENT='用户表';{}



-- ----------------------------
-- Table structure for thinkcms_user_baseinfo
-- ----------------------------
DROP TABLE IF EXISTS `thinkcms_user_baseinfo`;{}
CREATE TABLE `thinkcms_user_baseinfo` (
  `bid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `realname` char(20) NOT NULL DEFAULT '' COMMENT '真实姓名',
  `sex` enum('男','女') NOT NULL DEFAULT '男' COMMENT '性别',
  `birthday` date DEFAULT NULL COMMENT '生日',
  `qq` char(15) NOT NULL DEFAULT '' COMMENT 'qq',
  `email` char(60) NOT NULL DEFAULT '' COMMENT '邮箱地址',
  `phone` char(11) NOT NULL DEFAULT '' COMMENT '手机号码',
  `face` varchar(200) NOT NULL DEFAULT '' COMMENT '头像',
  `user_uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'user表关联外键',
  PRIMARY KEY (`bid`),
  KEY `fk_rb_user_baseinfo_rb_user1_idx` (`user_uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户基本信息表';{}

-- ----------------------------
-- Records of thinkcms_user_baseinfo
-- ----------------------------

-- ----------------------------
-- Table structure for thinkcms_user_comment
-- ----------------------------
DROP TABLE IF EXISTS `thinkcms_user_comment`;{}
CREATE TABLE `thinkcms_user_comment` (
  `cmid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `content` varchar(500) NOT NULL DEFAULT '' COMMENT '评论内容',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '评论时间',
  `verifystate` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '1审核中 2 审核通过  3 不通过',
  `article_aid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '文章主表关联外键',
  `user_uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户表关联外键',
  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '父级id',
  `score` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '评分',
  PRIMARY KEY (`cmid`),
  KEY `fk_rb_user_comment_rb_article1_idx` (`article_aid`),
  KEY `fk_rb_user_comment_rb_user1_idx` (`user_uid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='评论表';{}
-- ----------------------------
-- Records of thinkcms_user_comment
-- ----------------------------

-- ----------------------------
-- Table structure for thinkcms_user_grade
-- ----------------------------
DROP TABLE IF EXISTS `thinkcms_user_grade`;{}
CREATE TABLE `thinkcms_user_grade` (
  `gid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `gname` char(20) NOT NULL DEFAULT '' COMMENT '会员等级',
  PRIMARY KEY (`gid`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='会员等级';{}
-- ----------------------------
-- Records of thinkcms_user_grade
-- ----------------------------
INSERT INTO `thinkcms_user_grade` VALUES ('1', '普通会员');{}
INSERT INTO `thinkcms_user_grade` VALUES ('3', 'VIP会员');{}

DROP TABLE IF EXISTS `thinkcms_addons`;{}
CREATE TABLE `thinkcms_addons` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL DEFAULT '' COMMENT '插件名称',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '安装时间',
  `user_uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户表关联外键',
  `remark` varchar(60) NOT NULL DEFAULT '' COMMENT '插件文件夹名称',
  PRIMARY KEY (`id`),
  KEY `key_user_uid` (`user_uid`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COMMENT='插件表';