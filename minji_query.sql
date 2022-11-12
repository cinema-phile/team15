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