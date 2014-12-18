drop table if exists `sys_category`;
create table if not exists `sys_category`(
	`cid` int auto_increment,
	`pid` int unsigned not null default 0 comment '父ID',
	`name` varchar(20) not null comment '分类名称',
	`status` tinyint unsigned not null default 1 comment '状态,1-正常,10-无效',
	`addtime` int unsigned not null,
	primary key(`cid`),
	key pid(`pid`)
)engine=InnoDB default charset=utf8 comment='菜单分类';
