/*==============================================================*/
/* DBMS name:      MySQL 5.0                                    */
/* Created on:     5.5.2017 18:04:52                            */
/*==============================================================*/

DROP TABLE IF EXISTS members;
DROP TABLE IF EXISTS referencese;
DROP TABLE IF EXISTS events;
DROP TABLE IF EXISTS sponsors;
DROP TABLE IF EXISTS menus;
DROP TABLE IF EXISTS seo;
DROP TABLE IF EXISTS block_menus;
DROP TABLE IF EXISTS block_header;
DROP TABLE IF EXISTS block_members;
DROP TABLE IF EXISTS block_references;
DROP TABLE IF EXISTS block_events;
DROP TABLE IF EXISTS block_contacts;
DROP TABLE IF EXISTS block_articles;
DROP TABLE IF EXISTS block_sponsors;
DROP TABLE IF EXISTS block_footer;
DROP TABLE IF EXISTS userrights;
DROP TABLE IF EXISTS rights;
DROP TABLE IF EXISTS users;



/*==============================================================*/
/* Table: block_header                                          */
/*==============================================================*/
create TABLE block_header
(
  id                    SERIAL,
  style                 TEXT,
  bg_type               varchar(255) not null DEFAULT "color",
  heading_1             varchar(255) not null DEFAULT "",
  heading_2             varchar(255) not null DEFAULT "",
  button_1              varchar(255) not null DEFAULT "",
  button_2              varchar(255) not null DEFAULT "",
  button_1_link         TEXT not null DEFAULT "",
  button_2_link         TEXT not null DEFAULT "",
  image                 VARCHAR(255) default null,
  active                SMALLINT DEFAULT 0,
  position              INTEGER not NULL DEFAULT 696969,
  primary key (id)
) ENGINE=InnoDB CHARACTER SET utf8
;


/*==============================================================*/
/* Table: block_members                                         */
/*==============================================================*/
create TABLE block_members
(
   id                    SERIAL,
   style                 TEXT,
   bg_type               varchar(255) not null DEFAULT "color",
   heading_1             varchar(255) not null DEFAULT "",
   image                 VARCHAR(255) default null,
   active                SMALLINT DEFAULT 0,
   position              INTEGER not NULL DEFAULT 696969,
   primary key (id)
) ENGINE=InnoDB CHARACTER SET utf8
;

/*==============================================================*/
/* Table: block_references                                      */
/*==============================================================*/
create TABLE block_references
(
   id                    SERIAL,
   style                 TEXT,
   bg_type               varchar(255) not null DEFAULT "color",
   heading               varchar(255) not null DEFAULT "",
   image                 VARCHAR(255) default null,
   active                SMALLINT DEFAULT 0,
   position              INTEGER not NULL DEFAULT 696969,
   primary key (id)
) ENGINE=InnoDB CHARACTER SET utf8
;

/*==============================================================*/
/* Table: block_events                                          */
/*==============================================================*/
create TABLE block_events
(
  id                    SERIAL,
  style                 TEXT,
  bg_type               varchar(255) not null DEFAULT "color",
  heading               varchar(255) not null DEFAULT "",
  image                 VARCHAR(255) default null,
  active                SMALLINT DEFAULT 0,
  position              INTEGER not NULL DEFAULT 696969,
  primary key (id)
) ENGINE=InnoDB CHARACTER SET utf8
;

/*==============================================================*/
/* Table: block_contacts                                        */
/*==============================================================*/
create TABLE block_contacts
(
  id                    SERIAL,
  style                 TEXT,
  bg_type               varchar(255) not null DEFAULT "color",
  heading_1             varchar(255) not null DEFAULT "",
  heading_2             varchar(255) not null DEFAULT "",
  image                 VARCHAR(255) default null,
  email                 VARCHAR(255) not null DEFAULT "",
  phone                 VARCHAR(255) not null DEFAULT "",
  adress                VARCHAR(255) not null DEFAULT "",
  gpsx                  DOUBLE NOT NULL DEFAULT 0,
  gpsy                  DOUBLE NOT NULL DEFAULT 0,
  instagram             TEXT,
  facebook              TEXT,
  twitter               TEXT,
  linkedin              TEXT,
  active                SMALLINT DEFAULT 0,
  position              INTEGER not NULL DEFAULT 696969,
  primary key (id)
) ENGINE=InnoDB CHARACTER SET utf8
;

