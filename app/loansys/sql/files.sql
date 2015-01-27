drop table if exists `sys_files`;
create table if not exists `sys_files`(
	`id` int auto_increment,
	`uid` int unsigned not null comment '客户ID',
	`oid` int unsigned not null comment '操作者ID',
	`type` smallint unsigned not null comment '文件列表',
	`label` varchar(50) not null default '' comment '标签',
	`path` varchar(100) not null comment '文件路径',
	`info` varchar(500) not null default '' comment '描述说明',
	`is_img` tinyint unsigned not null default 0 comment '是否是图像资源',
	`addtime` int unsigned not null comment '上传时间',
	primary key(`id`),
	key uid(`uid`,`type`)
)engine=InnoDB default charset=utf8 comment='文件表';
