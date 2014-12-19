drop table if exists `sys_score`;
create table if not exists `sys_score`(
	`id` int auto_increment,
	`uid` int not null comment '用户ID',
	`oid` int not null comment '消费订单ID',
	`addtime` int unsigned not null comment '消费时间',
	primary key(`id`),
	key uid(`uid`)
)engine=InnoDB default charset=utf8 auto_increment=1000 comment='积分记录';
