drop table if exists `m_product`;
create table if not exists `m_product`(
	`p_id` int auto_increment,
	`pt_id` int unsigned not null comment '分类ID',
	`pa_id` varchar(500) not null comment '商品属性组ID, _ 分隔',
	`pname` varchar(100) not null,
	`price` decimal(10,2) not null,
	`count` int unsigned not null default 0 comment '库存量',
	`sale_count` int unsigned not null default 0 comment '销售量',
	`fav_point` int unsigned not null default 0 comment '关注数',
	`comments` int unsigned not null default 0 comment '评论数',
	`thumb` varchar(100) default '' comment '图片',
	`desc` varchar(200) not null comment '简单描述',
	`content` varchar(5000) not null comment '详细页面',
	`activity_id` int unsigned comment '活动ID',
	primary key(`p_id`),
	key pt_id(`pt_id`),
	key activity_id(`activity_id`)
)engine=InnoDB default charset=utf8;
