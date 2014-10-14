create table if not exists `user`(
	`uid` int not null auto_increment,
	`username` char(10) not null comment '用户名',
	`password` char(32) not null, 
	`nickname` varchar(20) not null default '' comment '昵称',
	`email` varchar(20) not null default '',
	`phone` int(11) not null default 0 comment '手机',
	`ip` int(11) not null default 0 comment '创建用户所用IP, ip2long', 
	primary key(`uid`),
	unique key(`username`),
	key email(`email`),
	key phone(`phone`)
)engine=InnoDB default charset=utf8;