/*==============================================================*/
/* Table: block_articles                                        */
/*==============================================================*/
create TABLE block_articles
(
  id                    SERIAL,
  style                 TEXT,
  bg_type               varchar(255) not null DEFAULT "color",
  heading_1             varchar(255) not null DEFAULT "",
  heading_2             varchar(255) not null DEFAULT "",
  text                  TEXT not null DEFAULT "",
  image                 VARCHAR(255) default null,
  image_article         VARCHAR(255) default null,
  active                SMALLINT DEFAULT 0,
  position              INTEGER not NULL DEFAULT 696969,
  primary key (id)
) ENGINE=InnoDB CHARACTER SET utf8
;

/*==============================================================*/
/* Table: block_sponsors                                        */
/*==============================================================*/
create TABLE block_sponsors
(
  id                    SERIAL,
  style                 TEXT,
  bg_type               varchar(255) not null DEFAULT "color",
  heading               varchar(255) not null DEFAULT "",
  image                 VARCHAR(255) default null,
  active                SMALLINT DEFAULT 0,
  position              INTEGER not NULL DEFAULT 696969,
  primary key (id)
) ENGINE=InnoDB CHARACTER SET utf8
;

/*==============================================================*/
/* Table: block_menu                                            */
/*==============================================================*/
create TABLE block_menus
(
  id                    SERIAL,
  style                 TEXT,
  bg_type               varchar(255) not null DEFAULT "color",
  heading               varchar(255) DEFAULT "",
  image                 VARCHAR(255) default null,
  instagram             TEXT,
  facebook              TEXT,
  twitter               TEXT,
  linkedin              TEXT,
  primary key (id)
) ENGINE=InnoDB CHARACTER SET utf8
;

/*==============================================================*/
/* Table: block_footer                                          */
/*==============================================================*/
create TABLE block_footer
(
  id                    SERIAL,
  style                 TEXT,
  text                  TEXT,
  primary key (id)
) ENGINE=InnoDB CHARACTER SET utf8
;

/*==============================================================*/
/* Table: members                                               */
/*==============================================================*/
create TABLE members
(
   id                    SERIAL,
   name                  varchar(255) not null DEFAULT "",
   text                  TEXT not null DEFAULT "",
   image                 VARCHAR(255) default null,
   owner                 BIGINT UNSIGNED,
   active                TINYINT not null DEFAULT 0,
   primary key (id),
   foreign key (owner) references block_members (id) on delete CASCADE
) ENGINE=InnoDB CHARACTER SET utf8
;

/*==============================================================*/
/* Table: referencese                                           */
/*==============================================================*/
create TABLE referencese
(
   id                    SERIAL,
   name                  varchar(255) not null DEFAULT "",
   text                  TEXT not null DEFAULT "",
   image                 VARCHAR(255) default null,
   owner                 BIGINT UNSIGNED,
   active                TINYINT not null DEFAULT 0,
   reference             TEXT not null DEFAULT "",
   primary key (id),
   foreign key (owner) references block_references (id) on delete CASCADE
) ENGINE=InnoDB CHARACTER SET utf8
;

/*==============================================================*/
/* Table: events                                                */
/*==============================================================*/
create TABLE events
(
  id                    SERIAL,
  heading               varchar(255) not null DEFAULT "",
  event_time            DATETIME,
  text                  TEXT not null DEFAULT "",
  link                  VARCHAR(255) not null DEFAULT "#",
  image                 VARCHAR(255) default null,
  owner                 BIGINT UNSIGNED,
  active                TINYINT not null DEFAULT 0,
  position              INTEGER not NULL DEFAULT 696969,
  primary key (id),
  foreign key (owner) references block_events (id) on delete CASCADE
) ENGINE=InnoDB CHARACTER SET utf8
;

/*==============================================================*/
/* Table: sponsors                                              */
/*==============================================================*/
create TABLE sponsors
(
  id                    SERIAL,
  link                  VARCHAR(255) not null DEFAULT "#",
  image                 VARCHAR(255) default null,
  owner                 BIGINT UNSIGNED,
  primary key (id),
  foreign key (owner) references block_sponsors (id) on delete CASCADE
) ENGINE=InnoDB CHARACTER SET utf8
;

/*==============================================================*/
/* Table: menus                                                 */
/*==============================================================*/
create TABLE menus
(
  id                    SERIAL,
  link                  VARCHAR(255) not null DEFAULT "#",
  text                  VARCHAR(255) default null,
  active                TINYINT not null DEFAULT 0,
  position              INTEGER not NULL DEFAULT 696969,
  owner                 BIGINT UNSIGNED,
  block_owner           VARCHAR(255) NOT NULL DEFAULT "",
  primary key (id),
  foreign key (owner) references block_menus (id) on delete CASCADE
) ENGINE=InnoDB CHARACTER SET utf8
;

