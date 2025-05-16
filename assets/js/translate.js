var selectedLanguage1 = 'SRB';
var currentSelectedLanguage = 'SRB';

function catchCurrentLanguage(){
    let urlParams = new URLSearchParams(window.location.search);
    
    if (urlParams != null){
        var currentLanguage =  urlParams.get('language');
        defaultTranslate(currentLanguage);
    }
    else {
        defaultTranslate('SRB');
    }
}

function defaultTranslate(language){
    var languageTexts;
    if (language == 'SRB'){
        languageTexts = new serbianText();
        currentSelectedLanguage = 'SRB';
        document.querySelectorAll('[id="nameId"]').forEach(function(el) {el.style.display = 'block';});
        document.querySelectorAll('[id="nameEngId"]').forEach(function(el) {el.style.display = 'none';});
        
        if (document.querySelectorAll('[id="descriptionEngId"]') != null){
            document.querySelectorAll('[id="descriptionEngId"]').forEach(function(el) {el.style.display = 'none';});
            document.querySelectorAll('[id="descriptionId"]').forEach(function(el) {el.style.display = 'block';});
        }
    } else if (language == 'ENG'){
        languageTexts = new englishText();
        currentSelectedLanguage = 'ENG';
        document.querySelectorAll('[id="nameEngId"]').forEach(function(el) {el.style.display = 'block';});
        document.querySelectorAll('[id="nameId"]').forEach(function(el) {el.style.display = 'none';});
        
        if (document.querySelectorAll('[id="descriptionEngId"]') != null){
            document.querySelectorAll('[id="descriptionEngId"]').forEach(function(el) {el.style.display = 'block';});
            document.querySelectorAll('[id="descriptionId"]').forEach(function(el) {el.style.display = 'none';});
        }
    }

    translateToLanguage(languageTexts);
}

function translateToLanguage(languageTexts){
    /*document.getElementById("translateButton").innerHTML = languageTexts.translateButton;*/
    document.getElementById("txt_creator").innerHTML = languageTexts.txt_creator;
    document.getElementById("txt_li_map").innerHTML = languageTexts.txt_li_map;
    document.getElementById("txt_li_info").innerHTML = languageTexts.txt_li_info;
    document.getElementById("txt_li_events").innerHTML = languageTexts.txt_li_events;
    document.getElementById("txt_title").innerHTML = languageTexts.txt_title;
    
    // Postavi dinamički href sa vrednošću
    document.getElementById("txt_li_map").href = `./Map.php?locationId=0&language=${currentSelectedLanguage}`;
    document.getElementById("txt_li_info").href = `./Info.php?language=${currentSelectedLanguage}`;
    
    if (document.getElementById("txt_li_home") != null){
        document.getElementById("txt_li_home").innerHTML = languageTexts.txt_li_home;
        document.getElementById("txt_li_home").href = `./index.php?language=${currentSelectedLanguage}`;
    }
    
    if (document.getElementById("txt_li_location_map") != null){
        document.getElementById("txt_li_location_map").innerHTML = languageTexts.txt_li_location_map;
    }
    
    if (document.getElementById("txt_li_location_navigation") != null){
        document.getElementById("txt_li_location_navigation").innerHTML = languageTexts.txt_li_location_navigation;
    }
    
    /*document.getElementById("textId2").innerHTML = languageTexts.textId2;
    document.getElementById("textId3").innerHTML = languageTexts.textId3;
    document.getElementById("textId4").innerHTML = languageTexts.textId4;
    document.getElementById("textId5").innerHTML = languageTexts.textId5;*/
}