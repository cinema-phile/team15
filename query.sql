-- --------------------------------------------------------
-- # 1
-- 로그인 & 회원가입 페이지 (완료)
--

-- 회원가입 : user input (userid, password, name)
insert into users (userid, password, name, profile) values (?, ?, ?, ?);

-- 회원가입 : 아이디 중복 방지 -> 존재하면 1 존재하지 않으면 0 반환
select EXISTS (select * from users where userid = ?);

-- 로그인 : userid와 password 일치하는 회원 존재하는지 -> 존재하면 1, 존재하지 않으면 0 반환
select EXISTS (select * from users where userid = ? and password = ?);

-- --------------------------------------------------------
-- # 2
-- 메인페이지 - 영화 TOP5 watch_movie table에서 movie_cd 제일 많은 영화
--

-- 영화 TOP5
select * from movie 

-- --------------------------------------------------------
-- # 3
-- 메인페이지 - 검색 결과 (영화)
--

-- 영화명으로 검색
select movie_nm, open_yr, imgUrl from movie where INSTR(movie_nm, '%{$title}%');

-- 영화명 + 장르로 검색 (장르 단일 선택)
select movie_nm, open_yr, imgUrl from movie where INSTR(movie_nm, '%{$title}%') and INSTR(genre, '%{$genre}%');

-- 영화명 + 장르로 검색 (장르 복수 선택)
select movie_nm, open_yr, imgUrl from movie where INSTR(movie_nm, '%{$title}%') and INSTR(genre, '%{$genre}%') or INSTR(genre, '%{$genre}%');


-- 영화명으로 검색 (연도순 정렬)
select movie_cd, movie_nm, open_yr, imgUrl from movie where INSTR(movie_nm, '%{$title}%') group by open_yr with drill down;

-- 영화명 + 장르로 검색 (장르 단일 선택) (연도순 정렬)
select movie_cd, movie_nm, open_yr, imgUrl from movie where INSTR(movie_nm, '%{$title}%') and INSTR(genre, '%{$genre}%') group by open_yr with drill down;

-- 영화명 + 장르로 검색 (장르 복수 선택) (연도순 정렬)
select movie_cd, movie_nm, open_yr, imgUrl from movie where INSTR(movie_nm, '%{$title}%') and INSTR(genre, '%{$genre}%') or INSTR(genre, '%{$genre}%') group by open_yr with drill down;


-- (관람 등급)


-- --------------------------------------------------------
-- # 4
-- 메인페이지 - 검색 결과 (영화인)
--

-- 영화인 이름으로 검색
select people_cd, people_nm, rep_role_nm, sex, profile from people where INSTR(people_nm, '%{$name}%');

-- 영화인 이름 + 영화배우 옵션으로 검색
select people_cd, people_nm, rep_role_nm, sex, profile from people where INSTR(people_nm, '%{$name}%') and INSTR(rep_role_nm, '%{$role}%');

-- --------------------------------------------------------
-- # 5
-- 메인페이지 - 영화인 상세정보 (FILMOGRAPHY)
--

-- 영화인 상세정보 출력
select people_nm, people_nm_en, sex, profile from people where people_cd = ?;

-- 영화인 필모 이름 split해서 출력 (while문 돌리면서 i번째랑 people_cd 전달)
select substring_index(substring_index(filmo_names, '|', ?), '|', -1) from people where people_cd = ?;
-- ex) select substring_index(substring_index(filmo_names, '|', 4), '|', -1) from people where people_cd = 10000433; -> 4번째 작품 파싱되어 추출
-- => 전에 파싱한 작품 이름이랑 다음에 파싱한 작품 이름이 같을 경우 break로 빠져 나오기
-- => 이 값을 영화인 테이블에 update해서 column에 film_total로 저장해둘까요?? ㅇㅇ

-- 영화인 필모가 DB에 있는지 조회 -> 있으면 0 없으면 1 반환
select if (EXISTS (select movie_cd from movie where movie_nm = ?), true, false);

-- 영화인 필모 정보 불러오기
select movie_cd, imgUrl from movie where movie_nm = ?;

-- 영화인 맡은 배역 이름 불러오기
select cast_nm from characters where movie_cd = ? and people_cd = ?

-- 나의 팬 지수 : 유저가 봤다고 표시한 배우 참여 작품수 / 배우의 총 작품수 (film_total)
select count(
    select * from watch_movie where movie_cd = ?;
) as watchedCnt from watch_movie where userid = ?;
-- -> 즐겨찾기 테이블 -> people_cd 같은 row들을 다 카운트하는 문으로

-- 평균 팬 지수


-- 즐겨찾기 등록
insert into star_people (userid, people_cd) values (?, ?);

-- 즐겨찾기 삭제
delete from star_people where userid = ? and people_cd = ?;

-- --------------------------------------------------------
-- # 5
-- 메인페이지 - 영화 상세정보 (FILM)
--

-- 영화 상세정보 출력 (movie_cd, movie_nm, genre, runtime, age, stroy, open_yr, open_dt, nation, rate, directors, imgUrl)
select * from movie where movie_cd = ?;

-- 해당 유저가 봤는지 안 봤는지
select EXISTS (select * from watch_movie where userid = ? and movie_cd = ?);

-- 출연 배우 출력 (characters, people table join -> cast_nm, people_nm, profile, sex)
select c.cast_nm, p.people_nm, p.profile, p.sex from characters as c join people as p on c.people_cd = p.people_cd where c.movie_cd = ?;

