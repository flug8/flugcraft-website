

// VARIABLES

const isTouchDevice = () => {  
    return (('ontouchstart' in window) ||  
      (navigator.maxTouchPoints > 0) ||  
      (navigator.msMaxTouchPoints > 0));  
}  
console.log("isTouchDevice -> " + isTouchDevice())


var mouseonheader = false;
var productinactive = true;
var burgeractive = false;
var fiverractive = false;

var headerwhite = true;

var galleryRows = 2;
var gallerySpaceW = 30;


// FUNCTIONS


function headerDefault() {
    if(headerwhite){
        document.getElementById("header").classList.remove("header3");
    }else{
        document.getElementById("header").classList.add("header3");
    }
}

function fixwidth(){
    const w = window.innerWidth;
    if(w > 960 && burgeractive == true) {
        hideBurgerNavigationMenu();
        burgeractive = false;
    }
    if(w <= 960 && productinactive == false){
        moh = mouseonheader;
        console.log("Modified onheader status! (old:" + moh + ")");
        mouseOnHeaderStatus(false);
        hideProductNavigationMenu();
        productinactive = true;
        setTimeout(mouseOnHeaderStatus, 10, moh);
    }
    if(w <= 600 ) {
        galleryRows = 2;
        gallerySpaceW = 10;
        document.body.style.setProperty("--gallery-rows", 2);
        document.body.style.setProperty("--gallery-space-w", "10px");
    }else{
        galleryRows = 4;
        gallerySpaceW = 30;
        document.body.style.setProperty("--gallery-rows", 4);
        document.body.style.setProperty("--gallery-space-w", "30px");
    }
}

function hideAll() {
    const moh = mouseonheader;
    mouseOnHeaderStatus(false);
    hideBurgerNavigationMenu();
    hideFiverrNavigationMenu();
    hideProductNavigationMenu();
    mouseOnHeaderStatus(moh);

}

function mouseOnHeaderStatus(n){
    mouseonheader = n;
}

function showNavigationHoverEffect(id){
    document.getElementById(id + "run").style.transform = "translateY(6px)";
}

function hideNavigationHoverEffect(id){
    if(productinactive || id !== "hover1"){
        document.getElementById(id + "run").style.transform = "translateY(0px)";
    }
}

function resizeHeaderOnScroll() {
    const YPos = window.pageYOffset || document.documentElement.scrollTop;
    
}

function toggleBurgerNavigation() {
    if(!burgeractive){
        showBurgerNavigationMenu();
        console.log("on");
        burgeractive = true;
    }else{
        hideBurgerNavigationMenu();
        console.log("off");
        burgeractive = false;
    }
}

function hideFiverrOnMobile () {

    if(isTouchDevice() == true) {}
        if(fiverractive == true) {
            console.log("mobile"+ window.innerWidth);
            hideFiverrNavigationMenu();
        }else{
            showFiverrNavigationMenu();
            console.log("YAY");
        }
        console.log("MOBILE");
    console.log("TOUCHED" + isTouchDevice());
}







function showFiverrNavigationMenu() {
    const check = document.getElementById("popupMOF").style.height
    hideBurgerNavigationMenu();
    console.log(check);
    if(check == false || check == "0px"){
        /*console.log(check + "!")
        const c = window.getComputedStyle( document.body , null).getPropertyValue("background-color");
        const c2 = window.getComputedStyle( document.getElementById("whitecolor") , null).getPropertyValue("color");*/
        document.getElementById("arrowMOF").style.transform = "rotate(90deg)";
        /*document.getElementById("arrowMOFPath").style.stroke = c;
        document.getElementById("fiverrMOFPath").style.fill = c;
        document.getElementById("fiverrMOFCircle").style.fill = c;*/
        var h = 220 + document.getElementById("heaL").clientHeight;
        document.getElementById("popupMOF").style.height = h + "px";
        /*document.getElementById("header-wrapper").style.borderBottomColor = c2;
        document.getElementById("btna").style.backgroundColor = c2;
        document.getElementById("btnatxt").style.color = c;*/
        document.getElementById("bgMOF").style.opacity = ".3";
        document.getElementById("bgMOF").style.pointerEvents = "auto";
        setTimeout(function() {fiverractive = true}, 150) ;
        /*for(var i=0; i<3; i++) {
            j = i+1;
            document.getElementById("line"+ j).style.backgroundColor = c2;      
        }
        for(var i=0; i<4; i++) {
            j = i+1;
            document.getElementById("hover" + j).style.color = c2;        
        }
        for(var i=0; i<4; i++) {
            j = i+1;
            document.getElementById("hover" + j + "run").style.backgroundColor = c2;        
        }*/
        document.getElementById("header").classList.add("header3");
        for(var i=0; i<3; i++) {
            const m = document.getElementById("MOFLE" + (i+1));
            m.style.transitionDuration = "1s";
            m.style.transitionDelay = i*.15 +"s";
            m.style.transform = "translate(0px,0px)";
            m.style.opacity = "1";
            m.style.pointerEvents = "auto";
        }

    }
}






