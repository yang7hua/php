drop table if exists `info`;
create table if not exists `info`(
	`id` int auto_increment,
	`key` varchar(20) not null unique,
	`value` varchar(255) not null,
	`type` tinyint unsigned not null default 1 comment '配置类别',
	primary key(`id`),
	key type(`type`)
)default charset=utf8 comment='信息表';
