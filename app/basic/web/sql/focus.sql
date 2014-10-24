drop table if exists `focus`;
create table if not exists `focus`(
	`id` smallint unsigned not null auto_increment,
	`image` varchar(255) not null,
	`blog_id` int unsigned not null default 0,
	`title` varchar(100) not null default '',
	`type` tinyint unsigned not null default 1 comment '焦点图位置,默认为首页',
	primary key(`id`),
	key `type`(`type`)
)default charset=utf8 comment='焦点图';
