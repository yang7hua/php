drop table if exists `sys_order`;
create table if not exists `sys_order`(
	`oid` int auto_increment,
	`uid` int unsigned not null,
	`mid` int unsigned not null default 0 comment '菜单ID',
	`gid` int unsigned not null default 0 comment '组合菜单ID',
	`fid` int unsigned not null default 0 comment '优惠菜单ID, 如满积分赠送',
	`amount` decimal(6,2) not null comment '消费金额',
	`status` tinyint unsigned not null default 0 comment '订单状态',
	`remark` varchar(100) not null default '' comment '订单备注',
	`addtime` int unsigned not null,
	primary key(`oid`),
	key uid(`uid`),
	key `mid`(`mid`),
	key status(`status`)
)engine=InnoDB default charset=utf8 comment='订单表';
