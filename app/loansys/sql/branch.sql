drop table if exists `sys_branch`;
create table if not exists `sys_branch`(
	`bid` int auto_increment,
	`name` varchar(50) not null comment '门店名称',
	`province` int default 0 comment '所在省份',
	`city` int default 0 comment '所在城市',
	primary key(`bid`),
	key province(`province`)
)engine=InnoDB default charset=utf8 comment='门店表';
