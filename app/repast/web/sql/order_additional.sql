drop table if exists `sys_order_additional`;
create table if not exists `sys_order_additional`(
	`id` int auto_increment,
	`oid` int unsigned not null comment '订单ID',
	`mid` int unsigned not null comment '菜单ID',
	`addtime` int unsigned not null comment '添加时间',
	primary key(`id`),
	key oid(`oid`),
	key `mid`(`mid`)
)engine=InnoDB default charset=utf8 comment='订单附加产品';
