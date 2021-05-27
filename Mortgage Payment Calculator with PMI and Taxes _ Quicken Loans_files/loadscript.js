function addscript() {
    var b = document.createElement("script");
    b.setAttribute("type", "text/javascript");
    b.setAttribute("charset", "iso-8859-1");
    b.setAttribute("src", "https://static.cdn-apple.com/businesschat/start-chat-button/1/index.js");
    document.getElementsByTagName("head").item(0).appendChild(b);
}

function LPStartABC() {
    console.log("start");
    if (typeof lpTag !== undefined && typeof lpTag.events !== undefined && typeof lpTag.events.bind !== undefined) {
        console.log("add binding");
        lpTag.events.bind("LP_OFFERS", "OFFER_IMPRESSION", function(a, b) {
            //console.log("******");
            //console.log(a);
            if (a.engagementName.indexOf("ABCInject")>-1 ) {
                addscript();
            }
        })
    } else {
        //onsole.log("wait and retry");
        setTimeout('LPStartABC()', 1000);
    }
}
LPStartABC();