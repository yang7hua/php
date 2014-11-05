drop table if exists `review`;
create table if not exists `review`(
	`id` int auto_increment,
	`pid` int unsigned not null default 0 comment '父级评论id',
	`blog_id` int unsigned not null comment '博客ID',
	`nickname` varchar(20) not null default '' comment '昵称',
	`content` varchar(140) not null default '' comment '评论内容',
	`time` int not null,
	primary key(`id`),
	key pid(`pid`)
)default charset=utf8 comment='评论';
