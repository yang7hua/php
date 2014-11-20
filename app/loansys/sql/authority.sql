drop table if exists `sys_authority`;
create table if not exists `sys_authority`(
	`id` int auto_increment,
	`app` tinyint unsigned not null default 0 comment 'app，1-loansys, 2-sysadm',	
	`controller` varchar(20) not null comment '控制器, 小写形式',
	`action` varchar(20) not null comment '方法名称, 小写形式',
	primary key(`id`),
	key app(`app`)
)engine=InnoDB default charset=utf8 comment='权限表，存储所有可设置的权限';
