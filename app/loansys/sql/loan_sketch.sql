/**
* 因为贷款信息会经过后面的人员多次修改审批, 
* 此表记录客户经理提交的数据, 和所有的修改信息
* 最终数据记录在loan表中
*/
drop table if exists `sys_loan_sketch`;
create table if not exists `sys_loan_sketch`(
	`id` int unsigned not null auto_increment,
	`lid` int unsigned not null comment '贷款ID',
    `uid` int unsigned NOT NULL COMMENT '贷款人UID',
    `oid` int unsigned NOT NULL DEFAULT '0' COMMENT '操作人员ID',

    `loan_type` tinyint(1) unsigned NOT NULL DEFAULT 0 COMMENT '贷款方式,1-车贷,2-信用贷, 由面审人员确定',
    `use_type` smallint(3) NOT NULL COMMENT '贷款用途',
    `use_type_info` varchar(1000) NOT NULL COMMENT '贷款用途详细说明',
    `amount` decimal(6,2) NOT NULL COMMENT '贷款金额, 万为单位',
    `deadline` tinyint(2) unsigned NOT NULL COMMENT '贷款期限',
    `deadline_type` char(1) NOT NULL DEFAULT 'm' COMMENT '期限类型:m-月,y-年,d-天,a-时',
    `days` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '几天标',
    `repay_method` char(1) NOT NULL DEFAULT 'm' COMMENT '还款方式:m-按月分期,i-按月付息,到期还本,e-到期还本息',
	`repay_source` char(1) not null default 0 comment '还款来源', 
    `description` text NOT NULL COMMENT '贷款描述',

	`otype` tinyint unsigned not null default 0 comment '操作类型,0-客户经理提交草稿,10-初次面审,30-核查人员完成后面审复审',
	`addtime` int not null comment '贷款修改时间',
	PRIMARY key (`id`),
	key lid(`lid`),
	key uid(`uid`),
	key oid(`oid`),
	key otype(`otype`),
	key loan_type(`loan_type`)
)engine=InnoDB default charset=utf8 comment='贷款表';
