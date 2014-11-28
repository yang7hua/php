create table if not exists `ops_year_meeting_apply`(
	`id` int auto_increment,
	`uid` int unsigned not null comment '用户ID',
	`realname` varchar(20) not null comment '真实姓名',
	`gender` enum('m', 'w') not null comment '称呼,m-先生, w-女士',
	`mobile` varchar(11) not null comment '手机',
	`other_mobile` varchar(15) not null default '' comment '备用联系方式',
	`qq` varchar(13) not null default '' comment 'qq', 
	`comefrom` varchar(50) not null comment '出发城市',
	`traffic` tinyint unsigned not null comment '交通方式',
	`addtime` int not null comment '申请时间',	
	`status` tinyint unsigned not null default 1 comment '状态, 1-申请成功, 0-取消, 20-异常',
	primary key(`id`),
	key uid(`uid`),
	key status(`status`)
)engine=InnoDB default charset=utf8 comment='年会报名表';
