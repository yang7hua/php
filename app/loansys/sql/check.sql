-- 核查人员
-- 包括上门核查、车评人员

drop table if exists `sys_check`;
create table if not exists `sys_check`(
	`id` int not null auto_increment,
	`oid` int unsigned not null comment '核查人员ID',
	`uid` int unsigned not null comment '贷款客户ID',
	-- 因为客户情况随着时间会有所变化，次记录对应1条贷款

	-- 上门核查
	`visit_company_address` varchar(1000) not null default '' comment '外访公司地址',
	`license_compay_address` tinyint unsigned not null default 1 comment '公司地址是否与证件一致, 1-一致',
	`income_company_address` tinyint unsigned not null default 1 comment '公司地址与收入证明是否一致',
	`company_status` tinyint unsigned default 0 comment '公司开业状况',
	`company_area` varchar(100) default '' comment '公司经营面积',
	`company_decorate` varchar(100) default '' comment '内部装饰',
	`company_industry` varchar(100) default '' comment '公司所属行业',
	`company_people_number` varchar(100) default '' comment '公司人数',
	`company_info` varchar(1000) default '' comment '公司其它情况',

	`job_year` varchar(100) default '' comment '入职年限',
	`job_duty` varchar(100) default '' comment '现任职务',
	`job_income` varchar(100) default '' comment '收入',
	`invest_amount` decimal(6,2) default 0.00 comment '投资金额',
	`invest_rate` varchar(100) default '' comment '投资比率',
	`job_company` varchar(100) default '' comment '公司名',

	`visit_address` varchar(1000) not null default '' comment '外访公司地址',
	`house_live_address` tinyint unsigned default 1 comment '房产地址是否与居住地址一致',
	`house_live_address_info` varchar(1000) default '' comment '房产和居住地址不一致的说明',
	`house_live_often` tinyint unsigned default 0 comment '居住房屋是否有常住痕迹',

	-- 车评 
	`car_loan` tinyint unsigned not null default 0 comment '全款车，1-有贷款，0-全款', 
	`car_otherhand` tinyint unsigned not null default 1 comment 'x手车, 1-一手, 2-二手, 3-三手车, 默认为一手车',
	`car_secondhand_info` varchar(1000) not null default '' comment '二手车说明',
	`car_brand` int unsigned not null default 0 comment '车品牌id',
	`car_type` varchar(20) not null default '' comment '车型号',
	`car_price` float(6,2) not null default 0.00 comment '价格，万为单位',
	`car_buytime` int not null default 0 comment '购买时间',
	`car_appearance` tinyint not null default 0 comment '外观, 0-无',
	`car_inappearance` tinyint not null default 0 comment '内观',
	`car_accident_info` varchar(1000) not null default '' comment '事故说明',
	`car_fall_price` float(7,2) not null default 0.00 comment '每月掉价幅度',
	`car_assess_price` float(6,2) not null default 0.00 comment '评估价格',
	`car_sys_assess_price` float(6,2) not null default 0.00 comment '系统评估价格',
	
	`addtime` int not null comment '核查时间',

	primary key(`id`),
	key oid(`oid`),
	key uid(`uid`)
)engine=InnoDB default charset=utf8 comment='核实表,包括客户基本情况和固定资产等';
