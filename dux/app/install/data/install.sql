# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# http://github.com/sequelpro/sequelpro
#
# Host: localhost (MySQL 5.6.35)
# Database: duxshop
# Generation Time: 2017-11-15 17:20:52 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table dux_article
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_article`;

CREATE TABLE `dux_article` (
  `article_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `class_id` int(10) NOT NULL DEFAULT '0' COMMENT '栏目ID',
  `content_id` int(10) NOT NULL DEFAULT '0' COMMENT '内容ID',
  `content` text COMMENT '内容',
  PRIMARY KEY (`article_id`),
  KEY `class_id` (`class_id`),
  KEY `content_id` (`content_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table dux_article_class
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_article_class`;

CREATE TABLE `dux_article_class` (
  `class_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) NOT NULL DEFAULT '0' COMMENT '上级栏目',
  `category_id` int(10) NOT NULL DEFAULT '0',
  `tpl_class` varchar(250) DEFAULT '' COMMENT '栏目模板',
  `tpl_content` varchar(250) DEFAULT '' COMMENT '内容模板',
  PRIMARY KEY (`class_id`),
  KEY `category_id` (`category_id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table dux_mall
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_mall`;

CREATE TABLE `dux_mall` (
  `mall_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `seller_id` int(10) NOT NULL DEFAULT '0' COMMENT '卖家ID',
  `class_id` int(10) NOT NULL COMMENT '分类ID',
  `content_id` int(10) NOT NULL COMMENT '内容ID',
  `brand_id` int(10) NOT NULL DEFAULT '0' COMMENT '品牌ID',
  `attr_recommand` int(10) NOT NULL DEFAULT '0' COMMENT '属性-推荐',
  `attr_hot` int(10) NOT NULL DEFAULT '0' COMMENT '属性-热门',
  `attr_sendfree` int(10) NOT NULL DEFAULT '0' COMMENT '属性-包邮',
  `goods_no` varchar(50) NOT NULL DEFAULT '' COMMENT '商品编号',
  `sell_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '销售价',
  `market_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '市场价',
  `cost_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '成本价',
  `update_time` int(10) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `up_time` int(10) NOT NULL DEFAULT '0' COMMENT '上架时间',
  `down_time` int(10) NOT NULL DEFAULT '0' COMMENT '下架时间',
  `store` int(10) NOT NULL DEFAULT '0' COMMENT '库存',
  `weight` int(10) NOT NULL DEFAULT '0' COMMENT '重量',
  `images` text COMMENT '组图',
  `content` text COMMENT '详情',
  `unit` varchar(20) NOT NULL DEFAULT '' COMMENT '单位',
  `sale` int(10) NOT NULL DEFAULT '0' COMMENT '销量',
  `spec_data` text COMMENT '规格数据',
  `favorite` int(10) NOT NULL DEFAULT '0' COMMENT '收藏量',
  `comments` int(10) NOT NULL DEFAULT '0' COMMENT '评论',
  `score` int(10) NOT NULL DEFAULT '0' COMMENT '评分',
  `freight_type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '运费类型',
  `freight_tpl` int(10) NOT NULL DEFAULT '1' COMMENT '运费模板',
  `freight_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '固定运费',
  `service_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '退换货状态',
  `cod_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '到付支持',
  `point_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '购物送积分',
  `attr_limit` int(10) NOT NULL DEFAULT '0' COMMENT '限购数量',
  PRIMARY KEY (`mall_id`),
  KEY `seller_id` (`seller_id`),
  KEY `class_id` (`class_id`),
  KEY `content_id` (`content_id`),
  KEY `brand_id` (`brand_id`),
  KEY `attr_recommand` (`attr_recommand`),
  KEY `attr_hot` (`attr_hot`),
  KEY `attr_sendfree` (`attr_sendfree`),
  KEY `update_time` (`update_time`),
  KEY `sale` (`sale`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table dux_mall_class
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_mall_class`;

CREATE TABLE `dux_mall_class` (
  `class_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) NOT NULL DEFAULT '0' COMMENT '上级栏目',
  `category_id` int(10) NOT NULL DEFAULT '0',
  `tpl_class` varchar(250) DEFAULT '' COMMENT '栏目模板',
  `tpl_content` varchar(250) DEFAULT '' COMMENT '内容模板',
  `spec_group_id` int(10) NOT NULL DEFAULT '0' COMMENT '规格分组',
  PRIMARY KEY (`class_id`),
  KEY `category_id` (`category_id`),
  KEY `parent_id` (`parent_id`),
  KEY `spec_group_id` (`spec_group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table dux_mall_order
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_mall_order`;

CREATE TABLE `dux_mall_order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table dux_mall_products
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_mall_products`;

CREATE TABLE `dux_mall_products` (
  `products_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '货品ID',
  `mall_id` int(10) NOT NULL COMMENT '商品ID',
  `products_no` varchar(20) NOT NULL DEFAULT '' COMMENT '货号',
  `spec_data` text COMMENT '规格属性',
  `sell_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '销售价',
  `market_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '市场价',
  `cost_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '成本价',
  `weight` int(10) NOT NULL DEFAULT '0' COMMENT '重量',
  `store` int(10) NOT NULL DEFAULT '0' COMMENT '库存',
  `sale` int(10) NOT NULL DEFAULT '0' COMMENT '销量',
  PRIMARY KEY (`products_id`),
  KEY `mall_id` (`mall_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



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
	(4,'reg_agreement','尊敬的客户您好，欢迎您访本网站。在您注册成为网站会员之前，请您务必认真阅读和理解《网站用户注册协议》（以下简称：协议）中所有的条款。您须完全同意协议中所有的条款，才可以注册成为本网站的会员，使用里面的服务。您在网站的注册和操作均将被视为是您对协议所有条款及内容的自愿接受。&lt;br&gt;　　第一条 声明&lt;br&gt;　　（一）网站内在线产品的所有权归本站所有。&lt;br&gt;　　（二）您在网站进行注册时，一旦点击“我接受”按钮，即表示为您已自愿接受协议中所有的条款和内容。&lt;br&gt;　　（三）协议条款的效力范围仅限于本网站，您在网站的行为均受协议的约束。&lt;br&gt;　　（四）您使用网站服务的行为，即被视为您已知悉本网站的相关公告并同意。&lt;br&gt;　　（五）本网站有权在未提前通知您的情况下修改协议的条款，您每次进入网站在使用服务前，都应先查阅一遍协议。&lt;br&gt;　　（六）本网站有权在未提前通知您的情况下修改、暂停网站部分或全部的服务，且不承担由此产生来自您和第三方的任何责任。&lt;br&gt;　　（七）本网站提供免费注册服务，您的注册均是自愿行为，注册成功后，您可以得到网站更加完善的服务。&lt;br&gt;　　（八）您注册成为会员后账户和密码如有灭失，不会影响到您已办理成功业务的效力，本网站可恢复您的注册账户及相关信息但不承担除此以外的其它任何责任。&lt;br&gt;　　第二条 用户管理&lt;br&gt;　　（一）您在本网站的所有行为都须符合中国的法律法规，您不得利用本网站提供的服务制作、复制、发布、传播以下信息：&lt;br&gt;　　1、反对宪法基本原则的；&lt;br&gt;　　2、危害国家安全、泄露国家秘密、颠覆国家政权、破坏国家统一的；&lt;br&gt;　　3、损害国家荣誉和利益的；&lt;br&gt;　　4、煽动民族仇恨、民族歧视、破坏民族团结的；&lt;br&gt;　　5、破坏国家宗教政策，宣扬邪教和封建迷信的；&lt;br&gt;　　6、散布谣言、扰乱社会秩序、破坏社会稳定的；&lt;br&gt;　　7、散布淫秽、色情、赌博、暴力、凶杀、恐怖内容或者教唆犯罪的；&lt;br&gt;　　8、侮辱或者诽谤他人，侵害他人合法权益的；&lt;br&gt;　　9、以及法律、法规禁止的其他内容；&lt;br&gt;　　（二）您在本网站的行为，还必须符合其它国家和地区的法律规定以及国际法的有关规定。&lt;br&gt;　　（三）不得利用本网站从事以下活动：&lt;br&gt;　　1、未经允许，进入他人计算机信息网络或者使用他人计算机信息网络的资源；&lt;br&gt;　　2、未经允许，对他人计算机信息网络的功能进行删除、修改或增加；&lt;br&gt;　　3、未经允许，对他人计算机信息网络中存储、处理或者传输的数据和应用程序进行删除、修改或者增加；&lt;br&gt;　　4、制作、故意传播计算机病毒等破坏性程序的；&lt;br&gt;　　5、其他危害计算机信息网络安全的行为；&lt;br&gt;　　（四）遵守本网站其他规定和程序：&lt;br&gt;　　1、您对自己在本网站中的行为和操作承担全部责任；&lt;br&gt;　　2、您承担责任的形式包括但不仅限于，对受到侵害者进行赔偿、在本网站首先承担了因您的行为导致的行政处罚或侵权损害赔偿责任后，您应给予本网站的等额赔偿；&lt;br&gt;　　3、如果本网站发现您传输的信息含有本协议第二条所列内容之一的，本网站有权在不通知您的情况下采取包括但不仅限于向国家有关机关报告、保存有关记录、删除该内容及链接地址、关闭服务器、暂停您账号的操作权限、停止向您提供服务等措施；&lt;br&gt;　　第三条 注册会员权利和义务&lt;br&gt;　　（一）注册会员有权用本网站提供的服务功能。&lt;br&gt;　　（二）注册会员同意遵守包括但不仅限于《中华人民共和国保守国家秘密法》、《中华人民共和国计算机信息系统安全保护条例》、《计算机软件保护条例》、《互联网电子公告服务管理规定》、《互联网信息服务管理办法》等在内的法律、法规。&lt;br&gt;　　（三）您注册时有义务提供完整、真实、的个人信息，信息如有变更，应及时更新。&lt;br&gt;　　（四）您成为注册会员须妥善保管用户名和密码，用户登录后进行的一切活动均视为是您本人的行为和意愿，您负全部责任。&lt;br&gt;　　（五）您在使用本网站服务时，同意且接受本网站提供的各类信息服务。&lt;br&gt;　　（六）您使用本网站时，禁止有以下行为：&lt;br&gt;　　1、上载、张贴、发送电子邮件或以其他方式传送含有违反国家法律、法规的信息或资料，这些资料包括但不仅限于资讯、资料、文字、软件、音乐、照片、图形、等（下同）；&lt;br&gt;　　2、散布淫秽、色情、赌博、暴力、凶杀、恐怖或者教唆犯罪的资料；&lt;br&gt;　　3、冒充任何个人或机构，或以虚伪不实的方式误导他人以为其与任何人或任何机构有关；&lt;br&gt;　　4、通过本网站干扰、破坏或限制他人计算机软件、硬件或通讯设备功能的行为；&lt;br&gt;　　5、通过本网站跟踪或以其他方式骚扰他人；&lt;br&gt;　　第四条 用户隐私&lt;br&gt;　　我们承诺，对您个人的信息和隐私的安全承担保密义务。未经您授权或同意，本网站不会将您的个人资料信息泄露给第三方，但以下情况除外，且本网站不承担任何责任：&lt;br&gt;　　（一）政府单位按照中华人民共和国的法律、行政法规、部门规章、司法解释等规范性法律文件（统称“法律法规”），要求本网站提供的；&lt;br&gt;　　（二）由于您将用户和密码告知或泄露给他人，由此导致的个人资料泄露；&lt;br&gt;　　（三）包括但不仅限于黑客攻击、计算机病毒侵入或发作、政府管制等不可抗力而造成的用户个人资料泄露、丢失、被盗用或被篡改等；&lt;br&gt;　　（四）您通过本网站链接其他网站造成的个人资料泄露以及由此导致的任何法律争议和后果；&lt;br&gt;　　（五）为免除他人正在遭受威胁到其生命、身体或财产等方面的危险，所采取的措施；&lt;br&gt;　　（六）本网站会与其他网站链接，但不对其他网站的隐私政策及内容负责；&lt;br&gt;　　（七）此外，您若发现有任何非法使用您的用户账号或安全漏洞的情况，应立即通告本网站；&lt;br&gt;　　（八）由于您自身的疏忽、大意等过错所导致的；&lt;br&gt;　　（九）您在本网站的有关记录有可能成为您违反法律法规和本协议的证据；&lt;br&gt;　　第五条 知识产权&lt;br&gt;　　本网站所有的域名、商号、商标、文字、视像及声音内容、图形及图像均受有关所有权和知识产权法律的保护，未经本网站事先以书面明确允许，任何个人或单位，均不得进行复制和使用。&lt;br&gt;　　第六条 法律适用&lt;br&gt;　　（一）协议由本网站的所有人负责修订，并通过本网站公布，您的注册行为即被视为您自愿接受协议的全部条款，受其约束。&lt;br&gt;　　（二）协议的生效、履行、解释及争议的解决均适用中华人民共和国法律。&lt;br&gt;　　（三）您使用网站提供的服务如产生争议，原则上双方协商解决，协商不成可向本网站所有人所在的仲裁机构、人民法院进行调解或提起诉讼。&lt;br&gt;　　（四）协议的条款如与法律相抵触，本网站可进行重新解析，而其他条款则保持对您产生法律效力和约束。','注册协议'),
	(5,'verify_status','0','验证码状态'),
	(7,'reg_check','1','注册审核'),
	(8,'verify_second','30','发送间隔'),
	(9,'verify_minute','2','限制分钟'),
	(10,'verify_minute_num','10','限制条数'),
	(11,'verify_expire','1800','时效秒'),
	(13,'reg_role','1','注册用户组'),
	(14,'reg_type','all','帐号类型'),
	(15,'reg_info','&lt;p&gt;&lt;font color=&quot;#000000&quot;&gt;关于我们&lt;/font&gt;&lt;/p&gt;','关于会员'),
	(16,'verify_sms_tpl','您的验证码是[验证码],有效期[有效期]分钟,如非本人操作,请忽略本消息','短信验证码模板'),
	(20,'verify_mail_tpl','&lt;div style=&quot;width:680px;padding:0 10px;margin:0 auto;&quot;&gt;\n&lt;div style=&quot;line-height:1.5;font-size:14px;margin-bottom:25px;color:#4d4d4d;&quot;&gt;&lt;strong style=&quot;display:block;margin-bottom:15px;&quot;&gt;亲爱的会员您好！ &lt;/strong&gt; &lt;strong style=&quot;display:block;margin-bottom:15px;&quot;&gt; 请在验证码输入框中输入： &lt;span style=&quot;color:#f60;font-size: 24px&quot;&gt;&lt;span style=&quot;border-bottom:1px dashed #ccc;z-index:1&quot;&gt;[验证码]&lt;/span&gt;&lt;/span&gt;，以完成操作，验证码有效期[有效期]分钟。 &lt;/strong&gt;&lt;/div&gt;\n\n&lt;div style=&quot;margin-bottom:30px;&quot;&gt;\n&lt;p style=&quot;color:#747474;&quot;&gt;&lt;small style=&quot;display:block;margin-bottom:20px;font-size:12px;&quot;&gt;注意：此操作可能会修改您的密码、登录邮箱或绑定手机。如非本人操作，请及时登录并修改密码以保证帐户安全&lt;br /&gt;\n（工作人员不会向你索取此验证码，请勿泄漏！) &lt;/small&gt;&lt;/p&gt;\n&lt;/div&gt;\n&lt;/div&gt;\n','邮件验证码模板'),
	(21,'clear_withdraw','50','提现额度'),
	(22,'clear_tax','5','提现手续费'),
	(23,'clear_num','10','当月提现次数'),
	(24,'notice_recharge_status','1',''),
	(25,'notice_recharge_class','a:2:{i:0;s:4:\"mail\";i:1;s:6:\"wechat\";}',''),
	(26,'notice_recharge_title','充值成功',''),
	(27,'notice_recharge_sms_tpl','恭喜您充值[充值金额]元成功',''),
	(28,'notice_recharge_mail_tpl','',''),
	(29,'notice_recharge_wechat_tpl','',''),
	(30,'verify_image','0','图形验证码状态');

/*!40000 ALTER TABLE `dux_member_config` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table dux_member_connect
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_member_connect`;

CREATE TABLE `dux_member_connect` (
  `connect_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL COMMENT '用户ID',
  `open_id` varchar(100) NOT NULL DEFAULT '' COMMENT '平台ID',
  `token` varchar(250) NOT NULL DEFAULT '' COMMENT '密钥',
  `type` varchar(10) NOT NULL DEFAULT '' COMMENT '类型',
  `data` text NOT NULL COMMENT '数据',
  PRIMARY KEY (`connect_id`),
  KEY `user_id` (`user_id`),
  KEY `open_id` (`open_id`),
  KEY `token` (`token`),
  KEY `type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table dux_member_feedback
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_member_feedback`;

CREATE TABLE `dux_member_feedback` (
  `feedback_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `time` int(10) NOT NULL DEFAULT '0',
  `user_id` int(10) NOT NULL DEFAULT '0',
  `content` text NOT NULL,
  PRIMARY KEY (`feedback_id`)
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
	(1,'title','会员标题','会员中心','会员中心标题信息',1),
	(2,'logo','会员标志','public/member/images/header-logo.png','logo图片相对地址',1),
	(3,'login','登录图片','public/member/images/login-banner.png','登录图片相对地址',1);

/*!40000 ALTER TABLE `dux_member_info` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table dux_member_notice
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_member_notice`;

CREATE TABLE `dux_member_notice` (
  `notice_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL DEFAULT '0',
  `time` int(10) NOT NULL DEFAULT '0',
  `icon` varchar(50) NOT NULL COMMENT '图标',
  `content` text NOT NULL COMMENT '内容',
  `url` varchar(250) NOT NULL DEFAULT '' COMMENT '链接',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '查看状态',
  PRIMARY KEY (`notice_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table dux_member_real
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_member_real`;

CREATE TABLE `dux_member_real` (
  `real_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL DEFAULT '0',
  `tel` varchar(20) NOT NULL,
  `name` varchar(250) NOT NULL DEFAULT '' COMMENT '姓名',
  `idcard` varchar(50) NOT NULL DEFAULT '' COMMENT '身份证号码',
  `image` varchar(250) NOT NULL DEFAULT '' COMMENT '身份证照片',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态',
  `create_time` int(10) NOT NULL COMMENT '提交时间',
  `remark` text NOT NULL COMMENT '审核备注',
  `auth_admin` int(10) NOT NULL DEFAULT '0',
  `auth_time` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`real_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table dux_pay_recharge
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_pay_recharge`;

CREATE TABLE `dux_pay_recharge` (
  `recharge_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `recharge_no` varchar(50) NOT NULL DEFAULT '' COMMENT '充值单号',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '提交时间',
  `complete_time` int(10) NOT NULL DEFAULT '0' COMMENT '完成时间',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '充值金额',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '充值状态',
  `pay_no` varchar(50) NOT NULL DEFAULT '' COMMENT '交易名',
  `pay_name` varchar(20) NOT NULL DEFAULT '' COMMENT '交易编号',
  `remark` varchar(250) NOT NULL DEFAULT '' COMMENT '备注',
  PRIMARY KEY (`recharge_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table dux_member_role
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_member_role`;

CREATE TABLE `dux_member_role` (
  `role_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '角色名',
  `description` varchar(50) NOT NULL COMMENT '描述',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态',
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `dux_member_role` WRITE;
/*!40000 ALTER TABLE `dux_member_role` DISABLE KEYS */;

INSERT INTO `dux_member_role` (`role_id`, `name`, `description`, `status`)
VALUES
	(1,'普通用户','普通默认用户',1);

/*!40000 ALTER TABLE `dux_member_role` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table dux_member_user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_member_user`;

CREATE TABLE `dux_member_user` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(10) NOT NULL DEFAULT '0',
  `nickname` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL DEFAULT '',
  `tel` varchar(20) NOT NULL DEFAULT '',
  `password` varchar(250) NOT NULL DEFAULT '',
  `avatar` varchar(250) DEFAULT '',
  `province` varchar(50) DEFAULT '',
  `city` varchar(50) DEFAULT '',
  `region` varchar(50) DEFAULT '',
  `reg_time` int(10) NOT NULL DEFAULT '0',
  `login_time` int(10) NOT NULL DEFAULT '0',
  `login_ip` varchar(200) DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `sex` tinyint(1) NOT NULL DEFAULT '1',
  `birthday` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`),
  KEY `role_id` (`role_id`)
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
  PRIMARY KEY (`verify_id`),
  KEY `receive` (`receive`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table dux_order
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_order`;

CREATE TABLE `dux_order` (
  `order_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单ID',
  `order_app` varchar(50) NOT NULL DEFAULT '' COMMENT '商品应用',
  `order_seller_id` int(11) NOT NULL DEFAULT '0' COMMENT '卖家ID',
  `order_seller_name` varchar(50) NOT NULL COMMENT '卖家名称',
  `order_seller_url` varchar(250) NOT NULL DEFAULT '' COMMENT '卖家URL',
  `order_user_id` int(10) NOT NULL DEFAULT '0' COMMENT '订单用户',
  `order_no` varchar(20) NOT NULL DEFAULT '' COMMENT '订单号',
  `order_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '订单金额',
  `order_currency` text NOT NULL COMMENT '货币信息',
  `order_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '订单状态',
  `order_sum` int(10) NOT NULL DEFAULT '0' COMMENT '商品总数',
  `order_title` varchar(250) NOT NULL DEFAULT '' COMMENT '订单描述',
  `order_image` varchar(250) NOT NULL COMMENT '订单图片',
  `order_create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `order_complete_time` int(10) NOT NULL DEFAULT '0' COMMENT '完成时间',
  `order_close_time` int(10) NOT NULL DEFAULT '0' COMMENT '取消时间',
  `order_complete_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '完成状态',
  `order_ip` varchar(250) NOT NULL DEFAULT '' COMMENT '下单IP',
  `order_remark` varchar(250) NOT NULL DEFAULT '' COMMENT '订单备注',
  `order_coupon` varchar(100) NOT NULL DEFAULT '' COMMENT '优惠券',
  `receive_name` varchar(50) NOT NULL DEFAULT '' COMMENT '收件人',
  `receive_tel` varchar(20) NOT NULL DEFAULT '' COMMENT '收件电话',
  `receive_province` varchar(100) NOT NULL DEFAULT '' COMMENT '收件地区',
  `receive_city` varchar(100) NOT NULL DEFAULT '',
  `receive_region` varchar(100) NOT NULL DEFAULT '',
  `receive_address` varchar(250) NOT NULL DEFAULT '' COMMENT '收件地址',
  `receive_zip` varchar(50) NOT NULL DEFAULT '' COMMENT '收件邮编',
  `pay_type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '付款方式(1在线 0货到)',
  `pay_data` text NOT NULL COMMENT '付款信息',
  `pay_time` int(10) NOT NULL COMMENT '付款时间',
  `pay_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '付款状态',
  `parcel_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '配货状态',
  `comment_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '评论状态',
  `take_id` int(10) NOT NULL DEFAULT '0' COMMENT '配送点',
  `delivery_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '发货状态(1发货 0未发货)',
  `delivery_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '运费',
  PRIMARY KEY (`order_id`),
  KEY `order_app` (`order_app`),
  KEY `order_seller_id` (`order_seller_id`),
  KEY `order_user_id` (`order_user_id`),
  KEY `order_complete_status` (`order_complete_status`),
  KEY `pay_type` (`pay_type`),
  KEY `pay_status` (`pay_status`),
  KEY `parcel_status` (`parcel_status`),
  KEY `comment_status` (`comment_status`),
  KEY `delivery_status` (`delivery_status`),
  KEY `take_id` (`take_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table dux_order_address
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_order_address`;

CREATE TABLE `dux_order_address` (
  `add_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL COMMENT '用户ID',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '姓名',
  `tel` varchar(20) NOT NULL DEFAULT '' COMMENT '电话',
  `province` varchar(100) NOT NULL DEFAULT '' COMMENT '省份',
  `city` varchar(100) NOT NULL DEFAULT '' COMMENT '城市',
  `region` varchar(100) NOT NULL DEFAULT '' COMMENT '地区',
  `address` varchar(250) NOT NULL DEFAULT '' COMMENT '详细地址',
  `zip` int(50) NOT NULL COMMENT '邮编',
  `default` tinyint(1) NOT NULL DEFAULT '0' COMMENT '默认',
  PRIMARY KEY (`add_id`),
  KEY `user_id` (`user_id`),
  KEY `default` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table dux_order_cart
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_order_cart`;

CREATE TABLE `dux_order_cart` (
  `cart_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL COMMENT '用户ID',
  `data` text NOT NULL COMMENT '数据',
  PRIMARY KEY (`cart_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table dux_order_comment
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_order_comment`;

CREATE TABLE `dux_order_comment` (
  `comment_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_goods_id` int(10) NOT NULL DEFAULT '0' COMMENT '订单商品ID',
  `user_id` int(10) NOT NULL COMMENT '用户ID',
  `app` varchar(20) NOT NULL DEFAULT '0' COMMENT '应用名',
  `has_id` int(10) NOT NULL DEFAULT '0' COMMENT '关联ID',
  `spec` text NOT NULL COMMENT '商品属性',
  `time` int(10) NOT NULL COMMENT '评价时间',
  `content` text NOT NULL COMMENT '评价内容',
  `level` tinyint(1) NOT NULL DEFAULT '3' COMMENT '评价分数',
  `images` text COMMENT '评论图片',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '审核状态',
  PRIMARY KEY (`comment_id`),
  KEY `order_goods_id` (`order_goods_id`),
  KEY `user_id` (`user_id`),
  KEY `app` (`app`),
  KEY `has_id` (`has_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table dux_order_config
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_order_config`;

CREATE TABLE `dux_order_config` (
  `config_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `description` varchar(250) NOT NULL DEFAULT '',
  PRIMARY KEY (`config_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `dux_order_config` WRITE;
/*!40000 ALTER TABLE `dux_order_config` DISABLE KEYS */;

INSERT INTO `dux_order_config` (`config_id`, `name`, `content`, `description`)
VALUES
	(1,'waybill_type','kdniao','快递查询接口'),
	(14,'notice_status','1',''),
	(15,'notice_pay_class','a:3:{i:0;s:3:\"sms\";i:1;s:3:\"app\";i:2;s:6:\"wechat\";}',''),
	(16,'notice_pay_title','您有新的订单已付款',''),
	(18,'notice_pay_status','1',''),
	(19,'notice_pay_sms_tpl','您有新的订单已付款，请耐心等待发货',''),
	(20,'notice_pay_mail_tpl','&lt;p&gt;&lt;strong style=&quot;display:block;margin-bottom:15px;&quot;&gt;&lt;font size=&quot;3&quot;&gt;亲爱的会员您好！ &lt;/font&gt;&lt;/strong&gt; &lt;strong style=&quot;display:block;margin-bottom:15px;&quot;&gt;&lt;font size=&quot;3&quot;&gt; 您订购的商品【[订单标题]】已经付款，请您耐心等待发货。&lt;/font&gt;&lt;/strong&gt;&lt;/p&gt;\n\n&lt;p&gt;订单号：[订单编号]&lt;/p&gt;\n\n&lt;p&gt;支付号：[支付号]&lt;/p&gt;\n\n&lt;p&gt;支付金额：[支付金额]&lt;/p&gt;\n\n&lt;p&gt;支付时间：[支付时间]&lt;/p&gt;\n\n&lt;div style=&quot;margin-bottom:30px;&quot;&gt;\n&lt;p style=&quot;color:#747474;&quot;&gt;&lt;small style=&quot;display:block;margin-bottom:20px;font-size:12px;&quot;&gt;如有问题请及时跟我们工作人员联系，谨防诈骗电话。&lt;/small&gt;&lt;/p&gt;\n&lt;/div&gt;\n\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n',''),
	(21,'notice_pay_wechat_tpl','订单号：[订单编号]\n商品名称：[订单标题] \n订单金额：[订单金额]\n支付时间：[支付时间]',''),
	(22,'notice_delivery_status','1',''),
	(23,'notice_delivery_class','a:3:{i:0;s:3:\"sms\";i:1;s:3:\"app\";i:2;s:6:\"wechat\";}',''),
	(24,'notice_delivery_title','您订购的商品已发货，请注意收货',''),
	(25,'notice_delivery_sms_tpl','您订购的商品【[订单标题]】已发货，请注意收货',''),
	(26,'notice_delivery_mail_tpl','&lt;p&gt;&lt;strong style=&quot;display:block;margin-bottom:15px;&quot;&gt;&lt;font size=&quot;3&quot;&gt;亲爱的会员您好！ &lt;/font&gt;&lt;/strong&gt; &lt;strong style=&quot;display:block;margin-bottom:15px;&quot;&gt;&lt;font size=&quot;3&quot;&gt; 您订购的商品【[订单标题]】已发货，请注意收货。&lt;/font&gt;&lt;/strong&gt;&lt;/p&gt;\n\n&lt;p&gt;订单号：[订单编号]&lt;/p&gt;\n\n&lt;p&gt;快递名称：[快递名称]&lt;/p&gt;\n\n&lt;p&gt;快递单号：[快递单号]&lt;/p&gt;\n\n&lt;div style=&quot;margin-bottom:30px;&quot;&gt;\n&lt;p style=&quot;color:#747474;&quot;&gt;&lt;small style=&quot;display:block;margin-bottom:20px;font-size:12px;&quot;&gt;如有问题请及时跟我们工作人员联系，谨防诈骗电话。&lt;/small&gt;&lt;/p&gt;\n&lt;/div&gt;\n\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n',''),
	(27,'notice_delivery_wechat_tpl','订单号：[订单编号]\n订单名称：[订单标题] \n快递名称：[快递名称]\n快递单号：[快递单号]',''),
	(28,'notice_complete_status','1',''),
	(29,'notice_complete_class','a:3:{i:0;s:3:\"sms\";i:1;s:3:\"app\";i:2;s:6:\"wechat\";}',''),
	(30,'notice_complete_title','您购买得商品已确认完成，感谢您的光临',''),
	(31,'notice_complete_sms_tpl','请在订购的商品【[订单标题]】已经确认收货，感谢您的再次光临。',''),
	(32,'notice_complete_mail_tpl','&lt;p&gt;&lt;strong style=&quot;display:block;margin-bottom:15px;&quot;&gt;&lt;font size=&quot;3&quot;&gt;亲爱的会员您好！ &lt;/font&gt;&lt;/strong&gt; &lt;strong style=&quot;display:block;margin-bottom:15px;&quot;&gt;&lt;font size=&quot;3&quot;&gt; 您在订购的商品【[订单标题]】已经确认收货，感谢您的再次光临。&lt;/font&gt;&lt;/strong&gt;&lt;/p&gt;\n\n&lt;p&gt;订单号：[订单编号]&lt;/p&gt;\n\n&lt;p&gt;下单时间：[下单时间]&lt;/p&gt;\n\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n\n&lt;p&gt;确认时间：[确认时间]&lt;/p&gt;\n\n&lt;div style=&quot;margin-bottom:30px;&quot;&gt;\n&lt;p style=&quot;color:#747474;&quot;&gt;&lt;small style=&quot;display:block;margin-bottom:20px;font-size:12px;&quot;&gt;如有问题请及时跟我们工作人员联系，谨防诈骗电话。&lt;/small&gt;&lt;/p&gt;\n&lt;/div&gt;\n\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n',''),
	(33,'notice_complete_wechat_tpl','订单号：[订单编号]\n订单名称：[订单标题]\n下单时间：[下单时间]\n确认时间：[确认时间]',''),
	(34,'cod_status','0',''),
	(35,'amount_status','1',''),
	(36,'contact_name','DuxSHOP',''),
	(37,'contact_tel','18000000000',''),
	(38,'contact_province','北京市',''),
	(39,'contact_city','北京市市辖区',''),
	(41,'contact_address','无',''),
	(42,'contact_zip','10010',''),
	(44,'contact_region','东城区',''),
	(45,'notice_pay_app_tpl','您的订单已经支付，请注意查收',''),
	(46,'notice_delivery_app_tpl','您的订单已经发货，请注意查收',''),
	(47,'notice_complete_app_tpl','订单已完成','');

/*!40000 ALTER TABLE `dux_order_config` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table dux_order_config_delivery
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_order_config_delivery`;

CREATE TABLE `dux_order_config_delivery` (
  `delivery_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `seller_id` int(10) NOT NULL COMMENT '卖家ID',
  `name` varchar(50) NOT NULL COMMENT '模板名称',
  `first_weight` int(10) NOT NULL DEFAULT '1000' COMMENT '首重重量',
  `first_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '首重价格',
  `second_weight` int(10) NOT NULL DEFAULT '1000' COMMENT '续重重量',
  `second_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '续重价格',
  `support_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '报价支持',
  `support_rate` int(11) NOT NULL DEFAULT '0' COMMENT '保价费率',
  `support_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '最低保价',
  `area` text NOT NULL COMMENT '配送地区',
  `tpl` text NOT NULL COMMENT '快递模板',
  PRIMARY KEY (`delivery_id`),
  KEY `seller_id` (`seller_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `dux_order_config_delivery` WRITE;
/*!40000 ALTER TABLE `dux_order_config_delivery` DISABLE KEYS */;

INSERT INTO `dux_order_config_delivery` (`delivery_id`, `seller_id`, `name`, `first_weight`, `first_price`, `second_weight`, `second_price`, `support_status`, `support_rate`, `support_price`, `area`, `tpl`)
VALUES
	(1,0,'默认模板',1000,7.00,1000,3.00,0,0,0.00,'','');

/*!40000 ALTER TABLE `dux_order_config_delivery` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table dux_order_config_express
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_order_config_express`;

CREATE TABLE `dux_order_config_express` (
  `express_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '物流名称',
  `logo` varchar(250) NOT NULL DEFAULT '' COMMENT '物流LOGO',
  `label` varchar(50) NOT NULL DEFAULT '' COMMENT '物流标识',
  `url` varchar(250) NOT NULL COMMENT '物流网址',
  `sort` int(10) NOT NULL DEFAULT '0' COMMENT '顺序',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`express_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `dux_order_config_express` WRITE;
/*!40000 ALTER TABLE `dux_order_config_express` DISABLE KEYS */;

INSERT INTO `dux_order_config_express` (`express_id`, `name`, `logo`, `label`, `url`, `sort`, `status`)
VALUES
	(3,'圆通快递','','YTO','',0,1),
	(4,'顺丰','','SF','',0,1),
	(5,'优速物流','','UC','',0,1);

/*!40000 ALTER TABLE `dux_order_config_express` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table dux_order_coupon
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_order_coupon`;

CREATE TABLE `dux_order_coupon` (
  `coupon_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `seller_id` int(11) NOT NULL COMMENT '卖家ID',
  `type` varchar(20) NOT NULL DEFAULT '' COMMENT '类型',
  `has_id` int(10) NOT NULL COMMENT '关联ID',
  `rule` text NOT NULL COMMENT '优惠券规则',
  `url` varchar(250) NOT NULL DEFAULT '' COMMENT '使用链接',
  `name` varchar(250) NOT NULL DEFAULT '' COMMENT '名称',
  `money` int(10) NOT NULL COMMENT '面值',
  `meet_money` int(10) NOT NULL COMMENT '满足费用',
  `start_time` int(10) NOT NULL COMMENT '开始时间',
  `end_time` int(10) NOT NULL COMMENT '结束时间',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态',
  `stock` int(10) NOT NULL DEFAULT '1' COMMENT '库存量',
  `receive` int(10) NOT NULL DEFAULT '0' COMMENT '领取量',
  `expiry_day` int(10) NOT NULL DEFAULT '1' COMMENT '有效天数',
  `exchange_type` varchar(20) NOT NULL DEFAULT '' COMMENT '兑换方式',
  `exchange_price` int(10) NOT NULL DEFAULT '0' COMMENT '兑换价格',
  PRIMARY KEY (`coupon_id`),
  KEY `seller_id` (`seller_id`),
  KEY `type` (`type`),
  KEY `has_id` (`has_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



# Dump of table dux_order_coupon_log
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_order_coupon_log`;

CREATE TABLE `dux_order_coupon_log` (
  `log_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `coupon_id` int(10) NOT NULL DEFAULT '0' COMMENT '优惠券ID',
  `start_time` int(10) NOT NULL COMMENT '开始时间',
  `end_time` int(10) NOT NULL COMMENT '结束时间',
  `status` tinyint(1) NOT NULL COMMENT '使用状态',
  `del` tinyint(1) NOT NULL COMMENT '用户删除',
  PRIMARY KEY (`log_id`),
  KEY `user_id` (`user_id`),
  KEY `coupon_id` (`coupon_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



# Dump of table dux_order_delivery
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_order_delivery`;

CREATE TABLE `dux_order_delivery` (
  `delivery_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(10) NOT NULL DEFAULT '0' COMMENT '订单ID',
  `seller_id` int(10) NOT NULL COMMENT '卖家ID',
  `delivery_name` varchar(50) NOT NULL DEFAULT '' COMMENT '快递名称',
  `delivery_no` varchar(100) NOT NULL DEFAULT '' COMMENT '快递单号',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `receive_time` int(10) NOT NULL DEFAULT '0' COMMENT '收货时间',
  `receive_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '收货状态',
  `remark` varchar(250) NOT NULL DEFAULT '' COMMENT '发货备注',
  `print_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '打印状态',
  `export_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '导出状态',
  `log` text NOT NULL COMMENT '运单记录',
  `log_update` int(10) NOT NULL COMMENT '记录更新时间',
  PRIMARY KEY (`delivery_id`),
  KEY `order_id` (`order_id`),
  KEY `seller_id` (`seller_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table dux_order_fund
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_order_fund`;

CREATE TABLE `dux_order_fund` (
  `fund_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(10) NOT NULL COMMENT '订单ID',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '费用',
  `time` int(10) NOT NULL DEFAULT '0' COMMENT '时间',
  `user_id` int(10) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `remark` text NOT NULL COMMENT '备注',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '类型',
  `unit` varchar(20) NOT NULL DEFAULT '' COMMENT '单位',
  PRIMARY KEY (`fund_id`),
  KEY `order_id` (`order_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



# Dump of table dux_order_goods
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_order_goods`;

CREATE TABLE `dux_order_goods` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(10) NOT NULL COMMENT '订单ID',
  `user_id` int(10) NOT NULL COMMENT '用户ID',
  `has_id` int(10) NOT NULL COMMENT '关联ID',
  `sub_id` int(10) NOT NULL COMMENT '子关联ID',
  `goods_no` varchar(200) NOT NULL DEFAULT '' COMMENT '商品货号',
  `goods_qty` int(10) NOT NULL DEFAULT '1' COMMENT '商品数量',
  `goods_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品单价',
  `goods_cost_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '成本单价',
  `goods_market_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '市场单价',
  `goods_currency` text NOT NULL COMMENT '其他货币支付',
  `goods_weight` int(10) NOT NULL DEFAULT '0' COMMENT '商品重量',
  `goods_options` text NOT NULL COMMENT '商品属性',
  `goods_name` varchar(250) NOT NULL DEFAULT '' COMMENT '商品名称',
  `goods_image` varchar(250) NOT NULL DEFAULT '' COMMENT '商品图片',
  `goods_url` varchar(250) NOT NULL DEFAULT '' COMMENT '商品链接',
  `goods_point` decimal(10,2) NOT NULL COMMENT '商品积分',
  `price_total` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品总价',
  `delivery_id` int(10) NOT NULL DEFAULT '0' COMMENT '快递单ID',
  `delivery_type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '物流类型(1需要物流 0无需物流)',
  `delivery_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '发货状态',
  `service_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '售后状态(0未售后 1售后中 2售后完成)',
  `comment_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '评论状态',
  `extend` text NOT NULL COMMENT '扩展信息',
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `user_id` (`user_id`),
  KEY `has_id` (`has_id`),
  KEY `sub_id` (`sub_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table dux_order_log
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_order_log`;

CREATE TABLE `dux_order_log` (
  `log_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '日志ID',
  `order_id` int(10) NOT NULL COMMENT '订单ID',
  `msg` varchar(250) NOT NULL DEFAULT '' COMMENT '消息',
  `remark` varchar(250) NOT NULL DEFAULT '' COMMENT '备注',
  `time` int(10) NOT NULL COMMENT '时间',
  `ip` varchar(250) NOT NULL COMMENT '操作IP',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0后台,1会员',
  PRIMARY KEY (`log_id`),
  KEY `order_id` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table dux_order_parcel
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_order_parcel`;

CREATE TABLE `dux_order_parcel` (
  `parcel_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(10) NOT NULL COMMENT '订单ID',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `status` tinyint(1) NOT NULL COMMENT '状态 0 配送失败 1 待配送 2 配送中 3配送完成',
  `log` text NOT NULL COMMENT '记录',
  `remark` varchar(250) NOT NULL DEFAULT '' COMMENT '备注',
  PRIMARY KEY (`parcel_id`),
  KEY `order_id` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table dux_order_pay
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_order_pay`;

CREATE TABLE `dux_order_pay` (
  `pay_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL DEFAULT '0',
  `pay_no` varchar(25) NOT NULL,
  `order_ids` varchar(250) NOT NULL DEFAULT '',
  `time` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`pay_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table dux_order_receipt
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_order_receipt`;

CREATE TABLE `dux_order_receipt` (
  `receipt_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `seller_id` int(10) NOT NULL DEFAULT '0' COMMENT '卖家ID',
  `order_id` int(10) NOT NULL COMMENT '订单ID',
  `order_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '订单金额',
  `receipt_no` varchar(20) NOT NULL DEFAULT '' COMMENT '收款单号',
  `receipt_pirce` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '实收金额',
  `receipt_time` int(10) NOT NULL DEFAULT '0' COMMENT '收款时间',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '收款状态',
  `remark` varchar(250) NOT NULL DEFAULT '' COMMENT '备注',
  PRIMARY KEY (`receipt_id`),
  KEY `seller_id` (`seller_id`),
  KEY `order_id` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table dux_order_refund
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_order_refund`;

CREATE TABLE `dux_order_refund` (
  `refund_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_goods_id` int(10) NOT NULL COMMENT '订单商品ID',
  `user_id` int(10) NOT NULL COMMENT '用户ID',
  `refund_no` varchar(50) NOT NULL COMMENT '退款单号',
  `money` decimal(10,2) NOT NULL COMMENT '退款金额',
  `cause` varchar(250) NOT NULL DEFAULT '' COMMENT '原因',
  `content` text NOT NULL COMMENT '描述',
  `images` text NOT NULL COMMENT '图片',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态(0取消 1待审核 2退款 3未退款)',
  `create_time` int(10) NOT NULL COMMENT '创建时间',
  `process_time` int(10) NOT NULL COMMENT '处理时间',
  `admin_user_id` int(10) NOT NULL COMMENT '处理人员',
  `admin_remark` varchar(250) NOT NULL DEFAULT '' COMMENT '处理备注',
  PRIMARY KEY (`refund_id`),
  KEY `order_goods_id` (`order_goods_id`),
  KEY `user_id` (`user_id`),
  KEY `refund_no` (`refund_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table dux_order_return
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_order_return`;

CREATE TABLE `dux_order_return` (
  `return_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_goods_id` int(10) NOT NULL COMMENT '订单商品ID',
  `user_id` int(10) NOT NULL COMMENT '用户ID',
  `return_no` varchar(50) NOT NULL DEFAULT '' COMMENT '退货单号',
  `money` decimal(10,2) NOT NULL COMMENT '退款金额',
  `cause` varchar(250) NOT NULL DEFAULT '' COMMENT '原因',
  `content` text NOT NULL COMMENT '描述',
  `images` text NOT NULL COMMENT '图片',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态(0取消 1待审核 2待邮寄 3退款 4拒绝)',
  `delivery_name` varchar(50) NOT NULL DEFAULT '' COMMENT '快递名称',
  `delivery_no` varchar(50) NOT NULL DEFAULT '' COMMENT '快递单号',
  `create_time` int(10) NOT NULL COMMENT '创建时间',
  `process_time` int(10) NOT NULL COMMENT '处理时间',
  `complete_time` int(10) NOT NULL COMMENT '完成时间',
  `admin_user_id` int(10) NOT NULL COMMENT '处理人员',
  `admin_remark` varchar(250) NOT NULL DEFAULT '' COMMENT '处理备注',
  PRIMARY KEY (`return_id`),
  KEY `order_goods_id` (`order_goods_id`),
  KEY `user_id` (`user_id`),
  KEY `return_no` (`return_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table dux_order_take
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_order_take`;

CREATE TABLE `dux_order_take` (
  `take_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `seller_id` int(10) NOT NULL COMMENT '卖家 ID',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '名称',
  `tel` varchar(20) NOT NULL DEFAULT '' COMMENT '电话',
  `province` varchar(100) NOT NULL DEFAULT '' COMMENT '省份',
  `city` varchar(100) NOT NULL DEFAULT '' COMMENT '城市',
  `region` varchar(100) NOT NULL DEFAULT '' COMMENT '地区',
  `address` varchar(250) NOT NULL DEFAULT '' COMMENT '详细地址',
  `lat` varchar(50) NOT NULL DEFAULT '' COMMENT '经度',
  `lng` varchar(50) NOT NULL DEFAULT '' COMMENT '纬度',
  `start_time` varchar(20) NOT NULL DEFAULT '' COMMENT '营业开始时间',
  `stop_time` varchar(20) NOT NULL DEFAULT '' COMMENT '营业结束时间',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态',
  PRIMARY KEY (`take_id`),
  KEY `seller_id` (`seller_id`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table dux_order_waybill_config
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_order_waybill_config`;

CREATE TABLE `dux_order_waybill_config` (
  `config_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `type` varchar(250) NOT NULL DEFAULT '' COMMENT '类型名',
  `setting` text NOT NULL COMMENT '配置内容',
  PRIMARY KEY (`config_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

LOCK TABLES `dux_order_waybill_config` WRITE;
/*!40000 ALTER TABLE `dux_order_waybill_config` DISABLE KEYS */;

INSERT INTO `dux_order_waybill_config` (`config_id`, `type`, `setting`)
VALUES
	(1,'kdniao','a:4:{s:2:\"id\";s:7:\"1270588\";s:3:\"key\";s:36:\"38e456b7-0c58-4f64-bee2-e44f4115d4bd\";s:9:\"config_id\";s:1:\"1\";s:4:\"type\";s:6:\"kdniao\";}'),
	(2,'kd100','a:2:{s:9:\"config_id\";s:0:\"\";s:4:\"type\";s:5:\"kd100\";}');

/*!40000 ALTER TABLE `dux_order_waybill_config` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table dux_page
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_page`;

CREATE TABLE `dux_page` (
  `page_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(10) NOT NULL COMMENT '栏目ID',
  `label` varchar(250) NOT NULL COMMENT '标签',
  `parent_id` int(10) NOT NULL DEFAULT '0' COMMENT '上级栏目',
  `tpl` varchar(250) DEFAULT '' COMMENT '页面模板',
  `content` text NOT NULL COMMENT '内容',
  PRIMARY KEY (`page_id`),
  KEY `parent_id` (`parent_id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table dux_pay_account
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_pay_account`;

CREATE TABLE `dux_pay_account` (
  `account_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL COMMENT '用户ID',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '资金余额',
  `spend` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '支出金额',
  `charge` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '入账金额',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态',
  `recharge` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '充值金额',
  PRIMARY KEY (`account_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table dux_pay_bank
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_pay_bank`;

CREATE TABLE `dux_pay_bank` (
  `bank_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(20) NOT NULL,
  `name` varchar(250) NOT NULL DEFAULT '' COMMENT '银行名称',
  `logo` varchar(250) NOT NULL DEFAULT '' COMMENT '银行logo',
  `description` varchar(250) NOT NULL DEFAULT '' COMMENT '描述',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`bank_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `dux_pay_bank` WRITE;
/*!40000 ALTER TABLE `dux_pay_bank` DISABLE KEYS */;

INSERT INTO `dux_pay_bank` (`bank_id`, `label`, `name`, `logo`, `description`, `status`)
VALUES
	(1,'bcb','中国银行','','',1);

/*!40000 ALTER TABLE `dux_pay_bank` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table dux_pay_card
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_pay_card`;

CREATE TABLE `dux_pay_card` (
  `card_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL COMMENT '用户ID',
  `label` varchar(50) NOT NULL COMMENT '银行标识',
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '银行名称',
  `account_tel` varchar(20) NOT NULL DEFAULT '' COMMENT '银行电话',
  `account` varchar(50) NOT NULL DEFAULT '' COMMENT '账户号',
  `account_name` varchar(20) NOT NULL DEFAULT '' COMMENT '账户名称',
  `account_bank` varchar(100) NOT NULL DEFAULT '' COMMENT '开户行',
  PRIMARY KEY (`card_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table dux_pay_cash
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_pay_cash`;

CREATE TABLE `dux_pay_cash` (
  `cash_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL DEFAULT '0',
  `cash_no` varchar(50) NOT NULL DEFAULT '' COMMENT '流水号',
  `money` decimal(10,2) NOT NULL COMMENT '金额',
  `tax` int(10) NOT NULL DEFAULT '0' COMMENT '手续费百分比',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '提现状态',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '提现开始',
  `complete_time` int(10) NOT NULL DEFAULT '0' COMMENT '提现结束',
  `bank` varchar(50) NOT NULL DEFAULT '' COMMENT '开户行',
  `label` varchar(50) NOT NULL COMMENT '银行标识',
  `account` varchar(250) NOT NULL DEFAULT '' COMMENT '提现账户',
  `account_tel` varchar(20) NOT NULL DEFAULT '' COMMENT '开户电话',
  `account_name` varchar(20) NOT NULL DEFAULT '' COMMENT '账户姓名',
  `auth_remark` varchar(250) NOT NULL DEFAULT '' COMMENT '备注',
  `auth_admin` int(10) NOT NULL DEFAULT '0',
  `auth_time` int(10) NOT NULL DEFAULT '0',
  `account_bank` varchar(250) NOT NULL DEFAULT '',
  PRIMARY KEY (`cash_id`),
  KEY `user_id` (`user_id`),
  KEY `cash_no` (`cash_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table dux_pay_config
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_pay_config`;

CREATE TABLE `dux_pay_config` (
  `config_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `type` varchar(250) NOT NULL DEFAULT '' COMMENT '标识',
  `setting` text NOT NULL COMMENT '配置内容',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态',
  `sort` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`config_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;



# Dump of table dux_pay_log
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_pay_log`;

CREATE TABLE `dux_pay_log` (
  `log_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `account_id` int(10) NOT NULL DEFAULT '0',
  `log_no` varchar(50) NOT NULL DEFAULT '' COMMENT '流水号',
  `time` int(10) NOT NULL DEFAULT '0' COMMENT '交易时间',
  `money` decimal(10,2) DEFAULT '0.00' COMMENT '交易金额',
  `remark` varchar(250) NOT NULL DEFAULT '' COMMENT '交易备注',
  `pay_no` varchar(200) NOT NULL DEFAULT '' COMMENT '交易号',
  `pay_name` varchar(50) NOT NULL DEFAULT '' COMMENT '交易名',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0支出1收入',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '交易状态 0关闭 1未支付 2已支付',
  `source_value` varchar(250) NOT NULL DEFAULT '' COMMENT '来源信息',
  `source_url` varchar(250) NOT NULL DEFAULT '' COMMENT '来源地址',
  PRIMARY KEY (`log_id`),
  KEY `account_id` (`account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table dux_pay_stats
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_pay_stats`;

CREATE TABLE `dux_pay_stats` (
  `stats_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `spend` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '支出',
  `charge` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '收入',
  `time` int(10) NOT NULL DEFAULT '0' COMMENT '时间',
  `type` varchar(10) NOT NULL DEFAULT '' COMMENT '类型',
  `spend_num` int(10) NOT NULL DEFAULT '0',
  `charge_num` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`stats_id`),
  KEY `user_id` (`user_id`),
  KEY `type` (`spend`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table dux_points_account
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_points_account`;

CREATE TABLE `dux_points_account` (
  `account_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL COMMENT '用户ID',
  `points` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '积分余额',
  `spend` int(10) NOT NULL DEFAULT '0' COMMENT '消费积分',
  `charge` int(10) NOT NULL DEFAULT '0' COMMENT '充值积分',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态',
  PRIMARY KEY (`account_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table dux_points_log
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_points_log`;

CREATE TABLE `dux_points_log` (
  `log_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `account_id` int(10) NOT NULL DEFAULT '0',
  `log_no` varchar(50) NOT NULL DEFAULT '' COMMENT '流水号',
  `time` int(10) NOT NULL COMMENT '交易时间',
  `points` decimal(10,2) DEFAULT '0.00' COMMENT '交易积分',
  `remark` varchar(250) NOT NULL DEFAULT '' COMMENT '交易备注',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0支出1收入',
  PRIMARY KEY (`log_id`),
  KEY `account_id` (`account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table dux_sale_config
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_sale_config`;

CREATE TABLE `dux_sale_config` (
  `config_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL DEFAULT '',
  `content` varchar(250) NOT NULL DEFAULT '',
  `description` varchar(250) NOT NULL DEFAULT '',
  PRIMARY KEY (`config_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `dux_sale_config` WRITE;
/*!40000 ALTER TABLE `dux_sale_config` DISABLE KEYS */;

INSERT INTO `dux_sale_config` (`config_id`, `name`, `content`, `description`)
VALUES
	(1,'sale_status','0','分销开关'),
	(2,'sale_level','2','分销层级'),
	(3,'sale_purchase','0','分销内购'),
	(4,'apply_type','1','申请类型'),
	(5,'apply_check','1','申请审核'),
	(6,'apply_where','N;','申请条件'),
	(8,'level_type','1','升级条件'),
	(9,'clear_withdraw','1','提现额度'),
	(10,'clear_type','1','计算方式'),
	(11,'clear_tax','0','个人所得税'),
	(12,'clear_tax_free','10','免税额度'),
	(13,'clear_day','0','结算天数'),
	(34,'notice_join_status','1',''),
	(35,'notice_join_class','a:2:{i:0;s:3:\"sms\";i:1;s:6:\"wechat\";}',''),
	(36,'notice_pay_title','下级付款通知',''),
	(37,'notice_join_sms_tpl','',''),
	(38,'notice_join_mail_tpl','',''),
	(39,'notice_join_wechat_tpl','推荐人：[推荐人]\n时间：[时间]',''),
	(40,'notice_next_status','1',''),
	(41,'notice_next_class','a:2:{i:0;s:3:\"sms\";i:1;s:6:\"wechat\";}',''),
	(42,'notice_next_level','1',''),
	(43,'notice_next_sms_tpl','',''),
	(44,'notice_next_mail_tpl','',''),
	(45,'notice_next_wechat_tpl','您有新的下级用户加入\n昵称：[昵称]\n时间：[时间]\n下线层级：[下线层级]',''),
	(46,'notice_pay_status','0',''),
	(47,'notice_pay_class','a:2:{i:0;s:3:\"sms\";i:1;s:6:\"wechat\";}',''),
	(48,'notice_pay_level','1',''),
	(49,'notice_pay_sms_tpl','',''),
	(50,'notice_pay_mail_tpl','',''),
	(51,'notice_pay_wechat_tpl','',''),
	(52,'notice_confirm_status','1',''),
	(53,'notice_confirm_class','a:2:{i:0;s:3:\"sms\";i:1;s:6:\"wechat\";}',''),
	(54,'notice_confirm_level','1',''),
	(55,'notice_confirm_title','下级完成通知',''),
	(56,'notice_confirm_sms_tpl','',''),
	(57,'notice_confirm_mail_tpl','',''),
	(58,'notice_confirm_wechat_tpl','',''),
	(59,'notice_cash_status','0',''),
	(60,'notice_cash_class','a:2:{i:0;s:3:\"sms\";i:1;s:6:\"wechat\";}',''),
	(61,'notice_cash_title','提现申请提交通知',''),
	(62,'notice_cash_sms_tpl','',''),
	(63,'notice_cash_mail_tpl','',''),
	(64,'notice_cash_wechat_tpl','',''),
	(65,'notice_com_class','a:2:{i:0;s:3:\"sms\";i:1;s:6:\"wechat\";}',''),
	(66,'notice_com_title','佣金打款通知',''),
	(67,'notice_com_sms_tpl','',''),
	(68,'notice_com_mail_tpl','',''),
	(69,'notice_com_wechat_tpl','',''),
	(70,'notice_com_status','0',''),
	(71,'notice_level_status','0',''),
	(72,'notice_level_class','a:2:{i:0;s:3:\"sms\";i:1;s:6:\"wechat\";}',''),
	(73,'notice_level_title','分销升级通知',''),
	(74,'notice_level_sms_tpl','',''),
	(75,'notice_level_mail_tpl','',''),
	(76,'notice_level_wechat_tpl','',''),
	(77,'notice_sale_status','0',''),
	(78,'notice_sale_class','a:2:{i:0;s:3:\"sms\";i:1;s:6:\"wechat\";}',''),
	(79,'notice_sale_title','佣金打款通知',''),
	(80,'notice_sale_sms_tpl','',''),
	(81,'notice_sale_mail_tpl','',''),
	(82,'notice_sale_wechat_tpl','',''),
	(83,'notice_next_title','新增下级通知',''),
	(84,'apply_auto','','自动注册'),
	(85,'notice_join_title','欢迎您加入分销系统',''),
	(86,'sale_level_name','我的好友,我的粉丝','分销层级名称'),
	(87,'qrcode_image','public/sale/images/share-user.png',''),
	(88,'qrcode_avatar_x','42',''),
	(89,'qrcode_avatar_y','50',''),
	(90,'qrcode_avatar_width','128',''),
	(91,'qrcode_avatar_height','128',''),
	(92,'qrcode_username_x','266',''),
	(93,'qrcode_username_y','100',''),
	(94,'qrcode_username_size','26',''),
	(95,'qrcode_username_align','0',''),
	(96,'qrcode_rename','duxshop',''),
	(97,'qrcode_retext_x','195',''),
	(98,'qrcode_retext_y','155',''),
	(99,'qrcode_retext_size','25',''),
	(100,'qrcode_retext_align','0',''),
	(101,'qrcode_tip_x','195',''),
	(102,'qrcode_tip_y','375',''),
	(103,'qrcode_tip_size','25',''),
	(104,'qrcode_tip_align','1',''),
	(105,'qrcode_ad','',''),
	(106,'qrcode_ad_x','',''),
	(107,'qrcode_ad_y','',''),
	(108,'qrcode_ad_size','',''),
	(109,'qrcode_ad_align','0',''),
	(110,'qrcode_code_x','205',''),
	(111,'qrcode_code_y','845',''),
	(112,'qrcode_code_size','20',''),
	(113,'qrcode_code_align','0',''),
	(114,'qrcode_x','80',''),
	(115,'qrcode_y','491',''),
	(116,'qrcode_width','300',''),
	(117,'qrcode_height','300',''),
	(118,'qrcode_status','1',''),
	(119,'qrcode_avatar_status','on',''),
	(120,'qrcode_username_status','1',''),
	(121,'qrcode_username_color','000000',''),
	(122,'qrcode_retext_color','000000',''),
	(123,'qrcode_tip_color','ffffff',''),
	(124,'qrcode_ad_color','',''),
	(125,'qrcode_code_color','',''),
	(126,'qrcode_retext_status','1',''),
	(127,'qrcode_tip_status','1',''),
	(128,'qrcode_code_status','1',''),
	(129,'qrcode_ad1_text','我为duxshop代言',''),
	(130,'qrcode_ad1_status','1',''),
	(131,'qrcode_ad1_x','195',''),
	(132,'qrcode_ad1_y','155',''),
	(133,'qrcode_ad1_size','25',''),
	(134,'qrcode_ad1_color','000000',''),
	(135,'qrcode_ad1_align','0',''),
	(136,'qrcode_ad2_text','扫一扫进入duxshop商城',''),
	(137,'qrcode_ad2_status','1',''),
	(138,'qrcode_ad2_x','195',''),
	(139,'qrcode_ad2_y','375',''),
	(140,'qrcode_ad2_size','25',''),
	(141,'qrcode_ad2_color','ffffff',''),
	(142,'qrcode_ad2_align','1',''),
	(143,'qrcode_ad3_text','',''),
	(144,'qrcode_ad3_x','',''),
	(145,'qrcode_ad3_y','',''),
	(146,'qrcode_ad3_size','',''),
	(147,'qrcode_ad3_color','',''),
	(148,'qrcode_ad3_align','0','');

/*!40000 ALTER TABLE `dux_sale_config` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table dux_sale_content
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_sale_content`;

CREATE TABLE `dux_sale_content` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `app` varchar(20) NOT NULL COMMENT '应用名',
  `has_id` int(10) NOT NULL COMMENT '商品ID',
  `sale_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '参与分销',
  `sale_special` int(10) NOT NULL DEFAULT '0' COMMENT '独立计算',
  `sale_rate` text NOT NULL COMMENT '独立规则',
  PRIMARY KEY (`id`),
  KEY `app` (`app`),
  KEY `has_id` (`has_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table dux_sale_order
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_sale_order`;

CREATE TABLE `dux_sale_order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL DEFAULT '0' COMMENT '分销用户',
  `order_goods_id` int(10) NOT NULL DEFAULT '0' COMMENT '订单商品ID',
  `sale_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '订单状态 0 取消 1待完成 2已完成',
  `sale_money` decimal(10,2) NOT NULL COMMENT '佣金金额',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `complete_time` int(10) NOT NULL DEFAULT '0' COMMENT '完成时间',
  `level` tinyint(1) NOT NULL DEFAULT '1' COMMENT '佣金等级',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `order_goods_id` (`order_goods_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table dux_sale_statis
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_sale_statis`;

CREATE TABLE `dux_sale_statis` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL COMMENT '用户ID',
  `sale_order_money` decimal(10,2) NOT NULL COMMENT '分销订单总额',
  `sale_order_num` int(10) NOT NULL COMMENT '分销订单总数',
  `has_order_money` decimal(10,2) NOT NULL COMMENT '直属订单总额',
  `has_order_num` int(10) NOT NULL COMMENT '直属订单总数',
  `order_money` decimal(10,2) NOT NULL COMMENT '自购订单总额',
  `order_num` int(10) NOT NULL COMMENT '自购订单总数',
  `has_user_num` int(10) NOT NULL COMMENT '直属下线总数',
  `sale_user_num` int(10) NOT NULL COMMENT '分销下线总数',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table dux_sale_user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_sale_user`;

CREATE TABLE `dux_sale_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL COMMENT '分销用户',
  `level_id` int(11) NOT NULL DEFAULT '1' COMMENT '分销等级',
  `parent_id` int(10) NOT NULL DEFAULT '0' COMMENT '上级用户',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '用户状态',
  `join_time` int(10) NOT NULL DEFAULT '0' COMMENT '加入时间',
  `agent` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否分销商',
  `agent_time` int(10) NOT NULL DEFAULT '0' COMMENT '加入时间',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '分销金额',
  `code` varchar(20) NOT NULL DEFAULT '' COMMENT '推荐码',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `level_id` (`level_id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table dux_sale_user_apply
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_sale_user_apply`;

CREATE TABLE `dux_sale_user_apply` (
  `apply_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL COMMENT '申请用户',
  `apply_time` int(10) NOT NULL COMMENT '申请时间',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态 1申请中 0驳回申请 2审核通过',
  `remark` varchar(250) NOT NULL DEFAULT '' COMMENT '失败理由',
  `auth_admin` int(10) NOT NULL DEFAULT '0' COMMENT '审核管理员',
  `auth_time` int(10) NOT NULL DEFAULT '0' COMMENT '审核时间',
  PRIMARY KEY (`apply_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table dux_sale_user_level
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_sale_user_level`;

CREATE TABLE `dux_sale_user_level` (
  `level_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '等级名称',
  `level_where` int(10) NOT NULL COMMENT '升级条件',
  `comm_rate` text NOT NULL COMMENT '佣金比例',
  `special` tinyint(1) NOT NULL DEFAULT '0' COMMENT '特殊组',
  PRIMARY KEY (`level_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `dux_sale_user_level` WRITE;
/*!40000 ALTER TABLE `dux_sale_user_level` DISABLE KEYS */;

INSERT INTO `dux_sale_user_level` (`level_id`, `name`, `level_where`, `comm_rate`, `special`)
VALUES
	(1,'默认等级',0,'a:2:{i:1;a:2:{s:4:\"rate\";s:2:\"20\";s:5:\"money\";s:0:\"\";}i:2;a:2:{s:4:\"rate\";s:2:\"15\";s:5:\"money\";s:0:\"\";}}',0);

/*!40000 ALTER TABLE `dux_sale_user_level` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table dux_shop_brand
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_shop_brand`;

CREATE TABLE `dux_shop_brand` (
  `brand_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `seller_id` int(10) NOT NULL DEFAULT '0',
  `name` varchar(50) NOT NULL DEFAULT '',
  `home` varchar(250) DEFAULT '',
  `logo` varchar(250) DEFAULT '',
  `content` text,
  `sort` int(10) NOT NULL DEFAULT '0',
  `title` varchar(250) DEFAULT '',
  `keyword` varchar(250) DEFAULT '',
  `description` varchar(250) DEFAULT '',
  `status` int(10) NOT NULL DEFAULT '1',
  PRIMARY KEY (`brand_id`),
  KEY `seller_id` (`seller_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table dux_shop_config
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_shop_config`;

CREATE TABLE `dux_shop_config` (
  `config_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL DEFAULT '',
  `content` varchar(250) NOT NULL DEFAULT '',
  `description` varchar(250) NOT NULL DEFAULT '',
  PRIMARY KEY (`config_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `dux_shop_config` WRITE;
/*!40000 ALTER TABLE `dux_shop_config` DISABLE KEYS */;

INSERT INTO `dux_shop_config` (`config_id`, `name`, `content`, `description`)
VALUES
	(1,'stock_type','0',''),
	(2,'point_status','1',''),
	(3,'point_rate','20',''),
	(4,'info_name','DuxShop',''),
	(5,'info_logo','','');

/*!40000 ALTER TABLE `dux_shop_config` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table dux_shop_faq
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_shop_faq`;

CREATE TABLE `dux_shop_faq` (
  `faq_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `has_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品ID',
  `app` varchar(250) NOT NULL DEFAULT '' COMMENT '应用',
  `time` int(10) NOT NULL DEFAULT '0' COMMENT '资讯时间',
  `content` varchar(250) NOT NULL DEFAULT '' COMMENT '资讯内容',
  `reply_content` varchar(250) DEFAULT '' COMMENT '回复内容',
  `replay_time` int(10) NOT NULL DEFAULT '0' COMMENT '回复时间',
  PRIMARY KEY (`faq_id`),
  KEY `user_id` (`user_id`),
  KEY `has_id` (`has_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table dux_shop_follow
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_shop_follow`;

CREATE TABLE `dux_shop_follow` (
  `follow_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `has_id` int(10) NOT NULL DEFAULT '0' COMMENT '商品ID',
  `app` varchar(50) NOT NULL COMMENT '应用',
  `time` int(10) NOT NULL DEFAULT '0' COMMENT '时间',
  `title` varchar(250) NOT NULL COMMENT '标题',
  `image` varchar(250) NOT NULL COMMENT '形象图',
  `remark` varchar(200) NOT NULL DEFAULT '' COMMENT '备注',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '价格',
  PRIMARY KEY (`follow_id`),
  KEY `user_id` (`user_id`),
  KEY `has_id` (`has_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table dux_shop_footprint
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_shop_footprint`;

CREATE TABLE `dux_shop_footprint` (
  `footprint_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL DEFAULT '0',
  `ids` text,
  PRIMARY KEY (`footprint_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table dux_shop_help
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_shop_help`;

CREATE TABLE `dux_shop_help` (
  `help_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `class_id` int(10) NOT NULL COMMENT '分类ID',
  `title` varchar(250) NOT NULL DEFAULT '' COMMENT '标题',
  `content` text NOT NULL COMMENT '内容',
  `keyword` varchar(250) NOT NULL DEFAULT '' COMMENT '关键词',
  `description` varchar(250) NOT NULL DEFAULT '' COMMENT '描述',
  `sort` int(10) NOT NULL DEFAULT '0' COMMENT '顺序',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态',
  PRIMARY KEY (`help_id`),
  KEY `class_id` (`class_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



# Dump of table dux_shop_help_class
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_shop_help_class`;

CREATE TABLE `dux_shop_help_class` (
  `class_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL DEFAULT '' COMMENT '名称',
  `keyword` varchar(250) NOT NULL DEFAULT '' COMMENT '关键词',
  `description` varchar(250) NOT NULL DEFAULT '' COMMENT '描述',
  `sort` int(10) NOT NULL DEFAULT '0' COMMENT '顺序',
  PRIMARY KEY (`class_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



# Dump of table dux_shop_spec
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_shop_spec`;

CREATE TABLE `dux_shop_spec` (
  `spec_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `value` text,
  PRIMARY KEY (`spec_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table dux_shop_spec_group
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_shop_spec_group`;

CREATE TABLE `dux_shop_spec_group` (
  `group_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `spec_ids` varchar(250) NOT NULL DEFAULT '',
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table dux_site_adv
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_site_adv`;

CREATE TABLE `dux_site_adv` (
  `adv_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pos_id` int(10) NOT NULL DEFAULT '0',
  `title` varchar(250) NOT NULL DEFAULT '',
  `url` varchar(250) NOT NULL DEFAULT '',
  `url_ext` text NOT NULL,
  `image` varchar(250) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `start_time` int(10) NOT NULL DEFAULT '0',
  `stop_time` int(10) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `sort` int(10) NOT NULL DEFAULT '0',
  `view` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`adv_id`),
  KEY `pos_id` (`pos_id`),
  KEY `status` (`title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table dux_site_adv_position
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_site_adv_position`;

CREATE TABLE `dux_site_adv_position` (
  `pos_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL DEFAULT '',
  `label` varchar(50) NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`pos_id`),
  KEY `status` (`name`),
  KEY `type` (`label`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table dux_site_class
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_site_class`;

CREATE TABLE `dux_site_class` (
  `category_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `model_id` int(10) NOT NULL DEFAULT '0' COMMENT '模型ID',
  `name` varchar(250) NOT NULL DEFAULT '' COMMENT '名称',
  `subname` varchar(250) DEFAULT '' COMMENT '副名称',
  `sort` int(10) NOT NULL DEFAULT '0' COMMENT '排序',
  `url` varchar(259) DEFAULT '' COMMENT '外部链接',
  `image` varchar(250) DEFAULT '' COMMENT '形象图',
  `keyword` varchar(250) DEFAULT '' COMMENT '关键词',
  `description` varchar(250) DEFAULT '' COMMENT '描述',
  `filter_id` int(10) DEFAULT '0' COMMENT '筛选ID',
  PRIMARY KEY (`category_id`),
  KEY `model_id` (`model_id`),
  KEY `filter_id` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table dux_site_config
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_site_config`;

CREATE TABLE `dux_site_config` (
  `config_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL DEFAULT '',
  `content` varchar(250) NOT NULL DEFAULT '',
  `description` varchar(250) NOT NULL DEFAULT '',
  PRIMARY KEY (`config_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `dux_site_config` WRITE;
/*!40000 ALTER TABLE `dux_site_config` DISABLE KEYS */;

INSERT INTO `dux_site_config` (`config_id`, `name`, `content`, `description`)
VALUES
	(1,'tpl_index','index','默认首页模板'),
	(2,'tpl_class','list','默认栏目模板'),
	(3,'tpl_content','content','默认内容模板'),
	(6,'info_title','DuxSHOP商城管理系统','站点标题'),
	(7,'info_keyword','duxshop,b2c,开源商城系统,小型商城系统,免费商城系统','站点关键词'),
	(8,'info_desc','duxshop是一款基于php+mysql的高度可扩展化B2C商城管理系统','站点描述'),
	(9,'info_copyright','Copyright@2013-2017 duxphp.com All Rights Reserved.','版权信息'),
	(10,'info_email','','站点邮箱'),
	(11,'info_tel','','站点电话'),
	(12,'tpl_name','default','模板目录'),
	(13,'tpl_tags','tag','标签模板'),
	(15,'tpl_search','search','搜索模板'),
	(16,'info_name','DuxSHOP商城','站点名称'),
	(17,'config_site_status','1','站点状态'),
	(18,'config_mobile_status','1','移动状态'),
	(19,'config_site_error','站定维护中，本次维护预计需要4个小时，请谅解。','关闭说明');

/*!40000 ALTER TABLE `dux_site_config` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table dux_site_content
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_site_content`;

CREATE TABLE `dux_site_content` (
  `content_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `app` varchar(20) NOT NULL COMMENT '应用名',
  `pos_id` varchar(250) DEFAULT '' COMMENT '推荐位',
  `title` varchar(250) NOT NULL DEFAULT '' COMMENT '标题',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态',
  `subtitle` varchar(250) DEFAULT '' COMMENT '副标题',
  `image` varchar(250) DEFAULT '' COMMENT '形象图',
  `url` varchar(250) DEFAULT '' COMMENT '外部链接',
  `keyword` varchar(250) DEFAULT '' COMMENT '关键词',
  `description` varchar(250) DEFAULT '' COMMENT '描述',
  `tpl` varchar(50) DEFAULT '' COMMENT '模板名',
  `sort` int(10) NOT NULL DEFAULT '0' COMMENT '排序',
  `create_time` varchar(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `view` int(10) NOT NULL DEFAULT '0' COMMENT '浏览量',
  `source` varchar(250) DEFAULT '' COMMENT '来源',
  `auth` varchar(250) DEFAULT '' COMMENT '作者',
  `editor` varchar(250) DEFAULT '' COMMENT '编辑',
  `tags_id` varchar(250) DEFAULT '' COMMENT 'tags',
  `filter_id` int(10) NOT NULL DEFAULT '0' COMMENT '筛选ID',
  PRIMARY KEY (`content_id`),
  KEY `pos_id` (`pos_id`),
  KEY `title` (`title`),
  KEY `status` (`status`),
  KEY `sort` (`sort`),
  KEY `create_time` (`create_time`),
  KEY `view` (`view`),
  KEY `tags_id` (`tags_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table dux_site_content_attr
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_site_content_attr`;

CREATE TABLE `dux_site_content_attr` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `content_id` int(10) NOT NULL COMMENT '内容ID',
  `attr_id` int(10) NOT NULL COMMENT '属性ID',
  `value` varchar(250) NOT NULL DEFAULT '' COMMENT '属性值',
  PRIMARY KEY (`id`),
  KEY `content_id` (`content_id`),
  KEY `attr_id` (`attr_id`),
  KEY `value` (`value`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table dux_site_filter
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_site_filter`;

CREATE TABLE `dux_site_filter` (
  `filter_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL DEFAULT '',
  PRIMARY KEY (`filter_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table dux_site_filter_attr
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_site_filter_attr`;

CREATE TABLE `dux_site_filter_attr` (
  `attr_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '属性ID',
  `filter_id` int(10) NOT NULL COMMENT '筛选ID',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '控件类型',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '名称',
  `value` text COMMENT '属性值',
  PRIMARY KEY (`attr_id`),
  KEY `filter_id` (`filter_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table dux_site_form
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_site_form`;

CREATE TABLE `dux_site_form` (
  `form_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '表单名称',
  `description` varchar(250) DEFAULT '' COMMENT '表单描述',
  `label` varchar(50) DEFAULT '' COMMENT '表单标识',
  `tpl_list` varchar(50) DEFAULT '' COMMENT '列表模板',
  `tpl_info` varchar(50) DEFAULT '' COMMENT '内容模板',
  `status_list` tinyint(1) DEFAULT '0',
  `status_info` tinyint(1) DEFAULT '0',
  `submit` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`form_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table dux_site_form_field
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_site_form_field`;

CREATE TABLE `dux_site_form_field` (
  `field_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `form_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(50) DEFAULT '' COMMENT '字段名称',
  `label` varchar(50) DEFAULT '' COMMENT '字段标识',
  `type` varchar(50) DEFAULT '' COMMENT '字段类型',
  `tip` varchar(250) DEFAULT '' COMMENT '字段提示',
  `must` tinyint(1) DEFAULT '0' COMMENT '必须字段',
  `default` varchar(250) DEFAULT '' COMMENT '默认值',
  `sort` int(10) DEFAULT '0' COMMENT '字段顺序',
  `config` text COMMENT '字段配置',
  `show` tinyint(1) DEFAULT '0' COMMENT '列表显示',
  `submit` tinyint(1) DEFAULT '0' COMMENT '前台提交',
  PRIMARY KEY (`field_id`),
  KEY `form_id` (`form_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table dux_site_fragment
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_site_fragment`;

CREATE TABLE `dux_site_fragment` (
  `fragment_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(250) NOT NULL DEFAULT '' COMMENT '描述',
  `content` text COMMENT '内容',
  `editor` tinyint(1) NOT NULL DEFAULT '0' COMMENT '编辑器',
  PRIMARY KEY (`fragment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table dux_site_model
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_site_model`;

CREATE TABLE `dux_site_model` (
  `model_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '模型名称',
  `description` varchar(250) DEFAULT '' COMMENT '模型描述',
  `label` varchar(50) DEFAULT '' COMMENT '模型标识',
  PRIMARY KEY (`model_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table dux_site_model_field
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_site_model_field`;

CREATE TABLE `dux_site_model_field` (
  `field_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `model_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(50) DEFAULT '' COMMENT '字段名称',
  `label` varchar(50) DEFAULT '' COMMENT '字段标识',
  `type` varchar(50) DEFAULT '' COMMENT '字段类型',
  `tip` varchar(250) DEFAULT '' COMMENT '字段提示',
  `must` tinyint(1) DEFAULT '0' COMMENT '必须字段',
  `default` varchar(250) DEFAULT '' COMMENT '默认值',
  `sort` int(10) DEFAULT '0' COMMENT '字段顺序',
  `config` text COMMENT '字段配置',
  PRIMARY KEY (`field_id`),
  KEY `model_id` (`model_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table dux_site_nav
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_site_nav`;

CREATE TABLE `dux_site_nav` (
  `nav_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) DEFAULT '0' COMMENT '上级ID',
  `group_id` int(10) NOT NULL COMMENT '分组ID',
  `name` varchar(250) NOT NULL DEFAULT '' COMMENT '导航名称',
  `url` varchar(250) DEFAULT '' COMMENT '外链地址',
  `subname` varchar(10) DEFAULT '' COMMENT '导航副名称',
  `image` varchar(250) DEFAULT '' COMMENT '导航封面图',
  `keyword` varchar(250) DEFAULT '' COMMENT '导航关键词',
  `description` varchar(250) DEFAULT '' COMMENT '导航描述',
  `sort` int(10) DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`nav_id`),
  KEY `parent_id` (`parent_id`),
  KEY `group_id` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table dux_site_nav_group
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_site_nav_group`;

CREATE TABLE `dux_site_nav_group` (
  `group_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL DEFAULT '' COMMENT '分组名称',
  `description` varchar(250) NOT NULL DEFAULT '' COMMENT '分组描述',
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `dux_site_nav_group` WRITE;
/*!40000 ALTER TABLE `dux_site_nav_group` DISABLE KEYS */;

INSERT INTO `dux_site_nav_group` (`group_id`, `name`, `description`)
VALUES
	(1,'默认分组','系统默认导航');

/*!40000 ALTER TABLE `dux_site_nav_group` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table dux_site_position
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_site_position`;

CREATE TABLE `dux_site_position` (
  `pos_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL DEFAULT '',
  `sort` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`pos_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `dux_site_position` WRITE;
/*!40000 ALTER TABLE `dux_site_position` DISABLE KEYS */;

INSERT INTO `dux_site_position` (`pos_id`, `name`, `sort`)
VALUES
	(1,'全局推荐',0),
	(2,'栏目推荐',0);

/*!40000 ALTER TABLE `dux_site_position` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table dux_site_search
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_site_search`;

CREATE TABLE `dux_site_search` (
  `search_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `keyword` varchar(20) NOT NULL DEFAULT '',
  `num` int(10) NOT NULL DEFAULT '1',
  `app` varchar(20) NOT NULL DEFAULT '',
  `create_time` int(10) NOT NULL DEFAULT '0',
  `update_time` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`search_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table dux_site_tags
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_site_tags`;

CREATE TABLE `dux_site_tags` (
  `tag_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL DEFAULT '',
  `quote` int(10) NOT NULL DEFAULT '1',
  `view` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`tag_id`),
  KEY `name` (`name`),
  KEY `quote` (`quote`),
  KEY `view` (`view`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table dux_system_file
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_system_file`;

CREATE TABLE `dux_system_file` (
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
  KEY `time` (`time`) USING BTREE,
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='上传文件';



# Dump of table dux_system_info
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_system_info`;

CREATE TABLE `dux_system_info` (
  `info_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(50) NOT NULL DEFAULT '' COMMENT '键名',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '配置名称',
  `value` text NOT NULL COMMENT '配置值',
  `description` varchar(250) NOT NULL DEFAULT '' COMMENT '配置描述',
  `reserve` tinyint(1) NOT NULL DEFAULT '0' COMMENT '内置',
  PRIMARY KEY (`info_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table dux_system_notice
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_system_notice`;

CREATE TABLE `dux_system_notice` (
  `notice_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `icon` varchar(20) DEFAULT '',
  `content` varchar(250) DEFAULT '',
  `url` varchar(250) DEFAULT '',
  `time` int(10) NOT NULL DEFAULT '0',
  `type` varchar(20) NOT NULL DEFAULT 'primary',
  PRIMARY KEY (`notice_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table dux_system_role
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_system_role`;

CREATE TABLE `dux_system_role` (
  `role_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL DEFAULT '',
  `description` varchar(250) DEFAULT '',
  `purview` text,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `dux_system_role` WRITE;
/*!40000 ALTER TABLE `dux_system_role` DISABLE KEYS */;

INSERT INTO `dux_system_role` (`role_id`, `name`, `description`, `purview`)
VALUES
	(1,'管理员','系统后台管理员','a:255:{i:0;s:21:\"article.Content.index\";i:1;s:19:\"article.Content.add\";i:2;s:20:\"article.Content.edit\";i:3;s:22:\"article.Content.status\";i:4;s:19:\"article.Content.del\";i:5;s:19:\"article.Class.index\";i:6;s:17:\"article.Class.add\";i:7;s:18:\"article.Class.edit\";i:8;s:20:\"article.Class.status\";i:9;s:17:\"article.Class.del\";i:10;s:18:\"mall.Content.index\";i:11;s:16:\"mall.Content.add\";i:12;s:17:\"mall.Content.edit\";i:13;s:19:\"mall.Content.status\";i:14;s:16:\"mall.Content.del\";i:15;s:16:\"mall.Class.index\";i:16;s:14:\"mall.Class.add\";i:17;s:15:\"mall.Class.edit\";i:18;s:17:\"mall.Class.status\";i:19;s:14:\"mall.Class.del\";i:20;s:16:\"mall.Order.index\";i:21;s:14:\"mall.Order.add\";i:22;s:15:\"mall.Order.edit\";i:23;s:17:\"mall.Order.status\";i:24;s:14:\"mall.Order.del\";i:25;s:23:\"member.MemberUser.index\";i:26;s:21:\"member.MemberUser.add\";i:27;s:22:\"member.MemberUser.edit\";i:28;s:24:\"member.MemberUser.status\";i:29;s:21:\"member.MemberUser.del\";i:30;s:23:\"member.MemberReal.index\";i:31;s:23:\"member.MemberReal.check\";i:32;s:23:\"member.MemberRole.index\";i:33;s:21:\"member.MemberRole.add\";i:34;s:22:\"member.MemberRole.edit\";i:35;s:21:\"member.MemberRole.del\";i:36;s:23:\"member.PayAccount.index\";i:37;s:19:\"member.PayLog.index\";i:38;s:24:\"member.PayRecharge.index\";i:39;s:20:\"member.PayCash.index\";i:40;s:20:\"member.PayCard.index\";i:41;s:18:\"member.PayCard.add\";i:42;s:19:\"member.PayCard.edit\";i:43;s:18:\"member.PayCard.del\";i:44;s:20:\"member.PayConf.index\";i:45;s:22:\"member.PayConf.setting\";i:46;s:20:\"member.PayBank.index\";i:47;s:18:\"member.PayBank.add\";i:48;s:19:\"member.PayBank.edit\";i:49;s:18:\"member.PayBank.del\";i:50;s:26:\"member.PointsAccount.index\";i:51;s:22:\"member.PointsLog.index\";i:52;s:25:\"member.MemberConfig.index\";i:53;s:23:\"member.MemberConfig.reg\";i:54;s:31:\"member.MemberConfigManage.index\";i:55;s:29:\"member.MemberConfigManage.add\";i:56;s:30:\"member.MemberConfigManage.edit\";i:57;s:32:\"member.MemberConfigManage.status\";i:58;s:29:\"member.MemberConfigManage.del\";i:59;s:25:\"member.MemberVerify.index\";i:60;s:26:\"member.MemberVerify.status\";i:61;s:23:\"member.MemberVerify.del\";i:62;s:18:\"order.Config.index\";i:63;s:25:\"order.ConfigExpress.index\";i:64;s:26:\"order.ConfigDelivery.index\";i:65;s:23:\"order.WayBillConf.index\";i:66;s:25:\"order.WayBillConf.setting\";i:67;s:18:\"order.Parcel.index\";i:68;s:18:\"order.Parcel.print\";i:69;s:19:\"order.Parcel.status\";i:70;s:16:\"order.Parcel.del\";i:71;s:20:\"order.Delivery.index\";i:72;s:20:\"order.Delivery.print\";i:73;s:21:\"order.Delivery.status\";i:74;s:18:\"order.Delivery.del\";i:75;s:19:\"order.Receipt.index\";i:76;s:20:\"order.Receipt.status\";i:77;s:17:\"order.Receipt.del\";i:78;s:18:\"order.Refund.index\";i:79;s:17:\"order.Refund.info\";i:80;s:18:\"order.Return.index\";i:81;s:17:\"order.Return.info\";i:82;s:18:\"order.Coupon.index\";i:83;s:16:\"order.Coupon.add\";i:84;s:17:\"order.Coupon.edit\";i:85;s:19:\"order.Coupon.status\";i:86;s:16:\"order.Coupon.del\";i:87;s:21:\"order.CouponLog.index\";i:88;s:19:\"order.CouponLog.del\";i:89;s:15:\"page.Page.index\";i:90;s:13:\"page.Page.add\";i:91;s:14:\"page.Page.edit\";i:92;s:16:\"page.Page.status\";i:93;s:13:\"page.Page.del\";i:94;s:17:\"sale.Config.index\";i:95;s:23:\"sale.ConfigNotice.index\";i:96;s:15:\"sale.User.index\";i:97;s:20:\"sale.UserApply.index\";i:98;s:20:\"sale.UserLevel.index\";i:99;s:16:\"sale.Order.index\";i:100;s:15:\"sale.Cash.index\";i:101;s:16:\"shop.Brand.index\";i:102;s:14:\"shop.Brand.add\";i:103;s:15:\"shop.Brand.edit\";i:104;s:17:\"shop.Brand.status\";i:105;s:14:\"shop.Brand.del\";i:106;s:15:\"shop.Spec.index\";i:107;s:13:\"shop.Spec.add\";i:108;s:14:\"shop.Spec.edit\";i:109;s:16:\"shop.Spec.status\";i:110;s:13:\"shop.Spec.del\";i:111;s:20:\"shop.SpecGroup.index\";i:112;s:18:\"shop.SpecGroup.add\";i:113;s:19:\"shop.SpecGroup.edit\";i:114;s:21:\"shop.SpecGroup.status\";i:115;s:18:\"shop.SpecGroup.del\";i:116;s:17:\"shop.Config.index\";i:117;s:15:\"shop.Help.index\";i:118;s:13:\"shop.Help.add\";i:119;s:14:\"shop.Help.edit\";i:120;s:16:\"shop.Help.status\";i:121;s:13:\"shop.Help.del\";i:122;s:20:\"shop.HelpClass.index\";i:123;s:18:\"shop.HelpClass.add\";i:124;s:19:\"shop.HelpClass.edit\";i:125;s:21:\"shop.HelpClass.status\";i:126;s:18:\"shop.HelpClass.del\";i:127;s:17:\"site.Config.index\";i:128;s:15:\"site.Config.tpl\";i:129;s:21:\"site.FormManage.index\";i:130;s:19:\"site.FormManage.add\";i:131;s:20:\"site.FormManage.edit\";i:132;s:19:\"site.FormManage.del\";i:133;s:20:\"site.FormField.index\";i:134;s:18:\"site.FormField.add\";i:135;s:19:\"site.FormField.edit\";i:136;s:18:\"site.FormField.del\";i:137;s:22:\"site.ModelManage.index\";i:138;s:20:\"site.ModelManage.add\";i:139;s:21:\"site.ModelManage.edit\";i:140;s:20:\"site.ModelManage.del\";i:141;s:21:\"site.ModelField.index\";i:142;s:19:\"site.ModelField.add\";i:143;s:20:\"site.ModelField.edit\";i:144;s:19:\"site.ModelField.del\";i:145;s:14:\"site.Nav.index\";i:146;s:12:\"site.Nav.add\";i:147;s:13:\"site.Nav.edit\";i:148;s:15:\"site.Nav.status\";i:149;s:12:\"site.Nav.del\";i:150;s:19:\"site.NavGroup.index\";i:151;s:17:\"site.NavGroup.add\";i:152;s:18:\"site.NavGroup.edit\";i:153;s:20:\"site.NavGroup.status\";i:154;s:17:\"site.NavGroup.del\";i:155;s:19:\"site.Fragment.index\";i:156;s:17:\"site.Fragment.add\";i:157;s:18:\"site.Fragment.edit\";i:158;s:20:\"site.Fragment.status\";i:159;s:17:\"site.Fragment.del\";i:160;s:19:\"site.Position.index\";i:161;s:17:\"site.Position.add\";i:162;s:18:\"site.Position.edit\";i:163;s:20:\"site.Position.status\";i:164;s:17:\"site.Position.del\";i:165;s:17:\"site.Filter.index\";i:166;s:15:\"site.Filter.add\";i:167;s:16:\"site.Filter.edit\";i:168;s:18:\"site.Filter.status\";i:169;s:15:\"site.Filter.del\";i:170;s:14:\"site.Adv.index\";i:171;s:12:\"site.Adv.add\";i:172;s:13:\"site.Adv.edit\";i:173;s:15:\"site.Adv.status\";i:174;s:12:\"site.Adv.del\";i:175;s:22:\"site.AdvPosition.index\";i:176;s:20:\"site.AdvPosition.add\";i:177;s:21:\"site.AdvPosition.edit\";i:178;s:23:\"site.AdvPosition.status\";i:179;s:20:\"site.AdvPosition.del\";i:180;s:17:\"site.Search.index\";i:181;s:15:\"site.Search.add\";i:182;s:16:\"site.Search.edit\";i:183;s:15:\"site.Search.del\";i:184;s:18:\"system.Index.index\";i:185;s:21:\"system.Index.userData\";i:186;s:19:\"system.Notice.index\";i:187;s:17:\"system.Notice.del\";i:188;s:19:\"system.Update.index\";i:189;s:19:\"system.Config.index\";i:190;s:18:\"system.Config.user\";i:191;s:18:\"system.Config.info\";i:192;s:20:\"system.Config.upload\";i:193;s:25:\"system.ConfigManage.index\";i:194;s:23:\"system.ConfigManage.add\";i:195;s:24:\"system.ConfigManage.edit\";i:196;s:26:\"system.ConfigManage.status\";i:197;s:23:\"system.ConfigManage.del\";i:198;s:17:\"system.User.index\";i:199;s:15:\"system.User.add\";i:200;s:16:\"system.User.edit\";i:201;s:18:\"system.User.status\";i:202;s:15:\"system.User.del\";i:203;s:17:\"system.Role.index\";i:204;s:15:\"system.Role.add\";i:205;s:16:\"system.Role.edit\";i:206;s:15:\"system.Role.del\";i:207;s:24:\"system.Application.index\";i:208;s:22:\"system.Application.add\";i:209;s:23:\"system.Application.edit\";i:210;s:22:\"system.Application.del\";i:211;s:16:\"tools.Send.index\";i:212;s:14:\"tools.Send.add\";i:213;s:15:\"tools.Send.info\";i:214;s:20:\"tools.SendConf.index\";i:215;s:22:\"tools.SendConf.setting\";i:216;s:19:\"tools.SendTpl.index\";i:217;s:17:\"tools.SendTpl.add\";i:218;s:18:\"tools.SendTpl.edit\";i:219;s:17:\"tools.SendTpl.del\";i:220;s:23:\"tools.SendDefault.index\";i:221;s:17:\"tools.Label.index\";i:222;s:16:\"tools.Task.index\";i:223;s:25:\"wechat.WechatConfig.index\";i:224;s:24:\"wechat.ReplyConfig.index\";i:225;s:23:\"wechat.MenuConfig.index\";i:226;s:26:\"wechat.MaterialImage.index\";i:227;s:26:\"wechat.MaterialVideo.index\";i:228;s:26:\"wechat.MaterialVoice.index\";i:229;s:25:\"wechat.MaterialNews.index\";i:230;s:22:\"wechat.ReplyText.index\";i:231;s:20:\"wechat.ReplyText.add\";i:232;s:21:\"wechat.ReplyText.edit\";i:233;s:23:\"wechat.ReplyText.status\";i:234;s:20:\"wechat.ReplyText.del\";i:235;s:23:\"wechat.ReplyImage.index\";i:236;s:21:\"wechat.ReplyImage.add\";i:237;s:22:\"wechat.ReplyImage.edit\";i:238;s:24:\"wechat.ReplyImage.status\";i:239;s:21:\"wechat.ReplyImage.del\";i:240;s:23:\"wechat.ReplyVideo.index\";i:241;s:21:\"wechat.ReplyVideo.add\";i:242;s:22:\"wechat.ReplyVideo.edit\";i:243;s:24:\"wechat.ReplyVideo.status\";i:244;s:21:\"wechat.ReplyVideo.del\";i:245;s:23:\"wechat.ReplyVoice.index\";i:246;s:21:\"wechat.ReplyVoice.add\";i:247;s:22:\"wechat.ReplyVoice.edit\";i:248;s:24:\"wechat.ReplyVoice.status\";i:249;s:21:\"wechat.ReplyVoice.del\";i:250;s:22:\"wechat.ReplyNews.index\";i:251;s:20:\"wechat.ReplyNews.add\";i:252;s:21:\"wechat.ReplyNews.edit\";i:253;s:23:\"wechat.ReplyNews.status\";i:254;s:20:\"wechat.ReplyNews.del\";}');

/*!40000 ALTER TABLE `dux_system_role` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table dux_system_statistics
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_system_statistics`;

CREATE TABLE `dux_system_statistics` (
  `stat_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `date` varchar(8) DEFAULT '',
  `web` int(10) DEFAULT '0',
  `api` int(10) DEFAULT '0',
  `mobile` int(10) DEFAULT '0',
  PRIMARY KEY (`stat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `dux_system_statistics` WRITE;
/*!40000 ALTER TABLE `dux_system_statistics` DISABLE KEYS */;

INSERT INTO `dux_system_statistics` (`stat_id`, `date`, `web`, `api`, `mobile`)
VALUES
	(1,'20171113',1,0,0),
	(2,'20171115',4,0,0);

/*!40000 ALTER TABLE `dux_system_statistics` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table dux_system_user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_system_user`;

CREATE TABLE `dux_system_user` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(10) NOT NULL DEFAULT '0',
  `nickname` varchar(20) NOT NULL,
  `username` varchar(20) NOT NULL DEFAULT '',
  `password` varchar(128) NOT NULL DEFAULT '',
  `avatar` varchar(250) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  `reg_time` int(10) DEFAULT '0',
  `login_time` int(10) DEFAULT '0',
  `login_ip` varchar(50) DEFAULT '',
  `role_ext` varchar(250) DEFAULT '',
  PRIMARY KEY (`user_id`),
  KEY `role_id` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `dux_system_user` WRITE;
/*!40000 ALTER TABLE `dux_system_user` DISABLE KEYS */;

INSERT INTO `dux_system_user` (`user_id`, `role_id`, `nickname`, `username`, `password`, `avatar`, `status`, `reg_time`, `login_time`, `login_ip`, `role_ext`)
VALUES
	(1,1,'Dux','admin','21232f297a57a5a743894a0e4a801fc3','',1,0,1498467639,'::1','');

/*!40000 ALTER TABLE `dux_system_user` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table dux_tools_send
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_tools_send`;

CREATE TABLE `dux_tools_send` (
  `send_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `receive` varchar(250) NOT NULL DEFAULT '' COMMENT '接收账号',
  `title` varchar(250) NOT NULL DEFAULT '' COMMENT '发送标题',
  `content` text NOT NULL COMMENT '发送内容',
  `param` text COMMENT '附加参数',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '发送状态',
  `type` varchar(50) NOT NULL DEFAULT '' COMMENT '发送类型',
  `start_time` int(10) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `stop_time` int(10) NOT NULL DEFAULT '0' COMMENT '结束时间',
  `remark` varchar(250) NOT NULL COMMENT '备注',
  `user_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否会员',
  PRIMARY KEY (`send_id`),
  KEY `type` (`type`),
  KEY `start_time` (`start_time`),
  KEY `stop_time` (`stop_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;



# Dump of table dux_tools_send_config
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_tools_send_config`;

CREATE TABLE `dux_tools_send_config` (
  `config_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `type` varchar(250) NOT NULL DEFAULT '' COMMENT '类型名',
  `setting` text NOT NULL COMMENT '配置内容',
  PRIMARY KEY (`config_id`),
  KEY `type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;



# Dump of table dux_tools_send_default
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_tools_send_default`;

CREATE TABLE `dux_tools_send_default` (
  `default_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `class` varchar(50) NOT NULL DEFAULT '' COMMENT '种类',
  `type` varchar(50) NOT NULL DEFAULT '' COMMENT '类型',
  `tpl` text NOT NULL COMMENT '基础模板',
  PRIMARY KEY (`default_id`),
  KEY `type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `dux_tools_send_default` WRITE;
/*!40000 ALTER TABLE `dux_tools_send_default` DISABLE KEYS */;

INSERT INTO `dux_tools_send_default` (`default_id`, `class`, `type`, `tpl`)
VALUES
	(1,'sms','yunpian',''),
	(2,'mail','almail','<div style=\"width:700px;margin:0 auto;\">\n<table align=\"center\" border=\"0\" cellspacing=\"0\" style=\"width:700px;\" width=\"700\">\n	<tbody>\n		<tr>\n			<td>\n			<div style=\"width:700px;margin:0 auto;border-bottom:1px solid #ccc;margin-bottom:30px;\">\n			<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" height=\"39\" style=\"font:12px Tahoma, Arial, 宋体;\" width=\"700\">\n				<tbody>\n					<tr>\n						<td width=\"210\">&nbsp;</td>\n					</tr>\n				</tbody>\n			</table>\n			</div>\n			[内容区域]\n\n			<div style=\"width:700px;margin:0 auto;\">\n			<div style=\"padding:10px 10px 0;border-top:1px solid #ccc;color:#747474;margin-bottom:20px;line-height:1.3em;font-size:12px;\">\n			<p>此为系统邮件，请勿回复<br />\n			请保管好您的邮箱，避免账号被他人盗用</p>\n\n			<p>[网站名称] <span style=\"border-bottom: 1px dashed rgb(204, 204, 204); z-index: 1; position: static;\">[网址]</span></p>\n			</div>\n			</div>\n			</td>\n		</tr>\n	</tbody>\n</table>\n</div>\n\n<p>&nbsp;</p>\n'),
	(3,'wechat','wechat',''),
	(4,'app','xiaomi','');

/*!40000 ALTER TABLE `dux_tools_send_default` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table dux_tools_send_tpl
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_tools_send_tpl`;

CREATE TABLE `dux_tools_send_tpl` (
  `tpl_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(250) NOT NULL DEFAULT '' COMMENT '模板标题',
  `content` text NOT NULL COMMENT '模板内容',
  `time` int(10) NOT NULL COMMENT '时间',
  PRIMARY KEY (`tpl_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table dux_tools_task
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_tools_task`;

CREATE TABLE `dux_tools_task` (
  `task_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '任务ID',
  `tag` varchar(20) NOT NULL DEFAULT '' COMMENT '标签',
  `tag_id` int(10) NOT NULL COMMENT '关联ID',
  `title` varchar(250) NOT NULL DEFAULT '' COMMENT '任务名称',
  `remark` text NOT NULL COMMENT '任务介绍',
  `status` tinyint(1) NOT NULL COMMENT '0未执行 1执行中 2已完成',
  `complete_time` int(10) NOT NULL COMMENT '完成时间',
  `create_time` int(10) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`task_id`),
  KEY `tag` (`tag`),
  KEY `tag_id` (`tag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table dux_wechat_config
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_wechat_config`;

CREATE TABLE `dux_wechat_config` (
  `config_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `description` varchar(250) NOT NULL DEFAULT '',
  PRIMARY KEY (`config_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `dux_wechat_config` WRITE;
/*!40000 ALTER TABLE `dux_wechat_config` DISABLE KEYS */;

INSERT INTO `dux_wechat_config` (`config_id`, `name`, `content`, `description`)
VALUES
	(1,'appid','','AppID'),
	(2,'secret','','AppSecret'),
	(3,'token','','Token'),
	(4,'aeskey','','EncodingAESKey');

/*!40000 ALTER TABLE `dux_wechat_config` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table dux_wechat_material_image
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_wechat_material_image`;

CREATE TABLE `dux_wechat_material_image` (
  `material_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `media_id` varchar(100) NOT NULL DEFAULT '',
  `image` varchar(250) NOT NULL DEFAULT '',
  `url` varchar(250) NOT NULL DEFAULT '',
  `time` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`material_id`),
  KEY `media_id` (`media_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table dux_wechat_material_news
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_wechat_material_news`;

CREATE TABLE `dux_wechat_material_news` (
  `material_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `media_id` varchar(100) NOT NULL DEFAULT '',
  `data` text NOT NULL,
  `time` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`material_id`),
  KEY `media_id` (`media_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table dux_wechat_material_video
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_wechat_material_video`;

CREATE TABLE `dux_wechat_material_video` (
  `material_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `media_id` varchar(100) NOT NULL DEFAULT '',
  `url` varchar(250) NOT NULL DEFAULT '',
  `title` varchar(250) NOT NULL DEFAULT '',
  `description` varchar(250) NOT NULL DEFAULT '',
  `time` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`material_id`),
  KEY `media_id` (`media_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table dux_wechat_material_voice
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_wechat_material_voice`;

CREATE TABLE `dux_wechat_material_voice` (
  `material_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `media_id` varchar(100) NOT NULL DEFAULT '',
  `title` varchar(250) NOT NULL,
  `url` varchar(250) NOT NULL DEFAULT '',
  `time` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`material_id`),
  KEY `media_id` (`media_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table dux_wechat_menu
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_wechat_menu`;

CREATE TABLE `dux_wechat_menu` (
  `menu_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) NOT NULL DEFAULT '0',
  `name` varchar(100) NOT NULL DEFAULT '',
  `key` varchar(250) NOT NULL DEFAULT '',
  `type` tinyint(1) NOT NULL,
  `sort` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`menu_id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table dux_wechat_reply
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_wechat_reply`;

CREATE TABLE `dux_wechat_reply` (
  `reply_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL DEFAULT '',
  `keywords` text,
  `match` tinyint(1) NOT NULL DEFAULT '0',
  `priority` int(10) NOT NULL DEFAULT '0',
  `type` varchar(250) NOT NULL DEFAULT '',
  PRIMARY KEY (`reply_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table dux_wechat_reply_config
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_wechat_reply_config`;

CREATE TABLE `dux_wechat_reply_config` (
  `config_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `description` varchar(250) NOT NULL DEFAULT '',
  PRIMARY KEY (`config_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `dux_wechat_reply_config` WRITE;
/*!40000 ALTER TABLE `dux_wechat_reply_config` DISABLE KEYS */;

INSERT INTO `dux_wechat_reply_config` (`config_id`, `name`, `content`, `description`)
VALUES
	(1,'msg_welcome','欢迎关注','关注消息'),
	(2,'msg_default','www.duxshop.com','默认消息');

/*!40000 ALTER TABLE `dux_wechat_reply_config` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table dux_wechat_reply_media
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_wechat_reply_media`;

CREATE TABLE `dux_wechat_reply_media` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `reply_id` int(10) NOT NULL DEFAULT '0',
  `media_id` varchar(250) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `reply_id` (`reply_id`),
  KEY `media_id` (`media_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table dux_wechat_reply_text
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dux_wechat_reply_text`;

CREATE TABLE `dux_wechat_reply_text` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `reply_id` int(10) NOT NULL DEFAULT '0',
  `content` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `reply_id` (`reply_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
