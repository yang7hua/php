drop table `category`;
create table if not exists `category`(
	`cid` smallint not null auto_increment,
	`pid` smallint unsigned not null default 0 comment '父id',
	`name` varchar(15) not null default '' comment '分类名称',
	`uid` int unsigned not null default 0 comment '用户ID',
	primary key(`cid`),
	key pid(`pid`)
)engine=InnoDB default charset=utf8 comment='文章分类表';
