DROP TABLE IF EXISTS g2ex_user;
CREATE TABLE g2ex_user (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `created_at` int(10) unsigned NOT NULL,
  `updated_at` int(10) unsigned NOT NULL,
  `status` tinyint(1) unsigned NOT NULL default 8,
  `role` tinyint(1) unsigned NOT NULL default 0,
  `score` mediumint(8) unsigned NOT NULL default 0,
  `username` char(16) NOT NULL,
  `email` char(50) NOT NULL,
  `password_hash` char(80) NOT NULL,
  `auth_key` char(32) NOT NULL,
  `avatar` char(50) NOT NULL default 'avatar/0_{size}.png',
  `comment` char(20) NOT NULL default '',
   `reg` tinyint(1) unsigned NOT NULL default 0,
  PRIMARY KEY id(`id`),
  UNIQUE KEY username(`username`),
  UNIQUE KEY email(`email`),
  KEY status_id(`status`, `id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS g2ex_user_info;
CREATE TABLE g2ex_user_info (
  `user_id` mediumint(8) unsigned NOT NULL auto_increment,
  `last_login_at` int(10) unsigned NOT NULL,
  `last_login_ip` int(10) unsigned NOT NULL,
  `reg_ip` int(10) unsigned NOT NULL,
  `topic_count` mediumint(8) unsigned NOT NULL default 0,
  `comment_count` mediumint(8) unsigned NOT NULL default 0,
  `favorite_count` smallint(6) unsigned NOT NULL default 0,
  `favorite_node_count` smallint(6) unsigned NOT NULL default 0,
  `favorite_topic_count` smallint(6) unsigned NOT NULL default 0,
  `favorite_user_count` smallint(6) unsigned NOT NULL default 0,
  `website` varchar(100) NOT NULL default '',
  `about` varchar(255) NOT NULL default '',
  `location` varchar(100)  NOT NULL default '',
  `tagline` varchar(100)  NOT NULL default '',
  `topic_close` tinyint(1) unsigned NOT NULL default 0,
  `comment_close` tinyint(1) unsigned NOT NULL default 0,
  `top_close` tinyint(1) unsigned NOT NULL default 0,
  `css_close` tinyint(1) unsigned NOT NULL default 1,
  `email_close` tinyint(1) unsigned NOT NULL default 1,
  `mynodes` tinyint(1) unsigned NOT NULL default 0,
  `mycss` text  NOT NULL ,
  `qq` varchar(15)  NOT NULL default '',
  `favorite_vote_count` smallint(6) unsigned NOT NULL default 0,
  PRIMARY KEY user_id(`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS g2ex_token;
CREATE TABLE g2ex_token (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `created_at` int(10) unsigned NOT NULL,
  `updated_at` int(10) unsigned NOT NULL,
  `type` tinyint(1) unsigned NOT NULL,
  `status` tinyint(1) unsigned NOT NULL default 0,
  `user_id` mediumint(8) unsigned NOT NULL,
  `expires` int(10) unsigned NOT NULL,
  `token` varchar(50) NOT NULL COLLATE utf8_bin,
  `ext` varchar(200) NOT NULL default '',
  PRIMARY KEY id(`id`),
  UNIQUE KEY token(`token`),
  KEY user_type_expires(`user_id`, `type`, `expires`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS g2ex_siteinfo;
CREATE TABLE g2ex_siteinfo (
  `id` smallint(6) unsigned NOT NULL auto_increment,
  `nodes` smallint(6) unsigned NOT NULL default 0,
  `users` mediumint(8) unsigned NOT NULL default 0,
  `topics` mediumint(8) unsigned NOT NULL default 0,
  `comments` int(10) unsigned NOT NULL default 0,
  PRIMARY KEY id(`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO g2ex_siteinfo VALUES(1, 1, 0, 0, 0);

DROP TABLE IF EXISTS g2ex_node;
CREATE TABLE g2ex_node (
  `id` smallint(6) unsigned NOT NULL auto_increment,
  `created_at` int(10) unsigned NOT NULL,
  `updated_at` int(10) unsigned NOT NULL,
  `topic_count` mediumint(8) unsigned NOT NULL default 0,
  `favorite_count` smallint(6) unsigned NOT NULL default 0,
  `access_auth` tinyint(1) unsigned NOT NULL default 0,
  `invisible` tinyint(1) unsigned NOT NULL default 0,
  `name` varchar(20) NOT NULL,
  `ename` varchar(20) NOT NULL,
  `about` varchar(255) NOT NULL default '',
  `index` tinyint(1) unsigned NOT NULL default 0,
  `icon` char(100)  NOT NULL default 'static/node/default.png',
  `image` text  NOT NULL,
  `editor` varchar(20)  NOT NULL default 'SmdEditor',
  PRIMARY KEY id(`id`),
  UNIQUE KEY name(`name`),
  UNIQUE KEY ename(`ename`),
  KEY topic_id(`topic_count`, `id`),
  KEY invisible(`invisible`, `id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO g2ex_node VALUES(1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP(), 0, 0, 0, 0, 'По умолчанию', 'default', '','0','static/node/default.png','','SmdEditor');

DROP TABLE IF EXISTS g2ex_navi;
CREATE TABLE g2ex_navi (
  `id` smallint(6) unsigned NOT NULL auto_increment,
  `type` tinyint(1) unsigned NOT NULL default 0,
  `sortid` tinyint(1) unsigned NOT NULL default 50,
  `name` varchar(20) NOT NULL,
  `ename` varchar(20) NOT NULL,
  PRIMARY KEY id(`id`),
  UNIQUE KEY name(`type`, `name`),
  UNIQUE KEY ename(`type`, `ename`),
  KEY type_sort(`type`,`sortid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS g2ex_navi_node;
CREATE TABLE g2ex_navi_node (
  `id` int(10) unsigned NOT NULL auto_increment,
  `navi_id` smallint(6) unsigned NOT NULL,
  `node_id` smallint(6) unsigned NOT NULL,
  `visible` tinyint(1) unsigned NOT NULL default 0,
  `sortid` tinyint(1) unsigned NOT NULL default 50,
  PRIMARY KEY id(`id`),
  UNIQUE KEY navi_node(`navi_id`,`node_id`),
  KEY navi_node_sort(`navi_id`,`node_id`,`sortid`),
  KEY navi_node_visible_sort(`navi_id`,`node_id`,`visible`,`sortid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS g2ex_topic;
CREATE TABLE g2ex_topic (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `created_at` int(10) unsigned NOT NULL,
  `updated_at` int(10) unsigned NOT NULL,
  `replied_at` int(10) unsigned NOT NULL,
  `node_id` smallint(6) unsigned NOT NULL,
  `user_id` mediumint(8) unsigned NOT NULL,
  `reply_id` mediumint(8) unsigned NOT NULL default 0,
  `alltop` tinyint(1) unsigned NOT NULL default 0,
  `top` tinyint(1) unsigned NOT NULL default 0,
  `invisible` tinyint(1) unsigned NOT NULL default 0,
  `closed` tinyint(1) unsigned NOT NULL default 0,
  `access_auth` tinyint(1) unsigned NOT NULL default 0,
  `comment_closed` tinyint(1) unsigned NOT NULL default 0,
  `comment_count` mediumint(8) unsigned NOT NULL default 0,
  `favorite_count` smallint(6) unsigned NOT NULL default 0,
  `good` smallint(6) unsigned NOT NULL default 0,
  `views` mediumint(8) unsigned NOT NULL default 0,
  `title` char(120) NOT NULL,
  `tags` char(60) NOT NULL default '',
  `vote_count` smallint(6) unsigned NOT NULL default 0 ,
  `star` tinyint(1) unsigned NOT NULL default 0,
  `editor` varchar(20)  NOT NULL default 'SmdEditor',
  PRIMARY KEY id(`id`),
  KEY alllist(`node_id`, `alltop`, `replied_at`, `id`),
  KEY nodelist(`node_id`, `top`, `replied_at`, `id`),
  KEY hottopics(`node_id`, `created_at`, `comment_count`, `replied_at`),
  KEY updated(`updated_at`),
  KEY node_updated(`node_id`,`updated_at`),
  KEY allcount(`node_id`, `id`),
  KEY user_id(`user_id`,`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS g2ex_topic_content;
CREATE TABLE g2ex_topic_content (
  `topic_id` mediumint(8) unsigned NOT NULL auto_increment,
  `content` text NOT NULL,
  PRIMARY KEY topic_id(`topic_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS g2ex_comment;
CREATE TABLE g2ex_comment (
  `id` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  `updated_at` int(10) unsigned NOT NULL,
  `user_id` mediumint(8) unsigned NOT NULL,
  `topic_id` mediumint(8) unsigned NOT NULL,
  `position` mediumint(8) unsigned NOT NULL auto_increment,
  `invisible` tinyint(1) unsigned NOT NULL default 0,
  `good` smallint(6) unsigned NOT NULL default 0,
  `vote_count` smallint(6) unsigned NOT NULL default 0,
  `content` text NOT NULL,
  PRIMARY KEY topic_position(`topic_id`, `position`),
  UNIQUE KEY id(`id`),
  KEY user_id(`user_id`,`id`),
  KEY topic_updated(`topic_id`, `updated_at`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS g2ex_commentid;
CREATE TABLE g2ex_commentid (
  id int(10) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS g2ex_page;
CREATE TABLE g2ex_page (
  `id` smallint(6) unsigned NOT NULL auto_increment,
  `sortid` tinyint(1) unsigned NOT NULL default 50,
  `name` varchar(20) NOT NULL,
  `ename` varchar(20) NOT NULL,
  `url` varchar(100) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY id(`id`),
  UNIQUE KEY id(`id`),
  KEY adkey(`sortid`, `id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS g2ex_notice;
CREATE TABLE `g2ex_notice` (
  `id` int(10) NOT NULL auto_increment,
  `created_at` int(10) unsigned NOT NULL,
  `updated_at` int(10) unsigned NOT NULL,
  `type` tinyint(1) unsigned NOT NULL,
  `status` tinyint(1) unsigned NOT NULL default 0,
  `target_id` mediumint(8) unsigned NOT NULL,
  `source_id` mediumint(8) unsigned NOT NULL,
  `topic_id` mediumint(8) unsigned NOT NULL default 0,
  `position` mediumint(8) unsigned NOT NULL default 0,
  `notice_count` smallint(6) unsigned NOT NULL default 0,
  `msg` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY target_status_id(`target_id`,`status`, `id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS g2ex_tag;
CREATE TABLE g2ex_tag (
  `id` int(10) unsigned NOT NULL auto_increment,
  `created_at` int(10) unsigned NOT NULL,
  `updated_at` int(10) unsigned NOT NULL,
  `name` varchar(20) NOT NULL,
  `topic_count` smallint(6) unsigned NOT NULL default 0,
  PRIMARY KEY id(`id`),
  UNIQUE KEY name(`name`),
  KEY updated(`updated_at`, `id`),
  KEY topic_count(`topic_count`, `id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS g2ex_tag_topic;
CREATE TABLE g2ex_tag_topic (
  `id` int(10) unsigned NOT NULL auto_increment,
  `tag_id` int(10) unsigned NOT NULL,
  `topic_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY id(`id`),
  UNIQUE KEY tag_topic(`tag_id`,`topic_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS g2ex_link;
CREATE TABLE g2ex_link (
  `id` smallint(6) unsigned NOT NULL auto_increment,
  `sortid` tinyint(1) unsigned NOT NULL default 50,
  `name` varchar(20) NOT NULL,
  `url` varchar(100) NOT NULL,
  PRIMARY KEY id(`id`),
  KEY sort_id(`sortid`,`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO g2ex_link VALUES(1, 0, 'Ссылка 1', 'http://simpleforum.org/');
INSERT INTO g2ex_link VALUES(2, 0, 'Ссылка 2', 'http://g2ex.com');


DROP TABLE IF EXISTS g2ex_setting;
CREATE TABLE g2ex_setting (
  `id` smallint(6) unsigned NOT NULL auto_increment,
  `sortid` tinyint(1) unsigned NOT NULL default 50,
  `block` varchar(10) NOT NULL default '',
  `label` varchar(50) NOT NULL default '',
  `type` varchar(10) NOT NULL default 'text',
  `key` varchar(50) NOT NULL,
  `value_type` varchar(10) NOT NULL default 'text',
  `value` text NOT NULL,
  `option` text NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY id(`id`),
  UNIQUE KEY `key`(`key`),
  KEY block_sort_id(`block`,`sortid`,`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO g2ex_setting(`sortid`, `block`, `label`, `type`, `key`, `value_type`, `value`, `description`, `option`) VALUES
(1,'info', 'Название сайта','text', 'site_name','text', 'G2EX', 'учитывая мобильный просмотр, название сайта не должно быть слишком длинным.', ''),
(2,'info', 'Слоган','text', 'slogan','text', 'Это сообщество единомышленников.', 'не более 70 знаков', ''),
(3,'info', 'Описание сайта','textarea', 'description','text', 'Сообщество по интересам и увлекательному общению', 'для поисковых систем, не более 150 знаков', ''),
(4,'info', 'Лицензия ICP', 'text', 'icp','text', '', 'например ICP №0603xx', ''),
(5,'info', 'Email сайта', 'text', 'admin_email','text', '', 'для получения отчета об ошибках от пользователей', ''),
(1,'manage', 'Сайт закрыт', 'select','offline','integer', '0', 'по умолчанию: 0(открыт)', '["0(открыт)","1(закрыт)"]'),
(2,'manage', 'Сообщение', 'textarea','offline_msg','text', 'Приносим свои извинения, но сайт временно закрыт на технические работы', 'причина закрытия сайта', ''),
(3,'manage', 'Доступ на сайт', 'select','access_auth','integer', '0', 'по умолчанию: 0 (все), если 1, то только пользователи (для внутренних сообщений)', '["0(все)","1(пользователи)"]'),
(4,'manage', 'Проверка email', 'select','email_verify','integer', '0', 'рекомендуется 1 (подтверждать)，если 0, то без проверки', '["0(без проверки)","1(подтверждать)"]'),
(5,'manage', 'Проверка', 'select','admin_verify','integer', '0', 'проверять вручную регистрацию пользователей', '["0(отключено)","1(проверять)"]'),
(6,'manage', 'Регистрация', 'select','close_register', 'integer', '0','по умолчанию: 0 (открыта), 1 - закрыта, но можно через соцсети', '["0(открыта)","1(закрыта)","2(по инвайтам)"]'),
(7,'manage', 'Фильтр логинов', 'text','username_filter', 'text', '','запрещенные логины через запятую, например:  admin,webmaster,admin*', ''),
(8,'manage', 'Каптча', 'select','captcha_enabled', 'integer', '0','проверочный код при регистрации и авторизации', '["0(отключено)","1(включено)"]'),
(9,'manage', 'Автоссылки', 'select','autolink', 'integer', '0','автоотправка URL контента и ссылок', '["0(нет)","1(да)"]'),
(10,'manage', 'Фильт автоссылок', 'textarea','autolink_filter', 'text', '','без http://, домен или поддомен, каждый URL с новой строки', '["0(нет)","1(да)"]'),
(11,'manage', 'Шаблон', 'text','theme', 'text', 'g2ex','шаблон сайта, расположен в каталоге themes/', ''),
(12,'manage', 'Моб. шаблон', 'text','theme_mobile', 'text', 'mobile','шаблон сайта для мобильных устройств, расположен в каталоге themes/', ''),
(13,'manage', 'Группы', 'textarea','groups', 'text', '1500 USER\n3000 BRONZE\n5000 SILVER\n8000 GOLD\n15000 PLATINUM\n100000000 AD','формат строки: максимальная интеграция в систему и название группы', ''),
(1,'extend', 'meta-теги в заголовке head', 'textarea','head_meta', 'text', '','например:<br/>&lt;meta name="yandex-verification" content="6da0zdxxxxxxxx" /&gt;', ''),
(2,'extend', 'Код в footer', 'textarea','analytics_code', 'text', '','например код статистики google или yandex', ''),
(3,'extend', 'Ссылки в footer', 'textarea','footer_links','text', '', 'ссылки формата http://url<br />например:  http://yandex.ru/', ''),
(4,'extend', 'Временная зона', 'select','timezone','text', 'Europe/Moscow', 'Обратите особое внимание при изменении!', ''),
(5,'extend', 'Редактор', 'select','editor','text', 'WysibbEditor', 'рекомендуется Wysibb (BBCode), SimpleMarkdown', '{"WysibbEditor":"Wysibb (BBCode)"}'),
(1,'cache', 'Кэширование', 'select','cache_enabled','integer', '0', 'По умолчанию: 0 (выкл)', '["0(выкл)","1(вкл)"]'),
(2,'cache', 'Время кэша (мин)', 'text','cache_time','integer', '10', 'По умолчанию 10 минут', ''),
(3,'cache', 'Тип кэша', 'select','cache_type', 'text', 'file', 'По умолчанию file', '{"file":"file","apc":"apc","memcache":"memcache","memcached":"memcached"}'),
(4,'cache', 'Cache-сервер', 'textarea','cache_servers', 'text','', 'Тип кэша устанавливается в MemCache. Формат: IP сервер порт вес, например: 127.0.0.1 11211 100 или 127.0.0.2 11211 200', ''),
(1,'auth', 'Авторизация', 'select','auth_enabled', 'integer','0', 'авторизция через соцсети, по умолчанию отключена', '["0(нет)","1(да)"]'),
(2,'auth', 'Авторизация', 'textarea','auth_setting', 'text','[]', '', ''),
(1,'other', 'На главной', 'text', 'index_pagesize', 'integer', '20','сколько выводить на главной сообщений, по умолчанию 20', ''),
(2,'other', 'На странице', 'text','list_pagesize', 'integer', '20','сколько выводить на странице сообщений, по умолчанию 20', ''),
(3,'other', 'Комментарии', 'text','comment_pagesize', 'integer', '20','сколько выводить коммеентариев на странице, по умолчанию 20', ''),
(4,'other', 'ТОП топиков', 'text','hot_topic_num', 'integer', '10','популярные топики, по умолчанию 10', ''),
(5,'other', 'ТОП темы', 'text','hot_node_num', 'integer', '20','популярные темы, по умолчанию 20', ''),
(6,'other', 'Топик (мин)', 'text','edit_space', 'integer', '30','через сколько после публикации нельзя будет править топик, по умолчанию 30', ''),
(7,'other', 'Спам (топик)', 'text','topic_space', 'integer', '30','интервал размещения топиков, по умолчанию 30', ''),
(8,'other', 'Спам (коммент.)', 'text','comment_space', 'integer', '20','интервал размещения комментариев, по умолчанию 20', ''),
(9,'other', 'Каталог static', 'text','alias_static','text', '', 'по умолчанию /static в корне сайта，можно использовать как CDN: http://static.site.ru', ''),
(10,'other', 'Каталог avatar', 'text','alias_avatar','text', '', 'по умолчанию /avatar в корне сайта，можно использовать как CDN: http://avatar.site.ru', ''),
(11,'other', 'Каталог upload', 'text','alias_upload','text', '', 'по умолчанию /upload в корне сайта，можно использовать как CDN: http://upload.site.ru', ''),
(1,'mailer', 'Сервер SMTP', 'text','mailer_host', 'text', '','', ''),
(2,'mailer', 'Порт SMTP', 'text','mailer_port', 'integer', '','', ''),
(3,'mailer', 'Шифрование', 'text','mailer_encryption', 'text', '','например ssl,tls и т.д., без шифрования - оставьте поле пустым', ''),
(4,'mailer', 'Логин SMTP', 'text','mailer_username', 'text', '','полный адрес электронной почты', ''),
(5,'mailer', 'Пароль SMTP', 'password','mailer_password', 'text', '','пароль почтового ящика', ''),
(1,'upload', 'Аватары', 'select','upload_avatar','text', 'local', 'По умолчанию: загружать на сайт', '{"local":"на сайт","remote":"удаленно"}'),
(2,'upload', 'Файлы', 'select','upload_file','text', 'disable', 'По умолчанию: загружать на сайт', '{"disable":"отключено","local":"на сайт","remote":"удаленно"}'),
(3,'upload', 'Топики', 'text','upload_file_regday','integer', '30', 'через сколько дней после регистрации можно загружать файлы в топики', ''),
(3,'upload', 'Темы', 'text','upload_file_topicnum','integer', '20', 'через сколько дней после регистрации можно загружать файлы в темы', ''),
(4,'upload', 'Загрузка CDN', 'select','upload_remote', 'text','', '', '[]');

DROP TABLE IF EXISTS g2ex_favorite;
CREATE TABLE `g2ex_favorite` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `type` tinyint(1) unsigned NOT NULL default 0,
  `source_id` mediumint(8) unsigned NOT NULL default 0,
  `target_id` mediumint(8) unsigned NOT NULL default 0,
  PRIMARY KEY  (`id`),
  UNIQUE KEY source_type_target(`source_id`, `type`, `target_id`),
  KEY type_target(`type`, `target_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS g2ex_auth;
CREATE TABLE g2ex_auth (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `user_id` mediumint(8) unsigned NOT NULL default 0,
  `source` varchar(20) NOT NULL,
  `source_id` varchar(100) NOT NULL,
  PRIMARY KEY id(id),
  UNIQUE KEY user_source(`user_id`, `source`),
  UNIQUE KEY source_source_id(`source`, `source_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS g2ex_history;
CREATE TABLE `g2ex_history` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `user_id` mediumint(8) unsigned NOT NULL default 0,
  `type` tinyint(1) unsigned NOT NULL default 0,
  `action` tinyint(1) unsigned NOT NULL,
  `action_time` int(10) unsigned NOT NULL,
  `target` int(10) unsigned NOT NULL default 0,
  `ext` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY user_type_id(`user_id`, `type`, `id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS g2ex_ad;
CREATE TABLE g2ex_ad (
  `id` smallint(6) unsigned NOT NULL auto_increment,
  `created_at` int(10) unsigned NOT NULL,
  `expires` date NOT NULL,
  `location` tinyint(1) unsigned NOT NULL,
  `invisible` smallint(6) unsigned NOT NULL default 0,
  `node_id` smallint(6) unsigned NOT NULL default 1,
  `sortid` tinyint(1) unsigned NOT NULL default 50,
  `name` varchar(20) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY id(`id`),
  UNIQUE KEY id(`id`),
  KEY adkey(`location`,`node_id`, `expires`, `sortid`, `id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
(1, 0, 'WysibbEditor', 'Wysibb (BBcode)', 'Wysibb (BBcode)', 'SimpleForum', 'http://simpleforum.org', '1.0', '', '', ''),
(2, 0, 'SmdEditor', 'Simple Markdown', 'Simple Markdown', 'SimpleForum', 'http://simpleforum.org', '1.0', '', '', ''),
(3, 0, 'KeywordFilter', '关键字过滤', '违规词过滤', 'SimpleForum', 'http://simpleforum.org', '1.0', '[{\"label\":\"\\u8fc7\\u6ee4\\u5173\\u952e\\u5b57\",\"key\":\"keywords\",\"type\":\"textarea\",\"value_type\":\"text\",\"value\":\"\",\"description\":\"\\u4e00\\u884c\\u4e00\\u4e2a\\u8fc7\\u6ee4\\u8bcd\"}]', '{\"keywords\":\"\\u6027\\u5427\\r\\n\\u8f6e\\u5978\\r\\n\\u809b\\u4ea4\\r\\n\\u88f8\\u804a\\r\\n\\u8ff7\\u5978\\r\\n\\u6deb\\u6c34\\r\\n\\u62bd\\u63d2\\r\\n\\u624b\\u673a\\u5bc6\\u7801\\u7834\\r\\n\\u6deb\\u59bb\\r\\n\\u731b\\u63d2\\r\\n\\u7a74\\u7a74\\r\\n\\u8214\\u9634\\r\\n\\u79c1\\u670d\\r\\n\\u76d1\\u542c\\r\\n\\u6210\\u4eba\\u7535\\u5f71\\r\\n\\u6210\\u4eba\\u5c0f\\u8bf4\\r\\n\\u5f3a\\u5978\\r\\n\\u5c0f\\u7a74\\r\\n\\u67aa\\u5305\\r\\n\\u9ec4\\u8272\\u4e66\\u520a\\r\\n\\u9ec4\\u8272\\u7535\\u5f71\\r\\n\\u9ec4\\u8272\\u5c0f\\u8bf4\\r\\n\\u4e8c\\u5976\\r\\n\\u4e00\\u591c\\u60c5\\r\\n\\u591a\\u591c\\u60c5\\r\\n\\u901a\\u8bdd\\u8bb0\\u5f55\\u67e5\\u8be2\\r\\n\\u517c\\u804c\\u59b9\\u59b9\\r\\n\\u517c\\u804c\\u7f8e\\u5973\\r\\n\\u67aa\\u652f\\r\\n\\u624b\\u67aa\\r\\n\\u5b50\\u5f39\\r\\n\\u6bd2\\u54c1\\r\\nK\\u7c89\\r\\n\\u88f8\\u4f53\\r\\n\\u55e8\\u836f\\r\\n\\u4e09\\u632b\\u4ed1\\r\\n\\u4e09\\u5511\\u4ed1\\r\\n\\u4ee3\\u8003\\r\\n\\u66ff\\u8003\\r\\n\\u8003\\u8bd5\\u7b54\\u6848\\r\\n\\u53d1\\u7968\\r\\n\\u4ee3\\u5f00\\r\\n\\u4ee3\\u529e\\r\\n\\u4ee3\\u6ce8\\r\\n\\u589e\\u503c\\u7a0e\\r\\n\\u5047\\u5e01\\r\\n\\u5047\\u94b1\\r\\n\\u5904\\u5973\\u5730\\r\\n\\u53e3\\u4ea4\\r\\n\\u6027\\u4ea4\\r\\n\\u505a\\u7231\\r\\n\\u88f8\\u7167\\r\\n\\u767c\\u7968\\r\\n\\u653f\\u5e9c\\u5b98\\u5458\\r\\n\\u79fb\\u52a8\\u901a\\u8bdd\\u6e05\\u5355\\r\\n\\u8054\\u901a\\u901a\\u8bdd\\u6e05\\u5355\\r\\n\\u5c0f\\u7075\\u901a\\u901a\\u8bdd\\u6e05\\u5355\\r\\n\\u5ea7\\u673a\\u901a\\u8bdd\\u6e05\\u5355\\r\\n\\u670d\\u52a1\\u5bc6\\u7801\\u5b9a\\u4f4d\\r\\n\\u5bc6\\u7801\\u7834\\u89e3\\r\\n\\u673a\\u4e0a\\u5206\\u5668\\r\\n\\u4e0a\\u6d77\\u8d70\\u79c1\\r\\n\\u65e0\\u7801\\r\\n\\u5185\\u5c04\\r\\n\\u7fa4\\u4f53\\u4e8b\\u4ef6\\r\\n\\u8bc1\\u4e66\\u529e\\u7406\\r\\n\\u8bc1\\u4ef6\\u529e\\u7406\\r\\n\\u7687\\u51a0\\u5f00\\u6237\\r\\n\\u542c\\u5668\\r\\n\\u6267\\u4e1a\\u533b\\u5e08\\r\\n\\u4ee3\\u7406\\u7533\\u62a5\\u804c\\u79f0\\r\\n\\u7acb\\u4fe1\\u4ee3\\u7406\\r\\n\\u590d\\u5236\\u624b\\u673a\\r\\n\\u7687\\u51a0\\u570b\\u969b\\r\\n\\u8d44\\u683c\\u8bc1\\u4e66\\r\\n\\u529e\\u7406\\u771f\\u5b9e\\r\\n\\u60c5\\u611f\\u966a\\u62a4\\r\\n\\u7fa4\\u4f53\\u6d41\\u8840\\r\\n\\u7a0e\\u52a1\\u516c\\u53f8\\r\\n\\u5404\\u79cdZJ\\r\\n\\u6027\\u7231\\r\\n\\u4ee3\\u7406\\u5ba1\\u62a5\\r\\n\\u8d22\\u7a0e\\u6709\\u9650\\r\\n\\u7f8e\\u5973\\u62a4\\u966a\\r\\n\\u4ee3\\u7406\\u62a5\\u5173\\r\\n\\u75c5\\u6bd2\\u8425\\u9500\\r\\n\\u9999\\u70df\\u6279\\u53d1\\r\\n\\u5973\\u5b69\\u4e0a\\u95e8\\r\\n\\u7f8e\\u5973\\u8131\\u8863\\r\\n\\u4f20\\u5947sf\\r\\n\\u6d41\\u8840\\u4e8b\\u4ef6\\r\\n\\u529e\\u8bc1\\r\\n\\u8d22\\u7a0e\\u4ee3\\u7406\\r\\n\\u4e13\\u4e1a\\u7a0e\\u52a1\\r\\n\\u59b9\\u7684\\u670d\\u52a1\\r\\n\\u7f8e\\u5973\\u4e0a\\u95e8\\r\\n\\u5973\\u4e0a\\u95e8\\r\\n\\u67e5\\u624b\\u673a\\r\\n\\u5927\\u6e38\\u884c\\r\\nAV\\u5973\\r\\n\\u5317\\u4eac\\u5f02\\r\\n\\u5317\\u4eac\\u6d0b\\u599e\\r\\n\\u536b\\u661f\\u8ffd\\u8e2a\\r\\n\\u53f7\\u7801\\u5b9a\\u4f4d\\r\\n\\u7f8e\\u5973\\u6309\\u6469\\r\\n\\u7f8e\\u5973\\u517c\\u804c\\r\\n\\u5357\\u4eac630\\r\\n630\\u8f66\\u7978\\r\\n\\u7fa4\\u4f53\\u6027\\u4e8b\\u4ef6\\r\\n\\u730e\\u67aa\\r\\n\\u519b\\u7528\\u624b\\r\\n\\u624b\\u67aa\\r\\n\\u7f8e\\u56fd\\u79c3\\u9e70\\r\\n\\u5355\\u53cc\\u7ba1\\u730e\\r\\n\\u8ff7\\u60c5\\r\\n\\u8ff7\\u9b42\\r\\n\\u653f\\u5e9c\\u9886\\u5bfc\\r\\n\\u6bdb\\u6cfd\\u4e1c\\u590d\\u6d3b\\r\\n\\u4e2d\\u5c71\\u9886\\u5bfc\\r\\n\\u6bdb\\u4e3b\\u5e2d\\u590d\\u6d3b\\r\\n27\\u519b\\r\\n\\u514b\\u9686\\u624b\\u673a\\r\\n\\u5356\\u6deb\\r\\n\\u4e94\\u56db\\u8fd0\\u52a8\\r\\n\\u516d\\u56db\\u8fd0\\u52a8\\r\\n54\\u8fd0\\u52a8\\r\\n64\\u8fd0\\u52a8\\r\\n\\u81ea\\u7531\\u95e8\\r\\n\\u8273\\u7167\\u95e8\\r\\n\\u8273\\u95e8\\u7167\\r\\n\\u8d4c\\u535a\\r\\n\\u8001\\u5a46\\u6bd4\\u5212\\u8001\\u516c\\u731c\\r\\n\\u674e\\u548f\\u90fd\\u7b11\\u8db4\\u4e0b\\r\\n\\u6253\\u4eba\\u4e8b\\u4ef6\\r\\n\\u672c\\u94a2\\u9886\\u5bfc\\r\\n\\u67aa\\u51fa\\u552e\\r\\n\\u7406\\u771f\\u6bd5\\u4e1a\\r\\n\\u8d44\\u683c\\u6b63\\r\\n\\u4e09\\u966a\\u5973\\u81ea\\u5f3a\\u6b4c\\r\\n\\u4e09\\u966a\\u5973\\r\\n\\u591f\\u683c\\u5f53\\u9886\\u5bfc\\r\\n\\u8003\\u8bd5\\u4ee3\\r\\n\\u9886\\u5bfc\\u7a77\\u5149\\u86cb\\r\\n\\u9886\\u5bfc\\u8d2a\\u6c61\\u72af\"}', '{\"afterParse\":\"keywordFilter\"}'),
(4, 0, 'QiniuUpload', '七牛上传', '将文件上传到七牛云', 'SimpleForum', 'http://simpleforum.org/', '1.0', '[{\"label\":\"\\u7a7a\\u95f4\\u540d\",\"key\":\"bucketName\",\"type\":\"text\",\"value_type\":\"text\",\"value\":\"\",\"description\":\"\"},{\"label\":\"access key\",\"key\":\"accessKey\",\"type\":\"text\",\"value_type\":\"text\",\"value\":\"\",\"description\":\"\"},{\"label\":\"secret key\",\"key\":\"secretKey\",\"type\":\"text\",\"value_type\":\"text\",\"value\":\"\",\"description\":\"\"},{\"label\":\"\\u7a7a\\u95f4URL\",\"key\":\"url\",\"type\":\"text\",\"value_type\":\"text\",\"value\":\"\",\"description\":\"\"}]', '{\"bucketName\":\"\",\"accessKey\":\"\",\"secretKey\":\"\",\"url\":\"\"}', '');
