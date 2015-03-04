drop table if exists `ops_bestinvestor`;
create table if not exists `ops_bestinvestor`(
	`id` int auto_increment,
	`uid` int unsigned not null,
	`img` varchar(5000) not null comment '照片, 多张逗号分隔',
	`info` varchar(5000) not null comment '描述',
	`sign` char(4) not null comment '标识, 用于区分哪一期',
	`other_fields` varchar(5000) not null default '' comment '其它字段',
	`vote` int unsigned not null default 0 comment '得票数',
	`status` tinyint unsigned not null default 1 comment '状态',
	`addtime` int unsigned not null,
	primary key(`id`),
	key uid(`uid`),
	key sign(`sign`)
)engine=InnoDB default charset=utf8 comment='最佳投资人';

drop table if exists `ops_bestinvestor_vote`;
create table if not exists `ops_bestinvestor_vote`(
	`id` int auto_increment,
	`bid` int unsigned not null comment '投资人数据ID',
	`uid` int unsigned not null comment '投票者ID',
	`other_fields` varchar(5000) not null default '' comment '其它字段',
	`status` tinyint unsigned not null default 1 comment '投票状态',
	`sign` char(4) not null comment '标识, 用于区分哪一期投票, 主要用于判定用户投票次数',
	`addtime` int unsigned not null comment '投票时间',
	primary key(`id`),
	key bid(`bid`),
	key buid(`bid`, `uid`),
	key uid(`uid`)
)engine=InnoDB default charset=utf8 comment='最佳投资人投票表';
