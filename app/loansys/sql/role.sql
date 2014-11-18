-- 角色表
drop table if exists `sys_role`;
create table if not exists `sys_role`(
	`rid` int auto_increment,
	`did` int unsigned not null default 0 comment '部门id',
	`name` varchar(20) not null default '' comment '角色id',
	primary key(`rid`),
	key did(`did`)	
)engine=InnoDB default charset=utf8 comment='角色表';
