const genreBlock=document.querySelector(".genre");
const listBlock=document.querySelector(".list");
const btnBlock=document.querySelector(".btn");

function loadPage(){
    showResult();
}

window.onload = loadPage;

/*"스릴러/액션":{
    name: ' 도파민 폭발! 짜릿한 스릴러/액션',
    desc: '선을 넘을 듯 말듯 아슬아슬한 스릴을 즐기는 당신! 엄선된 거장들의 영화를 통해 짜릿한 쾌감을 느껴 보세요.',
    rec : [{name:"쿠앤틴 타란티노", movie:["킬빌", "저수지의 개들"]}, 
              {name:"알프레드 히치콕", movie:["사이코", "현기증"]}],
      url:"../../img/action.svg"
  },*/

function showResult(){
    const result = getResultFromURL();
    showGenreInfo(result);
    showGenreItems(result);
  
}

function getResultFromURL(){

    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const genre = urlParams.get('genre');
    btnBlock.querySelector("input").value=genre;
    return genre;

}

function showGenreInfo(genre){
   // console.log(resultBlock)
    console.log("test end", genre,genreList[genre]);
    const genreInfo = genreList[genre]
    genreBlock.querySelector(".title3").innerText=genreInfo.name;
    genreBlock.querySelector(".title5").innerText=genreInfo.desc;
    //console.log(resultBlock.querySelector(".genre-img").querySelector("img"));
    genreBlock.querySelector(".genre-img").querySelector("img").src=genreInfo.url;

}

/*
<div class="item">
    <span class="title4">알프레드 히치콕</span>
    <div class="title4 line"></div>
    <span class="title5 movie-title">싸이코</span>
    <span class="title5 movie-title">싸이코</span>
</div>

*/

function showGenreItems(genre){
    const items=genreList[genre].rec;

   

    for (let i = 0; i<items.length;i++){

    let item = document.createElement("div");
    item.classList.add("item");;
    console.log(item)
    let title = document.createElement("span");
    title.classList.add("title4");
    let line = document.createElement("div");
    line.classList.add("title4","line");
        item.appendChild(title);
        title.innerText= items[i].name;
        item.appendChild(line);
        console.log(items[i].movie.length)
        for (let j =0; j<items[i].movie.length;j++){
            console.log(items[i].movie[j])
            let movie =document.createElement("span");
            movie.classList.add("title5", "movie-title");
            movie.innerText=items[i].movie[j];
            item.appendChild(movie);
        }

        listBlock.appendChild(item);
    }

}