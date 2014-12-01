drop table if exists `sys_car_assess`;
create table if not exists `sys_car_assess`(
	`id` int not null auto_increment,
	`oid` int unsigned not null comment '核查人员ID',
	`uid` int unsigned not null comment '贷款客户ID',

	-- 车评 
	`car_loan` tinyint unsigned default 0 comment '全款车，1-有贷款，0-全款', 
	`car_otherhand` tinyint unsigned  default 1 comment 'x手车, 1-一手, 2-二手, 3-三手车, 默认为一手车',
	`car_secondhand_info` varchar(1000) default '' comment '二手车说明',
	`car_brand` varchar(30) default '' comment '车品牌',
	`car_type` varchar(0) default '' comment '车型号',
	`car_price` float(6,2) default 0.00 comment '价格，万为单位',
	`car_buytime` int default 0 comment '购买时间',
	`car_appearance` tinyint default 0 comment '外观, 0-无',
	`car_inappearance` tinyint default 0 comment '内观',
	`car_accident_info` varchar(1000) default '' comment '事故说明',
	`car_fall_price` float(8,2) default 0.00 comment '每月掉价幅度',
	`car_assess_price` float(8,2) default 0.00 comment '评估价格',
	`car_sys_assess_price` float(6,2) default 0.00 comment '系统评估价格',
	
	`addtime` int not null comment '评估时间',

	primary key(`id`),
	key oid(`oid`),
	key uid(`uid`)
)engine=InnoDB default charset=utf8 comment='核实表,包括客户基本情况和固定资产等';
