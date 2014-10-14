create table if not exists `blogs`(
	`id` int not null auto_increment,
	`cid` smallint unsigned not null default 0 comment '分类id',
	`title` varchar(50) not null default '' comment '标题',
	`content` text not null comment '内容',
	`addtime` int not null comment '添加时间',
	`uptime` int not null default 0 comment '更新时间',
	`status` enum('publish','trash','deleted','sketch') not null default 'sketch' comment '状态',
	`image` varchar(50) not null default '' comment '特色图像',
	`tags` varchar(50) not null default '' comment '标签, tag1,tag2...',
	primary key(`id`),
	key cid(`cid`)
)engine=InnoDB default charset=utf8;
