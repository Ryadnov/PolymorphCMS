-- phpMyAdmin SQL Dump
-- version 3.2.3
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Авг 16 2011 г., 13:18
-- Версия сервера: 5.1.40
-- Версия PHP: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- БД: `cms2`
--

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `inherit_templates` tinyint(1) DEFAULT '1',
  `inherit_settings` tinyint(1) DEFAULT '1',
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_keywords` text,
  `meta_descr` text,
  `is_empty` tinyint(1) DEFAULT '0',
  `alias` varchar(50) DEFAULT NULL,
  `published` tinyint(1) DEFAULT '0',
  `type` varchar(255) DEFAULT NULL,
  `lft` int(10) unsigned NOT NULL,
  `rgt` int(10) unsigned NOT NULL,
  `level` smallint(5) unsigned NOT NULL,
  `updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `lft` (`lft`),
  KEY `rgt` (`rgt`),
  KEY `level` (`level`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=141 ;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`id`, `title`, `inherit_templates`, `inherit_settings`, `meta_title`, `meta_keywords`, `meta_descr`, `is_empty`, `alias`, `published`, `type`, `lft`, `rgt`, `level`, `updated`) VALUES
(1, 'root', 0, 0, NULL, NULL, NULL, 0, 'root', 1, NULL, 1, 54, 1, '2011-08-10 18:31:53'),
(2, 'Создание и продвижение сайта', 1, 1, NULL, NULL, NULL, 0, 'create', 1, 'Page', 12, 13, 4, '2011-08-14 08:44:50'),
(5, 'Хостинг для сайта и регистрация доменного имени', 1, 1, NULL, NULL, NULL, 0, 'hosting', 1, 'Page', 16, 17, 4, '2011-08-14 08:44:51'),
(6, 'Создание мультимедия презентации', 1, 1, NULL, NULL, NULL, 0, 'multimedia', 1, 'Page', 14, 15, 4, '2011-08-14 16:39:10'),
(59, 'Главная', 1, 1, NULL, NULL, NULL, 0, 'index', 1, 'Page', 3, 4, 3, '2011-08-14 08:44:52'),
(22, 'Партнеры', 1, 1, NULL, NULL, NULL, 0, 'partners', 0, 'Record', 33, 34, 3, '2011-08-14 08:45:10'),
(21, 'Портфолио', 1, 1, NULL, NULL, NULL, 1, 'portfolio', 1, 'Record', 23, 30, 3, '2011-08-14 08:45:10'),
(77, 'main', 1, 1, NULL, NULL, NULL, 0, 'main', 0, 'Page', 2, 41, 2, '2011-08-14 08:44:53'),
(78, 'errors', 1, 1, NULL, NULL, NULL, 0, 'errors', 1, 'Page', 42, 45, 2, '2011-08-14 08:44:53'),
(79, 'not_found', 1, 1, NULL, NULL, NULL, 0, 'not_found', 1, 'Page', 43, 44, 3, '2011-08-14 08:44:54'),
(80, 'Услуги', 1, 1, NULL, NULL, NULL, 1, 'services', 0, 'Page', 11, 22, 3, '2011-08-14 08:44:55'),
(81, 'Новости', 1, 1, NULL, NULL, NULL, 0, 'news', 1, 'Record', 31, 32, 3, '2011-08-14 08:45:09'),
(84, 'Текст на индексе', 1, 1, NULL, NULL, NULL, 0, 'index_text', 0, 'Page', 46, 47, 2, '2011-08-14 08:44:55'),
(88, 'Клиенты', 1, 1, NULL, NULL, NULL, 0, 'clients', 0, 'Record', 35, 36, 3, '2011-08-14 08:45:07'),
(89, 'Публикации', 1, 1, NULL, NULL, NULL, 0, 'publics', 0, 'Record', 37, 38, 3, '2011-08-14 08:45:07'),
(128, 'Контакты', 1, 1, NULL, NULL, NULL, 0, 'contacts', 0, 'Page', 39, 40, 3, '2011-08-14 08:44:56'),
(129, 'О компании', 1, 1, NULL, NULL, NULL, 0, 'about', 0, 'Page', 5, 10, 3, '2011-08-14 08:44:57'),
(130, 'История, деятельность и команда', 1, 1, NULL, NULL, NULL, 0, 'history-work-and-team', 1, 'Page', 6, 7, 4, '2011-08-14 08:44:57'),
(131, 'Вакансии', 1, 1, NULL, NULL, NULL, 0, 'vacancy', 1, 'Page', 8, 9, 4, '2011-08-14 08:44:57'),
(132, 'Дизайн и верстка полиграфической продукции', 1, 1, NULL, NULL, NULL, 0, 'polygraph-design-and-makeup', 1, 'Page', 18, 19, 4, '2011-08-14 08:44:57'),
(133, 'Создание фирменного стиля', 1, 1, NULL, NULL, NULL, 0, 'corporate-identity', 1, 'Page', 20, 21, 4, '2011-08-14 08:44:58'),
(135, 'Дизайны и интерфейсы', 1, 1, NULL, NULL, NULL, 0, 'design-and-interfaces', 1, 'Record', 24, 25, 4, '2011-08-14 08:45:03'),
(136, 'Мультимедия презентации', 1, 1, NULL, NULL, NULL, 0, 'multimedia-presentations', 1, 'Record', 26, 27, 4, '2011-08-14 08:45:05'),
(137, 'Графический дизайн и печатная продукция', 1, 1, NULL, NULL, NULL, 0, 'graphic-design-and-printed', 1, 'Record', 28, 29, 4, '2011-08-14 08:45:05'),
(138, 'Карта сайта', 1, 1, NULL, NULL, NULL, 0, 'map', 1, 'Page', 49, 50, 3, '2011-08-14 08:44:59'),
(139, 'Другое ', 1, 1, NULL, NULL, NULL, 1, 'other', 1, 'Page', 48, 51, 2, '2011-08-14 08:45:00'),
(140, 'Модуль Users', 1, 1, NULL, NULL, NULL, 0, 'users', 1, 'Page', 52, 53, 2, '2011-08-14 08:45:00');

