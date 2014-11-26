-- 部门表
drop table if exists `sys_department`;
create table if not exists `sys_department`(
	`did` int auto_increment,
	`name` varchar(20) not null comment '部门名称',
	`bid` int unsigned not null default 0 comment '所属门店',
	primary key(`did`),
	key bid(`bid`)	
)engine=InnoDB default charset=utf8 comment='部门表';
