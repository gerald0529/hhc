/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50517
Source Host           : localhost:3306
Source Database       : dwz

Target Server Type    : MYSQL
Target Server Version : 50517
File Encoding         : 65001

Date: 2015-07-27 16:30:27
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
  `info` varchar(500) NOT NULL DEFAULT '' COMMENT '广告说明',
  `info_en` varchar(500) NOT NULL DEFAULT '' COMMENT '英广告说明',
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='广告表';{}
-- ----------------------------
-- Records of thinkcms_ad
-- ----------------------------

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='文档表';{}

-- ----------------------------
-- Records of thinkcms_article
-- ----------------------------


-- ----------------------------
-- Table structure for thinkcms_debris
-- ----------------------------
DROP TABLE IF EXISTS `thinkcms_debris`;{}
CREATE TABLE `thinkcms_debris` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(255) NOT NULL DEFAULT '' COMMENT '碎片标题',
  `title_en` char(255) NOT NULL DEFAULT '' COMMENT '英碎片标题',
  `pic_en` varchar(500) NOT NULL DEFAULT '' COMMENT '英图片',
  `pic` varchar(500) NOT NULL DEFAULT '' COMMENT '图片',
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `body` text COMMENT '详细内容',
  `body_en` text COMMENT '英详细内容',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='碎片表';{}

-- ----------------------------
-- Records of thinkcms_debris
-- ----------------------------


-- ----------------------------
-- Table structure for thinkcms_airlines
-- ----------------------------
DROP TABLE IF EXISTS `thinkcms_airlines`;{}
CREATE TABLE `thinkcms_airlines` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `account` char(255) NOT NULL DEFAULT '' COMMENT '号码',
  `name` char(255) NOT NULL DEFAULT '' COMMENT '名称',
  `name_en` char(255) NOT NULL DEFAULT '' COMMENT '英名称',
  `type` char(255) NOT NULL DEFAULT '' COMMENT '类型',
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `sort` int(10) NOT NULL DEFAULT '100' COMMENT '排序',
  `pic` varchar(500) NOT NULL DEFAULT '' COMMENT '图片',
  `url` varchar(500) NOT NULL DEFAULT '' COMMENT '拼凑链接',
  `url_eb` varchar(500) NOT NULL DEFAULT '' COMMENT '英拼凑链接',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='QQ客服表';{}

-- ----------------------------
-- Records of thinkcms_airlines
-- ----------------------------


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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='文档和属性表关联中间表';{}
-- ----------------------------
-- Records of thinkcms_article_attr
-- ----------------------------

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='图集';{}
-- ----------------------------
-- Records of thinkcms_article_pic
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='文档属性，用于筛选';{}
-- ----------------------------
-- Records of thinkcms_attr
-- ----------------------------

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='文档类型默认值';{}
-- ----------------------------
-- Records of thinkcms_attr_value
-- ----------------------------

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='栏目表';{}

-- ----------------------------
-- Records of thinkcms_category
-- ----------------------------

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
INSERT INTO `thinkcms_config` VALUES ('24', 'cfg_is_airlines', '开启在线客服', '0', '5', '更多设置', '100');{}
INSERT INTO `thinkcms_config` VALUES ('25', 'cfg_is_oss', '开启阿里云OSS', '0', '5', '更多设置', '100');{}

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
  `address` varchar(500) NOT NULL DEFAULT '' COMMENT '地址',
  `tel` char(10) NOT NULL DEFAULT '' COMMENT '固定电话',
  `phone` char(11) NOT NULL DEFAULT '' COMMENT '手机',
  `lookstate` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '1没有看 2已经阅读',
  `showstate` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '0不显示 1显示',
  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '父级',
  `user_uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '会员表关联外键',
  PRIMARY KEY (`fd_id`),
  KEY `fk_hd_feedback_rb_user1_idx` (`user_uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='留言表';{}

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='模型表';{}

-- ----------------------------
-- Records of thinkcms_model
-- ----------------------------
INSERT INTO `thinkcms_model` VALUES ('1', 'news', '新闻模型');{}
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='字段表';{}

