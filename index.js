const backImg = document.querySelector(".back-img");

let img = ['01', '02', '03'];
let imgIndex = 1;

let switchImg = () => {
    backImg.setAttribute('class', 'back-img back-img-'+img[imgIndex]);
    imgIndex++;
    if(imgIndex > 2) imgIndex = 0;
};

window.setInterval(switchImg, 4000);