drop table if exists `sys_menu`;
create table if not exists `sys_menu`(
	`mid` int auto_increment,
	`cid` int unsigned not null comment '分类ID',
	`aid` int unsigned not null default 0 comment '参加活动ID',
	`title` varchar(50) not null comment '名称',
	`price` decimal(6,2) not null,
	`img` varchar(100) not null,
	`favorable_price` decimal(6,2) not null comment '优惠价格',
	
	`provide_time` tinyint unsigned not null default 0 comment '供应时间, 0-全天, 1-上午, 10-中午, 20-下午 ...',
	`new` tinyint unsigned not null default 0 comment '新品',

	`good_point` int unsigned not null default 0 comment '点赞点数',
	`like_point` int unsigned not null default 0 comment '喜欢点数',
	`sell_point` int unsigned not null default 0 comment '已售点数',

	-- 味道相关
	`peppery` tinyint unsigned not null default 0 comment '辣度',

	`description` varchar(5000) not null default '' comment '菜单描述',
	`status` tinyint unsigned not null default 1 comment '菜单状态,1-上架, 0-下架',
	`addtime` int not null,

	primary key(`mid`),
	key cid(`cid`),
	key status(`status`),
	key provide_time(`provide_time`),
	key `new`(`new`)
)engine=InnoDB default charset=utf8 comment='菜单表';
