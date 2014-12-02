drop table if exists `sys_loan_sketch`;
create table if not exists `sys_loan_sketch`(
	`lid` int unsigned not null auto_increment,
    `uid` int unsigned NOT NULL COMMENT '贷款人UID',

    `loan_type` tinyint(1) unsigned NOT NULL DEFAULT 0 COMMENT '贷款方式,1-车贷,2-信用贷, 由面审人员确定',
    `use_type` smallint(3) NOT NULL COMMENT '贷款用途',
    `use_type_info` varchar(1000) NOT NULL COMMENT '贷款用途详细说明',
    `amount` decimal(6,2) NOT NULL COMMENT '贷款金额, 万为单位',
    `deadline` tinyint(2) unsigned NOT NULL COMMENT '贷款期限',
    `deadline_type` char(1) DEFAULT 'm' COMMENT '期限类型:m-月,y-年,d-天,a-时',
    `days` int(10) unsigned DEFAULT '0' COMMENT '几天标',
    `repay_method` char(1) NOT NULL DEFAULT 'o' COMMENT '还款方式:m-按月等额本息,i-按月付息,到期还本,o-等本等息',
	`repay_source` varchar(1000) not null default 0 comment '还款来源', 
    `description` varchar(5000) default '' COMMENT '贷款描述',

    `status` tinyint unsigned DEFAULT 0 COMMENT '状态: 0-客户经理提交草稿,10-初次面审,30-核查人员完成后面审复审, 1-面审审核成功, 11-审核失败, 21-风控审核成功, 50-还款中, 60-还款完成',
	`addtime` int not null comment '贷款修改时间',
	PRIMARY key (`lid`),
	key uid(`uid`),
	key loan_type(`loan_type`),
	key status(`status`)
)engine=InnoDB default charset=utf8 auto_increment=100001 comment='贷款初稿表,由客户经理添加';