function hideFiverrNavigationMenu() {
    const check = document.getElementById("popupMOF").style.height 
    if(check !== false && check !== "0px"){
    if(mouseonheader==false){
        /*const c = window.getComputedStyle( document.body , null).getPropertyValue("background-color");
        const c2 = window.getComputedStyle( document.getElementById("whitecolor") , null).getPropertyValue("color");*/
        document.getElementById("arrowMOF").style.transform = "rotate(0deg)";
        /*document.getElementById("arrowMOFPath").style.stroke = c2;
        document.getElementById("fiverrMOFPath").style.fill = c2;
        document.getElementById("fiverrMOFCircle").style.fill = c2;*/
        document.getElementById("popupMOF").style.height = "0px";
        /*document.getElementById("header-wrapper").style.borderBottomColor = c;
        document.getElementById("btna").style.backgroundColor = c;
        document.getElementById("btnatxt").style.color = c2;*/
        document.getElementById("bgMOF").style.opacity = "0";
        document.getElementById("bgMOF").style.pointerEvents = "none";
        /*for(var i=0; i<3; i++) {
            j = i+1;
            document.getElementById("line"+ j).style.backgroundColor = c;      
        }*/
        setTimeout(function() {fiverractive = false}, 150) ;
        headerDefault();
    /*for(var i=0; i<4; i++) {
        j = i+1;
        document.getElementById("hover" + j).style.color = c;        
    }
    for(var i=0; i<4; i++) {
        j = i+1;
        document.getElementById("hover" + j + "run").style.backgroundColor = c;        
    }*/
    for(var i=0; i<3; i++) {
        j = i+1;
        const m = document.getElementById("MOFLE" + j);
        m.style.transitionDuration = ".1s";
        m.style.transform = "translate(0px, -30px)";
        m.style.opacity = "0";
        m.style.transitionDelay = "0s";
        m.style.pointerEvents = "none";
    }
    }
    }
    
}






function showProductNavigationMenu() {
    const check = document.getElementById("popupP").style.height
    if(check == false || check == "0px"){
        /*const c = window.getComputedStyle( document.body , null).getPropertyValue("background-color");
        const c2 = window.getComputedStyle( document.getElementById("whitecolor") , null).getPropertyValue("color");
        //document.getElementById("arrowMOF").style.transform = "rotate(90deg)";
        document.getElementById("arrowMOFPath").style.stroke = c2;
        document.getElementById("fiverrMOFPath").style.fill = c2;
        document.getElementById("fiverrMOFCircle").style.fill = c2;*/
        document.getElementById("popupP").style.height = "620px";
        /*document.getElementById("header-wrapper").style.borderBottomColor = c;
        document.getElementById("btna").style.backgroundColor = c;
        document.getElementById("btnatxt").style.color = c2;*/
        document.getElementById("bgMOF").style.opacity = ".3";
        document.getElementById("bgMOF").style.pointerEvents = "auto";
        productinactive = false;
        document.getElementById("header").classList.remove("header3");
        /*for(var i=0; i<4; i++) {
            j = i+1;
            document.getElementById("hover" + j).style.color = c;        
        }
        for(var i=0; i<4; i++) {
            j = i+1;
            document.getElementById("hover" + j + "run").style.backgroundColor = c;        
        }*/
        for(var i=0; i<5; i++) {
            const m = document.getElementById("proLE" + (i+1));
            m.style.transitionDuration = "1s";
            m.style.transitionDelay = i*.15 +"s";
            m.style.transform = "translate(0px,0px)";
            m.style.opacity = "1";
            m.style.pointerEvents = "auto";
        }

    }
}




