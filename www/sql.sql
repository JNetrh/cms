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
  event_time            varchar(255) not null DEFAULT "",
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
  favicon               VARCHAR(255) DEFAULT "",
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
  (10, 'seo'),
  (11, 'authenticated');

--
-- Vypisuji data pro tabulku `userrights` a data pro tabulku `users`
--

INSERT INTO `users`(`email`, `password`) VALUES ("netj01@vse.cz", "$2y$10$4iP5iusxv7MAYDaB92moYuZdhEK.51V4j9mv7pSQbJnjP5NBG4BMa");
INSERT INTO `userrights`(`userId`, `rightId`) VALUES (1,1);
INSERT INTO `users`(`email`, `password`) VALUES ("example@example.cz", "$2y$10$4iP5iusxv7MAYDaB92moYuZdhEK.51V4j9mv7pSQbJnjP5NBG4BMa");
INSERT INTO `userrights`(`userId`, `rightId`) VALUES (2,1);