const menu = document.querySelector('.menu');
menu.addEventListener('click',function(){
    document.body.classList.toggle('menu-open');
});
window.addEventListener('click', function(e){ 
    if(e.target == document.querySelector('.overlay') || e.target == document.querySelector('.fa-times')){
        document.body.classList.toggle('menu-open');
    }
});
const submenu = document.querySelector('li#parent-menu');
submenu.addEventListener('click', (e) => {
    var child = submenu.childElementCount; // 2
    var a = submenu.childNodes[1].lastChild;
    if(a.classList.contains("fa-angle-right"))
    {
        a.classList.remove('fa-angle-right');
        a.classList.add('fa-angle-down');
    }
    else{
        a.classList.add('fa-angle-right');
        a.classList.remove('fa-angle-down');
    }
    submenu.childNodes[3].classList.toggle('active');
});
// click function dropdown
window.onclick = function(event){
    openCloseDropdown(event);
}
var func = document.querySelector('.function');
function openCloseDropdown(event){
    if(!event.target.matches('.dropdown-toggle')){
        func.classList.remove('dropdown');
    }
    else{
        func.classList.toggle('dropdown');
    }
}

var click_fb = document.querySelector('#clickfb');
var phanhoi = document.querySelector('.phanhoi-container');
var closePhanhoi = document.querySelector('.close-phanhoi');
if (click_fb) {
    click_fb.addEventListener('click', function () {
        phanhoi.classList.toggle('actives-phanhoi');
    });
}
if (phanhoi) {
    phanhoi.addEventListener('click', function (e) {
        var div = e.target;
        if (div.classList.contains('phanhoi-container')) {
            phanhoi.classList.remove('actives-phanhoi');
        }
    });
}
if (closePhanhoi) {
    closePhanhoi.addEventListener('click', function (e) {
        phanhoi.classList.remove('actives-phanhoi');
    });
}
