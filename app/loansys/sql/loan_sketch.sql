/**
* 因为贷款信息会经过后面的人员多次修改审批, 
* 此表记录客户经理提交的数据, 和所有的修改信息
* 最终数据记录在loan表中
*/
drop table if exists `sys_loan_sketch`;
create table if not exists `sys_loan_sketch`(
	`id` int unsigned not null auto_increment,
	`lid` int unsigned not null comment '贷款ID',
    `uid` bigint(10) unsigned NOT NULL COMMENT '贷款人UID',
    `oid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '操作人员ID',
    `title` varchar(120) NOT NULL default '' COMMENT '贷款标题',
    `type` tinyint(1) unsigned NOT NULL DEFAULT 0 COMMENT '贷款方式,1-车贷,2-信用贷, 由面审人员确定',
    `use_type` smallint(3) NOT NULL COMMENT '贷款用途',
    `amount` int(10) NOT NULL COMMENT '贷款金额',
    `deadline` tinyint(2) unsigned NOT NULL COMMENT '贷款期限',
    `deadline_type` char(1) NOT NULL DEFAULT 'm' COMMENT '期限类型:m-月,y-年,d-天,a-时',
    `days` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '几天标',
    `repay_method` char(1) NOT NULL DEFAULT 'm' COMMENT '还款方式:m-按月分期,i-按月付息,到期还本,e-到期还本息',
	`repay_source` char(1) not null comment '还款来源', 
    `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '状态: 1-草稿,2-无效,3-审核失败,11-待审核,12-待发布,21-招标中,31-已流标,32-满标待审,41-还款中,51-还款成功',
    `description` text NOT NULL COMMENT '贷款描述',
    `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '贷款备注',
	`addtime` int not null comment '贷款修改时间',
	PRIMARY key (`id`),
	key lid(`lid`),
	key uid(`uid`),
	key oid(`oid`),
	key type(`type`)
)engine=InnoDB default charset=utf8 comment='贷款表';
