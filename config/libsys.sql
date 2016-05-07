/*
 Navicat Premium Data Transfer

 Source Server         : libsys
 Source Server Type    : MariaDB
 Source Server Version : 50544
 Source Host           : 115.159.22.98
 Source Database       : libsys

 Target Server Type    : MariaDB
 Target Server Version : 50544
 File Encoding         : utf-8

 Date: 05/06/2016 22:58:50 PM
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

INSERT INTO `libsys_category` VALUES (1, '参考咨询');

-- ----------------------------
--  Table structure for `libsys_exam`
-- ----------------------------
DROP TABLE IF EXISTS `libsys_exam`;
CREATE TABLE `libsys_exam` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键，自增 ID',
  `uid` int(11) NOT NULL COMMENT '考试用户 ID',
  `answer_str` text NOT NULL COMMENT '答题答案列表，格式：A,C,B....',
  `topicid_str` text NOT NULL COMMENT '考试题目 ID 列表，格式：1,2,3,4....',
  `scores_str` text NOT NULL COMMENT '考试每题分值列表，格式：5,5,5,5.....',
  `score` tinyint(4) NOT NULL COMMENT '最后考试成绩',
  `begin_time` int(11) NOT NULL COMMENT '开始考试时间，时间戳',
  `end_time` int(11) NOT NULL COMMENT '结束考试时间，时间戳',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='考试数据表';

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
--  Table structure for `libsys_setting`
-- ----------------------------
DROP TABLE IF EXISTS `libsys_setting`;
CREATE TABLE `libsys_setting` (
  `key` varchar(255) NOT NULL DEFAULT '' COMMENT '键',
  `value` text NOT NULL COMMENT '值',
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='系统配置';

INSERT INTO `libsys_setting` VALUES ('article', 'a:2:{s:5:"title";s:12:"考试须知";s:7:"content";s:141:"考试需要登录后才能进行，管理员可在后台进行题库信息的管理、考试规则的管理以及考试信息统计的查看";}');
INSERT INTO `libsys_setting` VALUES ('examrule', 'a:0:{}');
INSERT INTO `libsys_setting` VALUES ('index', 'a:1:{s:6:"notify";s:58:"欢迎使用该系统，超管账号密码：libsys 123456";}');

-- ----------------------------
--  Table structure for `libsys_topic`
-- ----------------------------
DROP TABLE IF EXISTS `libsys_topic`;
CREATE TABLE `libsys_topic` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键，自增 ID',
  `subject` varchar(255) NOT NULL COMMENT '题目',
  `categoryid` tinyint(4) NOT NULL DEFAULT '0' COMMENT '题目分类',
  `option_a` varchar(255) NOT NULL DEFAULT '' COMMENT '选项 A',
  `option_b` varchar(255) NOT NULL DEFAULT '' COMMENT '选项 B',
  `option_c` varchar(255) NOT NULL DEFAULT '' COMMENT '选项 C',
  `option_d` varchar(255) NOT NULL DEFAULT '' COMMENT '选项 D',
  `answer` varchar(255) NOT NULL COMMENT '正确答案',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=401 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='题库';

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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='用户表';

INSERT INTO `libsys_user`(`username`, `password`, `salt`, `name`, `status`, `permission`) VALUES ('libsys', '0d8e4152fe8f8c2558ca89a788bb399a', 'libsys', '系统超级管理员', 1, 1);

SET FOREIGN_KEY_CHECKS = 1;
