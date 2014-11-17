--
-- 用户工作信息表
-- 针对每笔贷款的事实情况
-- 此表由面审人员完成
--

DROP TABLE IF EXISTS `sys_user_info`;
CREATE TABLE IF NOT EXISTS `sys_user_info` (
    `uid` int(10) unsigned NOT NULL COMMENT '用户ID',
	`lid` int unsigned not null COMMENT '对应每笔贷款的实时情况',
	`oid` int unsigned not null comment '操作人员ID',

	--基本情况
    `province` int(6) unsigned NOT NULL DEFAULT '0' COMMENT '居住省份',
    `city` int(6) unsigned NOT NULL DEFAULT '0' COMMENT '居住城市',
    `address` varchar(150) NOT NULL DEFAULT '' COMMENT '详细居住地址',
    `address_phone` varchar(20) NOT NULL DEFAULT '' COMMENT '居住地电话',
    `education` tinyint(1) NOT NULL DEFAULT '0' COMMENT '学历:0-未知,1-高中或以下,2-大专,3-本科,4-研究生或以上',
    `graduated_year` smallint(4) NOT NULL DEFAULT '0' COMMENT '毕业年份',
    `graduated_school` varchar(60) NOT NULL DEFAULT '' COMMENT '毕业学校',
	`info` varchar(1000) not null default '' COMMENT '基本情况说明',

	--婚姻情况
    `marriage` tinyint(1) NOT NULL DEFAULT '0' COMMENT '婚姻状况:0-未知,1-已婚,2-离异,3-未婚',
    `have_child` tinyint(1) NOT NULL DEFAULT '0' COMMENT '有无子女:0-未知,1-有,2-无',
	`child_info` varchar(100) not null default '' comment '子女情况说明',
	`spouse_name` varchar(10) not null default '' comment '配偶姓名', 
	`spouse_idcard` char(18) not null default '' COMMENT '配偶身份证',
	`spouse_info` varchar(100) not null default '' COMMENT '配偶情况说明',

	--固定资产
    `have_house` tinyint(1) NOT NULL DEFAULT '0' COMMENT '住房情况:0-未知,1-无,2-商品房,3-自建房',
    `house_loan` tinyint(1) NOT NULL DEFAULT '0' COMMENT '有无房贷:0-未知,1-有,2-无',
    `have_car` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否有车:0-未知,1-有,2-无',
    `car_brand` int NOT NULL DEFAULT 0 COMMENT '汽车品牌ID',
    `car_year` smallint(4) NOT NULL DEFAULT '0' COMMENT '购车年份',
    `car_loan` tinyint(1) NOT NULL DEFAULT '0' COMMENT '有无车贷:0-未知,1-有,2-无',

	--工作情况
    `company` varchar(90) NOT NULL COMMENT '单位名称或个人',
    `company_type` tinyint(1) unsigned NOT NULL COMMENT '公司类别',
    `company_scale` tinyint(1) unsigned NOT NULL COMMENT '公司规模',
    `industry` tinyint(2) unsigned NOT NULL COMMENT '行业', 
    `position` varchar(30) NOT NULL COMMENT '职位',
    `job_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '工作类型: 0-未知, 1-工薪阶层,2-私营企业主,3-自由职业,4-网络商家,5-其他',
    `salary` tinyint(1) unsigned NOT NULL COMMENT '月收入',
    `work_years` tinyint(1) unsigned NOT NULL COMMENT '工作年限',
    `work_email` varchar(64) NOT NULL COMMENT '工作邮箱',
    `company_address` varchar(150) NOT NULL COMMENT '公司地址',
    `company_phone` varchar(20) NOT NULL COMMENT '公司电话',

	--- 负债情况
	`debt_info` varchar(1000) not NULL default '' comment '负债总额(万为单位), 每月还款, 证明方式, 逾期情况, 按揭车还款情况',

    PRIMARY KEY (`uid`),
	key uid(`uid`),
	key oid(`oid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
