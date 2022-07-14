

// VARIABLES


var mouseonheader = false;
var productinactive = true;

// FUNCTIONS


function mouseOnHeaderStatus(n){
    mouseonheader = n;
    console.log("onheader: " + mouseonheader);
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





function showFiverrNavigationMenu() {
    const check = document.getElementById("popupMOF").style.height
    if(check == false || check == "0px"){
        const c = window.getComputedStyle( document.body , null).getPropertyValue("background-color");
        const c2 = window.getComputedStyle( document.getElementById("whitecolor") , null).getPropertyValue("color");
        document.getElementById("arrowMOF").style.transform = "rotate(90deg)";
        document.getElementById("arrowMOFPath").style.stroke = c;
        document.getElementById("fiverrMOFPath").style.fill = c;
        document.getElementById("fiverrMOFCircle").style.fill = c;
        document.getElementById("popupMOF").style.height = "440px";
        document.getElementById("header-wrapper").style.borderBottomColor = c2;
        document.getElementById("btna").style.backgroundColor = c2;
        document.getElementById("btnatxt").style.color = c;
        document.getElementById("bgMOF").style.opacity = ".3";
        document.getElementById("bgMOF").style.pointerEvents = "auto";
        for(var i=0; i<4; i++) {
            j = i+1;
            document.getElementById("hover" + j).style.color = c2;        
        }
        for(var i=0; i<4; i++) {
            j = i+1;
            document.getElementById("hover" + j + "run").style.backgroundColor = c2;        
        }
        for(var i=0; i<3; i++) {
            setTimeout(MOFLEshow, i*150, i)
        }

        function MOFLEshow(i) {
            j = i+1;
            const m = document.getElementById("MOFLE" + j);
            m.style.transitionDuration = "1s";
            m.style.transform = "translate(0px,0px)";
            m.style.opacity = "1";
            m.style.pointerEvents = "auto";
        }
    }
}






function hideFiverrNavigationMenu() {
    const check = document.getElementById("popupMOF").style.height 
    if(check == "440px"){
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
        document.getElementById("arrowMOFPath").style.stroke = c;
        document.getElementById("fiverrMOFPath").style.fill = c;
        document.getElementById("fiverrMOFCircle").style.fill = c;
        document.getElementById("popupP").style.height = "600px";
        document.getElementById("header-wrapper").style.borderBottomColor = c2;
        document.getElementById("btna").style.backgroundColor = c2;
        document.getElementById("btnatxt").style.color = c;
        document.getElementById("bgMOF").style.opacity = ".3";
        document.getElementById("bgMOF").style.pointerEvents = "auto";
        productinactive = false;
        for(var i=0; i<4; i++) {
            j = i+1;
            document.getElementById("hover" + j).style.color = c2;        
        }
        for(var i=0; i<4; i++) {
            j = i+1;
            document.getElementById("hover" + j + "run").style.backgroundColor = c2;        
        }
        for(var i=0; i<4; i++) {
            setTimeout(MOFLEshow, i*150, i)
        }

        function MOFLEshow(i) {
            j = i+1;
            const m = document.getElementById("PLE" + j);
            m.style.transitionDuration = "1s";
            m.style.transform = "translate(0px,0px)";
            m.style.opacity = "1";
            m.style.pointerEvents = "auto";
        }
    }
}




function hideProductNavigationMenu() {
    const check = document.getElementById("popupP").style.height 
    if(check == "600px"){
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
    for(var i=0; i<4; i++) {
        j = i+1;
        const m = document.getElementById("PLE" + j);
        m.style.transitionDuration = ".1s";
        m.style.transform = "translate(0px, -60px)";
        m.style.opacity = "0";
        setTimeout(function() {m.style.opacity = "0"}, 450)
        m.style.pointerEvents = "none";
    }
    }
    }
    
}










function showBurgerNavigationMenu() {
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
        for(var i=0; i<3; i++) {
            j = i+1;
            document.getElementById("line"+ j).style.backgroundColor = c2;      
        }
        /*for(var i=0; i<4; i++) {
            setTimeout(MOFLEshow, i*150, i)
        }

        function MOFLEshow(i) {
            j = i+1;
            const m = document.getElementById("PLE" + j);
            m.style.transitionDuration = "1s";
            m.style.transform = "translate(0px,0px)";
            m.style.opacity = "1";
            m.style.pointerEvents = "auto";
        }*/
    }
}




function hideBurgerNavigationMenu() {
    const check = document.getElementById("burgerpopup").style.height 
    if(check == "100%"){
    if(mouseonheader==false){
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
    /*for(var i=0; i<4; i++) {
        j = i+1;
        const m = document.getElementById("PLE" + j);
        m.style.transitionDuration = ".1s";
        m.style.transform = "translate(0px, -60px)";
        m.style.opacity = "0";
        setTimeout(function() {m.style.opacity = "0"}, 450)
        m.style.pointerEvents = "none";
    }*/
    }
    }
    
}




















// EVENT LISTENER


window.addEventListener("scroll", resizeHeaderOnScroll);