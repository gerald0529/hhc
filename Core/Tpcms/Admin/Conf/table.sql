CREATE TABLE `thinkcms_article_data` (
  `article_aid` int(10) unsigned NOT NULL COMMENT '主表关联外键',
  `body` text COMMENT '详细内容',
  KEY `fk_rb_article_data_rb_article1_idx` (`article_aid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='文章附表' 