function collapseSidebar() {
    document.body.classList.toggle('sidebar-expand');
    subMenu.forEach(item => {
        item.children[1].classList.remove('active');
    });
}

window.onclick = function (event) {
    openCloseDropdown(event);
}

// close all dropdown
function closeAllDropdown() {
    var dropdowns = document.querySelectorAll('.dropdown-expand');
    dropdowns.forEach(drops => {
        drops.classList.remove('dropdown-expand');
    })
}

function openCloseDropdown(event) {
    if (!event.target.matches('.dropdown-toggle')) {
        // close dropdown when click outside menu
        closeAllDropdown();
    }
    else {
        var toggle = event.target.dataset.toggle;
        //console.log(toggle);
        var content = document.querySelector(`#${toggle}`);
        //console.log(content);
        if (content.classList.contains('dropdown-expand')) {
            closeAllDropdown();
        }
        else {
            closeAllDropdown();
            content.classList.add('dropdown-expand');
        }
    }
}
/// sub menu
const subMenu = document.querySelectorAll('.has-sub');
subMenu.forEach(item => {
    item.addEventListener('click', (e) => {
        e.preventDefault();
        //alert("you just clicked me");
        console.log(item.children[1]);
        item.children[1].classList.toggle('active');
    });
});
// phan hoi
var phanhoi = document.querySelector('.phanhoi-container');
var closePhanhoi = document.querySelector('.close-phanhoi');
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
// feedback
var feedback = document.querySelector(".feedback-container");
var fb = document.querySelector(".feedback-fixed");
if (feedback) {
    feedback.addEventListener('click', function (e) {
        var div = e.target;
        if (div.classList.contains('feedback-container')) {
            feedback.classList.remove("actives");
        }
    });
}
var fb_close = document.querySelector('.close');
if (fb_close) {
    fb_close.addEventListener('click', function (e) {
        e.preventDefault();
        feedback.classList.remove("actives");
    });
}
// assigned person
var assign = document.querySelector(".assigned-container");
if (assign) {
    assign.addEventListener('click', function (e) {
        var div = e.target;
        if (div.classList.contains('assigned-container')) {
            assign.classList.remove("actives");
        }
    });
}
var assign_close = document.querySelector('.assigned-close');
if (assign_close) {
    assign_close.addEventListener('click', function (e) {
        e.preventDefault();
        assign.classList.remove("actives");
    });
}