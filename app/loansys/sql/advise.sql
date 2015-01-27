-- 需要修改数据的反馈表
drop table if exists `sys_advise`;
create table if not exists `sys_advise`(
	`id` int auto_increment,
	`uid` int unsigned not null comment '客户ID',
	`oid` int unsigned not null comment '关联操作者ID',
	`foid` int unsigned not null comment '提出者ID',
	`type` varchar(100) not null comment '类型',
	`reason` varchar(1000) not null comment '理由',
	`status` tinyint not null default 0 comment '状态 0-未处理 1-已处理 10-失效',
	`addtime` int unsigned not null comment '提出时间',
	primary key(`id`),
	key uid(`uid`,`status`,`type`),
	key oid(`oid`,`status`)
)engine=InnoDB default charset=utf8;
