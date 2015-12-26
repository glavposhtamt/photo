-- Таблица страниц

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


-- Таблица новостей

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
) ENGINE=InnoDB COMMENT 'Таблица новостей' CHARACTER SET utf8 COLLATE utf8_general_ci;

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

-- Таблица связей картинок с новостями и работами

CREATE TABLE `bind` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `file_name` varchar(255) DEFAULT NULL,
  `file_id` int(11) DEFAULT NULL,
  `news_id` int(11) DEFAULT NULL,
  `work_id` int(11) DEFAULT NULL,
  `position` int(11) DEFAULT 0,
  PRIMARY KEY (`id`),
  INDEX ixName ( file_name ),
  INDEX ixFile ( file_id ),
  INDEX ixNews ( news_id )
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Таблица для хранения названия картинки/водяного знака

CREATE TABLE `watermark`(
  `id` int(11) unsigned NOT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `file_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX ixName ( file_name ),    
  INDEX ixFile ( file_id )
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Таблица учебных заведений

CREATE TABLE `institution` (
    `id` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID',
    `title` varchar(255) NOT NULL DEFAULT '' COMMENT 'Название',
    `type` ENUM('Детский сад', 'Школа', 'ВУЗ') NOT NULL COMMENT 'Тип заведения',
    `city` varchar(255) DEFAULT NULL COMMENT 'Город',
    `street` varchar(255) DEFAULT NULL COMMENT 'Улица',
    PRIMARY KEY (id),
    INDEX ixTitle (title),
    INDEX ixCity (city),
    INDEX ixStreet (street)
) ENGINE=InnoDB COMMENT 'Таблица учебных заведений' CHARACTER SET utf8 COLLATE utf8_general_ci;

-- Таблица "Наши работы"

CREATE TABLE `work` (
    `id` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID',
    `institution` int UNSIGNED NOT NULL COMMENT 'ID учебного заведения',
    `school_class` int UNSIGNED NOT NULL COMMENT 'Класс',
    `year` int UNSIGNED NOT NULL COMMENT 'Год окончания',
    `anotation` varchar(255) NOT NULL DEFAULT '' COMMENT 'Анотация',
    `keywords` varchar(255) NOT NULL DEFAULT '' COMMENT 'Ключевые слова',
    `thumbnail` varchar(255) DEFAULT NULL COMMENT 'Промежуточная картинка',
    `mini` varchar(255) DEFAULT NULL COMMENT 'Миниатюрка новости',
    PRIMARY KEY (id),
    INDEX ixInstitution ( institution ),
    INDEX ixThumb ( thumbnail )
) ENGINE=InnoDB COMMENT 'Таблица работ' CHARACTER SET utf8 COLLATE utf8_general_ci;

-- Создаём временную таблицу для связей

CREATE TABLE `temp` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `file_name` varchar(255) DEFAULT NULL,
  `file_id` int(11) DEFAULT NULL,
  `type` ENUM('work', 'news') NOT NULL COMMENT 'Тип записи',
  PRIMARY KEY (`id`),
  INDEX ixName ( file_name )
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Создаём таблицу пользователей

CREATE TABLE `user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT ixUser UNIQUE KEY ( `user` ),
  INDEX ixPass ( `pass` )
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Отзывы/Советы

CREATE TABLE `review` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `author` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `institution` int UNSIGNED DEFAULT 0 COMMENT 'ID учебного заведения',
  `message` text NOT NULL DEFAULT '' COMMENT 'Текст',
  `type` varchar(10) NOT NULL,
  `status` int(1) DEFAULT 0,
  PRIMARY KEY (`id`),
  INDEX ixUser ( `institution` ),
  INDEX ixPass ( `type` ),
  INDEX ixStatus ( `status` )
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Ответы

CREATE TABLE `answer` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` varchar(255) DEFAULT 0,
  `review_id` int UNSIGNED DEFAULT 0 COMMENT 'ID отзыва/вопроса',
  `answer` text NOT NULL DEFAULT '' COMMENT 'Текст',
  PRIMARY KEY (`id`),
  INDEX ixUser ( `user_id` ),
  INDEX ixReview ( `review_id` )
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


