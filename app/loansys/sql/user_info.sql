--
-- 客户其它信息
-- 此表由面审人员完成
--

DROP TABLE IF EXISTS `sys_userinfo`;
CREATE TABLE IF NOT EXISTS `sys_userinfo` (
	`id` int unsigned not NULL auto_increment,
    `uid` int unsigned NOT NULL COMMENT '用户ID',
	`oid` int unsigned not null comment '操作人员ID',

    `loan_type` tinyint(1) unsigned NOT NULL DEFAULT 0 COMMENT '贷款方式,1-车贷,2-信用贷, 由面审人员确定',

	`bigger` tinyint unsigned not null default 0 comment '是否放大',

	-- 信用报告说明 
	`debt_amount` varchar(1000) not null default '' comment '负债总额',
	`debt_prove` varchar(1000) not null default '' comment '证明方式',
	`debt_month_repay` varchar(1000) not null default '' comment '每月需还款情况',
	`debt_info` varchar(1000) not NULL default '' comment '负债总额(万为单位), 每月还款, 证明方式, 逾期情况, 按揭车还款情况',
	`debt_car_info` varchar(1000) not null default '' COMMENT '按揭车还款情况',

	--基本情况说明
	`info_base`	varchar(5000) not null DEFAULT '' COMMENT '基本情况说明',
	`info_income` varchar(5000) not NULL DEFAULT '' COMMENT '收入情况说明',
	`use_info`	varchar(1000) not null DEFAULT '' COMMENT '借款用途说明',
	`repay_source` varchar(1000) not null DEFAULT '' COMMENT '还款来源核实',

	`addtime` int unsigned not NULL COMMENT '核实时间',

    PRIMARY KEY (`id`),
	key uid(`uid`),
	key oid(`oid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
