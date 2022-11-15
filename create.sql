-- --------------------------------------------------------
-- # 1
-- users Table Structure
--
create table users (
	userid varchar(20) not null primary key,
	password varchar(40) not null,
	name varchar(15) not null,
	profile varchar(500) not null
) ENGINE=InnoDB default CHARSET=utf8mb4;

-- index creation
create index idx_users_name on users(name);

-- --------------------------------------------------------
-- # 2
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

-- index creation
create index idx_movie_movie_nm on movie(movie_nm);

-- --------------------------------------------------------
-- # 3
-- people Table Structure
--
create table people (
	people_cd varchar(11) not null primary key,
	people_nm varchar(50) not null,
	people_nm_en varchar(255),
	rep_role_nm varchar(10),
	filmo_names varchar(255),
	sex varchar(10),
	profile varchar(500)
) ENGINE=InnoDB default CHARSET=utf8mb4;

-- --------------------------------------------------------
-- # 4
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
-- # 5
-- test Table Structure
--
create table test (
	typeid int not null auto_increment primary key,
	type_nm varchar(40) not null,
	type_title varchar(40) not null,
	type_content varchar(400) not null,
	recom_director varchar(11),
	recom_movie varchar(11),
	url varchar(500),
	foreign key (recom_director) references people (people_cd),
	foreign key (recom_movie) references movie (movie_cd)
) ENGINE=InnoDB default CHARSET=utf8mb4;

-- --------------------------------------------------------
-- # 6
-- test_result Table Structure(test-user Mapping Table)
--
create table test_result (
	userid varchar(20) not null primary key,
	typeid int not null,
	foreign key (userid) references users (userid),
	foreign key (typeid) references test (typeid)
) ENGINE=InnoDB default CHARSET=utf8mb4;

-- --------------------------------------------------------
-- # 7
-- star_movie Table Structure
--
create table star_movie (
	star_movie_id int not null auto_increment primary key,
	userid varchar(20) not null,
	movie_cd varchar(11) not null,
	foreign key (userid) references users (userid),
	foreign key (movie_cd) references movie (movie_cd)
) ENGINE=InnoDB default CHARSET=utf8mb4;

-- --------------------------------------------------------
-- # 8
-- star_people Table Structure
--
create table star_people (
	star_people_id int not null auto_increment primary key,
	userid varchar(20) not null,
	people_cd varchar(11) not null,
	foreign key (userid) references users (userid),
	foreign key (people_cd) references people (people_cd)
) ENGINE=InnoDB default CHARSET=utf8mb4;

-- --------------------------------------------------------
-- # 9
-- watch_movie Table Structure
--
create table watch_movie (
	watchid int not null auto_increment primary key,
	userid varchar(20) not null,
	movie_cd varchar(11) not null,
	timestamps timestamp not null,
	foreign key (movie_cd) references movie (movie_cd),
	foreign key (userid) references users (userid)
) ENGINE=InnoDB default CHARSET=utf8mb4;

-- --------------------------------------------------------
-- # 10
-- character_ranking Table Structure
--
create table character_ranking (
	rankid int not null auto_increment primary key,
	vote int default 0,
	character_id int not null,
	foreign key (character_id) references characters (character_id)
) ENGINE=InnoDB default CHARSET=utf8mb4;

-- --------------------------------------------------------
-- # 11
-- board Table Structure
--
create table board (
	boardid int not null auto_increment primary key,
	userid varchar(20) not null,
	title varchar(50) not null,
	content varchar(500) not null,
	timestamps timestamp not null DEFAULT CURRENT_TIMESTAMP,
	type varchar(10) not null,
	foreign key (userid) references users (userid)
) ENGINE=InnoDB default CHARSET=utf8mb4;

-- --------------------------------------------------------
-- # 12
-- comment Table Structure
--
create table comment (
	commentid int not null auto_increment primary key,
	boardid int not null,
	userid varchar(20) not null,
	content varchar(500) not null,
	timestamps timestamp not null DEFAULT CURRENT_TIMESTAMP,
	like_no int default 0,
	hate int default 0,
	foreign key (userid) references users (userid),
	foreign key (boardid) references board (boardid)
) ENGINE=InnoDB default CHARSET=utf8mb4;