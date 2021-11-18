/*
Navicat MySQL Data Transfer

Source Server         : localhost2
Source Server Version : 50726
Source Host           : localhost:3306
Source Database       : simao888

Target Server Type    : MYSQL
Target Server Version : 50726
File Encoding         : 65001

Date: 2021-11-10 19:49:05
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `dede_admin_log`
-- ----------------------------
DROP TABLE IF EXISTS `dede_admin_log`;
CREATE TABLE `dede_admin_log` (
  `id` bigint(16) unsigned NOT NULL AUTO_INCREMENT COMMENT '表id',
  `module` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `addons` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `admin_id` int(10) DEFAULT NULL COMMENT '管理员id',
  `username` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `method` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '请求方式',
  `controller` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `action` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '日志描述',
  `url` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `post_data` mediumtext COLLATE utf8mb4_unicode_ci,
  `get_data` mediumtext COLLATE utf8mb4_unicode_ci,
  `agent` mediumtext COLLATE utf8mb4_unicode_ci,
  `ip` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'ip地址',
  `create_time` int(11) DEFAULT NULL COMMENT '日志时间',
  `update_time` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`) USING BTREE,
  KEY `admin_id` (`admin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of dede_admin_log
-- ----------------------------

-- ----------------------------
-- Table structure for `dede_auth_rule`
-- ----------------------------
DROP TABLE IF EXISTS `dede_auth_rule`;
CREATE TABLE `dede_auth_rule` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `module` char(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'backend',
  `target` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT '_self' COMMENT '默认窗口',
  `href` char(150) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '链接',
  `title` char(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '名字',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '类型 1菜单，0 非菜单',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态1 可以用，0 所有禁止使用',
  `auth_verify` tinyint(2) NOT NULL DEFAULT '1' COMMENT '1验证 0不验证',
  `menu_status` tinyint(1) DEFAULT '0' COMMENT '0 不显示，1 显示',
  `icon` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '图标样式',
  `pid` int(5) NOT NULL DEFAULT '0' COMMENT '父栏目ID',
  `sort` int(11) DEFAULT '999' COMMENT '排序',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `update_time` int(11) DEFAULT NULL,
  `delete_time` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `href` (`href`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='权限节点';

-- ----------------------------
-- Records of dede_auth_rule
-- ----------------------------
INSERT INTO `dede_auth_rule` VALUES ('1', 'backend', '_self', 'config', '系统管理', '0', '1', '1', '1', null, '0', '1', '0', null, '0');
INSERT INTO `dede_auth_rule` VALUES ('2', 'backend', '_self', 'config/index', '基本设置', '0', '1', '1', '1', 'layui-icon-rate', '1', '1', '0', null, '0');
INSERT INTO `dede_auth_rule` VALUES ('3', 'backend', '_self', 'authRule', '权限管理', '0', '1', '1', '1', 'layui-icon-rate', '0', '1', '0', null, '0');
INSERT INTO `dede_auth_rule` VALUES ('4', 'backend', '_self', 'admin/index', '用户管理', '0', '1', '1', '1', '', '3', '1', '0', null, '0');
INSERT INTO `dede_auth_rule` VALUES ('5', 'backend', '_self', 'admin/addEdit', '添加编辑', '0', '1', '1', '0', '', '4', '1', '0', null, '0');
INSERT INTO `dede_auth_rule` VALUES ('6', 'backend', '_self', 'admin/del', '删除', '0', '1', '1', '0', 'layui-icon-delete', '4', '1', '0', null, '0');
INSERT INTO `dede_auth_rule` VALUES ('7', 'backend', '_self', 'admintype/index', '角色管理', '0', '0', '1', '0', 'layui-icon-vercode', '3', '1', '0', null, '0');
INSERT INTO `dede_auth_rule` VALUES ('12', 'backend', '_self', 'admintype/addEdit', '添加编辑', '0', '1', '1', '1', 'layui-icon-rate-solid', '7', '1', '0', null, '0');
INSERT INTO `dede_auth_rule` VALUES ('13', 'backend', '_self', 'admin/delAll', '用户批量删除', '0', '1', '1', '1', 'layui-icon-delete', '4', '1', '0', null, '0');
INSERT INTO `dede_auth_rule` VALUES ('14', 'backend', '_self', 'admintype/del', '删除', '0', '1', '1', '1', '', '7', '1', '0', null, '0');
INSERT INTO `dede_auth_rule` VALUES ('15', 'backend', '_self', 'admintype/delAll', '角色批量删除', '0', '1', '1', '1', '', '7', '1', '0', null, '0');
INSERT INTO `dede_auth_rule` VALUES ('16', 'backend', '_self', 'authRule/index', '菜单权限', '0', '1', '1', '1', 'layui-icon-username', '3', '1', '0', null, '0');
INSERT INTO `dede_auth_rule` VALUES ('17', 'backend', '_self', 'authRule/addEdit', '添加编辑', '0', '1', '1', '1', '', '16', '1', '0', null, '0');
INSERT INTO `dede_auth_rule` VALUES ('18', 'backend', '_self', 'authRule/del', '菜单权限删除', '0', '1', '1', '1', '', '16', '1', '0', null, '0');
INSERT INTO `dede_auth_rule` VALUES ('19', 'backend', '_self', 'authRule/delAll', '菜单权限批量删除', '0', '1', '1', '1', '', '16', '1', '0', null, '0');
INSERT INTO `dede_auth_rule` VALUES ('20', 'backend', '_self', 'content', '内容管理', '0', '1', '1', '1', '', '0', '1', '0', null, '0');
INSERT INTO `dede_auth_rule` VALUES ('21', 'backend', '_self', 'actlist/index', '文档列表', '0', '1', '1', '1', '', '20', '1', '0', null, '0');
INSERT INTO `dede_auth_rule` VALUES ('22', 'backend', '_self', 'arclist/addEdit', '文档添加编辑', '0', '1', '1', '1', '', '21', '1', '0', null, '0');
INSERT INTO `dede_auth_rule` VALUES ('23', 'backend', '_self', 'arclist/delAll', '文档批量删除', '0', '1', '1', '1', '', '21', '1', '0', null, '0');
INSERT INTO `dede_auth_rule` VALUES ('24', 'backend', '_self', 'arclist/del', '文档删除', '0', '1', '1', '1', '', '21', '1', '0', null, '0');
INSERT INTO `dede_auth_rule` VALUES ('25', 'backend', '_self', 'arctype/index', '栏目管理', '0', '1', '1', '1', '', '20', '1', '0', null, '0');
INSERT INTO `dede_auth_rule` VALUES ('26', 'backend', '_self', 'arctype/addEdit', '栏目添加编辑', '0', '1', '1', '1', '', '25', '1', '0', null, '0');
INSERT INTO `dede_auth_rule` VALUES ('27', 'backend', '_self', 'Arctype/del', '栏目删除', '0', '1', '1', '1', '', '25', '1', '0', null, '0');
INSERT INTO `dede_auth_rule` VALUES ('28', 'backend', '_self', 'Arctype/delAll', '栏目批量删除', '0', '1', '1', '1', '', '25', '1', '0', null, '0');
INSERT INTO `dede_auth_rule` VALUES ('29', 'backend', '_self', 'Channeltype/index', '模型管理', '0', '1', '1', '1', '', '20', '1', '0', null, '0');
INSERT INTO `dede_auth_rule` VALUES ('30', 'backend', '_self', 'channeltype/addEdit', '模型编辑', '0', '1', '1', '1', '', '29', '1', '0', null, '0');
INSERT INTO `dede_auth_rule` VALUES ('31', 'backend', '_self', 'channeltype/del', '模型删除', '0', '1', '1', '1', '', '29', '1', '0', null, '0');
INSERT INTO `dede_auth_rule` VALUES ('32', 'backend', '_self', 'channeltype/delAll', '模型批量删除', '0', '1', '1', '1', '', '29', '1', '0', null, '0');
INSERT INTO `dede_auth_rule` VALUES ('33', 'backend', '_self', 'flink/index', '友情链接', '0', '1', '1', '1', '', '20', '1', '0', null, '0');
INSERT INTO `dede_auth_rule` VALUES ('34', 'backend', '_self', 'flink/addEdit', '友情链接添加编辑', '0', '1', '1', '1', '', '33', '1', '0', null, '0');
INSERT INTO `dede_auth_rule` VALUES ('35', 'backend', '_self', 'flink/del', '友情链接删除', '0', '1', '1', '1', '', '33', '1', '0', null, '0');
INSERT INTO `dede_auth_rule` VALUES ('36', 'backend', '_self', 'flink/delAll', '友情链接批量删除', '0', '1', '1', '1', '', '33', '1', '0', null, '0');
INSERT INTO `dede_auth_rule` VALUES ('37', 'backend', '_self', 'diyforms', '自定义表单', '0', '1', '1', '1', '', '0', '1', '0', null, '0');
INSERT INTO `dede_auth_rule` VALUES ('38', 'backend', '_self', 'myppt', '广告管理', '0', '1', '1', '1', '', '0', '1', '0', null, '0');
INSERT INTO `dede_auth_rule` VALUES ('39', 'backend', '_self', 'myppttype/index', '广告分类', '0', '1', '1', '1', '', '38', '1', '0', null, '0');
INSERT INTO `dede_auth_rule` VALUES ('40', 'backend', '_self', 'myppttype/addEdit', '添加编辑', '0', '1', '1', '1', '', '39', '1', '0', null, '0');
INSERT INTO `dede_auth_rule` VALUES ('41', 'backend', '_self', 'myppttype/del', '删除', '0', '1', '1', '1', '', '39', '1', '0', null, '0');
INSERT INTO `dede_auth_rule` VALUES ('42', 'backend', '_self', 'myppttype/delAll', '批量删除', '0', '1', '1', '1', '', '39', '1', '0', null, '0');
INSERT INTO `dede_auth_rule` VALUES ('43', 'backend', '_self', 'myppt/index', '广告列表', '0', '1', '1', '1', '', '38', '1', '0', null, '0');
INSERT INTO `dede_auth_rule` VALUES ('44', 'backend', '_self', 'myppt/addEdit', '添加编辑', '0', '1', '1', '1', '', '43', '1', '0', null, '0');
INSERT INTO `dede_auth_rule` VALUES ('45', 'backend', '_self', 'myppt/del', '删除', '0', '1', '1', '1', '', '43', '1', '0', null, '0');
INSERT INTO `dede_auth_rule` VALUES ('46', 'backend', '_self', 'myppt/delAll', '批量删除', '0', '1', '1', '1', '', '43', '1', '0', null, '0');
INSERT INTO `dede_auth_rule` VALUES ('47', 'backend', '_self', 'tool', '工具管理', '0', '1', '1', '1', '', '0', '1', '0', null, '0');
INSERT INTO `dede_auth_rule` VALUES ('48', 'backend', '_self', 'tool/index', '内容替换', '0', '1', '1', '1', '', '47', '1', '0', null, '0');
INSERT INTO `dede_auth_rule` VALUES ('49', 'backend', '_self', 'tool/replaceTag', '一键换标签', '0', '1', '1', '1', '', '48', '1', '0', null, '0');
INSERT INTO `dede_auth_rule` VALUES ('50', 'backend', '_self', 'tool/replaceContent', '模板替换内容', '0', '1', '1', '1', '', '48', '1', '0', null, '0');
INSERT INTO `dede_auth_rule` VALUES ('51', 'backend', '_self', 'tool/delAll', '批量删除', '0', '1', '1', '1', '', '48', '1', '0', null, '0');
INSERT INTO `dede_auth_rule` VALUES ('52', 'backend', '_self', 'tool/del', '删除', '0', '1', '1', '1', '', '48', '1', '0', null, '0');
INSERT INTO `dede_auth_rule` VALUES ('53', 'backend', '_self', 'setsql/index', '数据库操作', '0', '1', '1', '1', '', '47', '1', '0', null, '0');
INSERT INTO `dede_auth_rule` VALUES ('54', 'backend', '_self', 'setsql/importYysql', '导入数据库', '0', '1', '1', '1', '', '53', '1', '0', null, '0');
INSERT INTO `dede_auth_rule` VALUES ('55', 'backend', '_self', 'setsql/replacePrefix', '修改表前缀', '0', '1', '1', '1', '', '53', '1', '0', null, '0');
INSERT INTO `dede_auth_rule` VALUES ('56', 'backend', '_self', 'setsql/deleteTable', '删除数据库', '0', '1', '1', '1', '', '53', '1', '0', null, '0');
INSERT INTO `dede_auth_rule` VALUES ('57', 'backend', '_self', 'adminLog/index', '管理员日志', '0', '1', '1', '1', '', '1', '1', '0', null, '0');
INSERT INTO `dede_auth_rule` VALUES ('58', 'backend', '_self', 'adminLog/del', '删除', '0', '1', '1', '1', '', '57', '1', '0', null, '0');
INSERT INTO `dede_auth_rule` VALUES ('59', 'backend', '_self', 'adminLog/delAll', '批量删除', '0', '1', '1', '1', '', '57', '1', '0', null, '0');
