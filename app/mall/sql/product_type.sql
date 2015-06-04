drop table if exists `m_product_type`;
create table if not exists `m_product_type`(
	`pt_id` int auto_increment,
	`pid` int unsigned not null default 0 comment '父级ID',
	`pt_name` varchar(50) not null comment '分类名称',
	`pta_id` varchar(500) not null comment '商品类型属性ID, _ 分隔',
	primary key(`pt_id`),
	key pid(`pid`)
)engine=InnoDB default charset=utf8;
