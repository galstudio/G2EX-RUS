ALTER TABLE `g2ex_topic` ADD COLUMN `access_auth` tinyint(1) unsigned NOT NULL default 0 AFTER `closed`;
ALTER TABLE `g2ex_topic` ADD COLUMN  `good` smallint(6) unsigned NOT NULL default 0 AFTER `favorite_count`;
OPTIMIZE TABLE `g2ex_topic`;

ALTER TABLE `g2ex_comment` ADD COLUMN `good` smallint(6) unsigned NOT NULL default 0 AFTER `invisible`;
ALTER TABLE `g2ex_comment` ADD COLUMN `vote_count` smallint(6) unsigned NOT NULL default 0 AFTER `good`;
OPTIMIZE TABLE `g2ex_comment`;

DROP TABLE IF EXISTS g2ex_plugin;
CREATE TABLE g2ex_plugin (
  `id` smallint(6) unsigned NOT NULL auto_increment,
  `status` tinyint(1) unsigned NOT NULL default 0,
  `pid` varchar(20) NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(255) NOT NULL default '',
  `author` varchar(20) NOT NULL default '',
  `url` varchar(255) NOT NULL default '',
  `version` varchar(10) NOT NULL default '',
  `config` text NOT NULL,
  `settings` text NOT NULL,
  `events` text NOT NULL,
  PRIMARY KEY id(`id`),
  UNIQUE KEY `pid`(`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


INSERT INTO `g2ex_plugin` (`id`, `status`, `pid`, `name`, `description`, `author`, `url`, `version`, `config`, `settings`, `events`) VALUES
(1, 0, 'WysibbEditor', 'Wysibb编辑器(BBcode)', 'Wysibb编辑器(BBcode)', 'SimpleForum', 'http://simpleforum.org', '1.0', '', '', ''),
(2, 0, 'SmdEditor', 'Simple Markdown编辑器', 'Simple Markdown编辑器', 'SimpleForum', 'http://simpleforum.org', '1.0', '', '', ''),
(3, 0, 'KeywordFilter', '关键字过滤', '违规词过滤', 'SimpleForum', 'http://simpleforum.org', '1.0', '[{\"label\":\"\\u8fc7\\u6ee4\\u5173\\u952e\\u5b57\",\"key\":\"keywords\",\"type\":\"textarea\",\"value_type\":\"text\",\"value\":\"\",\"description\":\"\\u4e00\\u884c\\u4e00\\u4e2a\\u8fc7\\u6ee4\\u8bcd\"}]', '{\"keywords\":\"\\u6027\\u5427\\r\\n\\u8f6e\\u5978\\r\\n\\u809b\\u4ea4\\r\\n\\u88f8\\u804a\\r\\n\\u8ff7\\u5978\\r\\n\\u6deb\\u6c34\\r\\n\\u62bd\\u63d2\\r\\n\\u624b\\u673a\\u5bc6\\u7801\\u7834\\r\\n\\u6deb\\u59bb\\r\\n\\u731b\\u63d2\\r\\n\\u7a74\\u7a74\\r\\n\\u8214\\u9634\\r\\n\\u79c1\\u670d\\r\\n\\u76d1\\u542c\\r\\n\\u6210\\u4eba\\u7535\\u5f71\\r\\n\\u6210\\u4eba\\u5c0f\\u8bf4\\r\\n\\u5f3a\\u5978\\r\\n\\u5c0f\\u7a74\\r\\n\\u67aa\\u5305\\r\\n\\u9ec4\\u8272\\u4e66\\u520a\\r\\n\\u9ec4\\u8272\\u7535\\u5f71\\r\\n\\u9ec4\\u8272\\u5c0f\\u8bf4\\r\\n\\u4e8c\\u5976\\r\\n\\u4e00\\u591c\\u60c5\\r\\n\\u591a\\u591c\\u60c5\\r\\n\\u901a\\u8bdd\\u8bb0\\u5f55\\u67e5\\u8be2\\r\\n\\u517c\\u804c\\u59b9\\u59b9\\r\\n\\u517c\\u804c\\u7f8e\\u5973\\r\\n\\u67aa\\u652f\\r\\n\\u624b\\u67aa\\r\\n\\u5b50\\u5f39\\r\\n\\u6bd2\\u54c1\\r\\nK\\u7c89\\r\\n\\u88f8\\u4f53\\r\\n\\u55e8\\u836f\\r\\n\\u4e09\\u632b\\u4ed1\\r\\n\\u4e09\\u5511\\u4ed1\\r\\n\\u4ee3\\u8003\\r\\n\\u66ff\\u8003\\r\\n\\u8003\\u8bd5\\u7b54\\u6848\\r\\n\\u53d1\\u7968\\r\\n\\u4ee3\\u5f00\\r\\n\\u4ee3\\u529e\\r\\n\\u4ee3\\u6ce8\\r\\n\\u589e\\u503c\\u7a0e\\r\\n\\u5047\\u5e01\\r\\n\\u5047\\u94b1\\r\\n\\u5904\\u5973\\u5730\\r\\n\\u53e3\\u4ea4\\r\\n\\u6027\\u4ea4\\r\\n\\u505a\\u7231\\r\\n\\u88f8\\u7167\\r\\n\\u767c\\u7968\\r\\n\\u653f\\u5e9c\\u5b98\\u5458\\r\\n\\u79fb\\u52a8\\u901a\\u8bdd\\u6e05\\u5355\\r\\n\\u8054\\u901a\\u901a\\u8bdd\\u6e05\\u5355\\r\\n\\u5c0f\\u7075\\u901a\\u901a\\u8bdd\\u6e05\\u5355\\r\\n\\u5ea7\\u673a\\u901a\\u8bdd\\u6e05\\u5355\\r\\n\\u670d\\u52a1\\u5bc6\\u7801\\u5b9a\\u4f4d\\r\\n\\u5bc6\\u7801\\u7834\\u89e3\\r\\n\\u673a\\u4e0a\\u5206\\u5668\\r\\n\\u4e0a\\u6d77\\u8d70\\u79c1\\r\\n\\u65e0\\u7801\\r\\n\\u5185\\u5c04\\r\\n\\u7fa4\\u4f53\\u4e8b\\u4ef6\\r\\n\\u8bc1\\u4e66\\u529e\\u7406\\r\\n\\u8bc1\\u4ef6\\u529e\\u7406\\r\\n\\u7687\\u51a0\\u5f00\\u6237\\r\\n\\u542c\\u5668\\r\\n\\u6267\\u4e1a\\u533b\\u5e08\\r\\n\\u4ee3\\u7406\\u7533\\u62a5\\u804c\\u79f0\\r\\n\\u7acb\\u4fe1\\u4ee3\\u7406\\r\\n\\u590d\\u5236\\u624b\\u673a\\r\\n\\u7687\\u51a0\\u570b\\u969b\\r\\n\\u8d44\\u683c\\u8bc1\\u4e66\\r\\n\\u529e\\u7406\\u771f\\u5b9e\\r\\n\\u60c5\\u611f\\u966a\\u62a4\\r\\n\\u7fa4\\u4f53\\u6d41\\u8840\\r\\n\\u7a0e\\u52a1\\u516c\\u53f8\\r\\n\\u5404\\u79cdZJ\\r\\n\\u6027\\u7231\\r\\n\\u4ee3\\u7406\\u5ba1\\u62a5\\r\\n\\u8d22\\u7a0e\\u6709\\u9650\\r\\n\\u7f8e\\u5973\\u62a4\\u966a\\r\\n\\u4ee3\\u7406\\u62a5\\u5173\\r\\n\\u75c5\\u6bd2\\u8425\\u9500\\r\\n\\u9999\\u70df\\u6279\\u53d1\\r\\n\\u5973\\u5b69\\u4e0a\\u95e8\\r\\n\\u7f8e\\u5973\\u8131\\u8863\\r\\n\\u4f20\\u5947sf\\r\\n\\u6d41\\u8840\\u4e8b\\u4ef6\\r\\n\\u529e\\u8bc1\\r\\n\\u8d22\\u7a0e\\u4ee3\\u7406\\r\\n\\u4e13\\u4e1a\\u7a0e\\u52a1\\r\\n\\u59b9\\u7684\\u670d\\u52a1\\r\\n\\u7f8e\\u5973\\u4e0a\\u95e8\\r\\n\\u5973\\u4e0a\\u95e8\\r\\n\\u67e5\\u624b\\u673a\\r\\n\\u5927\\u6e38\\u884c\\r\\nAV\\u5973\\r\\n\\u5317\\u4eac\\u5f02\\r\\n\\u5317\\u4eac\\u6d0b\\u599e\\r\\n\\u536b\\u661f\\u8ffd\\u8e2a\\r\\n\\u53f7\\u7801\\u5b9a\\u4f4d\\r\\n\\u7f8e\\u5973\\u6309\\u6469\\r\\n\\u7f8e\\u5973\\u517c\\u804c\\r\\n\\u5357\\u4eac630\\r\\n630\\u8f66\\u7978\\r\\n\\u7fa4\\u4f53\\u6027\\u4e8b\\u4ef6\\r\\n\\u730e\\u67aa\\r\\n\\u519b\\u7528\\u624b\\r\\n\\u624b\\u67aa\\r\\n\\u7f8e\\u56fd\\u79c3\\u9e70\\r\\n\\u5355\\u53cc\\u7ba1\\u730e\\r\\n\\u8ff7\\u60c5\\r\\n\\u8ff7\\u9b42\\r\\n\\u653f\\u5e9c\\u9886\\u5bfc\\r\\n\\u6bdb\\u6cfd\\u4e1c\\u590d\\u6d3b\\r\\n\\u4e2d\\u5c71\\u9886\\u5bfc\\r\\n\\u6bdb\\u4e3b\\u5e2d\\u590d\\u6d3b\\r\\n27\\u519b\\r\\n\\u514b\\u9686\\u624b\\u673a\\r\\n\\u5356\\u6deb\\r\\n\\u4e94\\u56db\\u8fd0\\u52a8\\r\\n\\u516d\\u56db\\u8fd0\\u52a8\\r\\n54\\u8fd0\\u52a8\\r\\n64\\u8fd0\\u52a8\\r\\n\\u81ea\\u7531\\u95e8\\r\\n\\u8273\\u7167\\u95e8\\r\\n\\u8273\\u95e8\\u7167\\r\\n\\u8d4c\\u535a\\r\\n\\u8001\\u5a46\\u6bd4\\u5212\\u8001\\u516c\\u731c\\r\\n\\u674e\\u548f\\u90fd\\u7b11\\u8db4\\u4e0b\\r\\n\\u6253\\u4eba\\u4e8b\\u4ef6\\r\\n\\u672c\\u94a2\\u9886\\u5bfc\\r\\n\\u67aa\\u51fa\\u552e\\r\\n\\u7406\\u771f\\u6bd5\\u4e1a\\r\\n\\u8d44\\u683c\\u6b63\\r\\n\\u4e09\\u966a\\u5973\\u81ea\\u5f3a\\u6b4c\\r\\n\\u4e09\\u966a\\u5973\\r\\n\\u591f\\u683c\\u5f53\\u9886\\u5bfc\\r\\n\\u8003\\u8bd5\\u4ee3\\r\\n\\u9886\\u5bfc\\u7a77\\u5149\\u86cb\\r\\n\\u9886\\u5bfc\\u8d2a\\u6c61\\u72af\"}', '{\"afterParse\":\"keywordFilter\"}'),
(4, 0, 'QiniuUpload', '七牛上传', '将文件上传到七牛云', 'SimpleForum', 'http://simpleforum.org/', '1.0', '[{\"label\":\"\\u7a7a\\u95f4\\u540d\",\"key\":\"bucketName\",\"type\":\"text\",\"value_type\":\"text\",\"value\":\"\",\"description\":\"\"},{\"label\":\"access key\",\"key\":\"accessKey\",\"type\":\"text\",\"value_type\":\"text\",\"value\":\"\",\"description\":\"\"},{\"label\":\"secret key\",\"key\":\"secretKey\",\"type\":\"text\",\"value_type\":\"text\",\"value\":\"\",\"description\":\"\"},{\"label\":\"\\u7a7a\\u95f4URL\",\"key\":\"url\",\"type\":\"text\",\"value_type\":\"text\",\"value\":\"\",\"description\":\"\"}]', '{\"bucketName\":\"\",\"accessKey\":\"\",\"secretKey\":\"\",\"url\":\"\"}', '');

INSERT INTO g2ex_setting(`sortid`, `block`, `label`, `type`, `key`, `value_type`, `value`, `description`, `option`) VALUES
(2,'auth', '第三方登录设定', 'textarea','auth_setting', 'text','[]', '', '');

update g2ex_setting set `value`='WysibbEditor', `option`='{"WysibbEditor":"Wysibb编辑器(BBCode)","SmdEditor":"SimpleMarkdown编辑器"}'  where `key`='editor' and `value`='wysibb';
update g2ex_setting set `value`='SmdEditor', `option`='{"WysibbEditor":"Wysibb编辑器(BBCode)","SmdEditor":"SimpleMarkdown编辑器"}'  where `key`='editor' and `value`='smd';
update g2ex_setting set `value`='', `option`='[]'  where `key`='upload_remote';
delete from g2ex_setting where `block` in ('auth.qq', 'auth.weibo');
delete from g2ex_setting where `key` in ('upload_remote_info', 'upload_remote_url');

/*g2ex 升级变更 */
ALTER TABLE g2ex_node MODIFY COLUMN editor varchar(20) ;
ALTER TABLE g2ex_topic MODIFY COLUMN editor varchar(20) ;
ALTER TABLE g2ex_ad ADD COLUMN `invisible` smallint(6) unsigned NOT NULL default 0 AFTER `location`;
ALTER TABLE g2ex_node DROP COLUMN `ad`;
ALTER TABLE g2ex_node DROP COLUMN `ad_close`;
ALTER TABLE g2ex_node DROP COLUMN `role`;
UPDATE g2ex_history set action ='52' where action ='100';
UPDATE g2ex_history set ext= REPLACE( ext, '}',',"msg":""}') where action=52;
UPDATE g2ex_node set editor ='SmdEditor' where editor ='smd';
UPDATE g2ex_node set editor ='WysibbEditor' where editor ='wysibb';
UPDATE g2ex_topic set editor ='SmdEditor' where editor ='smd';
UPDATE g2ex_topic set editor ='WysibbEditor' where editor ='wysibb';
UPDATE g2ex_ad set node_id ='1' where node_id ='0';
UPDATE g2ex_user_info set email_close ='1' where email_close ='0';