function hideProductNavigationMenu() {
    const check = document.getElementById("popupP").style.height 
    if(check == "620px"){
    if(mouseonheader==false){
        /*const c = window.getComputedStyle( document.body , null).getPropertyValue("background-color");
        const c2 = window.getComputedStyle( document.getElementById("whitecolor") , null).getPropertyValue("color");
        //document.getElementById("arrowMOF").style.transform = "rotate(0deg)";
        document.getElementById("arrowMOFPath").style.stroke = c2;
        document.getElementById("fiverrMOFPath").style.fill = c2;
        document.getElementById("fiverrMOFCircle").style.fill = c2;*/
        document.getElementById("popupP").style.height = "0px";
        /*document.getElementById("header-wrapper").style.borderBottomColor = c;
        document.getElementById("btna").style.backgroundColor = c;
        document.getElementById("btnatxt").style.color = c2;*/
        document.getElementById("bgMOF").style.opacity = "0";
        document.getElementById("bgMOF").style.pointerEvents = "none";
        productinactive = true;
        hideNavigationHoverEffect("hover1");
        headerDefault();
    /*for(var i=0; i<4; i++) {
        j = i+1;
        document.getElementById("hover" + j).style.color = c;        
    }
    for(var i=0; i<4; i++) {
        j = i+1;
        document.getElementById("hover" + j + "run").style.backgroundColor = c;        
    }*/
    for(var i=0; i<5; i++) {
        j = i+1;
        const m = document.getElementById("proLE" + j);
        m.style.transitionDuration = ".1s";
        m.style.transform = "translate(0px, -60px)";
        m.style.opacity = "0";
        m.style.transitionDelay = "0s";
        m.style.pointerEvents = "none";
    }
    }
    }
    
}










function showBurgerNavigationMenu() {
    mouseOnHeaderStatus(false);
    hideFiverrNavigationMenu();
    mouseOnHeaderStatus(true);
    const check = document.getElementById("burgerpopup").style.height
    if(check == false || check == "0px"){
        /*const c = window.getComputedStyle( document.body , null).getPropertyValue("background-color");
        const c2 = window.getComputedStyle( document.getElementById("whitecolor") , null).getPropertyValue("color");
        //document.getElementById("arrowMOF").style.transform = "rotate(90deg)";
        document.getElementById("arrowMOFPath").style.stroke = c;
        document.getElementById("fiverrMOFPath").style.fill = c;
        document.getElementById("fiverrMOFCircle").style.fill = c;*/
        document.getElementById("burgerpopup").style.height = "200vh";
        /*document.getElementById("header-wrapper").style.borderBottomColor = c2;
        document.getElementById("btna").style.backgroundColor = c2;
        document.getElementById("btnatxt").style.color = c;*/
        burgeractive = true;
        document.getElementById("header").classList.add("header3");
        /*for(var i=0; i<3; i++) {
            j = i+1;
            document.getElementById("line"+ j).style.backgroundColor = c2;      
        }*/
        document.getElementById("line1").style.transform = "translateY(10px) rotate(45deg)";
        document.getElementById("line1").style.width = "35px";
        document.getElementById("line3").style.transform = "translateY(-10px) rotate(-45deg)";
        document.getElementById("line3").style.width = "35px";
        document.getElementById("line2").style.width = "3px";
        for(var i=0; i<4; i++) {
            const m = document.getElementById("BNE" + (i+1));
            m.style.transitionDuration = "1s";
            m.style.transitionDelay = i*.15 +"s";
            m.style.transform = "translate(0px,0px)";
            m.style.opacity = "1";
            m.style.pointerEvents = "auto";
        }

    }
}




function hideBurgerNavigationMenu() {
    const check = document.getElementById("burgerpopup").style.height 
    if(check == "200vh"){
        /*const c = window.getComputedStyle( document.body , null).getPropertyValue("background-color");
        const c2 = window.getComputedStyle( document.getElementById("whitecolor") , null).getPropertyValue("color");
        //document.getElementById("arrowMOF").style.transform = "rotate(0deg)";
        document.getElementById("arrowMOFPath").style.stroke = c2;
        document.getElementById("fiverrMOFPath").style.fill = c2;
        document.getElementById("fiverrMOFCircle").style.fill = c2;*/
        document.getElementById("burgerpopup").style.height = "0px";
        /*document.getElementById("header-wrapper").style.borderBottomColor = c;
        document.getElementById("btna").style.backgroundColor = c;
        document.getElementById("btnatxt").style.color = c2;
        for(var i=0; i<3; i++) {
            j = i+1;
            document.getElementById("line"+ j).style.backgroundColor = c;      
        }*/
        headerDefault();
        document.getElementById("line1").style.transform = "none";
        document.getElementById("line1").style.width = "30px";
        document.getElementById("line3").style.transform = "none";
        document.getElementById("line3").style.width = "30px";
        document.getElementById("line2").style.width = "30px";
        burgeractive = false;
    for(var i=0; i<4; i++) {
        j = i+1;
        const m = document.getElementById("BNE" + j);
        m.style.transitionDuration = ".1s";
        m.style.transitionDelay = "0s";
        m.style.transform = "translate(0px, -60px)";
        m.style.opacity = "0";
        m.style.pointerEvents = "none";
    }
}
    
}