-- --------------------------------------------------------

--
-- Структура таблицы `cities`
--

CREATE TABLE IF NOT EXISTS `cities` (
  `city_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`city_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `cities`
--

INSERT INTO `cities` (`city_id`, `name`) VALUES
(1, 'Астана'),
(3, 'Актау');

-- --------------------------------------------------------

--
-- Структура таблицы `config`
--

CREATE TABLE IF NOT EXISTS `config` (
  `key` varchar(100) COLLATE utf8_bin NOT NULL,
  `value` text COLLATE utf8_bin,
  PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Дамп данных таблицы `config`
--

INSERT INTO `config` (`key`, `value`) VALUES
('emailToRegistraiton', 0x737570706f7274406461736f2e6972),
('siteTitle', 0x6461736f2e6972),
('recentCommentCount', 0x35),
('recentPostCount', 0x35),
('recentQuestionsCount', 0x35),
('siteDescr', 0x6461736f2e6972),
('rssImgUrl', 0x696d616765732f7273735f696d672e706e67),
('baseUrl', 0x687474703a2f2f6461736f2e69722f);

-- --------------------------------------------------------

--
-- Структура таблицы `image_gallery`
--

CREATE TABLE IF NOT EXISTS `image_gallery` (
  `image_id` int(11) NOT NULL AUTO_INCREMENT,
  `model_id` int(11) DEFAULT NULL,
  `type_id` varchar(50) DEFAULT NULL,
  `src` varchar(255) DEFAULT NULL,
  `title` text,
  `descr` text,
  `created` timestamp NULL DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  PRIMARY KEY (`image_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=69 ;

--
-- Дамп данных таблицы `image_gallery`
--

INSERT INTO `image_gallery` (`image_id`, `model_id`, `type_id`, `src`, `title`, `descr`, `created`, `sort`) VALUES
(62, 13, NULL, '5566_def_58.jpg', NULL, 'Сиськи', '2011-06-22 12:32:56', 18),
(59, 13, NULL, 'pr172.jpg', NULL, NULL, '2011-06-22 12:30:28', 15),
(49, 14, NULL, '6c15006e391e0410712d86a2f965a8b0.jpg', NULL, NULL, '2011-06-21 16:40:12', 5),
(50, 14, NULL, '7a92ee791c8d093fdca93b7e02093a67.jpg', NULL, NULL, '2011-06-21 16:40:17', 6),
(51, 14, NULL, '12c69b44e1cdb67fa025df540a4e6894_full.jpg', NULL, NULL, '2011-06-21 16:40:25', 7),
(52, 14, NULL, '4690b5661378af0afd3fe65569255006_full.jpg', NULL, NULL, '2011-06-21 16:40:34', 8),
(60, 13, NULL, 'b272.jpg', NULL, NULL, '2011-06-22 12:30:33', 16),
(61, 13, NULL, '120429424830_7.jpg', NULL, NULL, '2011-06-22 12:32:16', 17),
(55, 13, NULL, 'b2.jpg', NULL, 'sdfsdf', '2011-06-22 11:41:01', 11),
(56, 13, NULL, 'img169.jpg', NULL, NULL, '2011-06-22 11:43:57', 12),
(57, 13, NULL, 'img147.jpg', NULL, NULL, '2011-06-22 11:49:34', 13),
(64, 13, NULL, 'a_e062f811f.jpg', NULL, NULL, '2011-06-22 12:34:55', 20),
(65, 13, NULL, 'a_e062f8f67.jpg', NULL, NULL, '2011-06-22 12:36:52', 21),
(68, 13, NULL, 'a_e062f8f34.jpg', NULL, NULL, '2011-06-22 12:42:14', 23);

-- --------------------------------------------------------

--
-- Структура таблицы `lookup`
--

CREATE TABLE IF NOT EXISTS `lookup` (
  `lookup_id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(50) NOT NULL,
  `code` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `position` int(11) NOT NULL,
  PRIMARY KEY (`lookup_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=44 ;

--
-- Дамп данных таблицы `lookup`
--

INSERT INTO `lookup` (`lookup_id`, `type`, `code`, `name`, `position`) VALUES
(18, 'deleteCategoryVariant', '1', 'Скопировать в другую категорию', 0),
(19, 'deleteCategoryVariant', '0', 'Удалить', 1),
(7, 'gender', '0', 'Женский', 0),
(8, 'gender', '1', 'Мужской', 1),
(12, 'role', 'admin', 'Администратор', 3),
(13, 'MPublished', '0', 'Не Опубликован', 0),
(14, 'MPublished', '1', 'Опубликован', 1),
(40, 'FPublished', '0', 'Не Опубликована', 0),
(41, 'FPublished', '1', 'Опубликована', 1),
(42, 'NPublished', '0', 'Не Опубликовано', 0),
(43, 'NPublished', '1', 'Опубликовано', 1),
(38, 'YesNo', '0', 'Нет', 0),
(39, 'YesNo', '1', 'Да', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `plugins`
--

CREATE TABLE IF NOT EXISTS `plugins` (
  `plugin_id` int(11) NOT NULL AUTO_INCREMENT,
  `json_settings` text,
  `published` tinyint(1) DEFAULT '0',
  `class` varchar(50) DEFAULT NULL,
  `title` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`plugin_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Дамп данных таблицы `plugins`
--

INSERT INTO `plugins` (`plugin_id`, `json_settings`, `published`, `class`, `title`) VALUES
(1, '{}', 1, 'MainContent', 'Главный контент'),
(2, '{"alias":"main"}', 1, 'Menu', 'Менюшка'),
(10, '{}', 1, 'Dummy', 'Текст'),
(11, '{}', 1, 'ImageGallery', 'Галлерея Изображений');

-- --------------------------------------------------------

--
-- Структура таблицы `profiles`
--

CREATE TABLE IF NOT EXISTS `profiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `raiting` int(11) DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL,
  `gender` tinyint(1) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `icq` int(11) DEFAULT NULL,
  `skype` varchar(255) DEFAULT NULL,
  `blog_id` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `family` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `site` varchar(255) DEFAULT NULL,
  `about` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=56 ;

--
-- Дамп данных таблицы `profiles`
--

INSERT INTO `profiles` (`id`, `user_id`, `raiting`, `company`, `gender`, `birthday`, `icq`, `skype`, `blog_id`, `name`, `family`, `phone`, `site`, `about`) VALUES
(12, 12, NULL, '2', 1, '2011-07-30', NULL, 'двыо', NULL, 'Alexey', 'Sharov', '', '', ''),
(53, 53, NULL, '', 1, '0000-00-00', NULL, '', NULL, 'ir  Имя', 'ir Фамилия', '', '', ''),
(55, 56, NULL, '', 1, '0000-00-00', NULL, '', NULL, 'admin', 'admin', '', '', '');

-- --------------------------------------------------------

--
-- Структура таблицы `profiles_fields`
--

CREATE TABLE IF NOT EXISTS `profiles_fields` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `required` tinyint(2) NOT NULL,
  `position` tinyint(5) NOT NULL,
  `visible` tinyint(1) NOT NULL,
  `varname` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `field_type` varchar(255) DEFAULT NULL,
  `field_size` tinyint(5) DEFAULT NULL,
  `field_size_min` tinyint(5) DEFAULT NULL,
  `error_message` varchar(255) DEFAULT NULL,
  `default` varchar(255) DEFAULT NULL,
  `widget` varchar(255) DEFAULT NULL,
  `widgetparams` text,
  `range` text,
  `other_validator` varchar(255) DEFAULT NULL,
  `match` varchar(255) DEFAULT NULL,
  `hidden_value` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Дамп данных таблицы `profiles_fields`
--

INSERT INTO `profiles_fields` (`id`, `required`, `position`, `visible`, `varname`, `title`, `field_type`, `field_size`, `field_size_min`, `error_message`, `default`, `widget`, `widgetparams`, `range`, `other_validator`, `match`, `hidden_value`) VALUES
(1, 0, 0, 1, 'company', 'Компания', NULL, 100, 0, 'company_error', '', NULL, NULL, NULL, NULL, NULL, NULL),
(2, 0, 1, 1, 'gender', 'Пол', NULL, 1, 0, 'gender_error', '0', NULL, NULL, '1==мужской;0==женский', NULL, NULL, NULL),
(3, 0, 2, 1, 'birthday', 'День рождения', 'DATE', NULL, NULL, 'birthday_error', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 0, 3, 1, 'icq', 'icq', NULL, 50, NULL, 'icq_error', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 0, 4, 1, 'skype', 'skype', NULL, 50, NULL, 'skype_error', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 1, 5, 1, 'name', 'Имя', NULL, 50, NULL, 'name_error', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 1, 6, 1, 'family', 'Фамилия', NULL, 50, NULL, 'family_error', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 0, 7, 1, 'phone', 'Телефон', NULL, 50, NULL, 'phone_error', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 0, 8, 1, 'site', 'Сайт', NULL, 50, NULL, 'site_error', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 0, 9, 1, 'about', 'О себе', 'TEXT', NULL, NULL, 'about_error', NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `records`
--

CREATE TABLE IF NOT EXISTS `records` (
  `record_id` int(11) NOT NULL AUTO_INCREMENT,
  `sort` int(11) DEFAULT NULL,
  `alias` varchar(50) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `descr` text,
  `month` int(11) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `published` tinyint(1) DEFAULT '0',
  `index_text` text,
  `second_title` text,
  `title` text,
  `sidebar_text` text,
  `portfolio_work_type_id` int(11) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `activity` int(11) DEFAULT NULL,
  `text` text,
  `result_url` varchar(255) DEFAULT NULL,
  `result_title` varchar(255) DEFAULT NULL,
  `service` text,
  `icon` varchar(255) DEFAULT NULL,
  `icon_big` varchar(255) DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL,
  `updaetd` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `created` datetime NOT NULL,
  PRIMARY KEY (`record_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Дамп данных таблицы `records`
--

INSERT INTO `records` (`record_id`, `sort`, `alias`, `category_id`, `descr`, `month`, `year`, `published`, `index_text`, `second_title`, `title`, `sidebar_text`, `portfolio_work_type_id`, `city_id`, `activity`, `text`, `result_url`, `result_title`, `service`, `icon`, `icon_big`, `img`, `updaetd`, `created`) VALUES
(1, 2, 'companyPi', 135, NULL, 9, 2011, 1, '<p>Мы писали, рисовали и верстали, забивали - наши пальчики устали!</p>', 'Сайт зафигачили для ПиКомпании!', 'Сайт "{more}Компании Пи...{/more}"', '<p>xxx: ТИИИИИИИИИХА В ЛЕСУ<br />xxx: только не спииииит совааааааа<br />xxx: ставит сова на видюху дрова, вот и не спииит соваааа</p>', NULL, 1, NULL, '<p>Узнаете места? Верно, теперь Панорамы улиц добрались до Кирова, Иркутска, Курска, Ярославля и даже известного в Украине туристического центра &ndash; Каменца-Подольского.<img style="display: block; margin-left: auto; margin-right: auto;" src="../../images/imgdat/04a0ff12ef2caa6df46cb1d8282_prev.jpg" alt="" width="590" height="425" /><br /><br />Теперь можно разглядеть со всех сторон церковь Иоанна Предтечи в Ярославле (известную не только благодаря своей красоте, но и изображению на тысячерублевой купюре) и пройтись мимо церкви св.Георгия или Триумфальной арки в Курске. Погрузиться в атмосферу позапрошлого века на перекрестке улиц Дрелевского и Большевиков в Кирове, а после прогуляться по пешеходной улице в Иркутске, совмещающей архитектуру 19 века и современные магазины. И даже заглянуть внутрь старинной крепости в Каменце-Подольском!<br /><br />Куда отправиться дальше &ndash; решать вам. Выбирайте интересные места для прогулок с помощью списка городов.</p>', 'pi.ru', 'www.pi.ru', NULL, 'b153.jpg', 'pr1.jpg', NULL, '2011-07-09 13:36:08', '0000-00-00 00:00:00'),
(14, 3, 'weqwe', 135, NULL, 11, 2009, 1, '<p>sdfsdfs</p>', 'asdsad', 'sdfdsfsdf', '<p>sdfsdfsdfsdf</p>', 1, 1, NULL, '<p>sdfdsf</p>', 'fsdfsd', '342423', NULL, NULL, NULL, NULL, '2011-08-13 21:35:07', '2011-06-21 16:19:26'),
(15, 4, NULL, 135, NULL, 10, 2005, 1, '<p>Я рад рассказать о том, что Microsoft в сотрудничестве с Joyent предоставит ресурсы для портирования Node на Windows. Как вы уже могли слышать ранее в этом году, мы начали работу над нативным портом на Windows &mdash; с целью использовать высокопроизводительный IOCP API.<br /><br /> Эта работа требует в значительной степени модифицировать базовую структуру и мы очень рады тому, что теперь получаем официальное руководство и инженерные ресурсы от Microsoft. От Rackspace так же выделено время Bert Belder для выполнения этой работы.<br /><br /> Результатом будет официальный бинарный релиз node.exe опубликованный на nodejs.org, который будет работать на Windows Azure и других версиях Windows начиная с Windows Server 2003.</p>', 'Сайт для финпола', 'Сайт (линк)Финпола(/линк)', '<p>Перевод статьи Влада Савова (Vlad Savov) из блога Engadget. Это его авторская колонка и подразумевает личное мнение журналиста.</p>', 2, 1, NULL, '<p>После ивента Google Inside Search на прошлой неделе старший вице-президент Google по поиску Алан Юстас немного рассказал о том, что главный исполнительный директор Ларри Пейдж думает о поиске.<br /><br /> Вот некоторые долгосрочные цели:<br />Ответы, а не просто результаты. Пейдж недоволен тем, что Google по запросу предоставляет только набор разрозненных ссылок, и хочет, чтобы поисковая система предоставляла более организованные и последовательные результаты. Например, по запросу &laquo;какой лучший способ создать скафандр?&raquo; Google могла бы показывать набор обучающих видео, а затем компании, которые могут предоставить материалы, инженерные ресурсы и так далее для выполнения задачи.</p>', 'finpol.kz', 'finpol.kz', NULL, 'b1.jpg', 'shit.jpg', 'IMG_116664.JPG', '2011-07-05 17:43:27', '2011-06-24 10:55:38');

-- --------------------------------------------------------

--
-- Структура таблицы `template_blocks`
--

CREATE TABLE IF NOT EXISTS `template_blocks` (
  `block_id` int(11) NOT NULL AUTO_INCREMENT,
  `alias` varchar(50) DEFAULT NULL,
  `json_settings` text,
  `published` tinyint(1) DEFAULT '0',
  `category_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`block_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=34 ;

--
-- Дамп данных таблицы `template_blocks`
--

INSERT INTO `template_blocks` (`block_id`, `alias`, `json_settings`, `published`, `category_id`) VALUES
(1, 'header', '{}', 0, 1),
(2, 'content', '{}', 0, 1),
(3, 'left', NULL, 0, 1),
(33, 'header', NULL, 0, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `template_widgets`
--

CREATE TABLE IF NOT EXISTS `template_widgets` (
  `template_widget_id` int(11) NOT NULL AUTO_INCREMENT,
  `json_settings` text,
  `published` tinyint(1) DEFAULT '0',
  `class` varchar(50) DEFAULT NULL,
  `title` varchar(50) DEFAULT NULL,
  `block_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`template_widget_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Дамп данных таблицы `template_widgets`
--

INSERT INTO `template_widgets` (`template_widget_id`, `json_settings`, `published`, `class`, `title`, `block_id`) VALUES
(1, '{}', 1, 'MainContent', 'Главный контент', 2),
(2, '{"alias":"main"}', 1, 'Menu', 'Менюшка', 3),
(10, '{}', 1, 'Dummy', 'Текст', 2);

-- --------------------------------------------------------

--
-- Структура таблицы `type_page`
--

CREATE TABLE IF NOT EXISTS `type_page` (
  `page_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `sidebar` text,
  `text` text,
  `created` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `image_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`page_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=57 ;

--
-- Дамп данных таблицы `type_page`
--

INSERT INTO `type_page` (`page_id`, `category_id`, `sidebar`, `text`, `created`, `image_name`) VALUES
(5, 59, '', '<p class="bigger"><span style="font-size: 19px;">Уже 10 лет <a href="#">мы</a> создаем для <a href="#">наших клиентов</a></span> <span style="font-size: 21px;">качественные <a href="#">сайты</a>, <a href="#">flash-презентации</a></span>, <span style="font-size: 15px;">занимаемся разработкой <a href="#">мультимедиа презентаций</a></span>, <span style="font-size: 19px;"><a href="#">дизайном печатной продукции</a></span>.</p>', NULL, NULL),
(2, 4, NULL, '<p>Полный комплекс услуг по проектированию, разработке и сопровождению программного обеспечения, включая консалтинг, разработку ТЗ, разработку интерфейса и проектирование баз данных, систем клиент/сервер, геоинформационных систем, систем документооборота, а также постпроектную техническую и информационную поддержку.</p>', NULL, NULL),
(3, 5, NULL, '<p>Пока здесь ничего не написано</p>', NULL, NULL),
(4, 6, NULL, '<p>Разработка качественных и высокоэффективных мультимедиа продуктов, таких как: элетронные визитки, презентации брэндов, электронные каталоги продуктов, а также мультимедийные учебники и энциклопедии, справочники и самоучители.</p>', NULL, NULL),
(7, 77, NULL, 'Пока здесь ничего не написано', NULL, NULL),
(8, 78, NULL, 'Пока здесь ничего не написано', NULL, NULL),
(9, 79, NULL, 'Пока здесь ничего не написано', NULL, NULL),
(10, 80, NULL, 'Пока здесь ничего не написано', NULL, NULL),
(56, 84, NULL, 'Пока здесь ничего не написано', NULL, NULL),
(14, 90, NULL, 'Пока здесь ничего не написано', NULL, NULL),
(15, 91, NULL, 'Пока здесь ничего не написано', NULL, NULL),
(16, 92, NULL, 'Пока здесь ничего не написано', NULL, NULL),
(17, 93, NULL, 'Пока здесь ничего не написано', NULL, NULL),
(18, 94, NULL, 'Пока здесь ничего не написано', NULL, NULL),
(19, 98, NULL, 'Пока здесь ничего не написано', NULL, NULL),
(20, 99, NULL, 'Пока здесь ничего не написано', NULL, NULL),
(21, 100, NULL, 'Пока здесь ничего не написано', NULL, NULL),
(22, 101, NULL, 'Пока здесь ничего не написано', NULL, NULL),
(23, 106, NULL, 'Пока здесь ничего не написано', NULL, NULL),
(24, 107, NULL, 'Пока здесь ничего не написано', NULL, NULL),
(25, 108, NULL, 'Пока здесь ничего не написано', NULL, NULL),
(26, 109, NULL, 'Пока здесь ничего не написано', NULL, NULL),
(27, 110, NULL, 'Пока здесь ничего не написано', NULL, NULL),
(28, 111, NULL, 'Пока здесь ничего не написано', NULL, NULL),
(29, 112, NULL, 'Пока здесь ничего не написано', NULL, NULL),
(30, 113, NULL, 'Пока здесь ничего не написано', NULL, NULL),
(31, 114, NULL, 'Пока здесь ничего не написано', NULL, NULL),
(32, 115, NULL, 'Пока здесь ничего не написано', NULL, NULL),
(33, 116, NULL, 'Пока здесь ничего не написано', NULL, NULL),
(34, 117, NULL, 'Пока здесь ничего не написано', NULL, NULL),
(35, 118, NULL, 'Пока здесь ничего не написано', NULL, NULL),
(36, 119, NULL, 'Пока здесь ничего не написано', NULL, NULL),
(37, 120, NULL, 'Пока здесь ничего не написано', NULL, NULL),
(38, 121, NULL, 'Пока здесь ничего не написано', NULL, NULL),
(39, 122, NULL, 'Пока здесь ничего не написано', NULL, NULL),
(40, 123, NULL, 'Пока здесь ничего не написано', NULL, NULL),
(41, 124, NULL, 'Пока здесь ничего не написано', NULL, NULL),
(42, 125, NULL, 'Пока здесь ничего не написано', NULL, NULL),
(43, 127, NULL, 'Пока здесь ничего не написано', NULL, NULL),
(44, 126, NULL, 'Пока здесь ничего не написано', NULL, NULL),
(45, 128, '', '<p>Пока здесь ничего не написано</p>', NULL, NULL),
(46, 129, NULL, '<p>Пока здесь ничего не написано</p>', '2011-08-02 21:03:14', NULL),
(47, 130, NULL, 'Пока здесь ничего не написано', NULL, NULL),
(48, 131, NULL, 'Пока здесь ничего не написано', NULL, NULL),
(49, 132, NULL, 'Пока здесь ничего не написано', NULL, NULL),
(50, 133, NULL, 'Пока здесь ничего не написано', NULL, NULL),
(52, 138, '', '<p>{portlet:id=map}</p>', NULL, NULL),
(53, 139, NULL, 'Пока здесь ничего не написано', NULL, NULL),
(54, 2, NULL, 'Пока здесь ничего не написано', NULL, NULL),
(55, 140, NULL, 'Пока здесь ничего не написано', NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `createtime` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `activated` tinyint(1) NOT NULL,
  `banned` tinyint(1) NOT NULL,
  `banned_reason` varchar(255) NOT NULL,
  `blog_id` int(11) NOT NULL,
  `lastvisit` int(11) NOT NULL,
  `superuser` tinyint(1) NOT NULL,
  `status` tinyint(3) NOT NULL,
  `activkey` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=57 ;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `role`, `username`, `password`, `createtime`, `email`, `activated`, `banned`, `banned_reason`, `blog_id`, `lastvisit`, `superuser`, `status`, `activkey`) VALUES
(12, 'webmaster', 'nizsheanez', '827ccb0eea8a706c4c34a16891f84e7b', 1305201336, 'www.pismeco@gmail.com', 0, 0, '', 0, 1305277117, 0, 1, '759e2e75999f483fa135f94cd59942ff'),
(56, 'admin', 'admin', '21232f297a57a5a743894a0e4a801fc3', 1307533423, 'admin@admin.ru', 0, 0, '', 0, 1313433188, 0, 1, '12655e2b7cddcb300d16c530caf24a23');
