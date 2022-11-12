const qnaBlock=document.querySelector(".test-qna");
const statusBlock = document.querySelector(".qna-status");
let genre = {"스릴러/액션":0, "코미디":0, "로맨스":0, "드라마":0,"SF/판타지":0,"애니메이션":0, "다큐멘터리":0, "호러":0}


function loadPage(){
    showQuestion(0);
}

window.onload = loadPage;


function moveResultPage(genre) {
    location.replace(`./result.html?genre=${genre}`);
}

function showQuestion(qIdx){
    console.log("show Question")
    // console.log(qIdx, qnaList.length)


    console.log("goNext",qIdx, qnaList[qIdx]);
    let qNum = qnaBlock.querySelector(".qna-num");
    let qQuestion = qnaBlock.querySelector(".qna-question");
    
    qNum.innerHTML=`Q${qIdx+1}`;
    qQuestion.innerHTML=`${qnaList[qIdx].q}`;

    showChoices(qIdx,  qnaList[qIdx].a);
    updateProgressBar(qIdx);

}

function updateProgressBar(qIdx){
    let status = statusBlock.querySelector('.status-bar');
    status.style.width =(100/qnaList.length) * (qIdx+1)  + '%';
    //console.log(status,(100/qnaList.length) * (qIdx+1))
}

function getKeyFromMaxValue(obj) {
    const result = Object.keys(obj).reduce((a, b) => obj[a] > obj[b] ? a : b);
    // console.log(result);
    return result;
  }


function showChoices(qIdx,ans){

    const choiceBlock=qnaBlock.querySelector(".btn");

    for(let i in ans){
        // addAnswer(qnaList[qIdx].a[i].answer, qIdx);
        //console.log(ans[i].answer);
        let choice = document.createElement("button");
        choice.classList.add("btn-choice");
        choiceBlock.appendChild(choice);
        choice.innerText = ans[i].answer;
        choice.addEventListener("click", function(){
            let btns = choiceBlock.children;
            setTimeout(() => {
                let target = ans[i].type;
                for(let i = 0; i < target.length; i++){
                  genre[target[i]] += 1;
                }
                for(let i=0; i<btns.length; i++) {
                    btns[i].style.display = "none";
                }
                console.log(genre);
                if (qIdx+1 == qnaList.length){
                    const res = getKeyFromMaxValue(genre)
                    moveResultPage(res);
                    return;
                }

                showQuestion(++qIdx);
              },450)
        });
    }
}