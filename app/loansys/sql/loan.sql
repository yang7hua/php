drop table if exists `sys_loan`;
create table if not exists `sys_loan`(
	`lid` int unsigned not null auto_increment,
    `uid` int unsigned NOT NULL COMMENT '贷款人UID',
	`oid` int unsigned not null comment '操作者ID',

    `loan_type` tinyint(1) unsigned NOT NULL DEFAULT 0 COMMENT '贷款方式,1-车贷,2-信用贷, 由面审人员确定',
    `use_type` smallint(3) NOT NULL COMMENT '贷款用途',
    `use_type_info` varchar(1000) NOT NULL COMMENT '贷款用途详细说明',
    `amount` decimal(6,2) NOT NULL COMMENT '同意贷款金额, 万为单位',
    `deadline` tinyint(2) unsigned NOT NULL COMMENT '贷款期限',
    `deadline_type` char(1) DEFAULT 'm' COMMENT '期限类型:m-月,y-年,d-天,a-时',
    `days` int(10) unsigned DEFAULT '0' COMMENT '几天标',
	`apr` float(6,2) default 0.00 comment '批准年利率', 
    `repay_method` char(1) NOT NULL DEFAULT 'o' COMMENT '还款方式:m-按月等额本息,i-按月付息,到期还本,o-等本等息',
	`repay_source` varchar(1000) not null default 0 comment '还款来源', 
    `description` varchar(5000) default '' COMMENT '贷款描述',

    `begintime` int unsigned DEFAULT 0 COMMENT '还款起始时间',
    `endtime` int unsigned DEFAULT 0 COMMENT '还款结束时间',
    `return_num` tinyint(2) unsigned DEFAULT 0 COMMENT '已还期数',
    `remain_amount` decimal(10,2) DEFAULT 0.00 COMMENT '剩余本金',
    `return_amount` decimal(10,2) DEFAULT 0.00 COMMENT '已经还总额',
	`last_repay_time` int default 0 comment '最近一次还款时间',
	`next_repay_time` int default 0 comment '下一次还款时间',

	`reason` varchar(1000)  default '' comment '同意或者拒绝的理由',
	`remark` varchar(1000) default '' comment '补充说明',

	`bank`	varchar(1000) default '' comment '开户银行',
	`bank_card` varchar(20) default '' comment '银行卡号',
	`contract` tinyint unsigned default 0 comment '合同签署',
	`gps` tinyint unsigned default 0 comment 'GPS安装状况',
	`remit_certify` varchar(200) default '' comment '汇款凭证',

    `status` tinyint unsigned DEFAULT 0 COMMENT '状态',
	`addtime` int not null comment '贷款添加时间',

	PRIMARY key (`lid`),
	key uid(`uid`),
	key loan_type(`loan_type`),
	key status(`status`),
	key oid(`oid`)
)engine=InnoDB default charset=utf8 auto_increment=100001 comment='贷款表';
