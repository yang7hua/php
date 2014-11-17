drop table if exists `sys_check`;
create table if not exists `sys_check`(
	`id` int not null auto_increment,
	`aid` int unsigned not null comment '核查人员ID',
	`uid` int unsigned not null comment '贷款客户ID',
	/*因为客户情况随着时间会有所变化，次记录对应1条贷款*/
	`lid` int unsigned not null comment '关联的贷款ID',

	`license_compay_address` tinyint unsigned not null default 0 comment '公司地址是否与证件一致, 0-一致',
	`income_company_address` tinyint unsigned not null default 0 comment '公司地址与收入证明是否一致',
	`company_info` varchar(1000) not null default '' comment '公司经营状况',
	`house_live_address` tinyint unsigned not null default 0 comment '房产地址是否与居住地址一致',
	`house_live_address_info` varchar(1000) not null default '' comment '房产和居住地址不一致的说明',
	`live_often` tinyint unsigned not null default 0 comment '居住房屋是否有常住痕迹',

	`car_loan` tinyint unsigned not null default 0 comment '全款车，1-有贷款，0-全款', 
	`car_otherhand` tinyint unsigned not null defaut 1 comment 'x手车, 1-一手, 2-二手, 3-三手车',
	`car_secondhand_info` varchar(1000) not null default '' comment '二手车说明',
	`car_brand` int unsigned not null defaut 0 comment '车品牌id',
	`car_type` varchar(20) not null default '' comment '车型号',
	`car_price` float(6,2) not null default 0.00 comment '价格，万为单位',
	`car_buytime` int not null default 0 comment '购买时间',
	`car_appearance` tinyint not null default 0 comment '外观, 0-无',
	`car_inappearance` tinyint not null default 0 comment '内观',
	`car_accident_info` varchar(1000) not null default '' comment '事故说明',
	`car_fall_price` float(7,2) not null default 0.00 comment '每月掉价幅度',
	`car_assess_price` float(6,2) not null defaut 0.00 comment '评估价格',
	`car_sys_assess_price` float(6,2) not null defaut 0.00 comment '系统评估价格',
	
	`addtime` int not null comment '核查时间',

	primary key(`id`),
	key aid(`aid`),
	key uid(`uid`),
	key lid(`lid`)

)engine=InnoDB defaut charset=utf8 comment='核实表,包括客户基本情况和固定资产等';
