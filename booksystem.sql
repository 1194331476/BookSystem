/*
Navicat MySQL Data Transfer

Source Server         : mysql
Source Server Version : 50719
Source Host           : localhost:3306
Source Database       : booksystem

Target Server Type    : MYSQL
Target Server Version : 50719
File Encoding         : 65001

Date: 2018-01-03 16:48:06
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `book`
-- ----------------------------
DROP TABLE IF EXISTS `book`;
CREATE TABLE `book` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `bookName` varchar(50) NOT NULL COMMENT '书名',
  `author` varchar(50) NOT NULL COMMENT '作者',
  `num` int(10) NOT NULL COMMENT '数量',
  `price` double(10,2) NOT NULL COMMENT '单价',
  `barcode` varchar(50) NOT NULL COMMENT '条码',
  `bookType` int(10) NOT NULL,
  `cover` varchar(100) NOT NULL DEFAULT 'nocover.jpg' COMMENT '封面地址',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of book
-- ----------------------------
INSERT INTO `book` VALUES ('1', '达达自传', '达达', '10', '51.50', '000', '1', '2018-01-03/5a4c7e4104a12.jpg');
INSERT INTO `book` VALUES ('2', '金瓶梅', '奥巴马', '10', '56.30', '1', '1', '2018-01-03/5a4c7e1e90d3a.jpg');
INSERT INTO `book` VALUES ('4', '剪灯新话', '达达', '102', '11.65', '45', '1', '2018-01-03/5a4c7e5029196.jpg');
INSERT INTO `book` VALUES ('5', '红楼梦', '曹雪芹', '10', '50.36', '红楼梦', '1', '2018-01-03/5a4c7d33c3a9c.jpg');

-- ----------------------------
-- Table structure for `booktype`
-- ----------------------------
DROP TABLE IF EXISTS `booktype`;
CREATE TABLE `booktype` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `bookTypeName` varchar(20) NOT NULL COMMENT '类型名称',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of booktype
-- ----------------------------
INSERT INTO `booktype` VALUES ('1', '武侠');
INSERT INTO `booktype` VALUES ('2', '玄幻');
INSERT INTO `booktype` VALUES ('3', '悬疑');

-- ----------------------------
-- Table structure for `power`
-- ----------------------------
DROP TABLE IF EXISTS `power`;
CREATE TABLE `power` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `powerName` varchar(50) CHARACTER SET utf8 NOT NULL COMMENT '权限名称',
  `powerUrl` varchar(100) CHARACTER SET utf8 DEFAULT NULL COMMENT '权限地址',
  `parentId` int(10) NOT NULL DEFAULT '0' COMMENT '父节点',
  `icon` varchar(50) CHARACTER SET utf8 DEFAULT NULL COMMENT '图标',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of power
-- ----------------------------
INSERT INTO `power` VALUES ('1', '系统管理', '', '0', null);
INSERT INTO `power` VALUES ('2', '用户管理', '/Home/User/listPage', '1', null);
INSERT INTO `power` VALUES ('3', '角色管理', '/Home/Role/listPage', '1', null);
INSERT INTO `power` VALUES ('4', '权限管理', '/Home/Power/listPage', '1', null);
INSERT INTO `power` VALUES ('13', '图书管理', '', '0', '');
INSERT INTO `power` VALUES ('14', '图书管理', '/Home/Book/listPage', '13', '');

-- ----------------------------
-- Table structure for `role`
-- ----------------------------
DROP TABLE IF EXISTS `role`;
CREATE TABLE `role` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `roleName` varchar(50) CHARACTER SET utf8 NOT NULL COMMENT '角色名',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of role
-- ----------------------------
INSERT INTO `role` VALUES ('1', '系统管理员');
INSERT INTO `role` VALUES ('5', '账号管理员');
INSERT INTO `role` VALUES ('6', '前端管理员');

-- ----------------------------
-- Table structure for `roleandpower`
-- ----------------------------
DROP TABLE IF EXISTS `roleandpower`;
CREATE TABLE `roleandpower` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `roleId` int(10) NOT NULL COMMENT '角色主键',
  `powerId` int(10) NOT NULL COMMENT '权限主键',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of roleandpower
-- ----------------------------
INSERT INTO `roleandpower` VALUES ('36', '5', '1');
INSERT INTO `roleandpower` VALUES ('37', '5', '2');
INSERT INTO `roleandpower` VALUES ('42', '6', '8');
INSERT INTO `roleandpower` VALUES ('43', '6', '12');
INSERT INTO `roleandpower` VALUES ('44', '6', '9');
INSERT INTO `roleandpower` VALUES ('45', '1', '1');
INSERT INTO `roleandpower` VALUES ('46', '1', '2');
INSERT INTO `roleandpower` VALUES ('47', '1', '3');
INSERT INTO `roleandpower` VALUES ('48', '1', '4');
INSERT INTO `roleandpower` VALUES ('49', '1', '13');
INSERT INTO `roleandpower` VALUES ('50', '1', '14');

-- ----------------------------
-- Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `userName` varchar(50) CHARACTER SET utf8 NOT NULL COMMENT '用户名',
  `password` varchar(50) CHARACTER SET utf8 NOT NULL DEFAULT '000' COMMENT '密码',
  `trueName` varchar(50) CHARACTER SET utf8 NOT NULL COMMENT '真实姓名',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', 'admin', '000', 'admin');
INSERT INTO `user` VALUES ('10', 'front', '000', 'front');
INSERT INTO `user` VALUES ('11', 'hd', '123456', 'hd');

-- ----------------------------
-- Table structure for `userandrole`
-- ----------------------------
DROP TABLE IF EXISTS `userandrole`;
CREATE TABLE `userandrole` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userId` int(10) NOT NULL COMMENT '用户id',
  `roleId` int(10) NOT NULL COMMENT '角色id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of userandrole
-- ----------------------------
INSERT INTO `userandrole` VALUES ('1', '8', '1');
INSERT INTO `userandrole` VALUES ('2', '8', '5');
INSERT INTO `userandrole` VALUES ('3', '9', '1');
INSERT INTO `userandrole` VALUES ('5', '1', '1');
INSERT INTO `userandrole` VALUES ('6', '1', '5');
INSERT INTO `userandrole` VALUES ('8', '10', '6');
