-- --------------------------------------------------------
-- # 1
-- users Table Structure
--
create table users (
		userid varchar(20) not null primary key,
		password varchar(40) not null,
		name varchar(15) not null,
		typeid int default 1,
		profile int not null
) ENGINE=InnoDB default CHARSET=utf8mb4;

-- --------------------------------------------------------
-- # 3
-- movie Table Structure
--
create table movie (
  movie_cd varchar(11) not null primary key,
  movie_nm varchar(50) not null,
  genre varchar(40) not null,
  runtime varchar(30) not null,
  age varchar(40) not null,
  story varchar(3000) not null,
  open_yr varchar(30),
  open_dt varchar(40),
  nation varchar(30),
  rate float default 0.0,
  directors varchar(50),
  imgUrl varchar(500)
) ENGINE=InnoDB default CHARSET=utf8mb4;

-- --------------------------------------------------------
-- # 4
-- people Table Structure
--
create table people (
		people_cd varchar(11) not null primary key,
		people_nm varchar(50) not null,
		people_nm_en varchar(255),
		rep_role_nm varchar(10),
		filmo_names varchar(255),
		film_total int default 0,
		sex varchar(10),
		profile varchar(500)
) ENGINE=InnoDB default CHARSET=utf8mb4;

-- --------------------------------------------------------
-- # 5
-- characters Table Structure
--
create table characters (
		character_id int not null auto_increment primary key,
		movie_cd varchar(11) not null,
		people_cd varchar(11) not null,
		cast_nm varchar(50),
		sex varchar(10),
		foreign key (movie_cd) references movie (movie_cd),
		foreign key (people_cd) references people (people_cd)
) ENGINE=InnoDB default CHARSET=utf8mb4;

-- --------------------------------------------------------
-- # 2
-- test Table Structure
--
create table test (
		typeid int not null auto_increment primary key,
		type_nm varchar(40) not null,
		type_content varchar(400) not null,
		recom_director varchar(11),
		recom_movie varchar(11),
		foreign key (recom_director) references people (people_cd),
		foreign key (recom_movie) references movie (movie_cd)
) ENGINE=InnoDB default CHARSET=utf8mb4;

ALTER TABLE users
  ADD CONSTRAINT FOREIGN KEY (typeid) REFERENCES test (typeid);
COMMIT;

-- --------------------------------------------------------
-- # 6
-- star Table Structure
--
create table star_movie (
		star_movie_id int not null auto_increment primary key,
		userid varchar(20) not null,
		movie_cd varchar(11) not null,
		foreign key (userid) references users (userid),
		foreign key (movie_cd) references movie (movie_cd)
) ENGINE=InnoDB default CHARSET=utf8mb4;

create table star_people (
		star_people_id int not null auto_increment primary key,
		userid varchar(20) not null,
		people_cd varchar(11) not null,
		foreign key (userid) references users (userid),
		foreign key (people_cd) references people (people_cd)
) ENGINE=InnoDB default CHARSET=utf8mb4;

-- --------------------------------------------------------
-- # 7
-- watch_movie Table Structure
--
create table watch_movie (
		watchid int not null auto_increment primary key,
		movie_cd varchar(11) not null,
		userid varchar(20) not null,
		foreign key (movie_cd) references movie (movie_cd),
		foreign key (userid) references users (userid)
) ENGINE=InnoDB default CHARSET=utf8mb4;

-- --------------------------------------------------------
-- # 8
-- character_ranking Table Structure
--
create table character_ranking (
		rankid int not null auto_increment primary key,
		vote int default 0,
		character_id int not null,
		foreign key (character_id) references characters (character_id)
) ENGINE=InnoDB default CHARSET=utf8mb4;

-- --------------------------------------------------------
-- # 9
-- board_information Table Structure
--
create table board_information (
		boardid_info int not null auto_increment primary key,
		userid varchar(20) not null,
		title varchar(50) not null,
		content varchar(500) not null,
		timestamps timestamp not null,
		watch int default 0,
		foreign key (userid) references users (userid)
) ENGINE=InnoDB default CHARSET=utf8mb4;

-- --------------------------------------------------------
-- # 10
-- comment_information Table Structure
--
create table comment_information (
		commentid_info int not null auto_increment primary key,
		boardid_info int not null,
		userid varchar(20) not null,
		content varchar(500) not null,
		timestamps timestamp not null,
		like_no int default 0,
		hate int default 0,
		foreign key (boardid_info) references board_information (boardid_info),
		foreign key (userid) references users (userid)
) ENGINE=InnoDB default CHARSET=utf8mb4;

-- --------------------------------------------------------
-- # 11
-- board_free Table Structure
--
create table board_free (
		boardid_free int not null auto_increment primary key,
		userid varchar(20) not null,
		title varchar(50) not null,
		content varchar(500) not null,
		timestamps timestamp not null,
		watch int default 0,
		foreign key (userid) references users (userid)
) ENGINE=InnoDB default CHARSET=utf8mb4;

-- --------------------------------------------------------
-- # 12
-- comment_free Table Structure
--
create table comment_free (
		commentid_free int not null auto_increment primary key,
		boardid_free int not null,
		userid varchar(20) not null,
		content varchar(500) not null,
		timestamps timestamp not null,
		like_no int default 0,
		hate int default 0,
		foreign key (userid) references users (userid),
		foreign key (boardid_free) references board_free (boardid_free)
) ENGINE=InnoDB default CHARSET=utf8mb4;

-- --------------------------------------------------------