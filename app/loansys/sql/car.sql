drop table if exists `sys_car_assess`;
create table if not exists `sys_car_assess`(
	`id` int not null auto_increment,
	`oid` int unsigned not null comment '核查人员ID',
	`uid` int unsigned not null comment '贷款客户ID',

	-- 基本信息
	`car_owner` varchar(10) not null comment '车主',
	`home_address` varchar(100) not null comment '住址',
	`mobile` varchar(50) not null comment '联系电话',
	`car_photos` varchar(100) default '0' comment '照片,fileid，多张逗号分隔',
	`car_number` varchar(20) not null comment '牌照',
	`car_nature` tinyint unsigned default 1 comment '性质，1-私有，0-公有', 

	-- 原始情况
	`car_brand` varchar(30) default '' comment '车品牌',
	`car_type` varchar(30) default '' comment '车型号',
	`car_color` varchar(30) not null comment '车身颜色',
	`car_vin` varchar(50) not null comment '车辆识别代码 vin',
	`car_engine_number` varchar(50) not null comment '发动机号',
	`car_seat_count` varchar(50) not null default '' comment '坐位数/排量',
	`car_register_date` int unsigned not null comment '登记日期',
	`car_mileage` int unsigned not null default 0 comment '里程，公里',
	`car_age` tinyint unsigned not null default 0 comment '使用年限',
	`car_use` varchar(50) not null default '' comment '使用用途',

	-- 检车核对交易证件
	`car_bill` varchar(20) default '0' comment '发票，fileid',
	`car_register_license` varchar(20) default '0' comment '登记证书',
	`car_legal_idcard` varchar(20) default '0' comment '法人代码或身份证',
	`car_other_license` varchar(50) default '0' comment '其它证件',
	`car_tax_addition` varchar(20) default '0' comment '购置税附加税',
	`car_tax_use` varchar(20) default '0' comment '车船使用税',
	`car_insure` varchar(20) default '0' comment '交强险',
	`car_other_tax` varchar(50) default '0' comment '其它税费',

	`car_status_tech` tinyint unsigned comment '技术状况',
	`car_status_maintain` tinyint unsigned comment '维修保养',
	`car_make_quality` tinyint unsigned comment '制造质量',
	`car_work_nature` tinyint unsigned comment '工作性质',
	`car_work_status` tinyint unsigned comment '工作条件',

	`car_loan` tinyint unsigned default 0 comment '全款车，1-有贷款，0-全款', 
	`car_loan_info` varchar(1000) not null default '' comment '车辆贷款说明',
	`car_price` float(6,2) default 0.00 comment '购买价格，万',
	`car_price_now` float(6,2) default 0.00 comment '现价，万',
	`car_fall_price` float(8,2) default 0.00 comment '每月掉价幅度',
	`car_new_rate` tinyint unsigned not null comment '成新率',
	`car_reset_capital` float(6,2) default 0.00 comment '重置成本',
	`car_assess_price` float(8,2) default 0.00 comment '评估价格',
	`car_sys_assess_price` float(6,2) default 0.00 comment '系统评估价格',
	`car_assess_remark` varchar(1000) not null default '' comment '评估说明',
	
	`addtime` int not null comment '评估时间',

	primary key(`id`),
	key oid(`oid`),
	key uid(`uid`)
)engine=InnoDB default charset=utf8 comment='车相关信息';
