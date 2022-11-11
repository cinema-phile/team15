const startBlock=document.querySelector(".test-start");
const qnaBlock=document.querySelector(".test-qna");
const statusBlock = document.querySelector(".qna-status");
let genre = {"스릴러/액션":0, "코미디":0, "로맨스":0, "드라마":0,
"SF/판타지":0,"애니메이션":0, "다큐멘터리":0, "호러":0}

function showQuestion(qIdx){
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
    console.log(status,(100/qnaList.length) * (qIdx+1))
}



function showChoices(qIdx,ans){

    const choiceBlock=qnaBlock.querySelector(".btn");

    for(let i in ans){
        // addAnswer(qnaList[qIdx].a[i].answer, qIdx);
        console.log(ans[i].answer);
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

                showQuestion(++qIdx);
              },450)
        });
    }
}


// 장르 테스트 버튼 클릭 시 테스트 문항으로 넘어가는 함수
function start(){
    // console.log(startBlock);
    startBlock.style.display="none";
    qnaBlock.style.display="flex";
    statusBlock.style.display="block"
    showQuestion(0);
}