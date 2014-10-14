create table if not exists `tags`(
	`id` int not null auto_increment,
	`name` varchar(10) not null comment '标签名称',
	`blog_id` int not null comment '博客ID',
	primary key(`id`),
	unique key(`name`)
)engine=InnoDB default charset=utf8 comment='标签表';
