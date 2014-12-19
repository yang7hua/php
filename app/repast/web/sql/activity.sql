drop table if exists `sys_activity`;
create table if not exists `sys_activity`(
	`aid` int auto_increment,
	`title` varchar(50) not null comment '活动标题',
	`shortname` varchar(20) not null comment '简称',
	`description` varchar(5000) not null comment '活动描述',
	`addtime` int unsigned not null,
	`status` tinyint unsigned not null,
	primary key(`aid`),
	key status(`status`)
)engine=InnoDB default charset=utf8 comment='活动表';
