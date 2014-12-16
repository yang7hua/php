drop table if exists `sys_admini`;
create table if not exists `sys_admini`(
	`aid` int auto_increment,
	`bid` int unsigned not null comment '门店ID',
	`username` varchar(20) not null unique,
	`password` varchar(32) not null,
	`status` tinyint unsigned not null default 1 comment '状态,1-正常,0-删除,20-冻结',
	`addtime` int unsigned not null,
	primary key(`aid`),
	key `bid`(`bid`)
)engine=InnoDB default charset=utf8 comment='管理员表';
