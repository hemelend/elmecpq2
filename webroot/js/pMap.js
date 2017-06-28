 /*
     pMap - a JavaScript to add image map support to pChart graphs!
     Copyright (C) 2008 Jean-Damien POGOLOTTI
     Version  1.1 last updated on 08/20/08

     http://pchart.sourceforge.net

     This program is free software: you can redistribute it and/or modify
     it under the terms of the GNU General Public License as published by
     the Free Software Foundation, either version 1,2,3 of the License, or
     (at your option) any later version.

     This program is distributed in the hope that it will be useful,
     but WITHOUT ANY WARRANTY; without even the implied warranty of
     MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
     GNU General Public License for more details.

     You should have received a copy of the GNU General Public License
     along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

 var pMap_IE            = document.all?true:false;
 var pMap_ImageMap      = new Array();
 var pMap_ImageID       = "";
 var pMap_MouseX        = 0;
 var pMap_MouseY        = 0;
 var pMap_CurrentMap    = -1;
 var pMap_URL           = "";
 var pMap_Tries         = 0;
 var pMap_MaxTries      = 5;
 var pMap_HTTP_Timeout  = 1000;
 var pMap_MUTEX         = false;
 var pMap_MUTEX_Timeout = 100;

 if (!pMap_IE) { document.captureEvents(Event.MOUSEMOVE); }

 function getMousePosition(e)
  {
   /* Protect against event storm */
   if (pMap_MUTEX) { return(0);}
   pMap_MUTEX = true;
   setTimeout("pMap_MUTEX=false",pMap_MUTEX_Timeout);

   /* Determine mouse position over the chart */
   if (pMap_IE)
    { pMap_MouseX = event.clientX + document.body.scrollLeft; pMap_MouseY = event.clientY + document.body.scrollTop; }
//   { pMap_MouseX = event.clientX; pMap_MouseY = event.clientY; }
   else
    { pMap_MouseX = e.pageX; pMap_MouseY = e.pageY; }  
   
   pMap_MouseX -= document.getElementById(pMap_ImageID).offsetLeft;
   pMap_MouseY -= document.getElementById(pMap_ImageID).offsetTop;

   if(pMap_IE)
   {
	   //doing the offsetXY manually 
	   pMap_MouseX -= 352;
	   pMap_MouseY -= 272;
//	   alert("objName= "+obj.id+"  offsetLeft= "+obj.offsetLeft+"  offsetTop= "+obj.offsetTop+"  hasLayout= "+obj.currentStyle.hasLayout);
//	   var parent = document.getElementById(pMap_ImageID).offsetParent;
//		
//       if(parent != document.body) 
//	{
//    	   alert("ObjName=" +parent.id+"  X="+parent.x);
//	}
//	   	
//	   alert("ObjName=" +document.getElementById(pMap_ImageID).id+"  offsetLeft="+document.getElementById(pMap_ImageID).offsetLeft);
//	   alert((document.getElementById(pMap_ImageID).offsetParent).offsetLeft);
   }

//    alert(pMap_MouseX);
//   	alert(pMap_MouseY);

   /* Check if we are flying over a map zone */
   Found = false;

   	var arr_length = pMap_ImageMap.length;

   	var i=0;
//   for (Map in pMap_ImageMap)
   	for(i=0;i<arr_length;i++)
    {
	   //there is something with this array so please review it
//	   alert(Map);
//   		alert(i);
//	   alert(pMap_ImageMap[Map]);
	   
//	 if (pMap_ImageMap[Map] != ''){
//		 alert(pMap_ImageMap[Map]);
//	     Values = pMap_ImageMap[Map].split(',');
//   		alert(pMap_ImageMap[i]); 
   		Values = pMap_ImageMap[i].split(",");
   		
	     if ( pMap_MouseX>=Values[0] && pMap_MouseX<=Values[2])
	      {
	       if ( pMap_MouseY>=Values[1] && pMap_MouseY<=Values[3] )
	        {
	         Found = true;
//	         alert(Found);
//	         if ( pMap_CurrentMap != Map )
//	          { overlib(Values[5], CAPTION, Values[4], WIDTH, 80); pMap_CurrentMap = Map; }
	         if (pMap_CurrentMap != i)
	         { overlib(Values[5], CAPTION, Values[4], WIDTH, 80, BGCOLOR, '#000000', BGCLASS,'test'); pMap_CurrentMap = i; }
//	         { overlib(Values[5], CAPTION, Values[4], WIDTH, 80, OFFSETX, -280, OFFSETY, -210); pMap_CurrentMap = i;}
	        }
	      }
	     if ( !Found && pMap_CurrentMap != -1 ) { nd(); pMap_CurrentMap = -1; }
//	  }
    }
  }

 function LoadImageMap(ID,iURL)  { pMap_ImageID = ID, pMap_URL = iURL; AjaxLoad();  }

 function AjaxLoad()
  {
   var xmlhttp=false;

   /*@cc_on @*/
   /*@if (@_jscript_version >= 5)
    try { xmlhttp = new ActiveXObject("Msxml2.XMLHTTP"); } catch (e) { try { xmlhttp = new ActiveXObject("Microsoft.XMLHTTP"); } catch (E) { xmlhttp = false; } }
   @end @*/
   if (!xmlhttp && typeof XMLHttpRequest!='undefined')
    { try { xmlhttp = new XMLHttpRequest(); } catch (e) { xmlhttp=false; } }
   if (!xmlhttp && window.createRequest)
    { try { xmlhttp = window.createRequest(); } catch (e) { xmlhttp=false; } }

   xmlhttp.open("GET", pMap_URL + "?Seed=" + Math.random(),true);
   xmlhttp.onreadystatechange=function() {

    if (xmlhttp.readyState==4)
     {
      if (xmlhttp.status == 404)
       {
        if ( pMap_Tries == pMap_MaxTries ) { alert("Failed to load image map"); return(0); }

        pMap_Tries++;
        setTimeout("AjaxLoad()",1000);
        return(0);
       }

      Result        = xmlhttp.responseText;
      pMap_ImageMap = Result.split("\r");
      pMap_ImageMap.pop();
//      pMap_ImageMap.pop();
//      alert(pMap_ImageMap);
     }
    }
   xmlhttp.send(null)
  }
