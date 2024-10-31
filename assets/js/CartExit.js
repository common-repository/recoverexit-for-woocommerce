//mobile
setTimeout(() => {
  document.addEventListener("scroll", scrollSpeed);
  document.addEventListener('mouseout', mouseEvent);
}, my_options.time_length);

scrollSpeed = () => {
  lastPosition = window.scrollY;
  setTimeout(() => {
    newPosition = window.scrollY;
  }, 100);
  
  if (typeof newPosition !== 'undefined') {
  currentSpeed = newPosition - lastPosition;
  
  if (currentSpeed > my_options.scroll_speed) {
    
    document.getElementById("lcwindow").style.display = "block";
	if (my_options.bgover == 'Yes') {
	document.getElementById("overlaybox").style.width = "100%";
	}
	my_options.overall_sc++;
	
    var data = {
        action: 'recexit_total_counter_funct',
        thecount: my_options.overall_sc,
		uid: my_options.uid
    };

    jQuery.post(my_options.ajaxurl, data, function(response) {
    });



    document.removeEventListener("scroll", scrollSpeed);
	document.removeEventListener("mouseout", mouseEvent);
  }
  }
};

//desktop 
const mouseEvent = e => {

var y = event.clientY;
if (y < 10){
	
    if (!e.toElement && !e.relatedTarget) {
            
	document.getElementById("lcwindow").style.display = "block";
	if (my_options.bgover == 'Yes') {
	document.getElementById("overlaybox").style.width = "100%";
	}

	my_options.overall_sc++;
	
    var data = {
        action: 'recexit_total_counter_funct',
        thecount: my_options.overall_sc,
		uid: my_options.uid
    };

    jQuery.post(my_options.ajaxurl, data, function(response) {
    
    });

    document.removeEventListener("scroll", scrollSpeed);
	document.removeEventListener("mouseout", mouseEvent);		
    }
	}
};

function closebox() {
  var x = document.getElementById("lcwindow").style.visibility;
	document.getElementById("lcwindow").style.display = "none";

//feedback
if (my_options.fbt == 'Yes') {
document.getElementById("lcwindowfb").style.display = "block";	
}else{
document.getElementById("overlaybox").style.width = "0";
}
}

function closefbox () {
  var x = document.getElementById("lcwindowfb").style.visibility;
	document.getElementById("lcwindowfb").style.display = "none";
	document.getElementById("overlaybox").style.width = "0";
}
function applyingtext () {
    var elem = document.getElementById("applyofferbutton");
	elem.innerText = '[APPLYING DISCOUNT]';
	elem.style.fontWeight = 'bold';
}