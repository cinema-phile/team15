-- --------------------------------------------------------
-- # 1
-- 로그인 & 회원가입 페이지 (완료)
-- INSERT 1, SELECT 2

-- 회원가입 : user input (userid, password, name)
insert into users (userid, password, name, profile) values (?, ?, ?, ?);

-- 회원가입 : 아이디 중복 방지 -> 존재하면 1 존재하지 않으면 0 반환
select EXISTS (select * from users where userid = ?);

-- 로그인 : userid와 password 일치하는 회원 존재하는지 -> 존재하면 1, 존재하지 않으면 0 반환
select EXISTS (select * from users where userid = ? and password = ?);

-- --------------------------------------------------------
-- # 2
-- 메인페이지 - 영화 TOP5 watch_movie table에서 movie_cd 제일 많은 영화
-- SELECT 2, ROLLUP

-- 영화 TOP5 (유저들이 가장 많이 본 영화)
select m.movie_cd, m.movie_nm, m.imgUrl, cntMovie from movie m JOIN ( 
    select movie_cd, count(movie_cd) as 'cntMovie'
    from watch_movie
    group by movie_cd
) c on m.movie_cd = c.movie_cd order by c.cntMovie desc limit 5;

-- 가장 최신에 개봉한 영화
select * from (
    select movie_cd, movie_nm, imgUrl, open_dt
    from movie
    group by open_dt with rollup
) a order by a.open_dt desc limit 5;

-- --------------------------------------------------------
-- # 3
-- 메인페이지 - 검색 결과 (영화)
-- SELECT 8

-- 영화명으로 검색
select movie_nm, open_yr, imgUrl from movie where INSTR(movie_nm, ?);

-- 영화명 + 장르로 검색 (장르 단일 선택)
select movie_nm, open_yr, imgUrl from movie where INSTR(movie_nm, ?) and INSTR(genre, ?);

-- 영화명 + 장르로 검색 (장르 복수 선택)
select movie_nm, open_yr, imgUrl from movie where INSTR(movie_nm, ?) and INSTR(genre, ?) or INSTR(genre, ?);


-- 영화명으로 검색 (연도순 정렬)
select * from (
    select movie_cd, movie_nm, open_yr, imgUrl
    from movie
    where INSTR(movie_nm, ?)
    group by open_yr with rollup
) a order by a.open_yr desc;

-- 영화명 + 장르로 검색 (장르 단일 선택) (연도순 정렬)
select * from (
    select movie_cd, movie_nm, open_yr, imgUrl
    from movie
    where INSTR(movie_nm, ?) and INSTR(genre, ?)
    group by open_yr with rollup
) a order by a.open_yr desc;

-- 영화명 + 장르로 검색 (장르 복수 선택) (연도순 정렬)
select * from (
    select movie_cd, movie_nm, open_yr, imgUrl
    from movie
    where INSTR(movie_nm, ?) and INSTR(genre, ?) or INSTR(genre, ?)
    group by open_yr with rollup
) a order by a.open_yr desc;


-- 영화명 + 관람 등급 검색 (관람 등급 단일 선택) (연도순 정렬)
select * from (
    select movie_cd, movie_nm, open_yr, imgUrl
    from movie
    where INSTR(movie_nm, ?) and INSTR(age, ?)
    group by open_yr with rollup
) a order by a.open_yr desc;

-- 영화명 + 관람 등급 검색 (관람 등급 복수 선택) (연도순 정렬)
select * from (
    select movie_cd, movie_nm, open_yr, imgUrl
    from movie
    where INSTR(movie_nm, ?) and INSTR(age, ?) or INSTR(age, ?)
    group by open_yr with rollup
) a order by a.open_yr desc;

-- --------------------------------------------------------
-- # 4
-- 메인페이지 - 검색 결과 (영화인)
-- SELECT 2

-- 영화인 이름으로 검색
select people_cd, people_nm, rep_role_nm, sex, profile from people where INSTR(people_nm, ?);

-- 영화인 이름 + 영화배우 옵션으로 검색
select people_cd, people_nm, rep_role_nm, sex, profile from people where INSTR(people_nm, ?) and INSTR(rep_role_nm, ?);

-- --------------------------------------------------------
-- # 5
-- 메인페이지 - 영화인 상세정보 (FILMOGRAPHY)
-- SELECT 5, UPDATE 1, INSERT 1, DELETE 1

-- 영화인 상세정보 출력
select people_nm, people_nm_en, sex, profile from people where people_cd = ?;

