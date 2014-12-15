drop table if exists `sys_order`;
create table if not exists `sys_order`(
	`oid` int auto_increment,
	`uid` int unsinged not null,
	`mid` int unsinged not null comment '菜单ID',
	`status` tinyint unsinged not null default 0 comment '订单状态',
	`remark` varchar(100) not null default '' comment '订单备注',
	`addtime` int unsinged not null,
	primary key(`oid`),
	key uid(`uid`),
	key mid(`mid`),
	key status(`status`)
)engine=InnoDB default charset=utf8 comment='订单表';