/*
    2: color3
    3: invert wrapper (do not use)
    4: transparent
    5: color2
*/

function headerBackgroundColor (u = 0) {
    const header = document.getElementById("header").classList;
    if(window.location.pathname == "/about") {
        if(document.getElementById("otherprojects").getBoundingClientRect().y < 120){
            header.remove("header2");
        }else{
            header.add("header2");
        }
    }else if(window.location.pathname == "/") {
        const h2 = document.querySelector(".home2").getBoundingClientRect().y;
        const h3 = document.querySelector(".home3");
        const h4 = document.querySelector(".home4").getBoundingClientRect().y;
        header.remove("header2", "header4", "header5");
        if (h4 < 120) {
            headerwhite = true;
            headerDefault();
        } else if( h3.getBoundingClientRect().y < 120 && window.getComputedStyle(h3).display !== "none") {
            header.add("header2");
            headerwhite = true;
            headerDefault();
        } else if (h2 < 120) {
            headerwhite = true;
            headerDefault();
        } else if (true) {
            header.add("header4");
            headerwhite = false;
            headerDefault();
        }
    }else if(window.location.pathname == "/contact"){
        header.add("header2");
    }
}











function textareaAutoGrow(element){
    element.style.height = "auto";
    element.style.height = (element.scrollHeight) + "px";
    console.log(element.scrollHeight);
}



















// EVENT LISTENER


window.addEventListener("scroll", resizeHeaderOnScroll);
window.addEventListener("scroll", headerBackgroundColor);
window.addEventListener("resize", fixwidth);
window.addEventListener("scroll", toggleHeader);
window.addEventListener("scroll", hideAll);
window.addEventListener("resize", function () {
    galleryHeight();
    const h = document.querySelectorAll(".mgridH");
    for (let i = 0; i < h.length ; i++) {
        h[i].style.height = ( ( document.querySelector(".mgrid").clientWidth / galleryRows - gallerySpaceW / galleryRows) * 2 + 10 ) + "px";
    }
    const w = document.querySelectorAll(".mgridW");
    for (let i = 0; i < w.length ; i++) {
        w[i].style.width = ( ( document.querySelector(".mgrid").clientWidth / galleryRows - gallerySpaceW / galleryRows) * 2 + 10 ) + "px";
    }
})






window.transitionToPage = function(href) {
    document.getElementById("transition").style.opacity = 1;
    document.getElementById("transition").style.pointerEvents = "auto";
    setTimeout(function() { 
        window.location.href = href
    }, 500)
}

document.addEventListener('DOMContentLoaded', function(event) {
    document.getElementById("transition").style.opacity = 0;
    document.getElementById("transition").style.pointerEvents = "none";
    window.scrollTo(0,0);
    headerBackgroundColor(1);
    if(window.location.pathname == "/"){
        typeIt1();
    }else if(window.location.pathname == "/contact"){
        document.querySelector("textarea").setAttribute("oninput","textareaAutoGrow(this)");
        document.querySelector("textarea").setAttribute("rows","2");
    }else if(window.location.pathname == "/gallery"){
        fixwidth();
        randomizeChildren("mgrid")
        galleryHeight();
        loadGallery();
        Packery1();
        randomGallery();
        
    }
    
    
})

function galleryHeight() {document.body.style.setProperty("--mgrid-item-width", ( document.querySelector(".mgrid").clientWidth / galleryRows - gallerySpaceW / galleryRows) + "px");};

window.addEventListener("focus", function(event) {
    document.getElementById("transition").style.opacity = 0;
    document.getElementById("transition").style.pointerEvents = "none";
    headerBackgroundColor();
})