-- ----------------------------
-- Records of thinkcms_model_field
-- ----------------------------
INSERT INTO `thinkcms_model_field` VALUES ('1', 'article_aid', '关联字段', '', '1', '1', '0', '1', '0', '1', '100', '');{}
INSERT INTO `thinkcms_model_field` VALUES ('2', 'body', '详细内容', '', '0', '3', '0', '0', '0', '1', '100', '');{}

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='字段默认值表';{}
-- ----------------------------
-- Records of thinkcms_model_field_value
-- ----------------------------
INSERT INTO `thinkcms_model_field_value` VALUES ('1', '', '1');{}

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='广告位置';{}

-- ----------------------------
-- Records of thinkcms_position
-- ----------------------------

-- ----------------------------
-- Table structure for thinkcms_type
-- ----------------------------
DROP TABLE IF EXISTS `thinkcms_type`;{}
CREATE TABLE `thinkcms_type` (
  `typeid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `typename` varchar(30) NOT NULL DEFAULT '' COMMENT '类型名称',
  PRIMARY KEY (`typeid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='文档类型';{}
-- ----------------------------
-- Records of thinkcms_type
-- ----------------------------

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
  KEY `fk_dwz_upload_dwz_user1_idx` (`user_uid`),
  KEY `key_ad_aid` (`relation`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COMMENT='编辑器图片表';{}
-- ----------------------------
-- Records of thinkcms_upload
-- ----------------------------
insert into `thinkcms_upload` ( `remark`, `addtime`, `user_uid`, `id`, `ext`, `size`, `path`, `relation`, `name`, `type`) values ( '55b5be6961c07.png', '1438872044', '1', '11', 'png', '7585', './Data/Uploads/image/2015/08/06', '6', '55c371ec3d5e0.png', 'config');{}

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
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='用户表';{}


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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='评论表';{}

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
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='会员等级';{}
-- ----------------------------
-- Records of thinkcms_user_grade
-- ----------------------------
INSERT INTO `thinkcms_user_grade` VALUES ('1', '普通会员');{}
INSERT INTO `thinkcms_user_grade` VALUES ('2', 'VIP会员');{}

DROP TABLE IF EXISTS `thinkcms_addons`;{}
CREATE TABLE `thinkcms_addons` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL DEFAULT '' COMMENT '插件名称',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '安装时间',
  `user_uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户表关联外键',
  `remark` varchar(60) NOT NULL DEFAULT '' COMMENT '插件文件夹名称',
  PRIMARY KEY (`id`),
  KEY `key_user_uid` (`user_uid`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COMMENT='插件表';{}

-- ----------------------------
-- Table structure for wx_attention
-- ----------------------------
DROP TABLE IF EXISTS `thinkcms_attention`;{}
CREATE TABLE `thinkcms_attention` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `subscribe` tinyint(4) NOT NULL DEFAULT '1' COMMENT '用户是否订阅该公众号标识，值为0时，代表此用户没有关注该公众号，拉取不到其余信息',
  `openid` char(200) NOT NULL DEFAULT '' COMMENT '用户OPENID标识',
  `nickname` varchar(400) NOT NULL DEFAULT '' COMMENT '昵称',
  `sex` tinyint(4) NOT NULL DEFAULT '0' COMMENT '值为1时是男性，值为2时是女性，值为0时是未知',
  `city` char(200) NOT NULL DEFAULT '' COMMENT '国家',
  `country` char(200) NOT NULL DEFAULT '' COMMENT '城市',
  `province` char(200) NOT NULL DEFAULT '' COMMENT '省份' ,
  `language` char(255) NOT NULL DEFAULT '' COMMENT '语言',
  `headimgurl` varchar(500) NOT NULL DEFAULT '' COMMENT '用户头像，最后一个数值代表正方形头像大小（有0、46、64、96、132数值可选，0代表640*640正方形头像），用户没有头像时该项为空。若用户更换头像，原有头像URL将失效。',
  `subscribe_time` int(11) NOT NULL DEFAULT '0',
  `unionid` char(250) NOT NULL DEFAULT '',
  `remark` varchar(500) NOT NULL DEFAULT '',
  `groupid` int(11) NOT NULL DEFAULT '0' COMMENT '用户所在的分组ID',
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COMMENT='微信关注列表组信息';{}

-- ----------------------------
-- Table structure for wx_groups
-- ----------------------------
DROP TABLE IF EXISTS `thinkcms_groups`;{}
CREATE TABLE `thinkcms_groups` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '分组名称',
  `count` int(11) NOT NULL DEFAULT '0' COMMENT '分组人数',
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='微信分组信息';{}

-- ----------------------------
-- Table structure for wx_image
-- ----------------------------
DROP TABLE IF EXISTS `thinkcms_image`;{}
CREATE TABLE `thinkcms_image` (
  `mid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(200) NOT NULL DEFAULT '' COMMENT '图片标题',
  `media_id` varchar(500) NOT NULL DEFAULT '' COMMENT 'media_id',
  `file` varchar(500) NOT NULL DEFAULT '',
  `url` varchar(500) NOT NULL DEFAULT '',
  `is_upload` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 不同步 1 同步',
  `addtime` int(11) NOT NULL DEFAULT '0',
  `account_id` int(11) NOT NULL DEFAULT '0' COMMENT '客户ID',
  PRIMARY KEY (`mid`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COMMENT='微信图片信息资源';{}

-- ----------------------------
-- Table structure for wx_mass
-- ----------------------------
DROP TABLE IF EXISTS `thinkcms_mass`;{}
CREATE TABLE `thinkcms_mass` (
  `pid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sender` char(100) NOT NULL DEFAULT '',
  `uid` int(11) NOT NULL DEFAULT '0',
  `sendertime` int(11) NOT NULL DEFAULT '0',
  `sendertype` char(100) NOT NULL,
  `usertype` char(100) NOT NULL DEFAULT '',
  `msg_id` int(11) NOT NULL DEFAULT '0',
  `msg_data_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`pid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;{}

-- ----------------------------
-- Table structure for wx_menu
-- ----------------------------
DROP TABLE IF EXISTS `thinkcms_menu`;{}
CREATE TABLE `thinkcms_menu` (
  `cid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT '0',
  `type` char(60) NOT NULL DEFAULT '',
  `name` char(30) NOT NULL DEFAULT '',
  `key` char(100) NOT NULL DEFAULT '',
  `sub_button` varchar(200) NOT NULL DEFAULT '',
  `addtime` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`cid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;{}

-- ----------------------------
-- Table structure for wx_preview
-- ----------------------------
DROP TABLE IF EXISTS `thinkcms_preview`;{}
CREATE TABLE `thinkcms_preview` (
  `pid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sender` char(100) NOT NULL DEFAULT '',
  `uid` int(11) NOT NULL DEFAULT '0',
  `sendertime` int(11) NOT NULL DEFAULT '0',
  `sendertype` char(100) NOT NULL,
  `usertype` char(100) NOT NULL DEFAULT '',
  `msg_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`pid`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;{}


-- ----------------------------
-- Table structure for wx_thumb
-- ----------------------------
DROP TABLE IF EXISTS `thinkcms_thumb`;{}
CREATE TABLE `thinkcms_thumb` (
  `tid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(200) NOT NULL DEFAULT '' COMMENT '标题',
  `thumb_media_id` varchar(500) NOT NULL DEFAULT '' COMMENT '图文消息的封面图片素材id（必须是永久mediaID）',
  `author` char(200) NOT NULL DEFAULT '' COMMENT '图文消息的摘要，仅有单图文消息才有摘要，多图文此处为空',
  `digest` varchar(500) NOT NULL DEFAULT '' COMMENT '图文消息的摘要，仅有单图文消息才有摘要，多图文此处为空',
  `show_cover_pic` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否显示封面，0为false，即不显示，1为true，即显示',
  `content` text COMMENT '图文消息的具体内容，支持HTML标签，必须少于2万字符，小于1M，且此处会去除JS',
  `content_source_url` varchar(500) NOT NULL DEFAULT '' COMMENT '图文消息的原文地址，即点击“阅读原文”后的URL',
  `is_upload` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 不同步 1 同步',
  `addtime` int(11) NOT NULL DEFAULT '0',
  `img_url` varchar(500) NOT NULL DEFAULT '',
  `media_id` varchar(500) NOT NULL DEFAULT '',
  `thumb_media_tid` varchar(500) NOT NULL DEFAULT '',
  `url` varchar(500) NOT NULL DEFAULT '',
  `index` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`tid`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COMMENT='微信图文';{}

-- ----------------------------
-- Table structure for wx_video
-- ----------------------------
DROP TABLE IF EXISTS `thinkcms_video`;{}
CREATE TABLE `thinkcms_video` (
  `vid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(200) NOT NULL DEFAULT '',
  `media_id` varchar(500) NOT NULL DEFAULT '',
  `file` varchar(500) NOT NULL DEFAULT '',
  `down_url` varchar(500) NOT NULL DEFAULT '',
  `is_upload` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 不同步 1 同步',
  `addtime` int(11) NOT NULL DEFAULT '0',
  `account_id` int(11) NOT NULL DEFAULT '0' COMMENT '客户ID',
  `introduction` varchar(500) NOT NULL DEFAULT '',
  PRIMARY KEY (`vid`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;{}


-- ----------------------------
-- Table structure for wx_voice
-- ----------------------------
DROP TABLE IF EXISTS `thinkcms_voice`;{}
CREATE TABLE `thinkcms_voice` (
  `vid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(200) NOT NULL DEFAULT '',
  `media_id` varchar(500) NOT NULL DEFAULT '',
  `file` varchar(500) NOT NULL DEFAULT '',
  `down_url` varchar(500) NOT NULL DEFAULT '',
  `is_upload` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 不同步 1 同步',
  `addtime` int(11) NOT NULL DEFAULT '0',
  `account_id` int(11) NOT NULL DEFAULT '0' COMMENT '客户ID',
  `introduction` varchar(500) NOT NULL DEFAULT '',
  PRIMARY KEY (`vid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;{}


-- ----------------------------
-- Table structure for wx_wx_category
-- ----------------------------
DROP TABLE IF EXISTS `thinkcms_wcategory`;{}
CREATE TABLE `thinkcms_wx_category` (
  `cid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(60) NOT NULL DEFAULT '',
  `type` char(50) NOT NULL DEFAULT '',
  `key` char(200) NOT NULL DEFAULT '',
  `url` varchar(500) NOT NULL DEFAULT '',
  `sort` int(11) NOT NULL DEFAULT '100',
  `addtime` int(11) NOT NULL DEFAULT '0',
  `pid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`cid`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COMMENT='微信菜单栏目';{}


-- ----------------------------
-- Table structure for wx_wx_config
-- ----------------------------
DROP TABLE IF EXISTS `thinkcms_wconfig`;{}
CREATE TABLE `thinkcms_wx_config` (
  `appid` char(30) NOT NULL DEFAULT '',
  `appsecret` char(60) NOT NULL DEFAULT '',
  `aid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `addtime` int(11) NOT NULL DEFAULT '0',
  `uid` int(11) NOT NULL DEFAULT '0',
  `token` varchar(100) NOT NULL DEFAULT '',
  `encodingaeskey` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`aid`),
  UNIQUE KEY `appid` (`appid`),
  UNIQUE KEY `appsecret` (`appsecret`),
  UNIQUE KEY `uid` (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='微信配置 ';{}


-- ----------------------------
-- Table structure for wx_wx_keywords
-- ----------------------------
DROP TABLE IF EXISTS `thinkcms_wkeywords`;{}
CREATE TABLE `thinkcms_wx_keywords` (
  `kid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `content` varchar(1000) NOT NULL DEFAULT '',
  `media_id` char(200) NOT NULL DEFAULT '',
  `title` char(200) NOT NULL DEFAULT '',
  `description` varchar(500) NOT NULL DEFAULT '',
  `music_url` varchar(500) NOT NULL DEFAULT '',
  `hq_music_url` varchar(500) NOT NULL DEFAULT '',
  `new_count` varchar(500) NOT NULL DEFAULT '',
  `pic_url` varchar(500) NOT NULL DEFAULT '',
  `url` varchar(500) NOT NULL DEFAULT '',
  `is_default` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 不是默认 1默认',
  `keywords` char(100) NOT NULL DEFAULT '',
  `addtime` int(11) NOT NULL DEFAULT '0',
  `type` char(50) NOT NULL DEFAULT '',
  `keywords_type` char(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`kid`),
  UNIQUE KEY `keywords` (`keywords`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='微信关键字自动回复';{}


-- ----------------------------
-- Table structure for wx_wx_type
-- ----------------------------
DROP TABLE IF EXISTS `thinkcms_wtype`;{}
CREATE TABLE `thinkcms_wx_type` (
  `type` char(50) NOT NULL DEFAULT '',
  `tid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`tid`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='微信消息类型';{}