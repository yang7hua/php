drop table if exists `sys_favorite`;
create table if not exists `sys_favorite`(
	`fid` int auto_increment,
	`mid` int unsigned not null comment '菜单ID',
	`aid` int unsigned not null comment '活动ID',
	`addtime` int unsigned not null comment '添加时间',
	`status` tinyint unsigned not null comment '状态',
	primary key(`fid`),
	key mid(`mid`),
	key aid(`adi`),
	key status(`status`)
)engine=InnoDB default charset=utf8 comment='活动菜单,如满积分赠送活动';