-- 영화인 필모 이름 split해서 출력 (while문 돌리면서 i번째랑 people_cd 전달)
select substring_index(substring_index(filmo_names, '|', ?), '|', -1) from people where people_cd = ?;
-- ex) select substring_index(substring_index(filmo_names, '|', 4), '|', -1) from people where people_cd = 10000433; -> 4번째 작품 파싱되어 추출
-- => 전에 파싱한 작품 이름이랑 다음에 파싱한 작품 이름이 같을 경우 break로 빠져 나오기
-- => 이 값을 영화인 테이블에 update해서 column에 film_total로 저장해둘까요?? 저장하기로!! -> DB 반영 완료

-- film_total 값 업데이트
update people set film_total = ? where people_cd = ?;

-- 영화인 필모가 DB에 있는지 조회 -> 있으면 0 없으면 1 반환
select if (EXISTS (select movie_cd from movie where movie_nm = ?), true, false);

-- 영화인 필모 정보 불러오기
select movie_cd, imgUrl from movie where movie_nm = ?;

-- 영화인 맡은 배역 이름 불러오기
select cast_nm from characters where movie_cd = ? and people_cd = ?

-- 나의 팬 지수 : 유저가 봤다고 표시한 배우 참여 작품수 / 배우의 총 작품수 (film_total)
create procedure team15.calcMyFanRatio()
begin
    declare i int default 1;
    while (i <= (select film_total from people where people_cd = ?)) do 
        select substring_index(substring_index(filmo_names, '|', i), '|', -1) from people where people_cd = ?;
        set i = i + 1;
    end while;

    
end
-- -> 즐겨찾기 테이블 -> people_cd 같은 row들을 다 카운트하는 문으로??

-- 평균 팬 지수


-- 즐겨찾기 등록
insert into star_people (userid, people_cd) values (?, ?);

-- 즐겨찾기 삭제
delete from star_people where userid = ? and people_cd = ?;

-- --------------------------------------------------------
-- # 5
-- 메인페이지 - 영화 상세정보 (FILM)
-- SELECT 3, INSERT 1, DELETE 1

-- 영화 상세정보 & 배역 정보 출력
select m.*, c.cast_nm, p.people_nm, p.profile, p.sex
from characters as c
left join movie as m on m.movie_cd = c.movie_cd
left join people as p on c.people_cd = p.people_cd
where c.movie_cd = ?;

-- 해당 유저가 봤는지 안 봤는지 -> 봤으면 1 보지 않았으면 0
select EXISTS (select * from watch_movie where userid = ? and movie_cd = ?);

-- 영화 관람 퍼센티지 계산 : 관람한 유저 수(cntMovie), 총 유저 수(cntMovie)
select cntMovie, cntUser from ( 
    select movie_cd, count(movie_cd) as 'cntMovie'
    from watch_movie
    group by movie_cd
) c, (
    select count(*) as 'cntUser'
    from users
) u where c.movie_cd = ?;

-- 본 영화로 등록
insert into watch_movie (userid, movie_cd) values (?, ?);

-- 본 영화 삭제
delete from watch_movie where userid = ? and movie_cd = ?;

-- --------------------------------------------------------
-- # 6
-- 커뮤니티 : 자유게시판
-- 

-- 게시글 목록 출력 (최신순 정렬)
select f.boardid_free, f.title, f.content, f.timestamps, u.name, u.profile, c.content, c.like_no, c.hate
from board_free as f
left join users as u on f.userid = u.userid
left join comment_free as c on f.boardid_free = c.boardid_free
where (
    c.commentid_free = (
        select r.best from (
            select b.commentid_free as best, max(b.diff) 
            from (
                select commentid_free, (a.like_no - a.hate) as diff
                from comment_free as a
            ) b
        ) r
    )
) order by f.timestamps desc;

-- 게시글 작성
insert into board_free (userid, title, content) values (?, ?, ?);

-- 게시글 수정
update board_free set title = ?, content = ? where boardid_free = ?;

-- 게시글 삭제
delete from board_free where boardid_free = ?;

-- 게시글 상세 출력
select f.boardid_free, f.title, f.content, f.timestamps, u.name, u.profile
from board_free as f
inner join users as u on f.userid = u.userid

-- Best 댓글 2개 출력
select c.userid, c.content, c.like_no, c.hate from comment_free as c join (
    select commentid_free, (a.like_no - a.hate) as diff
    from comment_free as age
) b on c.commentid_free = b.comment_free order by b.diff desc limit 2;

-- 최신 댓글 순 정렬
select * from comment_free order by timestamps desc;

-- 댓글 작성
insert into comment_free (boardid_free, userid, content) values (?, ?, ?);

-- 댓글 수정
update comment_free set content = ? where commentid_free = ?;

-- 댓글 삭제
delete from comment_free where commentid_free = ?;

-- 좋아요
update comment_free set like_no = (like_no + 1) where commentid_free = ?;

-- 싫어요
update comment_free set hate = (hate + 1) where commentid_free = ?;
