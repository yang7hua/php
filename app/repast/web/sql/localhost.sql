-- phpMyAdmin SQL Dump
-- version 4.1.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2014-12-25 15:28:57
-- 服务器版本： 5.6.20
-- PHP Version: 5.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `repast`
--

-- --------------------------------------------------------

--
-- 表的结构 `sys_activity`
--

CREATE TABLE IF NOT EXISTS `sys_activity` (
  `aid` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL COMMENT '活动标题',
  `shortname` varchar(20) NOT NULL COMMENT '简称',
  `description` varchar(5000) NOT NULL COMMENT '活动描述',
  `addtime` int(10) unsigned NOT NULL,
  `status` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`aid`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='活动表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `sys_admini`
--

CREATE TABLE IF NOT EXISTS `sys_admini` (
  `aid` int(11) NOT NULL AUTO_INCREMENT,
  `bid` int(10) unsigned NOT NULL COMMENT '门店ID',
  `username` varchar(20) NOT NULL,
  `password` varchar(32) NOT NULL,
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态,1-正常,0-删除,20-冻结',
  `addtime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`aid`),
  UNIQUE KEY `username` (`username`),
  KEY `bid` (`bid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='管理员表' AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `sys_admini`
--

INSERT INTO `sys_admini` (`aid`, `bid`, `username`, `password`, `status`, `addtime`) VALUES
(1, 1, 'yanghua', 'c734aef723539f59d978f1cccdb5885d', 1, 1355760000);

-- --------------------------------------------------------

--
-- 表的结构 `sys_category`
--

CREATE TABLE IF NOT EXISTS `sys_category` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '父ID',
  `name` varchar(20) NOT NULL COMMENT '分类名称',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态,1-正常,10-无效',
  `addtime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`cid`),
  KEY `pid` (`pid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='菜单分类' AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `sys_category`
--

INSERT INTO `sys_category` (`cid`, `pid`, `name`, `status`, `addtime`) VALUES
(1, 0, 'AB', 1, 1418969850);

-- --------------------------------------------------------

--
-- 表的结构 `sys_group`
--

CREATE TABLE IF NOT EXISTS `sys_group` (
  `gid` int(11) NOT NULL AUTO_INCREMENT,
  `price` decimal(6,2) NOT NULL COMMENT '套餐价格',
  `favorable_price` decimal(6,2) NOT NULL COMMENT '优惠价格',
  `mids` varchar(100) NOT NULL COMMENT '菜单ID组合,逗号分隔',
  `description` varchar(5000) NOT NULL DEFAULT '' COMMENT '描述',
  `addtime` int(10) unsigned NOT NULL,
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态,1-上架, 0-下架',
  PRIMARY KEY (`gid`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='组合套餐' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `sys_menu`
--

CREATE TABLE IF NOT EXISTS `sys_menu` (
  `mid` int(11) NOT NULL AUTO_INCREMENT,
  `cid` int(10) unsigned NOT NULL COMMENT '分类ID',
  `aid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '参加活动ID',
  `title` varchar(50) NOT NULL COMMENT '名称',
  `price` decimal(6,2) NOT NULL,
  `img` varchar(100) NOT NULL,
  `favorable_price` decimal(6,2) NOT NULL COMMENT '优惠价格',
  `provide_time` tinyint(3) unsigned NOT NULL COMMENT '供应时间, 1-上午, 10-中午, 20-下午 ...',
  `new` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '新品',
  `good_point` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '点赞点数',
  `like_point` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '喜欢点数',
  `sell_point` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '已售点数',
  `peppery` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '辣度',
  `description` varchar(5000) NOT NULL DEFAULT '' COMMENT '菜单描述',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '菜单状态,1-上架, 0-下架',
  `addtime` int(11) NOT NULL,
  PRIMARY KEY (`mid`),
  KEY `cid` (`cid`),
  KEY `status` (`status`),
  KEY `provide_time` (`provide_time`),
  KEY `new` (`new`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='菜单表' AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `sys_menu`
--

INSERT INTO `sys_menu` (`mid`, `cid`, `aid`, `title`, `price`, `img`, `favorable_price`, `provide_time`, `new`, `good_point`, `like_point`, `sell_point`, `peppery`, `description`, `status`, `addtime`) VALUES
(1, 1, 0, 'abc', '32.00', '', '28.00', 0, 1, 0, 0, 0, 0, '', 1, 1419229300),
(2, 1, 0, 'ccc', '19.00', '', '18.00', 0, 1, 0, 0, 0, 0, '', 1, 1419306043);

-- --------------------------------------------------------

--
-- 表的结构 `sys_order`
--

CREATE TABLE IF NOT EXISTS `sys_order` (
  `oid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned NOT NULL,
  `mid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '菜单ID',
  `gid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '组合菜单ID',
  `oaid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '附加ID, 如满积分赠送',
  `amount` decimal(6,2) NOT NULL COMMENT '消费金额',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '订单状态',
  `remark` varchar(100) NOT NULL DEFAULT '' COMMENT '订单备注',
  `addtime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`oid`),
  KEY `uid` (`uid`),
  KEY `mid` (`mid`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='订单表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `sys_order_additional`
--

CREATE TABLE IF NOT EXISTS `sys_order_additional` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `oid` int(10) unsigned NOT NULL COMMENT '订单ID',
  `mid` int(10) unsigned NOT NULL COMMENT '菜单ID',
  `addtime` int(10) unsigned NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`),
  KEY `oid` (`oid`),
  KEY `mid` (`mid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='订单附加产品' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `sys_user`
--

CREATE TABLE IF NOT EXISTS `sys_user` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(32) NOT NULL,
  `realname` varchar(10) NOT NULL DEFAULT '',
  `gender` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `email` varchar(20) NOT NULL DEFAULT '',
  `phone` varchar(11) NOT NULL DEFAULT '',
  `province` char(6) NOT NULL,
  `city` char(6) NOT NULL,
  `address` varchar(100) NOT NULL DEFAULT '',
  `point` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '消费积分',
  `vip` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '会员等级',
  `addtime` int(11) NOT NULL,
  PRIMARY KEY (`uid`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户表' AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
