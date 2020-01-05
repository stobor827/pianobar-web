 var startY = 0;
 var startX = 0;
var movecount = 0;
var startCount = 0;
  function checkObj(e){
    if( !e ){
      return true;
    }
    if( e.tagName.toLowerCase() == "body" || e.tagName.toLowerCase() == "html" ){
      return true;
    }else if( e.className.toLowerCase() == "scrollable" ){
      return false;
    }
    return checkObj( e.parentNode );
  };
  
  function scrollHandler(e){
    var curY = e.touches[0].pageY;
	var curX = e.touches[0].screenX;
    
    var pbList = document.getElementById( 'pblist' );
    
    if( pbList ){

      var divPos = pbList.scrollTop;
      var maxScroll = pbList.scrollHeight;
      maxScroll = maxScroll - pbList.clientHeight;
		
		/*if( curX != startX ){
			e.preventDefault();
			return;
		}*/
	
      if( curY > startY ){
        //scrolling up
        if( divPos == 0 ){
          e.preventDefault();
          return;
        }
      }else if( curY < startY ){
        //scrolling down
        if( divPos == maxScroll ){
          e.preventDefault();
          return;
        }
      }
      
    
      if( checkObj( e.target ) ){
        //we've determined that we should prevent scrolling
        e.preventDefault();
		return;
      }
    }else{
      //If we don't have a pblist element, we are on the index page.
      //no scrolling at all
	  
	  if( Math.abs(e.touches[0].pageY - startY) > 10 ||  Math.abs(e.touches[0].screenX - startX) > 10){
		  e.preventDefault();
	  }
	  
	//	e.preventDefault();
	//	e.stopPropogation();
	//  }else{
		  //movecout++;
		  //document.getElementById('info').innerHTML = movecount + ", " + e.changedTouches.length + ", " + e.targetTouches.length + ", " + e.touches.length + ", " + startCount;
		
	//  }
	  return;
    }
	
	//allow scrolling?
	
  };
  
  
  function onTouchStart( e ){
    startY = e.touches[0].pageY;
	startX = e.touches[0].screenX;
	movecount = 0;
	startCount++;
	 //document.getElementById('info').innerHTML = movecount + ", " + e.changedTouches.length + ", " + e.targetTouches.length + ", " + e.touches.length + ", " + startCount;
  };
  
  document.addEventListener('touchmove', scrollHandler );
  document.addEventListener( 'touchstart', onTouchStart );