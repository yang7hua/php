drop table if exists `m_car`;
create table if not exists `m_car`(
	`id` int auto_increment,
	`uid` int unsigned not null,
	`gid` int unsigned not null comment '商品编号',
	`price` decimal(10,2) not null comment '单价',
	`fav_price` decimal(10,2) not null comment '优惠价格',
	`count` tinyint unsigned not null default 1,
	`total_price` decimal(10,2) not null comment '商品总价',
	`gname` varchar(100) not null comment '商品名称',
	`addtime` int unsigned not null,
)engine=InnoDB default charset=utf8 auto_increment=1000;
