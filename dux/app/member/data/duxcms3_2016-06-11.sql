# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# http://github.com/sequelpro/sequelpro
#
# Host: localhost (MySQL 5.5.42)
# Database: duxcms3
# Generation Time: 2016-06-11 06:19:49 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table dux_member_config
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_member_config`;

CREATE TABLE `dux_member_config` (
  `config_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `description` varchar(250) DEFAULT '',
  PRIMARY KEY (`config_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `dux_member_config` WRITE;
/*!40000 ALTER TABLE `dux_member_config` DISABLE KEYS */;

INSERT INTO `dux_member_config` (`config_id`, `name`, `content`, `description`)
VALUES
	(1,'reg_status','1','开放注册'),
	(2,'reg_ban_name','','禁止使用名称'),
	(3,'reg_ban_ip','','禁止注册IP'),
	(4,'reg_agreement','&lt;p&gt;　　在注册前，敬请您阅读以下内容，在进行注册程序过程中点击“同意”按钮即表示用户完全接受本协议项下的全部条款。&lt;/p&gt;&lt;p&gt;　　第一条 会员资格&lt;/p&gt;&lt;p&gt;　　在您承诺完全同意本服务条款并在完成注册程序后，即可成为本网站会员，享受我们为您提供的服务。如用户拒绝支付该项费用，则不能使用相关的网络服务。&lt;/p&gt;&lt;p&gt;　　第二条 会员权限&lt;/p&gt;&lt;p&gt;　　1.会员须交纳会员费才能享有本网站提供的服务，可参阅会员收费标准及服务内容表；&lt;/p&gt;&lt;p&gt;　　2.任何会员均有义务遵守本规定及其它网络服务的协议、规定、程序及惯例。&lt;/p&gt;&lt;p&gt;　　第三条 会员资料&lt;/p&gt;&lt;p&gt;　　1.为了使我们能够更好地为会员提供服务，请您提供详尽准确的个人资料，如更改请及时更新，提供虚假资料所造成的后果由会员承担；&lt;/p&gt;&lt;p&gt;　　2.会员有责任保管好自己的注册密码并定期修改避免造成损失，由于会员疏忽所造成的损失由会员承担。用户应当对以其用户帐号进行的所有活动和事件负法律责任。&lt;/p&gt;&lt;p&gt;　　第四条 会员资格的取消&lt;/p&gt;&lt;p&gt;　　如发现任何会员有以下故意行为之一，本网保留取消其使用服务的权利，并无需做出任何补偿；&lt;/p&gt;&lt;p&gt;　　1.可能造成本网站全部或局部的服务受影响，或危害本网站运行；&lt;/p&gt;&lt;p&gt;　　2.以任何欺诈行为获得会员资格；&lt;/p&gt;&lt;p&gt;　　3.在本网站内从事非法商业行为，发布涉及敏感政治、宗教、色情或其它违反有关国家法律和政府法规的文字、图片等信息；&lt;/p&gt;&lt;p&gt;　　4.以任何非法目的而使用网络服务系统。&lt;/p&gt;&lt;p&gt;　　第五条 服务商的权利&lt;/p&gt;&lt;p&gt;　　1.有权审核、接受或拒绝会员的入会申请，有权撤销或停止会员的全部或部分服务内容；&lt;/p&gt;&lt;p&gt;　　2.有权修订会员的权利和义务，有权修改或调整本网站的服务内容；&lt;/p&gt;&lt;p&gt;　　3.有权将修订的会员的权利和义务以e-mail形式通知会员，会员收到通知后仍继续使用本网站服务者即表示会员同意并遵守新修订内容。&lt;/p&gt;&lt;p&gt;　　4.本网提供的服务仅供会员独立使用，未经本网授权，会员不得将会员号授予或转移给第三方。会员如果有违此例，本网有权向客户追索商业损失并保留追究法律责任的权利。&lt;/p&gt;&lt;p&gt;　　第六条 服务商的义务&lt;/p&gt;&lt;p&gt;　　1.认真做好本网站所涉及的网络及通信系统的技术维护工作，保证本网站的畅通和高效；&lt;/p&gt;&lt;p&gt;　　2.除不可抗拒的因素导致本网站临时停止或短时间停止服务以外，乙方如需停止本网站的全部或部分服务时，须提前在本网站上发布通知通告会员。&lt;/p&gt;&lt;p&gt;　　3.如本网站因系统维护或升级等原因需暂停服务，将事先通过主页、电子邮件等方式公告会员；&lt;/p&gt;&lt;p&gt;　　4.因不可抗力而使本网站服务暂停，所导致会员任何实际或潜在的损失，本网不做任何补偿；&lt;/p&gt;&lt;p&gt;　　5.本网不承担会员因遗失密码而受到的一切损失。&lt;/p&gt;&lt;p&gt;　　6.本网仅提供相关的网络服务，除此之外与相关网络服务有关的设备（如电脑、调制解调器及其他与接入互联网有关的装置）及所需的费用（如为接入互联网而支付的电话费及上网费）均应由用户自行负担。&lt;/p&gt;&lt;p&gt;　　第七条 附则&lt;/p&gt;&lt;p&gt;　　1.以上规定的范围仅限于本系统；&lt;/p&gt;&lt;p&gt;　　2.本网会员因违反以上规定而触犯有关法律法规，一切后果自负，湖北省金属网站不承担任何责任；&lt;/p&gt;&lt;p&gt;　　3.本规则未涉及之问题参见有关法律法规，当本规定与有关法律法规冲突时，以相应的法律法规为准。在本条款规定范围内，本系统拥有最终解释权。&lt;/p&gt;','注册协议'),
	(5,'verify_status','0','验证码状态'),
	(6,'verify_type','yunpian','验证方式'),
	(7,'reg_check','1','注册审核'),
	(8,'verify_second','30','发送间隔'),
	(9,'verify_minute','2','限制分钟'),
	(10,'verify_minute_num','10','限制条数'),
	(11,'verify_expire','1800','时效秒'),
	(12,'verify_name','DuxCmf','签名'),
	(13,'reg_role','1','注册用户组'),
	(14,'reg_type','tel','帐号类型'),
	(15,'reg_info','&lt;p&gt;&lt;font color=&quot;#000000&quot;&gt;DuxCMF为您提供WEB、移动端、微信、API为一体的综合管理&lt;span style=&quot;color: rgb(0, 0, 0); font-size: 14px;&quot;&gt;框架&lt;/span&gt;&lt;/font&gt;&lt;/p&gt;','关于会员'),
	(16,'verify_tpl','【{name}】您的验证码是{code},有效期{expire}分钟,如非本人操作,请忽略本消息','验证码模板');

/*!40000 ALTER TABLE `dux_member_config` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table dux_member_connect
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_member_connect`;

CREATE TABLE `dux_member_connect` (
  `connect_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `open_id` varchar(50) DEFAULT '',
  `token` varchar(250) DEFAULT '',
  `type` varchar(10) NOT NULL DEFAULT '',
  PRIMARY KEY (`connect_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table dux_member_file
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_member_file`;

CREATE TABLE `dux_member_file` (
  `file_id` int(10) NOT NULL AUTO_INCREMENT,
  `url` varchar(250) DEFAULT NULL,
  `original` varchar(250) DEFAULT NULL,
  `title` varchar(250) DEFAULT NULL,
  `ext` varchar(20) DEFAULT NULL,
  `size` int(10) DEFAULT NULL,
  `time` int(10) DEFAULT NULL,
  `user_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`file_id`),
  KEY `ext` (`ext`),
  KEY `time` (`time`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='上传文件';



# Dump of table dux_member_info
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_member_info`;

CREATE TABLE `dux_member_info` (
  `info_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(50) NOT NULL DEFAULT '' COMMENT '键名',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '配置名称',
  `value` text NOT NULL COMMENT '配置值',
  `description` varchar(250) NOT NULL DEFAULT '' COMMENT '配置描述',
  `reserve` tinyint(1) NOT NULL DEFAULT '0' COMMENT '内置',
  PRIMARY KEY (`info_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `dux_member_info` WRITE;
/*!40000 ALTER TABLE `dux_member_info` DISABLE KEYS */;

INSERT INTO `dux_member_info` (`info_id`, `key`, `name`, `value`, `description`, `reserve`)
VALUES
	(1,'title','会员标题','会员中心','会员中心标题信息',1);

/*!40000 ALTER TABLE `dux_member_info` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table dux_member_role
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_member_role`;

CREATE TABLE `dux_member_role` (
  `role_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '角色名',
  `description` varchar(50) NOT NULL COMMENT '描述',
  `point` int(10) NOT NULL COMMENT '需要积分',
  `special` tinyint(1) NOT NULL DEFAULT '0' COMMENT '特殊组',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态',
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `dux_member_role` WRITE;
/*!40000 ALTER TABLE `dux_member_role` DISABLE KEYS */;

INSERT INTO `dux_member_role` (`role_id`, `name`, `description`, `point`, `special`, `status`)
VALUES
	(1,'普通用户','普通默认用户',0,0,1);

/*!40000 ALTER TABLE `dux_member_role` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table dux_member_user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_member_user`;

CREATE TABLE `dux_member_user` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(10) NOT NULL,
  `email` varchar(100) NOT NULL DEFAULT '',
  `tel` varchar(20) NOT NULL DEFAULT '',
  `password` varchar(250) NOT NULL DEFAULT '',
  `nickname` varchar(50) NOT NULL DEFAULT '',
  `avatar` varchar(250) DEFAULT '',
  `province` varchar(50) DEFAULT '',
  `city` varchar(50) DEFAULT '',
  `region` varchar(50) DEFAULT '',
  `reg_time` int(11) NOT NULL DEFAULT '0',
  `login_time` int(11) DEFAULT '0',
  `login_ip` varchar(200) DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table dux_member_verify
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_member_verify`;

CREATE TABLE `dux_member_verify` (
  `verify_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `receive` varchar(60) NOT NULL DEFAULT '' COMMENT '接收方',
  `code` varchar(20) NOT NULL DEFAULT '' COMMENT '验证码',
  `time` int(10) NOT NULL COMMENT '创建时间',
  `type` int(10) NOT NULL DEFAULT '0' COMMENT '信道',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态',
  `expire` int(10) DEFAULT '1800' COMMENT '有效期',
  PRIMARY KEY (`verify_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table dux_model_test
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_model_test`;

CREATE TABLE `dux_model_test` (
  `data_id` int(10) NOT NULL AUTO_INCREMENT,
  `test` varchar(250) DEFAULT '',
  `content_id` int(10) NOT NULL,
  PRIMARY KEY (`data_id`),
  KEY `content_id` (`content_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `dux_model_test` WRITE;
/*!40000 ALTER TABLE `dux_model_test` DISABLE KEYS */;

INSERT INTO `dux_model_test` (`data_id`, `test`, `content_id`)
VALUES
	(1,'dsaddsad',4);

/*!40000 ALTER TABLE `dux_model_test` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table dux_pay_account
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_pay_account`;

CREATE TABLE `dux_pay_account` (
  `account_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL COMMENT '用户ID',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '资金余额',
  `spend` decimal(10,2) DEFAULT '0.00' COMMENT '消费金额',
  `charge` decimal(10,2) DEFAULT '0.00' COMMENT '充值金额',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态',
  PRIMARY KEY (`account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table dux_pay_cash
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_pay_cash`;

CREATE TABLE `dux_pay_cash` (
  `cash_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `account_id` int(11) NOT NULL,
  `cash_no` varchar(50) NOT NULL DEFAULT '' COMMENT '流水号',
  `money` decimal(10,2) NOT NULL COMMENT '金额',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '提现状态',
  `start_time` int(10) NOT NULL DEFAULT '0' COMMENT '提现开始',
  `stop_time` int(10) NOT NULL DEFAULT '0' COMMENT '提现结束',
  `account` varchar(250) NOT NULL DEFAULT '' COMMENT '提现账户',
  `account_type` varchar(250) NOT NULL DEFAULT '' COMMENT '提现类型',
  `account_name` varchar(20) NOT NULL DEFAULT '' COMMENT '账户姓名',
  `remark` varchar(250) NOT NULL DEFAULT '' COMMENT '备注',
  PRIMARY KEY (`cash_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table dux_pay_config
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_pay_config`;

CREATE TABLE `dux_pay_config` (
  `config_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `type` varchar(250) NOT NULL DEFAULT '' COMMENT '类型名',
  `setting` text NOT NULL COMMENT '配置内容',
  PRIMARY KEY (`config_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

LOCK TABLES `dux_pay_config` WRITE;
/*!40000 ALTER TABLE `dux_pay_config` DISABLE KEYS */;

INSERT INTO `dux_pay_config` (`config_id`, `type`, `setting`)
VALUES
	(1,'alipay',''),
	(2,'alipay_mobile','');

/*!40000 ALTER TABLE `dux_pay_config` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table dux_pay_log
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_pay_log`;

CREATE TABLE `dux_pay_log` (
  `log_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `account_id` int(11) NOT NULL,
  `log_no` varchar(50) NOT NULL DEFAULT '' COMMENT '流水号',
  `time` int(10) NOT NULL COMMENT '交易时间',
  `money` decimal(10,2) DEFAULT '0.00' COMMENT '交易金额',
  `remark` varchar(250) NOT NULL DEFAULT '' COMMENT '交易备注',
  `pay_no` varchar(200) NOT NULL DEFAULT '' COMMENT '交易号',
  `pay_name` varchar(50) NOT NULL DEFAULT '' COMMENT '交易名',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0支出1收入',
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
