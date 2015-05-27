drop table if exists `m_product_attr`;
create table if not exists `m_product_attr`(
	`pa_id` int auto_increment,
	`pa_name` varchar(50) not null comment '属性名称',
	`pid` int unsigned not null default 0 comment '父ID,0表示属性名称,如果不为0表示是属性值',
	primary key(`pa_id`),
	key pid(`pid`)
)engine=InnoDB default charset=utf8;
