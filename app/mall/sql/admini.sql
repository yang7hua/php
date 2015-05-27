drop table if exists `m_admini`;
create table if not exists `m_admini`(
	`aid` int auto_increment,
	`aname` varchar(12) not null,
	`password` char(32) not null,
	`role_id` int unsigned not null,
	`addtime` int unsigned not null,
	`addip` int unsigned not null,
	`status` tinyint unsigned not null default 1,
	primary key(`aid`),
	unique key(`aname`)
)engine=InnoDB default charset=utf8;
