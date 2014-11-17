drop table if exists `user`;
create table if not exists `user`(
	`uid` int auto_increment comment '用户ID',
	`idcard` char(18) not null comment '身份证ID',
	`realname` varchar(10) not null comment '真实姓名',
    `gender` tinyint(1) NOT NULL DEFAULT '0' COMMENT '性别:0-未知,1-男,2-女',
    `birthdate` varchar(10) NOT NULL DEFAULT '' COMMENT '出生日期',
    `mobile` varchar(16) DEFAULT NULL COMMENT '手机号码',
    `email` varchar(64) DEFAULT NULL COMMENT '邮箱',
    `contact_name` varchar(30) NOT NULL DEFAULT '' COMMENT '紧急联系人',
    `contact_phone` varchar(20) NOT NULL default '' COMMENT '联系手机或电话',
	`addtime` int not null comment '客户创建日期',
	primary key(`uid`),
	unique key(`idcard`)
)engine=InnoDB default charset=utf8 comment='用户表';
