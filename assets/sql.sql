/*==============================================================*/
/* DBMS name:      MySQL 5.0                                    */
/* Created on:     5.5.2017 18:04:52                            */
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
   rights               double not null DEFAULT 0,
   primary key (id),
   unique (email)
) ENGINE=InnoDB CHARACTER SET utf8
;


/*==============================================================*/
/* Table: events                                                */
/*==============================================================*/
create table events
(
   id                   SERIAL,
   caption              varchar(255) not null,
   event_time           datetime,
   time                 datetime not null,
   description          text not null,
   type                 int,
   autor                BIGINT UNSIGNED,
   note                 varchar(255),
   primary key (id),
   foreign key (autor) references users (id) on delete set null
) ENGINE=InnoDB CHARACTER SET utf8
;

/*==============================================================*/
/* Table: news                                                  */
/*==============================================================*/
create table news
(
   id                   SERIAL,
   caption              varchar(255) not null,
   time                 varchar(255) not null,
   content              text not null,
   autor                BIGINT UNSIGNED,
   odkaz                varchar(255) not null,
   note                 varchar(255),
   created              TIMESTAMP,
   primary key (id),
   foreign key (autor) references users (id) on delete set null
) ENGINE=InnoDB CHARACTER SET utf8
;

/*==============================================================*/
/* Table: images                                                */
/*==============================================================*/
create table images
(
   id                   SERIAL,
   category             varchar(255) not null,
   alt                  varchar(255),
   img                  varchar(255) not null,
   owner                BIGINT UNSIGNED,
   primary key (id),
   foreign key (owner) references events (id) on delete set null,
   foreign key (owner) references news (id) on delete set null
) ENGINE=InnoDB CHARACTER SET utf8
;

/*==============================================================*/
/* Table: jobs         Ma42kl53                                         */
/*==============================================================*/
create table jobs
(
   id                   SERIAL,
   caption              varchar(255) not null,
   description          text not null,
   autor                BIGINT UNSIGNED,
   note                 text,
   timestamp            TIMESTAMP,
   primary key (id),
   foreign key (autor) references users (id) on delete set null
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
/* Table: userRights                                                */
/*==============================================================*/
create table userRights
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


/*==============================================================*/
/* Table: galery                                                */
/*==============================================================*/
create table galery
(
   id                   SERIAL,
   caption              varchar(255) not null,
   newsId               BIGINT UNSIGNED,
   cover                boolean,
   autor                BIGINT UNSIGNED,
   odkaz                varchar(255) not null,
   directory            varchar(255) not null,
   primary key (id),
   foreign key (newsId) references news (id) on delete set null,
   foreign key (autor) references users (id) on delete set null
) ENGINE=InnoDB CHARACTER SET utf8
;
