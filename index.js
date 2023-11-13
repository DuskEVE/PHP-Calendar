// 宣告每個要互動的document element
const backImg = document.querySelector('.back-img');
const imgBtn01 = document.querySelector('.nav-back-img-btn-01');
const imgBtn02 = document.querySelector('.nav-back-img-btn-02');
const imgBtn03 = document.querySelector('.nav-back-img-btn-03');
const imgBtn04 = document.querySelector('.nav-back-img-btn-04');
const imgBtn05 = document.querySelector('.nav-back-img-btn-05');

// img陣列存放所有背景圖片的名稱
let img = ['01', '02', '03', '04', '05'];
let btns = [imgBtn01, imgBtn02, imgBtn03, imgBtn04, imgBtn05];
let imgIndex = 1;

// resetOnBtn 會將目前背景圖片導航按鈕中有class on的element重設為非選取狀態(也就是將class列表的on移除，並將icon改為空心圓)
const resetOnBtn = () => {
    let onBtn = document.querySelector('.on');

    onBtn.classList.remove('fa-solid', 'on');
    onBtn.classList.add('fa-regular');
}
// setOnBtn 會將目標的背景圖片導航按鈕的element設為選取狀態(也就是將class列表加入on，並將icon改為實心圓)
const setOnBtn = (target) => {
    target.classList.remove('fa-regular');
    target.classList.add('fa-solid', 'on');
}
// switchImgAuto 用於自動循序切換背景圖片
const switchImgAuto = () => {
    backImg.className = `back-img back-img-${img[imgIndex]}`;
    resetOnBtn();
    setOnBtn(btns[imgIndex]);
    imgIndex++;
    if(imgIndex > 4) imgIndex = 0;
};
// 用setInterval設定每5秒呼叫switchImgAuto來自動循序切換背景圖片
let backImgTimer = setInterval(switchImgAuto, 5000);
// switchImg 用於處理當背景圖片導航按鈕的點擊事件(click event)被觸發時，切換背景圖片導航按鈕列的icon以及切換背景圖片和重設自動切換背景的timer
const switchImg = (event) => {
    let target = event.target;
    let className = target.className;

    resetOnBtn();
    setOnBtn(target);

    for(let i=0; i<img.length; i++){
        if(className.match(img[i]) !== null){
            imgIndex = i;
            backImg.className = `back-img back-img-${img[imgIndex]}`;
            break;
        }
    }

    clearInterval(backImgTimer);
    backImgTimer = setInterval(switchImgAuto, 5000);
};

// 為每一個背景圖案切換按鈕設定event listener
for(let i=0; i<btns.length; i++){
    btns[i].addEventListener('click', switchImg);
}