SET FOREIGN_KEY_CHECKS = 0;
select users, movie, people, characters, test, test_result, star_movie, star_people, watch_movie, character_ranking, board, comment
from information_schema.tables where table_schema = team15;
drop table if exists users;
drop table if exists movie;
drop table if exists people;
drop table if exists characters;
drop table if exists test;
drop table if exists test_result;
drop table if exists star_movie;
drop table if exists star_people;
drop table if exists watch_movie;
drop table if exists character_ranking;
drop table if exists board;
drop table if exists comment;