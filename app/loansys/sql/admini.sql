-- 作员表
drop table if exists `sys_admini`;
drop table if exists `sys_admin`;
create table if not exists `sys_admini`(
	`aid` int auto_increment,
	`username` varchar(20) not null unique comment '用户名',
	`password` varchar(50) not null comment '密码',
	`bid` int unsigned not null default 0 comment '门店ID',
	`issuper` tinyint unsigned not null default 0 comment '超级账号',
	`status` tinyint unsigned not null default 1 comment '帐号状态，1-正常, 10-冻结',
	primary key(`aid`),
	key bid(`bid`),
	key status(`status`)
)engine=InnoDB default charset=utf8 comment='管理员表';
