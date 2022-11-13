drop table test_result;
drop table test;

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


create table test_result (
userid varchar(20) not null primary key,
typeid int not null,
foreign key (userid) references users (userid),
foreign key (typeid) references test (typeid)
) ENGINE=InnoDB default CHARSET=utf8mb4;

INSERT INTO `test` (`typeid`, `type_nm`, `type_title`, `type_content`, `recom_director`, `recom_movie`, `url`) VALUES (NULL, 'thriller/action', '도파민 폭발! 짜릿한 스릴러/액션', '선을 넘을 듯 말듯 아슬아슬한 스릴을 즐기는 당신! 엄선된 거장들의 영화를 통해 짜릿한 쾌감을 느껴 보세요.', '10076801', '20030394', '../../img/action.svg'), (NULL, 'thriller/action', '도파민 폭발! 짜릿한 스릴러/액션', '선을 넘을 듯 말듯 아슬아슬한 스릴을 즐기는 당신! 엄선된 거장들의 영화를 통해 짜릿한 쾌감을 느껴 보세요.', '10076801', '19960120', '../../img/action.svg');
INSERT INTO `test` (`typeid`, `type_nm`, `type_title`, `type_content`, `recom_director`, `recom_movie`, `url`) VALUES (NULL, 'thriller/action', '도파민 폭발! 짜릿한 스릴러/액션', '선을 넘을 듯 말듯 아슬아슬한 스릴을 즐기는 당신! 엄선된 거장들의 영화를 통해 짜릿한 쾌감을 느껴 보세요.', '10045335', '19588006', '../../img/action.svg'), (NULL, 'thriller/action', '도파민 폭발! 짜릿한 스릴러/액션', '선을 넘을 듯 말듯 아슬아슬한 스릴을 즐기는 당신! 엄선된 거장들의 영화를 통해 짜릿한 쾌감을 느껴 보세요.', '10045335', '19608012', '../../img/action.svg');
