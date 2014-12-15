drop table if exists `sys_menu`;
create table if not exists `sys_menu`(
	`mid` int auto_increment,
	`pid` int unsigned not null default 0,
	`title` varchar(50) not null comment '名称',
	`price` decimal(6,2) not null,
	`img` varchar(100) not null,
	`favorable_price` decimal(6,2) not null comment '优惠价格',
	`provide_time` tinyint unsigned not null comment '供应时间, 1-上午, 10-中午, 20-下午 ...',
	`new` tinyint unsigned not null default 0 comment '新品',
	`good_point` int unsigned not null default 0 comment '点赞点数',
	`like_point` int unsigned not null default 0 comment '喜欢点数',
	`sell_point` int unsigned not null default 0 comment '已售点数',
	`description` varchar(5000) not null default '' comment '菜单描述',
	`status` tinyint unsigned not null default 1 comment '菜单状态,1-上架, 0-下架',
	`addtime` int not null,
	primary key(`mid`),
	key pid(`pid`),
	key status(`status`),
	key provide_time(`provide_time`)
)engine=InnoDB default charset=utf8 comment='菜单表';
