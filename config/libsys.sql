/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50711
 Source Host           : localhost
 Source Database       : libsys

 Target Server Type    : MySQL
 Target Server Version : 50711
 File Encoding         : utf-8

 Date: 05/06/2016 22:50:52 PM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `libsys_category`
-- ----------------------------
DROP TABLE IF EXISTS `libsys_category`;
CREATE TABLE `libsys_category` (
  `categoryid` tinyint(4) NOT NULL AUTO_INCREMENT COMMENT '分类 ID 主键自增',
  `categoryname` varchar(50) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '题目分类名',
  PRIMARY KEY (`categoryid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT COMMENT='题目分类数据表';

-- ----------------------------
--  Table structure for `libsys_exam`
-- ----------------------------
DROP TABLE IF EXISTS `libsys_exam`;
CREATE TABLE `libsys_exam` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `answer_str` text NOT NULL,
  `topicid_str` text NOT NULL,
  `scores_str` text NOT NULL,
  `score` tinyint(4) NOT NULL,
  `begin_time` int(11) NOT NULL,
  `end_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='考试数据表';

-- ----------------------------
--  Table structure for `libsys_position`
-- ----------------------------
DROP TABLE IF EXISTS `libsys_position`;
CREATE TABLE `libsys_position` (
  `positionid` int(11) NOT NULL AUTO_INCREMENT COMMENT '岗位 ID，主键',
  `positionname` varchar(15) NOT NULL DEFAULT '' COMMENT '岗位名',
  PRIMARY KEY (`positionid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='岗位表';

-- ----------------------------
--  Table structure for `libsys_question`
-- ----------------------------
DROP TABLE IF EXISTS `libsys_question`;
CREATE TABLE `libsys_question` (
  `id` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `option_a` varchar(255) NOT NULL,
  `option_b` varchar(255) NOT NULL,
  `option_c` varchar(255) NOT NULL,
  `option_d` varchar(255) NOT NULL,
  `category` tinyint(4) NOT NULL,
  `answer` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='题库';

-- ----------------------------
--  Table structure for `libsys_setting`
-- ----------------------------
DROP TABLE IF EXISTS `libsys_setting`;
CREATE TABLE `libsys_setting` (
  `key` varchar(255) NOT NULL DEFAULT '' COMMENT '键',
  `value` text NOT NULL COMMENT '值',
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='系统配置';

-- ----------------------------
--  Table structure for `libsys_topic`
-- ----------------------------
DROP TABLE IF EXISTS `libsys_topic`;
CREATE TABLE `libsys_topic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject` varchar(255) NOT NULL,
  `categoryid` tinyint(4) NOT NULL DEFAULT '0' COMMENT '题目分类',
  `option_a` varchar(255) NOT NULL,
  `option_b` varchar(255) NOT NULL,
  `option_c` varchar(255) NOT NULL,
  `option_d` varchar(255) NOT NULL,
  `answer` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=402 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='题库';

-- ----------------------------
--  Table structure for `libsys_user`
-- ----------------------------
DROP TABLE IF EXISTS `libsys_user`;
CREATE TABLE `libsys_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键 ID',
  `username` varchar(20) NOT NULL DEFAULT '' COMMENT '用户名',
  `password` varchar(50) NOT NULL DEFAULT '' COMMENT '密码 md5( md5(明文) + 盐 )',
  `salt` char(6) NOT NULL DEFAULT '' COMMENT '盐',
  `worknum` varchar(30) NOT NULL DEFAULT '' COMMENT '工号',
  `name` varchar(10) NOT NULL DEFAULT '' COMMENT '姓名',
  `email` varchar(50) NOT NULL DEFAULT '' COMMENT '邮箱',
  `positionid` int(11) NOT NULL DEFAULT '0' COMMENT '岗位 ID',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态：1 正常、2 禁用',
  `permission` tinyint(4) NOT NULL DEFAULT '3' COMMENT '权限等级：1 超管、2 普管、3 学生',
  `extra` text NOT NULL COMMENT '额外参数，序列化存储',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='用户表';

SET FOREIGN_KEY_CHECKS = 1;
