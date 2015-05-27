drop table if exists `m_sysadm_node`;
create table if not exists `m_sysadm_node`(
	`id` int auto_increment,
	`name` varchar(10),
	`controller_code` varchar(10),
	`controller_name` varchar(10),
	`action_code` varchar(10),
	`action_name` varchar(10),
	`type` tinyint unsigned not null comment '节点类型, 0-表示根导航',
	`status` tinyint unsigned not null default 1 comment '1-显示, 0-不显示',
	`sortno` int unsigned not null default 0,
	primary key(`id`),
	key type(`type`)
)engine=InnoDB default charset=utf8;
