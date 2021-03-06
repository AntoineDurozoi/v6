DROP TABLE IF EXISTS `#__securitycheckpro_db`;
CREATE TABLE `#__securitycheckpro_db` (
`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
`Product` VARCHAR(35) NOT NULL,
`Type` VARCHAR(35),
`Vulnerableversion` VARCHAR(10) DEFAULT '---',
`modvulnversion` VARCHAR(2) DEFAULT '==',
`Joomlaversion` VARCHAR(10) DEFAULT 'Notdefined',
`modvulnjoomla` VARCHAR(2) DEFAULT '==',
`description` VARCHAR(90),
`class` VARCHAR(70),
`published` VARCHAR(35),
`vulnerable` VARCHAR(70),
`solution_type` VARCHAR(35) DEFAULT '???',
`solution` VARCHAR(70),
PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
INSERT INTO `#__securitycheckpro_db` (`product`,`type`,`vulnerableversion`,`modvulnversion`,`Joomlaversion`,
`modvulnjoomla`,`description`,`class`,`published`,`vulnerable`,`solution_type`,`solution`) VALUES 
('Joomla!','core','3.0.0','==','3.0.0','==','Joomla! XSS Vulnerability','Typographical error','Oct 09 2012','Joomla! 3.0.0','update','3.0.1'),
('com_fss','component','1.9.1.1447','<=','3.0.0','>=','Joomla Freestyle Support Component','SQL Injection Vulnerability','Oct 19 2012','Versions prior to 1.9.1.1447','none','No details'),
('com_commedia','component','3.1','<=','3.0.0','>=','Joomla Commedia Component','SQL Injection Vulnerability','Oct 19 2012','Versions prior to 3.1','update','3.2'),
('Joomla!','core','3.0.1','<=','3.0.1','<=','Joomla! Core Clickjacking Vulnerability','Inadequate protection','Nov 08 2012','Joomla! 3.0.1 and 3.0.0 versions','update','3.0.2'),
('com_jnews','component','7.9.1','<','3.0.0','>=','Joomla jNews Component','Arbitrary File Creation Vulnerability','Nov 19 2012','Versions prior to 7.9.1','update','7.9.1'),
('com_bch','component','---','==','3.0.0','>=','Joomla Bch Component','Shell Upload Vulnerability','Dec 26 2012','Not especificed','none','No details'),
('com_aclassif','component','---','==','3.0.0','>=','Joomla Aclassif Component','Cross Site Scripting Vulnerability','Dec 26 2012','Not especificed','none','No details'),
('com_rsfiles','component','1.0.0 Rev 11','==','3.0.0','>=','Joomla RSFiles! Component','SQL Injection Vulnerability','Mar 19 2013','Version 1.0.0 Rev 11','update','1.0.0 Rev 12'),
('Joomla!','core','3.0.2','<=','3.0.2','<=','Joomla! XSS Vulnerability','Inadequate filtering','Apr 24 2013','Joomla! version 3.0.2 and earlier 3.0.x versions','update','3.1.0'),
('Joomla!','core','3.0.2','<=','3.0.2','<=','Joomla! DOS Vulnerability','Object unserialize method','Apr 24 2013','Joomla! version 3.0.2 and earlier 3.0.x versions','update','3.1.0'),
('Joomla!','core','3.0.2','<=','3.0.0','>=','Joomla! XSS Vulnerability','Inadequate filtering','Apr 24 2013','Joomla! version 3.0.2 and earlier 3.0.x versions','update','3.1.0'),
('Joomla!','core','3.0.2','<=','3.0.0','>=','Joomla! Information Disclosure Vulnerability','Inadequate permission checking','Apr 24 2013','Joomla! version 3.0.2 and earlier 3.0.x versions','update','3.1.0'),
('Joomla!','core','3.0.2','<=','3.0.0','>=','Joomla! XSS Vulnerability','Use of old version of Flash-based file uploader','Apr 24 2013','Joomla! version 3.0.2 and earlier 3.0.x versions','update','3.1.0'),
('Joomla!','core','3.0.2','<=','3.0.0','>=','Joomla! Privilege Escalation Vulnerability','Inadequate permission checking','Apr 24 2013','Joomla! version 3.0.2 and earlier 3.0.x versions','update','3.1.0'),
('Joomla!','core','3.0.2','<=','3.0.0','>=','Joomla! XSS Vulnerability','Inadequate filtering','Apr 24 2013','Joomla! version 3.0.2 and earlier 3.0.x versions','update','3.1.0'),
('com_jnews','component','8.0.1','<=','3.0.0','>=','Joomla Jnews Component','Cross Site Scripting Vulnerability','May 14 2013','Version 8.0.1 an earlier','update','8.1.x'),
('com_attachments','component','3.1.1','<','3.0.0','>=','Joomla Com_Attachments Component','Arbitrary File Upload Vulnerability','Jul 09 2013','Versions prior to 3.1.1','update','3.1.1'),
('System - Google Maps','plugin','3.1','<','3.0.0','>=','Joomla Googlemaps Plugin','XSS/XML Injection/Path Disclosure/DoS Vulnerabilities','Jul 17 2013','Version 3.1 and maybe above','update','3.1'),
('System - Google Maps','plugin','3.2','<=','3.0.0','>=','Joomla Googlemaps Plugin','XSS/DoS Vulnerabilities','Jul 26 2013','Version 3.2','update','3.x'),
('Joomla!','core','3.1.4','<=','3.0.0','>=','Joomla! Unauthorised Uploads Vulnerability','Inadequate filtering','Jul 31 2013','Joomla! 3.1.4 and earlier 3.x versions','update','3.1.5'),
('com_sectionex','component','2.5.96','<=','3.0.0','>=','Joomla SectionEx Component','SQL Injection Vulnerability','Aug 05 2013','Version 2.5.96 and maybe earlier','update','2.5.104'),
('com_joomsport','component','2.0.1','<','3.0.0','>=','Joomla joomsport Component','Multiple Vulnerabilities','Aug 20 2013','Versions prior to 2.0.1','update','2.0.1'),
('Joomla!','core','3.1.5','<=','3.0.0','>=','Joomla! XSS Vulnerability','Inadequate filtering','Nov 06 2013','Joomla! 3.1.5 and all earlier 3.x versions','update','3.2'),
('Joomla!','core','3.1.5','<=','3.0.0','>=','Joomla! XSS Vulnerability','Inadequate filtering','Nov 06 2013','Joomla! 3.1.5 and all earlier 3.x versions','update','3.2'),
('Joomla!','core','3.1.5','<=','3.0.0','>=','Joomla! XSS Vulnerability','Inadequate filtering','Nov 06 2013','Joomla! 3.1.5 and all earlier 3.x versions','update','3.2'),
('com_flexicontent','component','2.1.3','<=','3.0.0','>=','Joomla Flexicontent Component','Remote Code Execution Vulnerability','Dec 08 2013','Version 2.1.3 and earlier','none','No details'),
('com_mijosearch','component','2.0.1','<=','3.0.0','>=','Joomla MijoSearch Component','Cross Site Scripting/Exposure Vulnerability','Dec 16 2013','Version 2.0.1 and maybe earlier','update','2.0.4');

DROP TABLE IF EXISTS `#__securitycheckpro_sessions`;
CREATE TABLE IF NOT EXISTS `#__securitycheckpro_sessions` (
`userid` INT(4) UNSIGNED NOT NULL,
`session_id` VARCHAR(200) NOT NULL,
`username` VARCHAR(150) NOT NULL,
`ip` BIGINT NOT NULL,
`user_agent` VARCHAR(300) NOT NULL,
PRIMARY KEY (`userid`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;