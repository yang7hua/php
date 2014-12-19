drop table if exists `sys_user`;
create table if not exists `sys_user`(
	`uid` int auto_increment,
	`username` varchar(20) not null unique,
	`password` varchar(32) not null,

	`realname` varchar(10) not null default '',
	`gender` tinyint unsigned not null default 1,
	`email` varchar(20) not null default '',
	`phone` varchar(11) not null default '',
	`province` char(6) not null,
	`city` char(6) not null,
	`address` varchar(100) not null default '',

	`score` int unsigned not null default 0 comment '消费积分',
	`vip` tinyint unsigned not null default 0 comment '会员等级',

	`addtime` int not null,
	primary key(`uid`)
)engine=InnoDB default charset=utf8 auto_increment=100000 comment='用户表';