/*==============================================================*/
/* Table: seo                                                   */
/*==============================================================*/
create TABLE seo
(
  id                    SERIAL,
  keywords              TEXT,
  description           VARCHAR(255) default "",
  primary key (id)
) ENGINE=InnoDB CHARACTER SET utf8
;


/*==============================================================*/
/* Table: users                                                 */
/*==============================================================*/
create table users
(
   id                   SERIAL,
   email                varchar(255) not null,
   password             varchar(255) not null,
   primary key (id),
   unique (email)
) ENGINE=InnoDB CHARACTER SET utf8
;

/*==============================================================*/
/* Table: rights                                                */
/*==============================================================*/
create table rights
(
   id             SERIAL,
   name           varchar(255) not null,
   constraint unique_rights unique (name),
   primary key (id)
) ENGINE=InnoDB CHARACTER SET utf8
;


/*==============================================================*/
/* Table: userRights                                            */
/*==============================================================*/
create table userrights
(
   userId             BIGINT UNSIGNED not null,
   rightId            BIGINT UNSIGNED not null,
   primary key (userId, rightId),
   constraint FK_commonRights_usr foreign key (userId)
   references users (id),
   constraint FK_commonRights_rig foreign key (rightId)
   references rights (id)
) ENGINE=InnoDB CHARACTER SET utf8
;



