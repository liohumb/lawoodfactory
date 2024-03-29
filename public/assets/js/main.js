/*===== MENU SHOW =====*/ 
const showMenu = (toggleId, navId) =>{
    const toggle = document.getElementById(toggleId),
    nav = document.getElementById(navId)

    if(toggle && nav){
        toggle.addEventListener('click', ()=>{
            nav.classList.toggle('show')
        })
    }
}
showMenu('nav-toggle','nav-menu')

/*===== REMOVE MENU MOBILE =====*/
const navLink = document.querySelectorAll('.nav__link')

function linkAction(){
    /*Active link*/
    navLink.forEach(n => n.classList.remove('active'));
    this.classList.add('active');

    /*Remove menu mobile*/
    const navMenu = document.getElementById('nav-menu')
    navMenu.classList.remove('show')
}
navLink.forEach(n => n.addEventListener('click', linkAction))

/*===== POPULAR SWIPER =====*/
let swiperPopular = new Swiper('.products__mobile-container', {
    loop: true,
    spaceBetween: 30,
    slidesPerView: "auto",
    grabCursor: true,

    pagination: {
        el: ".swiper-pagination",
        dynamicBullets: true,
    },
    breakpoints: {
        768: {
            slidesPerView: 3,
        },
        1024: {
            spaceBetween: 48,
        },
    },
});

/*===== SHADOW NAVBAR ON SCROLL =====*/
window.addEventListener('scroll',(e)=>{
    const nav = document.getElementById('header');

    if (window.pageYOffset>0) {
        nav.classList.add("header__shadow");
    } else {
        nav.classList.remove("header__shadow");
    }
});

/*===== HIDE NAVBAR ON SCROLL =====*/
var lastScrollTop;

navbar = document.getElementById('header');

window.addEventListener('scroll',function(){
    var scrollTop = window.pageYOffset || document.documentElement.scrollTop;

    if (scrollTop > lastScrollTop) {
        navbar.style.top='-100px';
    } else {
        navbar.style.top='0';
    }

    lastScrollTop = scrollTop;
});