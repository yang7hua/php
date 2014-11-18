-- 作员表
drop table if exists `sys_operator`;
create table if not exists `sys_operator`(
	`oid` int auto_increment,
	`rid` int unsigned not null default 0 comment '角色ID',
	`username` varchar(20) not null unique comment '用户名',
	`password` varchar(50) not null comment '密码',
	`status` tinyint unsigned not null default 1 comment '帐号状态，1-正常, 10-冻结',
	primary key(`oid`),
	key did(`rid`),
	key status(`status`)
)engine=InnoDB default charset=utf8 comment='角色表';
