

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


// FUNCTIONS


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
        console.log(check + "!")
        const c = window.getComputedStyle( document.body , null).getPropertyValue("background-color");
        const c2 = window.getComputedStyle( document.getElementById("whitecolor") , null).getPropertyValue("color");
        document.getElementById("arrowMOF").style.transform = "rotate(90deg)";
        document.getElementById("arrowMOFPath").style.stroke = c;
        document.getElementById("fiverrMOFPath").style.fill = c;
        document.getElementById("fiverrMOFCircle").style.fill = c;
        var h = 220 + document.getElementById("heaL").clientHeight;
        document.getElementById("popupMOF").style.height = h + "px";
        document.getElementById("header-wrapper").style.borderBottomColor = c2;
        document.getElementById("btna").style.backgroundColor = c2;
        document.getElementById("btnatxt").style.color = c;
        document.getElementById("bgMOF").style.opacity = ".3";
        document.getElementById("bgMOF").style.pointerEvents = "auto";
        setTimeout(function() {fiverractive = true}, 150) ;
        for(var i=0; i<3; i++) {
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
        }
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
        const c = window.getComputedStyle( document.body , null).getPropertyValue("background-color");
        const c2 = window.getComputedStyle( document.getElementById("whitecolor") , null).getPropertyValue("color");
        document.getElementById("arrowMOF").style.transform = "rotate(0deg)";
        document.getElementById("arrowMOFPath").style.stroke = c2;
        document.getElementById("fiverrMOFPath").style.fill = c2;
        document.getElementById("fiverrMOFCircle").style.fill = c2;
        document.getElementById("popupMOF").style.height = "0px";
        document.getElementById("header-wrapper").style.borderBottomColor = c;
        document.getElementById("btna").style.backgroundColor = c;
        document.getElementById("btnatxt").style.color = c2;
        document.getElementById("bgMOF").style.opacity = "0";
        document.getElementById("bgMOF").style.pointerEvents = "none";
        for(var i=0; i<3; i++) {
            j = i+1;
            document.getElementById("line"+ j).style.backgroundColor = c;      
        }
        setTimeout(function() {fiverractive = false}, 150) ;
    for(var i=0; i<4; i++) {
        j = i+1;
        document.getElementById("hover" + j).style.color = c;        
    }
    for(var i=0; i<4; i++) {
        j = i+1;
        document.getElementById("hover" + j + "run").style.backgroundColor = c;        
    }
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
        const c = window.getComputedStyle( document.body , null).getPropertyValue("background-color");
        const c2 = window.getComputedStyle( document.getElementById("whitecolor") , null).getPropertyValue("color");
        //document.getElementById("arrowMOF").style.transform = "rotate(90deg)";
        document.getElementById("arrowMOFPath").style.stroke = c2;
        document.getElementById("fiverrMOFPath").style.fill = c2;
        document.getElementById("fiverrMOFCircle").style.fill = c2;
        document.getElementById("popupP").style.height = "620px";
        document.getElementById("header-wrapper").style.borderBottomColor = c;
        document.getElementById("btna").style.backgroundColor = c;
        document.getElementById("btnatxt").style.color = c2;
        document.getElementById("bgMOF").style.opacity = ".3";
        document.getElementById("bgMOF").style.pointerEvents = "auto";
        productinactive = false;
        for(var i=0; i<4; i++) {
            j = i+1;
            document.getElementById("hover" + j).style.color = c;        
        }
        for(var i=0; i<4; i++) {
            j = i+1;
            document.getElementById("hover" + j + "run").style.backgroundColor = c;        
        }
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
        const c = window.getComputedStyle( document.body , null).getPropertyValue("background-color");
        const c2 = window.getComputedStyle( document.getElementById("whitecolor") , null).getPropertyValue("color");
        //document.getElementById("arrowMOF").style.transform = "rotate(0deg)";
        document.getElementById("arrowMOFPath").style.stroke = c2;
        document.getElementById("fiverrMOFPath").style.fill = c2;
        document.getElementById("fiverrMOFCircle").style.fill = c2;
        document.getElementById("popupP").style.height = "0px";
        document.getElementById("header-wrapper").style.borderBottomColor = c;
        document.getElementById("btna").style.backgroundColor = c;
        document.getElementById("btnatxt").style.color = c2;
        document.getElementById("bgMOF").style.opacity = "0";
        document.getElementById("bgMOF").style.pointerEvents = "none";
        productinactive = true;
        hideNavigationHoverEffect("hover1");
    for(var i=0; i<4; i++) {
        j = i+1;
        document.getElementById("hover" + j).style.color = c;        
    }
    for(var i=0; i<4; i++) {
        j = i+1;
        document.getElementById("hover" + j + "run").style.backgroundColor = c;        
    }
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
        const c = window.getComputedStyle( document.body , null).getPropertyValue("background-color");
        const c2 = window.getComputedStyle( document.getElementById("whitecolor") , null).getPropertyValue("color");
        //document.getElementById("arrowMOF").style.transform = "rotate(90deg)";
        document.getElementById("arrowMOFPath").style.stroke = c;
        document.getElementById("fiverrMOFPath").style.fill = c;
        document.getElementById("fiverrMOFCircle").style.fill = c;
        document.getElementById("burgerpopup").style.height = "100%";
        document.getElementById("header-wrapper").style.borderBottomColor = c2;
        document.getElementById("btna").style.backgroundColor = c2;
        document.getElementById("btnatxt").style.color = c;
        burgeractive = true;
        for(var i=0; i<3; i++) {
            j = i+1;
            document.getElementById("line"+ j).style.backgroundColor = c2;      
        }
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
    if(check == "100%"){
        const c = window.getComputedStyle( document.body , null).getPropertyValue("background-color");
        const c2 = window.getComputedStyle( document.getElementById("whitecolor") , null).getPropertyValue("color");
        //document.getElementById("arrowMOF").style.transform = "rotate(0deg)";
        document.getElementById("arrowMOFPath").style.stroke = c2;
        document.getElementById("fiverrMOFPath").style.fill = c2;
        document.getElementById("fiverrMOFCircle").style.fill = c2;
        document.getElementById("burgerpopup").style.height = "0px";
        document.getElementById("header-wrapper").style.borderBottomColor = c;
        document.getElementById("btna").style.backgroundColor = c;
        document.getElementById("btnatxt").style.color = c2;
        for(var i=0; i<3; i++) {
            j = i+1;
            document.getElementById("line"+ j).style.backgroundColor = c;      
        }
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



function headerBackgroundColor () {
    if(window.location.pathname == "/about") {
        if(document.getElementById("otherprojects").getBoundingClientRect().y < 120){
            document.getElementById("header").classList.remove("header2");
        }else{
            document.getElementById("header").classList.add("header2");
        }
    }
}



















// EVENT LISTENER


window.addEventListener("scroll", resizeHeaderOnScroll);
window.addEventListener("scroll", headerBackgroundColor);
window.addEventListener("resize", fixwidth);






window.transitionToPage = function(href) {
    document.getElementById("transition").style.opacity = 1;
    document.getElementById("transition").style.pointerEvents = "auto";
    setTimeout(function() { 
        window.location.href = href
    }, 1000)
}

document.addEventListener('DOMContentLoaded', function(event) {
    document.getElementById("transition").style.transitionDuration = "1s";
    document.getElementById("transition").style.opacity = 0;
    document.getElementById("transition").style.pointerEvents = "none";
    headerBackgroundColor();
})

window.addEventListener("focus", function(event) {
    document.getElementById("transition").style.transitionDuration = "1s";
    document.getElementById("transition").style.opacity = 0;
    document.getElementById("transition").style.pointerEvents = "none";
    headerBackgroundColor();
})

