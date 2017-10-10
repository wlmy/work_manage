/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : work_management

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2017-10-10 21:43:01
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for wk_work_log
-- ----------------------------
DROP TABLE IF EXISTS `wk_work_log`;
CREATE TABLE `wk_work_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL DEFAULT '0',
  `log_type` varchar(10) DEFAULT '0' COMMENT '日志类型',
  `today_finished` text NOT NULL COMMENT '今日完成工作',
  `today_unfinished` text NOT NULL COMMENT '今日未完成工作',
  `week_finished` text NOT NULL COMMENT '本周完成工作',
  `week_summary` text NOT NULL COMMENT '本周工作总结',
  `next_week_plan` text NOT NULL COMMENT '下周计划',
  `month_finished` text NOT NULL COMMENT '本月工作内容',
  `month_summary` text NOT NULL COMMENT '本月工作总结',
  `next_month_plan` text NOT NULL COMMENT '下月计划',
  `year_target` text NOT NULL COMMENT '今年目标',
  `year_plan` text NOT NULL COMMENT '今年关键计划',
  `year_plan_finished_situation` text NOT NULL COMMENT '完成情况',
  `concerted` text COMMENT '需协调的工作',
  `editorContent` longtext,
  `status` int(1) NOT NULL DEFAULT '0' COMMENT '0: 正常  1:无效',
  `create_time` datetime NOT NULL COMMENT '创建日期',
  `update_time` datetime NOT NULL COMMENT '更新日期',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='工作日志表';

-- ----------------------------
-- Records of wk_work_log
-- ----------------------------
INSERT INTO `wk_work_log` VALUES ('1', '2', '0', '', '', '', '', '', '', '', '', '', '', '', null, '### Hello Editor.md !\r\n\r\n![](http://127.0.0.2/uploads/201710/59dcbfd8e397d_59dcbfd8.jpg)\r\n\r\nsdfsfsdf##### 成果和收获:\n  - Emoji;\n @@ -18,67 +128,361 @@\n      lib/\n      css/\n\n#####错误和不足之处:\n  - Emoji;\n @@ -18,67 +128,361 @@\nddd', '0', '2017-10-10 12:14:07', '2017-10-10 13:33:01');
INSERT INTO `wk_work_log` VALUES ('2', '1', '0', '', '', '', '', '', '', '', '', '', '', '', null, '### Hello Editor.md !\r\n\r\n![](http://127.0.0.2/uploads/201710/59dcbfd8e397d_59dcbfd8.jpg)\r\n\r\nsdfsfsdf', '0', '2017-10-10 12:14:07', '2017-10-10 12:43:47');
INSERT INTO `wk_work_log` VALUES ('3', '1', '0', '', '', '', '', '', '', '', '', '', '', '', null, '### Hello Editor.md !\r\n\r\n![](http://127.0.0.2/uploads/201710/59dcbfd8e397d_59dcbfd8.jpg)\r\n\r\nsdfsfsdf', '0', '2017-10-10 12:14:07', '2017-10-10 12:43:47');
INSERT INTO `wk_work_log` VALUES ('4', '1', '0', '', '', '', '', '', '', '', '', '', '', '', null, '### Hello Editor.md !\r\n\r\n![](http://127.0.0.2/uploads/201710/59dcbfd8e397d_59dcbfd8.jpg)\r\n\r\nsdfsfsdf', '0', '2017-10-10 12:14:07', '2017-10-10 12:43:47');
INSERT INTO `wk_work_log` VALUES ('5', '1', '0', '', '', '', '', '', '', '', '', '', '', '', null, '### Hello Editor.md !\r\n\r\n![](http://127.0.0.2/uploads/201710/59dcbfd8e397d_59dcbfd8.jpg)\r\n\r\nsdfsfsdf', '0', '2017-10-10 12:14:07', '2017-10-10 12:43:47');
INSERT INTO `wk_work_log` VALUES ('6', '1', '0', '', '', '', '', '', '', '', '', '', '', '', null, '### Hello Editor.md !\r\n\r\n![](http://127.0.0.2/uploads/201710/59dcbfd8e397d_59dcbfd8.jpg)\r\n\r\nsdfsfsdf', '0', '2017-10-10 12:14:07', '2017-10-10 12:43:47');