function typeIt1 () {
    const t = new TypeIt("#typeithome", {
        speed: 50,
        startdelay: 900,
        waitUntilVisible: true,
        lifeLike: true,
        afterComplete: function (instance) {
            if(window.innerWidth < 430) {
                document.getElementById("typeithomecolored").style.fontSize = "64px";  
            }else{
                document.getElementById("typeithomecolored").style.fontSize = "84px";
            }
            document.getElementById("typeithomecolored").style.color = "rgb(75,178,221)";
            setTimeout(function() {t.destroy(removeCursor = true);},200)
        }
    })
        .type("Make <strong class='typeithomecolored2'>your project</strong> better", {delay:1000})
        /*.move(-7, {delay:100})
        .delete(2, {delay:100})
        .type("<strong class='typeithomecolored2'>your project</strong>", {delay:1000})
        .move(7 , {delay:200})*/
        .delete(6)
        .type("not just better, ", {delay:700})
        .type("make it")
        .break()
        .type("<strong id='typeithomecolored'>stand out!</strong>")
        .go();
        

        
}


document.addEventListener("scroll", function(e) {
    if(window.location.pathname == '/'){
    var h = document.querySelector(".homemain").clientHeight;
    var y = window.scrollY;
    if(y >= h){
        //document.querySelector(".homemain2").style.display = "none";
    }
    document.querySelector(".homemain2").style.display = "auto";
    document.querySelector(".homemain2").style.transform = "translateY(" + ( ( y + y / h *120 ) / 2 ) + "px)";
    //document.querySelector("#typeithome").style.zoom = ( h - y / 3) / h;
    document.querySelector("#typeithome").style.transform = "translateY(" + ( ( y + y / h *120 ) / 3 ) + "px)";
    document.querySelector("#typeithome").style.opacity = ( ( h - 120 ) - y * 1.2 ) / h;
    }
    
});

var pScrollPos = window.pageYOffset;

function toggleHeader() {
    var cScrollPos = window.pageYOffset;

    if(pScrollPos < cScrollPos && cScrollPos >= 120) {
        document.getElementById("header").style.transform = "translateY(-120px)";
    }else{
        document.getElementById("header").style.transform = "translateY(0px)";
    }

    pScrollPos = cScrollPos;
}





function Packery1 () {
    var elem = document.querySelector('.mgrid');
    var msnry = new Packery( elem, {
      // options
      itemSelector: '.mgrid-item',
      percentPosition: true,
      gutter: 10,
    });
    }


const randomizeChildren = ((d) => {
    const e = document.querySelector("." + d);
    const n = e.cloneNode(true);
    const c = n.children;
    const f = document.createDocumentFragment();

    while (c.length > 0) {
        f.appendChild( c [Math.floor(Math.random() * c.length)] );
    };

    e.innerHTML = "";
    e.appendChild(f);
});


function loadGallery () {
    var img = document.querySelectorAll('.mgrid-item img'), i;

    for (i = 0; i < img.length; ++i) {
        console.log(i);
        var data = img[i].getAttribute("data-src");
        img[i].setAttribute("src" , data);
    }
}




function randomGalleryW (a) {
    for (let i = 0; i < a; i++){
        const e = document.querySelectorAll(".mgrida");
        let num = generateRandomInteger(e.length - 5);
        console.log(a);
        e[num].style.width = ( e[num].clientWidth * 2 + 10 ) + "px";
        e[num].classList.remove("mgrida");
        e[num].classList.add("mgridW");
        Packery1();
    }
}

function randomGalleryH (a) {
    for (let i = 0; i < a; i++){
        const e = document.querySelectorAll(".mgrida");
        let num = generateRandomInteger(e.length - 5);
        console.log(a);
        e[num].style.height = ( e[num].clientHeight * 2 + 10 ) + "px";
        e[num].classList.remove("mgrida");
        e[num].classList.add("mgridH");
        Packery1();
    }
}


function randomGallery () {
    const e = document.querySelectorAll(".mgrid-item");
    var a = ( ( e.length / 2.3 ) - ( ( e.length / 2.3 )% 4) ) - ( e.length % 4);
    console.log( ( a - ( a % 2 ) ) / 2 );
    randomGalleryH( ( a - ( a % 2 ) ) / 2 );
    randomGalleryW( ( a + ( a % 2 ) ) / 2 );
    console.log(a);

}

function generateRandomInteger(max) {
    return Math.floor(Math.random() * max) + 1;
}


