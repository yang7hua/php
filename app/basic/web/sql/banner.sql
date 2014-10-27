drop table if exists `banner`;
create table if not exists `banner`(
	`id` smallint not null auto_increment,
	`name` varchar(10) not null comment '导航名称',
	`url` varchar(255) not null default '' comment 'url地址',
	`sortno` smallint unsigned not null default 0 comment '排序',
	`pid` smallint unsigned not null default 0 comment '父级导航id',
	primary key(`id`),
	unique key(`name`)
)default charset=utf8 comment='导航';
