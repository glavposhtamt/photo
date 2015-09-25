--Таблица страниц

CREATE TABLE post (
    id int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID',
    route varchar(50) NOT NULL DEFAULT '' COMMENT 'роут',
    title varchar(255) NOT NULL DEFAULT '' COMMENT 'Заголовок',
    description text NOT NULL DEFAULT '' COMMENT 'Краткое описание поста',
    post text NOT NULL DEFAULT '' COMMENT 'Текст',
    date DATETIME NOT NULL DEFAULT 0 COMMENT 'Дата редактирования',
    PRIMARY KEY (id),
    CONSTRAINT ixRoute UNIQUE KEY ( route )
) COMMENT 'Таблица страниц сайта' CHARACTER SET utf8 COLLATE utf8_general_ci;


--Таблица новостей

CREATE TABLE news (
    id int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID',
    title varchar(255) NOT NULL DEFAULT '' COMMENT 'Заголовок',
    anotation varchar(255) NOT NULL DEFAULT '' COMMENT 'Анотация',
    news text NOT NULL DEFAULT '' COMMENT 'Текст',
    keywords varchar(255) NOT NULL DEFAULT '' COMMENT 'Ключевые слова',
    date DATETIME NOT NULL DEFAULT 0 COMMENT 'Дата редактирования',
    `thumbnail` varchar(255) DEFAULT NULL COMMENT 'Промежуточная картинка',
    `mini` varchar(255) DEFAULT NULL COMMENT 'Миниатюрка новости',
    PRIMARY KEY (id),
    INDEX ixThumb ( thumbnail )
) ENGINE=InnoDB COMMENT 'Таблица страниц сайта' CHARACTER SET utf8 COLLATE utf8_general_ci;

-- Таблица файлов

CREATE TABLE `files` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `size` int(11) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`),
  INDEX ixName ( name )
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `bind` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `file_name` varchar(255) DEFAULT NULL,
  `file_id` int(11) DEFAULT NULL,
  `news_id` int(11) DEFAULT NULL,
  `position` int(11) DEFAULT 0,
  PRIMARY KEY (`id`),
  INDEX ixName ( file_name ),
  INDEX ixFile ( file_id ),
  INDEX ixNews ( news_id )
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `watermark`(
  `id` int(11) unsigned NOT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `file_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX ixName ( file_name ),    
  INDEX ixFile ( file_id )
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

