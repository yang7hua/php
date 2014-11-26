-- 角色表
drop table if exists `sys_role`;
create table if not exists `sys_role`(
	`rid` int auto_increment,
	`name` varchar(20) not null default '' comment '角色id',
	`did` int unsigned not null default 0 comment '部门id',
	`bid` int unsigned not null default 0 comment '门店id',
	`auth` varchar(1000) default '' comment '权限';
	primary key(`rid`),
	key did(`did`),
	key bid(`bid`)	
)engine=InnoDB default charset=utf8 comment='角色表';
