-- ** LEADER BOARD 페이지 **

-- *'여성' 버튼 선택*
-- '여성' 배역에 대한 랭킹 결과 조회
select cast_nm from characters where sex='여자' and character_id IN (select character_id from character_ranking order by vote desc);
-- '여성' 배역에 대한 랭킹 TOP3 결과 조회
select cast_nm from characters where sex='여자' and character_id IN (select character_id from character_ranking order by vote desc) limit 3;

-- *'남성' 버튼 선택*
-- '남성' 배역에 대한 랭킹 결과 조회
select cast_nm from characters where sex='남자' and character_id IN (select character_id from character_ranking order by vote desc);
-- '남성' 배역에 대한 랭킹 TOP3 결과 조회
select cast_nm from characters where sex='남자' and character_id IN (select character_id from character_ranking order by vote desc)  limit 3;

-- *'전체보기'*
-- 배역에 대한 랭킹 결과 조회 (조건 없음)
select cast_nm from characters where character_id IN (select character_id from character_ranking order by vote desc);


-- ** VOTE 페이지 ** --
-- '응원하기' 버튼 누르면, 투표
update character_ranking set vote=vote+1 where character_id=?;


-- ** TEST 페이지 ** --
-- TEST 결과 유형 이름 출력
select type_title from test where type_nm=? limit 1;
-- TEST 결과 유형 소개글 출력
select type_content from test where type_nm=? limit 1;

-- 추천 감독 전체 출력 
select people_nm from people where people_cd IN (select recom_director from test where type_nm=?);
-- 추천 감독#1 (감독 이름 출력)
select people_nm from people where people_cd IN (select recom_director from test where type_nm=?) limit 1;
-- 추천 감독#2 (감독 이름 출력)
select people_nm from people where people_cd IN (select recom_director from test where type_nm=?) order by people_cd desc limit 1;

-- 감독#1 추천 영화 목록 전체 불러오기
select movie_nm from movie where movie_cd IN (SELECT recom_movie FROM test where type_nm=? and recom_director=(select people_cd from people where people_cd IN (select recom_director from test where type_nm=?) limit 1));
-- 감독#1의 추천 영화#1 (영화 제목 출력)
select movie_nm from movie where movie_cd=(SELECT recom_movie FROM test where type_nm=? and recom_director=(select people_cd from people where people_cd IN (select recom_director from test where type_nm=?) limit 1) limit 1);
-- 감독#1의 추천 영화#2 (영화 제목 출력)
select movie_nm from movie where movie_cd=(SELECT recom_movie FROM test where type_nm=? and recom_director=(select people_cd from people where people_cd IN (select recom_director from test where type_nm=?) limit 1) limit 1);

-- 감독#2의 추천 영화 목록 전체 불러오기
select movie_nm from movie where movie_cd IN (SELECT recom_movie FROM test where type_nm=? and recom_director=(select people_cd from people where people_cd IN (select recom_director from test where type_nm=?) order by people_cd desc limit 1));
-- 감독#2의 추천 영화#1 (영화 제목 출력)
select movie_nm from movie where movie_cd=(SELECT recom_movie FROM test where type_nm=? and recom_director=(select people_cd from people where people_cd IN (select recom_director from test where type_nm=?) order by people_cd desc limit 1) limit 1);
-- 감독#2의 추천 영화#2 (영화 제목 출력)
select movie_nm from movie where movie_cd=(SELECT recom_movie FROM test where type_nm=? and recom_director=(select people_cd from people where people_cd IN (select recom_director from test where type_nm=?) order by people_cd desc limit 1) order by movie_cd desc limit 1);

-- TEST 결과 저장
insert into test_result values (? , (select typeid from test where type_nm=? limit 1));

-- 'TEST 다시하기' 버튼 눌렀을때
delete from test_result where userid=?;


-- ** 회원 정보 페이지(My page) ** --
-- 회원의 테스트 결과 유형 이름 출력
select type_title from test where typeid=(select typeid from test_result where userid=?);
