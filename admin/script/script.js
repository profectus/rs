$(document).ready(function() {
	$(function() {
	  $("a[rel^='lightbox']").lightbox();
	});

	// main menu
	$("#main-nav li ul").hide();
	$("#main-nav li a.current").parent().find("ul").slideToggle("slow");
		
	$("#main-nav li a.nav-top-item").click(function() {
		$(this).parent().siblings().find("ul").slideUp("normal");
		$(this).next().slideToggle("normal");
		return false;
	});
		
	$("#main-nav li a.no-submenu").click(function() {
		window.location.href=(this.href);
		return false;
	});
	
	//mobilní verze
	$("#mobil_link").click(function(){    
    if ($("#main-nav").css("display") === "block")
    {
      $("#main-nav").slideUp();
      $(this).html("zobrazit menu");
      $("#main").show();
    }
    else
    {
      $("#main-nav").slideDown();
      $(this).html("skrýt menu");
      $("#main").hide();
    }
    return false;
  });
	
	// modal okna
	$("a[rel*=modal]").facebox();
	
	// F2 keydown
  jQuery(document).bind('keydown.f2',function (evt){
      if ($("#sidebar").css("display") === "block") { 
    $("#sidebar").hide();
      $("body").css("backgroundPosition","-200px");
      $("#main").css("left","-200px");
      $("#main").width($("#main").width() + 200);
    } else {
      $("#sidebar").show();
      $("body").css("backgroundPosition","0px");
      $("#main").css("left","0px");
      $("#main").width($("#main").width() - 200);
    } return false; 
  });
  
  if (navigator.userAgent.match(/(iPad|iPhone|iPod)/i)) {
	$('a[rel!="modal"][rel!="lightbox"]').each(function(){	  
	  url = $(this).attr("href");
	  if (url !== "#" && url !== "" && url != undefined) { $(this).attr("href","javascript: window.location.assign('"+url+"');");}
  });
  }
  
  
  
  $.datepicker.regional['cs'] = {
    closeText: 'Zavřít',
    prevText: 'Předchozí',
    nextText: 'Další',
    currentText: 'Hoy',
    monthNames: ['Leden','Únor','Březen','Duben','Květen','Červen', 'Červenec','Srpen','Září','Říjen','Listopad','Prosinec'],
    monthNamesShort: ['Leden','Únor','Březen','Duben','Květen','Červen', 'Červenec','Srpen','Září','Říjen','Listopad','Prosinec'],
    dayNames: ['Neděle','Pondělí','Úterý','Středa','Čtvrtek','Pátek','Sobota'],
    dayNamesShort: ['Ne','Po','Út','St','Čt','Pá','So'],
    dayNamesMin: ['Ne','Po','Út','St','Čt','Pá','So'],
    weekHeader: 'Sm',
    dateFormat: 'yy-mm-dd',
    firstDay: 1,
    isRTL: false,
    showMonthAfterYear: false,
	 changeMonth: true,
	 changeYear: true,
    yearSuffix: ''};  
	$.datepicker.setDefaults($.datepicker.regional['cs']);
});

$(function(){
  $(".tooltip[title]").mbTooltip({
    opacity : .80,  
    wait:1, 
    cssClass:"default", 
    timePerWord:5000,    
    hasArrow:false,     
    hasShadow:false,
    imgPath:"pics/",
    anchor:"parent",
    shadowColor:"#a59687",
    mb_fade:0
  });   
});

function loadEditor(id) {
	var instance = CKEDITOR.instances[id];
	if (instance) {CKEDITOR.remove(instance);}
	CKEDITOR.replace(id, {
		filebrowserBrowseUrl: '/admin/ckeditor/plugins/filemanager/index.html',
    toolbar: [
			["Maximize","-","Source"], ["Bold","Italic","Underline"],["Maximize", "-",],["Cut","Copy","Paste","PasteText","-","Undo","Redo"],["Styles","Format","FontSize"],"/",
			["TextColor","BGColor"],["Image","SpecialChar"]["Strike","Subscript","Superscript","-","RemoveFormat"],["NumberedList","BulletedList","-","CreateDiv","-","JustifyLeft","JustifyCenter","JustifyRight","JustifyBlock"],["Link","Unlink"],["Find","Replace","-","SelectAll"],['Image'],"/",
			
		],width: 750,resize_enabled:false
	});
}