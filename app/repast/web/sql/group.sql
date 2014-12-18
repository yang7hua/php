drop table if exists `sys_group`;
create table if not exists `sys_group`(
	`gid` int auto_increment,
	`price` decimal(6,2) not null comment '套餐价格',
	`favorable_price` decimal(6,2) not null comment '优惠价格',
	`mids` varchar(100) not null comment '菜单ID组合,逗号分隔',
	`description` varchar(5000) not null default '' comment '描述',
	`addtime` int unsigned not null,
	`status` tinyint unsigned not null default 1 comment '状态,1-上架, 0-下架',
	primary key(`id`),
	key status(`status`)
)engine=InnoDB default charset=utf8 comment='组合套餐';
