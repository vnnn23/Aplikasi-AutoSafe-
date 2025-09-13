document.addEventListener('DOMContentLoaded', function() {
    const logo = document.querySelector('.logo-anim');
    const text = document.querySelector('.slide-text');
    const subtitle = document.querySelector('.subtitle');
    setTimeout(() => {
        logo.classList.add('active');
    }, 800); 
    setTimeout(() => {
        logo.classList.add('slide');
    }, 2000);
    setTimeout(() => {
        text.classList.add('active');
    }, 2500);
    setTimeout(() => {
        subtitle.classList.add('active');
    }, 3000); 
    setTimeout(function() {
        window.location.href = "/landingpage";
    }, 4000); 
});