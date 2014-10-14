drop table `blogs`;
create table if not exists `blogs`(
	`id` int not null auto_increment,
	`cid` smallint unsigned unsigned not null default 0 comment '分类id',
	`uid` int unsigned not null default 0 comment '用户ID',
	`title` varchar(50) not null default '' comment '标题',
	`content` text not null comment '内容',
	`addtime` int not null comment '添加时间',
	`uptime` int not null default 0 comment '更新时间',
	`status` enum('publish','trash','deleted','sketch') not null default 'sketch' comment '状态,publish:发布,trash:垃圾,deleted:已删除,sketch:草稿',
	`image` varchar(50) not null default '' comment '特色图像',
	`tags` varchar(50) not null default '' comment '标签, tag1,tag2...',
	`read` mediumint unsigned not null default 0 comment '阅读数',
	`comment` mediumint unsigned not null default 0 comment '评论',
	`is_private` tinyint unsigned not null default 0 comment '仅自己可见',
	`allow_review` tinyint unsigned not null default 1 comment '是否允许评论',
	`author` varchar(10) not null default '' comment '作者', 
	primary key(`id`),
	key cid(`cid`)
)engine=InnoDB default charset=utf8;
