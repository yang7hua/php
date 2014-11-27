drop table if exists `sys_user`;
create table if not exists `sys_user`(
	`uid` int auto_increment comment '用户ID',
	`oid` int unsigned not null COMMENT '操作者ID',	
	`bid` int unsigned not null COMMENT '门店ID',	
	-- `lid` int unsigned default 0 COMMENT '对应每笔贷款的实时情况',
	`idcard` char(18) not null comment '身份证ID',
    `idcard_province` int unsigned NOT NULL DEFAULT 0 COMMENT '户籍省份',
    `idcard_city` int unsigned NOT NULL DEFAULT 0 COMMENT '户籍城市',
	`realname` varchar(10) not null comment '真实姓名',
    `gender` tinyint(1) DEFAULT 0 COMMENT '性别:0-未知,1-男,2-女',

	-- 基本情况
    `province` int(6) unsigned NOT NULL DEFAULT '0' COMMENT '居住省份',
    `city` int(6) unsigned NOT NULL DEFAULT '0' COMMENT '居住城市',
    `address` varchar(150) NOT NULL DEFAULT '' COMMENT '详细居住地址',
    `mobile` varchar(50) DEFAULT NULL DEFAULT '' COMMENT '联系电话 多个用;分隔',
    `contact_info` varchar(100) DEFAULT '' COMMENT '紧急联系人',
	`info` varchar(1000) not null default '' COMMENT '基本情况说明',

	-- 婚姻情况
    `marriage` tinyint(1) NOT NULL DEFAULT '0' COMMENT '婚姻状况:0-未知,1-已婚,2-离异,3-未婚',
    `have_child` tinyint(1) DEFAULT '0' COMMENT '有无子女:0-未知,1-有,2-无',
	`child_info` varchar(100) default '' comment '子女情况说明',
	`spouse_name` varchar(10) default '' comment '配偶姓名', 
	`spouse_idcard` char(18) default '' COMMENT '配偶身份证',
	`spouse_info` varchar(100) default '' COMMENT '配偶情况说明',
	`spouse_assure` tinyint unsigned default 1 comment '配偶是否愿意签担保函,1-是',

	-- 基本情况
	`addtime` int not null comment '客户创建日期',

	primary key(`uid`),
	key bid(`bid`),
	key oid(`oid`),
	key idcard(`idcard`),
	key realname(`realname`),
)engine=InnoDB default charset=utf8 auto_increment=100000 comment='用户表';
