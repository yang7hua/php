drop table if exists `sys_log`;
create table if exists `sys_log`(
	`id` int auto_increment,
	`oid` int unsigned not null comment '操作者ID',
	`uid` int unsigned not null comment '客户ID',
	`info` varchar(1000) not null comment '操作事件说明',
	`addtime` int unsigned comment '添加时间',
	primary key(`id`),
	key oid(`oid`),
	key uid(`uid`)
)engine=InnoDB default charset=utf8 comment='操作日志表';
