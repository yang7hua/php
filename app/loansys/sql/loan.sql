-- 原始数据记录在loan_sketch表中
-- 此表记录只有风控部门才能添加
-- 贷款的最终结果都在这张表
drop table if exists `sys_loan`;
create table if not exists `sys_loan`(
	`id` int unsigned not null auto_increment,
	`lid` int unsigned not null comment '贷款ID',
    `uid` int unsigned NOT NULL COMMENT '贷款人UID',
    `oid` int unsigned NOT NULL DEFAULT '0' COMMENT '操作人员ID, 此字段无法更改，记录的是客户经理的id',

    `type` tinyint(1) unsigned NOT NULL DEFAULT 0 COMMENT '贷款方式,1-车贷,2-信用贷, 由面审人员确定',
    `use_type` smallint(3) NOT NULL COMMENT '贷款用途',
    `amount` decimal(6,2) NOT NULL COMMENT '贷款金额 万为单位',
    `deadline` tinyint(2) unsigned NOT NULL COMMENT '贷款期限',
    `deadline_type` char(1) NOT NULL DEFAULT 'm' COMMENT '期限类型:m-月,y-年,d-天,a-时',
    `days` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '几天标',
    `repay_method` char(1) NOT NULL DEFAULT 'm' COMMENT '还款方式:m-按月分期,i-按月付息,到期还本,e-到期还本息',
	`repay_source` char(1) not null comment '还款来源', 
    `begintime` bigint(10) unsigned NOT NULL DEFAULT '0' COMMENT '还款起始时间',
    `endtime` bigint(10) unsigned NOT NULL DEFAULT '0' COMMENT '贷款结束时间',
    `remain_amount` decimal(6,2) NOT NULL DEFAULT '0.00' COMMENT '剩余本金',
    `return_num` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '已还期数',
    `return_amount` decimal(6,2) NOT NULL DEFAULT '0.00' COMMENT '已经还总额',
    `description` text NOT NULL COMMENT '贷款描述',

	`reason` varchar(1000) not null default '' comment '同意或者拒绝放款的理由',
	`risk` varchar(1000) not null default '' comment '可能存在风险说明',
	`notice` varchar(1000) not null default '' comment '贷后注意事项',
	`remark` varchar(1000) not null default '' comment '评审人员标注的其它事项',

    `status` tinyint(3) NOT NULL DEFAULT 1 COMMENT '状态: 1-面审审核成功, 11-审核失败, 21-风控审核成功, 50-还款中, 60-还款完成',

	`addtime` int not null comment '贷款创建时间',
	`uptime` int not null default 0 comment '修改时间',
	PRIMARY key (`id`),
	key lid(`lid`),
	key uid(`uid`),
	key oid(`oid`),
	key type(`type`),
	key status(`status`),
	key addtime(`addtime`)
)engine=InnoDB default charset=utf8 comment='贷款表';
