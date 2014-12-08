drop table if exists `sys_repay`;
create table if not exists `sys_repay`(
	`id` int auto_increment,
	`uid` int unsigned not null comment '客户编号',
	`lid` int unsigned not null comment '贷款ID',
	`oid` int unsigned not null comment '操作者ID',
	`amount` decimal(8,2) not null comment '还款金额',
	`no` tinyint unsigned not null comment '第几期',
	`date` int not null comment '还款日期',
	`status` tinyint unsigned not null comment '还款状态, 1-正常还款, 0-已逾期',
	`addtime` int not null comment '添加时间',
	primary key(`id`),
	key uid(`uid`),
	key lid(`lid`)
)engine=InnoDB default charset=utf8 comment='还款列表';
