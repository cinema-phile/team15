-- ** LEADER BOARD 페이지 **

-- *'여성' 버튼 선택*
-- '여성' 배역 (순위, 배역명) 랭킹 결과 조회
select rank() over (order by vote desc), cast_nm from characters a inner join character_ranking b on a.character_id=b.character_id where cast_nm!='' and sex='여자';
-- '여성' 배역 (순위, 배역명) 랭킹 TOP3 결과 조회
select rank() over (order by vote desc), cast_nm from characters a inner join character_ranking b on a.character_id=b.character_id where cast_nm!='' and sex='여자' limit 3;
-- '여성' 배역 (순위, 배역명, character_id) 랭킹 결과 조회
select rank() over (order by vote desc), cast_nm, a.character_id from characters a inner join character_ranking b on a.character_id=b.character_id where cast_nm!='' and sex='여자';
-- '여성' 배역 (순위, 배역명, character_id) 랭킹 TOP3 결과 조회
select rank() over (order by vote desc), cast_nm, a.character_id from characters a inner join character_ranking b on a.character_id=b.character_id where cast_nm!='' and sex='여자' limit 3;

-- *'남성' 버튼 선택*
-- '남성' 배역 (순위, 배역명) 랭킹 결과 조회
select rank() over (order by vote desc), cast_nm from characters a inner join character_ranking b on a.character_id=b.character_id where cast_nm!='' and sex='남자';
-- '남성' 배역 (순위, 배역명) 랭킹 TOP3 결과 조회
select rank() over (order by vote desc), cast_nm from characters a inner join character_ranking b on a.character_id=b.character_id where cast_nm!='' and sex='남자' limit 3;
-- '남성' 배역 (순위, 배역명, character_id) 랭킹 결과 조회
select rank() over (order by vote desc), cast_nm, a.character_id from characters a inner join character_ranking b on a.character_id=b.character_id where cast_nm!='' and sex='남자';
-- '남성' 배역 (순위, 배역명, character_id) 랭킹 TOP3 결과 조회
select rank() over (order by vote desc), cast_nm, a.character_id from characters a inner join character_ranking b on a.character_id=b.character_id where cast_nm!='' and sex='남자' limit 3;

-- *'전체보기'* (조건 없음)
-- 배역 (순위, 배역명) 랭킹 결과 조회
select rank() over (order by vote desc), cast_nm from characters a inner join character_ranking b on a.character_id=b.character_id where cast_nm!='';
-- 배역 (순위, 배역명) 랭킹 TOP3 결과 조회
select rank() over (order by vote desc), cast_nm from characters a inner join character_ranking b on a.character_id=b.character_id where cast_nm!='' limit 3;
-- 배역 (순위, 배역명, character_id) 랭킹 결과 조회
select rank() over (order by vote desc), cast_nm, a.character_id from characters a inner join character_ranking b on a.character_id=b.character_id where cast_nm!='';
-- 배역 (순위, 배역명, character_id) 랭킹 TOP3 결과 조회
select rank() over (order by vote desc), cast_nm, a.character_id from characters a inner join character_ranking b on a.character_id=b.character_id where cast_nm!='' limit 3;

-- 배역 득표수 조회
select vote from character_ranking where character_id=?;

-- 배역 작품명 조회
-- 방법 #1
select movie_nm from movie where movie_cd=(select movie_cd from characters where character_id=(select character_id from character_ranking where character_id=?));
-- 방법 #2
select movie_nm from movie where movie_cd=(select movie_cd from characters a inner join character_ranking b on a.character_id=b.character_id where a.character_id=?);

-- 배역을 맡은 배우 이미지 조회
-- 방법 #1
select profile from people where people_cd=(select people_cd from characters where character_id=(select character_id from character_ranking where character_id=?));
-- 방법 #2
select profile from people where people_cd=(select people_cd from characters a inner join character_ranking b on a.character_id=b.character_id where a.character_id=?);



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
-- 관심 영화 모아보기 개수 출력
select count(*) from star_movie where userid=?;
-- 관심 배우 모아보기 개수 출력
select count(*) from star_people where userid=?;
-- 관람 내역 (영화) 개수 출력
select count(*) from watch_movie where userid=?;
-- 최근 관람 영화명 출력
select movie_nm from movie where movie_cd=(select movie_cd from watch_movie where userid=? order by timestamps desc limit 1);

-- 관심 표시한 영화 모아보기 (영화명, 영화 포스터, 감독명/개봉일/장르)
select movie_nm, imgUrl, directors, open_yr, genre from movie where movie_cd IN (select movie_cd from star_movie where userid=?);
-- 관람 영화 목록 모아보기 (영화명, 영화 포스터, 감독명/개봉일/장르)
select movie_nm, imgUrl, directors, open_yr, genre from movie where movie_cd IN (select movie_cd from watch_movie where userid=?);
-- 관심 표시한 배우 모아보기 (배우 사진, 배우 이름, 필모 리스트)
select people_nm, filmo_names, profile from people where people_cd IN (select people_cd from star_people where userid=?);

-- 회원 정보 수정 (비밀번호, 이름 변경 가능)
update users set password=?, name=? where userid=?;
