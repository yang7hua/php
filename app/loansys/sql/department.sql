-- 部门表
drop table if exists `sys_department`;
create table if not exists `sys_department`(
	`did` int auto_increment,
	`pid` int unsigned not null default 0 comment '父级部门',
	`name` varchar(20) not null comment '部门名称',
	primary key(`did`),
	key pid(`pid`)	
)engine=InnoDB default charset=utf8 comment='部门表';