#
#
# --
# -- Vypisuji data pro tabulku `block_articles`
# --
#
# INSERT INTO `block_articles` (`id`, `style`, `bg_type`, `heading_1`, `heading_2`, `text`, `image`, `image_article`, `active`, `position`) VALUES
#   (2, '{\"heading_1_color\":\"#6ce246\",\"heading_2_color\":\"#6ce246\",\"text_color\":\"#43573d\",\"background_color\":\"#b5c2a8\",\"_submit\":\"Send\",\"_token_\":\"8949ocfz4tGA5es1ODDnSYSPs6N6CsLZ77xGo=\",\"_do\":\"articlesForm-submit\"}', 'image', 'Benátky', 'Návštěva benátek za krásného počasí', '<p>V benátkách je krásně. <span style=\"color: #222222; font-family: sans-serif; text-align: justify; background-color: #fdfeff;\">krajiny nazývaný </span><a class=\"new\" style=\"text-decoration-line: none; color: #a55858; background: none #fdfeff; font-family: sans-serif; text-align: justify;\" title=\"Fynbos (stránka neexistuje)\" href=\"https://cs.wikipedia.org/w/index.php?title=Fynbos&amp;action=edit&amp;redlink=1\">fynbos</a><span style=\"color: #222222; font-family: sans-serif; text-align: justify; background-color: #fdfeff;\">. Jméno </span><em style=\"color: #222222; font-family: sans-serif; text-align: justify; background-color: #fdfeff;\">Drosera regia</em><span style=\"color: #222222; font-family: sans-serif; text-align: justify; background-color: #fdfeff;\"> pochází z </span><a style=\"text-decoration-line: none; color: #0b0080; background: none #fdfeff; font-family: sans-serif; text-align: justify;\" title=\"Řečtina\" href=\"https://cs.wikipedia.org/wiki/%C5%98e%C4%8Dtina\">řeckého</a><span style=\"color: #222222; font-family: sans-serif; text-align: justify; background-color: #fdfeff;\"> </span><em style=\"color: #222222; font-family: sans-serif; text-align: justify; background-color: #fdfeff;\"><span class=\"cizojazycne\" lang=\"el\" title=\"řečtina\" xml:lang=\"el\">droseros</span></em><span style=\"color: #222222; font-family: sans-serif; text-align: justify; background-color: #fdfeff;\"> neboli „pokrytá rosou“ a </span><a style=\"text-decoration-line: none; color: #0b0080; background: none #fdfeff; font-family: sans-serif; text-align: justify;\" title=\"Latina\" href=\"https://cs.wikipedia.org/wiki/Latina\">latinského</a><span style=\"color: #222222; font-family: sans-serif; text-align: justify; background-color: #fdfeff;\"> </span><em style=\"color: #222222; font-family: sans-serif; text-align: justify; background-color: #fdfeff;\"><span class=\"cizojazycne\" lang=\"lat\" title=\"lat\" xml:lang=\"lat\">regia</span></em><span style=\"color: #222222; font-family: sans-serif; text-align: justify; background-color: #fdfeff;\">, což znamená „královská“. Rostlina vytváří až 70 cm dlouhé </span><a style=\"text-decoration-line: none; color: #0b0080; background: none #fdfeff; font-family: sans-serif; text-align: justify;\" title=\"List\" href=\"https://cs.wikipedia.org/wiki/List\">listy</a><span style=\"color: #222222; font-family: sans-serif; text-align: justify; background-color: #fdfeff;\">, pokryté lepkavými </span><a style=\"text-decoration-line: none; color: #0b0080; background: none #fdfeff; font-family: sans-serif; text-align: justify;\" title=\"Tentakule (botanika)\" href=\"https://cs.wikipedia.org/wiki/Tentakule_(botanika)\">tentakulemi</a><span style=\"color: #222222; font-family: sans-serif; text-align: justify; background-color: #fdfeff;\"> určenými pro lov </span><a style=\"text-decoration-line: none; color: #0b0080; background: none #fdfeff; font-family: sans-serif; text-align: justify;\" title=\"Hmyz\" href=\"https://cs.wikipedia.org/wiki/Hmyz\">hmyzu</a><span style=\"color: #222222; font-family: sans-serif; text-align: justify; background-color: #fdfeff;\">. Na dotyk kořisti rostlina reaguje ohýbáním tentakulí i samotných listů.</span></p>', './img/repo/05ac33c9af04040.04290125.jpg', './img/repo/205ac008ff9280f6.92397251.jpg', 1, 60);
#
# --
# -- Vypisuji data pro tabulku `block_contacts`
# --
#
# INSERT INTO `block_contacts` (`id`, `style`, `bg_type`, `heading_1`, `heading_2`, `image`, `email`, `phone`, `adress`, `gpsx`, `gpsy`, `instagram`, `facebook`, `twitter`, `linkedin`, `active`, `position`) VALUES
#   (2, '{\"heading_1_color\":\"#e9cd25\",\"heading_2_color\":\"#e9cd25\",\"text_color\":\"#88803a\",\"background_color\":\"#b1a22f\",\"block_background_color\":\"#cbc286\",\"_submit\":\"Send\",\"_token_\":\"rgh0sg4ioulZJ0SnhAU44gs6pSHLuGucCUK\\/0=\",\"_do\":\"contactsForm-submit\"}', 'image', 'Kontakt', 'Máte otázky? Napište!', './img/repo/25ac0087fa9dd42.59821951.jpg', 'netj01@vse.cz', '+ 420 123 987 564', 'Sokolí 46, Jablonec nad Nisou', 14.4378005, 50.0755381, 'www.instagram.com', 'www.facebook.com', 'www.twitter.com', 'www.linkedIn.com', 1, 50);
#
# --
# -- Vypisuji data pro tabulku `block_events`
# --
#
# INSERT INTO `block_events` (`id`, `style`, `bg_type`, `heading`, `image`, `active`, `position`) VALUES
#   (2, '{\"heading_color\":\"#2882cc\",\"background_color\":\"#276d96\",\"text_color\":\"#000000\",\"block_background_color\":\"#4fbcd8\",\"time_color\":\"#1411df\",\"_submit\":\"Send\",\"_token_\":\"nu009x7uh8T0iGf5OSb6KUFM+9x3wEPyHNZpY=\",\"_do\":\"eventsForm-submit\"}', 'color', 'Akce', './img/repo/55ac33c76c31177.35348263.jpg', 1, 30);
#
# --
# -- Vypisuji data pro tabulku `block_header`
# --
#
# INSERT INTO `block_header` (`id`, `style`, `bg_type`, `heading_1`, `heading_2`, `button_1`, `button_2`, `button_1_link`, `button_2_link`, `image`, `active`, `position`) VALUES
#   (2, '{\"heading_1_color\":\"#ffffff\",\"heading_2_color\":\"#ffffff\",\"button_1_color\":\"#000000\",\"button_1_background_color\":\"#ffffff\",\"button_1_border_color\":\"#575757\",\"button_2_color\":\"#ffffff\",\"button_2_background_color\":\"#000000\",\"button_2_border_color\":\"#595959\",\"background_color\":\"transparent\",\"_submit\":\"Odeslat\",\"_token_\":\"hetpvni6wrhRJgG+\\/4KxSe9F87J98vWbC6W4c=\",\"_do\":\"headerForm-submit\"}', 'image', 'Chlastáme jedno týdně. Ve sklepu', 'Protože můžeme', 'first button', 'second button', 'www.tady.cz', '#', './img/repo/145ac36bff0abcf8.03377651.jpg', 1, 10);
#
# --
# -- Vypisuji data pro tabulku `block_members`
# --
#
# INSERT INTO `block_members` (`id`, `style`, `bg_type`, `heading_1`, `image`, `active`, `position`) VALUES
#   (2, '{\"heading_1_color\":\"#884ea6\",\"background_color\":\"#F2F2F2\",\"text_color\":\"#3f693a\",\"name_color\":\"#5d3a69\",\"_submit\":\"Send\",\"_token_\":\"lf010vspz8ZK\\/EwjrGTaUj3UWyxqnKTNtqX\\/M=\",\"_do\":\"membersForm-submit\"}', 'color', 'Členové', NULL, 1, 20);
#
# --
# -- Vypisuji data pro tabulku `block_references`
# --
#
# INSERT INTO `block_references` (`id`, `style`, `bg_type`, `heading`, `image`, `active`, `position`) VALUES
#   (2, '{\"heading_color\":\"#13c37a\",\"background_color\":\"#7bcca7\",\"text_color\":\"#257446\",\"name_color\":\"#257446\",\"block_background_color\":\"#257446\",\"_submit\":\"Send\",\"_token_\":\"0s49sjyz3rP+MCINul+vuLLWQHA5TJ4gdvGNA=\",\"_do\":\"referencesForm-submit\"}', 'image', 'Reference', './img/repo/115ac33c8bcb6b24.52087986.jpg', 0, 40);
#
# --
# -- Vypisuji data pro tabulku `block_sponsors`
# --
#
# INSERT INTO `block_sponsors` (`id`, `style`, `bg_type`, `heading`, `image`, `active`, `position`) VALUES
#   (2, '{\"heading_color\":\"#d73333\",\"background_color\":\"#cd4c4c\",\"block_background_color\":\"#c69595\",\"_submit\":\"Send\",\"_token_\":\"jry3wsirh0hBCasQxYpOg8kANV+GcSO3uba74=\",\"_do\":\"sponsorsForm-submit\"}', 'image', 'Sponzoři', './img/repo/185ac0092b209c15.59203131.jpg', 1, 70);
#
# --
# -- Vypisuji data pro tabulku `events`
# --
#
# INSERT INTO `events` (`id`, `heading`, `event_time`, `text`, `link`, `image`, `owner`, `active`, `position`) VALUES
#   (4, 'Návštěva pláže', '2018-03-22 13:13:13', '<p>U rosnatky královské se vyvinulo mnoho charakteristik, které ji odlišují od většiny ostatních rosnatek − například dřevité oddenky či nerozvíjení květních stvolů.</p>', 'www.fb.com', './img/repo/65ac00be0de7879.54912168.jpg', 2, 1, 1),
#   (5, 'Čaj s citrónem', '2018-03-22 13:13:13', '<p>U rosnatky královské se vyvinulo mnoho charakteristik, které ji odlišují od většiny ostatních rosnatek − například dřevité oddenky či nerozvíjení květních stvolů.</p>', 'www.caj.cz', './img/repo/45ac00c0137edf8.13615111.jpg', 2, 1, 1),
#   (6, 'Na lavičce s Honzou', '2018-03-22 13:13:13', '<p>U rosnatky královské se vyvinulo mnoho charakteristik, které ji odlišují od většiny ostatních rosnatek − například dřevité oddenky či nerozvíjení květních stvolů.</p>', 'www.nalavicce.cz', './img/repo/125ac00c2054af38.62796067.jpg', 2, 1, 1);
#
# --
# -- Vypisuji data pro tabulku `members`
# --
#
# INSERT INTO `members` (`id`, `name`, `text`, `image`, `owner`, `active`) VALUES
#   (4, 'Kateřina Michnová', 'U rosnatky královské se vyvinulo mnoho charakteristik, které ji odlišují od většiny ostatních rosnatek − například dřevité oddenky či nerozvíjení květních stvolů.', './img/repo/175ac00b1e3ffe62.35233008.jpg', 2, 1),
#   (5, 'Martin Šťastný', 'U rosnatky královské se vyvinulo mnoho charakteristik, které ji odlišují od většiny ostatních rosnatek − například dřevité oddenky či nerozvíjení květních stvolů.', './img/repo/125ac00b301f0a42.99767614.jpg', 2, 1),
#   (6, 'Markéta Stmívalová', 'U rosnatky královské se vyvinulo mnoho charakteristik, které ji odlišují od většiny ostatních rosnatek − například dřevité oddenky či nerozvíjení květních stvolů.', './img/repo/145ac00b4403bad2.07513298.jpg', 2, 0),
#   (7, 'Eliáš krátký', 'U rosnatky královské se vyvinulo mnoho charakteristik, které ji odlišují od většiny ostatních rosnatek − například dřevité oddenky či nerozvíjení květních stvolů.', './img/repo/125ac00bb4a303c8.69197777.jpg', 2, 1);
#
# --
# -- Vypisuji data pro tabulku `referencese`
# --
#
# INSERT INTO `referencese` (`id`, `name`, `text`, `image`, `owner`, `active`, `reference`) VALUES
#   (4, 'Martina Kratochvílová', 'U rosnatky královské se vyvinulo mnoho charakteristik, které ji odlišují od většiny ostatních rosnatek − například dřevité oddenky či nerozvíjení květních stvolů.', './img/repo/65ac00c3e6343b1.03192346.jpg', 2, 0, '<p>U rosnatky královské se vyvinulo mnoho charakteristik, které ji odlišují od většiny ostatních rosnatek − například dřevité oddenky či nerozvíjení květních stvolů.</p>'),
#   (5, 'Martin Navrátil', 'U rosnatky královské se vyvinulo mnoho charakteristik, které ji odlišují od většiny ostatních rosnatek − například dřevité oddenky či nerozvíjení květních stvolů.', './img/repo/75ac00c6fede569.91110574.jpg', 2, 0, '<p>U rosnatky královské se vyvinulo mnoho charakteristik, které ji odlišují od většiny ostatních rosnatek − například dřevité oddenky či nerozvíjení květních stvolů.</p>'),
#   (6, 'Markéta Světlá', 'U rosnatky královské se vyvinulo mnoho charakteristik, které ji odlišují od většiny ostatních rosnatek − například dřevité oddenky či nerozvíjení květních stvolů.', './img/repo/205ac00c82ae5e05.56293940.jpg', 2, 0, '<p>U rosnatky královské se vyvinulo mnoho charakteristik, které ji odlišují od většiny ostatních rosnatek − například dřevité oddenky či nerozvíjení květních stvolů.</p>'),
#   (7, 'Karel', 'web designer', './img/repo/155ac257eb7e36b7.26244845.jpg', 2, 0, '<p>čtvrtá reference</p>');
#
# --
# -- Vypisuji data pro tabulku `rights`
# --
#
# --
# -- Vypisuji data pro tabulku `sponsors`
# --
#
# INSERT INTO `sponsors` (`id`, `link`, `image`, `owner`) VALUES
#   (4, 'www.xfinity.com', './img/repo/205ac00cbbe0cbe7.50804626.png', 2),
#   (5, 'www.reebok.com', './img/repo/65ac00ccfa83011.93584024.png', 2),
#   (6, 'krazyBee.com', './img/repo/125ac00cde0d1d68.77773386.png', 2),
#   (7, 'www.sponsor.com', './img/repo/15ac00cefc765e1.34376321.png', 2);

INSERT INTO `rights` (`id`, `name`) VALUES
  (1, 'admin'),
  (2, 'headers'),
  (3, 'members'),
  (4, 'references'),
  (5, 'events'),
  (6, 'contacts'),
  (7, 'articles'),
  (8, 'sponsors'),
  (9, 'menus'),
  (10, 'authenticated');

--
-- Vypisuji data pro tabulku `userrights` a data pro tabulku `users`
--

INSERT INTO `users`(`email`, `password`) VALUES ("netj01@vse.cz", "$2y$10$4iP5iusxv7MAYDaB92moYuZdhEK.51V4j9mv7pSQbJnjP5NBG4BMa");
INSERT INTO `userrights`(`userId`, `rightId`) VALUES (1,1);
INSERT INTO `users`(`email`, `password`) VALUES ("example@example.cz", "$2y$10$4iP5iusxv7MAYDaB92moYuZdhEK.51V4j9mv7pSQbJnjP5NBG4BMa");
INSERT INTO `userrights`(`userId`, `rightId`) VALUES (2,1);
# INSERT INTO `users`(`email`, `password`) VALUES ("marj17@vse.cz", "$2y$10$4iP5iusxv7MAYDaB92moYuZdhEK.51V4j9mv7pSQbJnjP5NBG4BMa");
# INSERT INTO `userrights`(`userId`, `rightId`) VALUES (3,1);
















