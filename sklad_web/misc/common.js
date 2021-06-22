/** 01

	01	2008-05-21	��������� ������� ucfirst() - ������ � ������� �����

*/

function getBodyScrollTop()
{
	return (self.pageYOffset || (document.documentElement && document.documentElement.scrollTop) || (document.body && document.body.scrollTop));
}

function getBodyScrollLeft()
{
	return (self.pageXOffset || (document.documentElement && document.documentElement.scrollLeft) || (document.body && document.body.scrollLeft));
}

function getDocumentHeight()
{
	return (document.body.scrollHeight > document.body.offsetHeight)?document.body.scrollHeight:document.body.offsetHeight;
}

function getDocumentWidth()
{
	return (document.body.scrollWidth > document.body.offsetWidth)?document.body.scrollWidth:document.body.offsetWidth;
}

function getClientCenterX()
{
	return parseInt(getClientWidth()/2)+getBodyScrollLeft();
}

function getClientCenterY()
{
	return parseInt(getClientHeight()/2)+getBodyScrollTop();
}

function getClientWidth()
{
  return document.compatMode=='CSS1Compat' && !window.opera?document.documentElement.clientWidth:document.body.clientWidth;
}

function getClientHeight()
{
  return document.compatMode=='CSS1Compat' && !window.opera?document.documentElement.clientHeight:document.body.clientHeight;
}

function urlparam_encode(str) {
	if (typeof(str) == 'array') str = implode(',', str);
	s = implode('!', str.split(/\//));
	return str.charAt(0) == '/' ? '!' + s : s;
}

function urlparam_decode(str) {
	return str.replace(/!/, '/');
}

function implode( glue, pieces ) {
    return ( ( pieces instanceof Array ) ? pieces.join ( glue ) : pieces );
}

function var_dump(data,addwhitespace,safety,level) {
	var rtrn = '';
	var dt,it,spaces = '';
	if (!level) level = 1;
	for (var i = 0; i < level; i++) spaces += '   ';
	if (typeof(data) != 'object') {
		dt = data;
		if (typeof(data) == 'string') {
			if (addwhitespace == 'html') {
				dt = dt.replace(/&/g,'&amp;');
				dt = dt.replace(/>/g,'&gt;');
				dt = dt.replace(/</g,'&lt;');
			}
			dt = dt.replace(/\"/g,'\"');
			dt = '"' + dt + '"';
		}
		if (typeof(data) == 'function' && addwhitespace) {
			dt = new String(dt).replace(/\n/g,"\n"+spaces);
			if (addwhitespace == 'html') {
				dt = dt.replace(/&/g,'&amp;');
				dt = dt.replace(/>/g,'&gt;');
				dt = dt.replace(/</g,'&lt;');
			}
		}
		if (typeof(data) == 'undefined') dt = 'undefined';
		if (addwhitespace == 'html') {
			if (typeof(dt) != 'string') dt = new String(dt);
			dt = dt.replace(/ /g,"&nbsp;").replace(/\n/g,"<br>");
		}
		return dt;
	}
	for (var x in data) {
		if(safety && (level > safety)) {
			dt = '*RECURSION*';
		} else {
			try {
				dt = var_dump(data[x],addwhitespace,safety,level+1);
			} catch (e) {
				continue;
			}
		}
		it = var_dump(x,addwhitespace,safety,level+1);
		rtrn += it + ':' + dt + ',';
		if (addwhitespace) rtrn += '\n'+spaces;
	}
	if (addwhitespace) {
		rtrn = '{\n' + spaces + rtrn.substr(0,rtrn.length-(2+(level*3))) + '\n' + spaces.substr(0,spaces.length-3) + '}';
	} else {
		rtrn = '{' + rtrn.substr(0,rtrn.length-1) + '}';
	}
	if (addwhitespace == 'html') {
		rtrn = rtrn.replace(/ /g,"&nbsp;").replace(/\n/g,"<br>");
	}
	return rtrn;
}

function trim (str) {
	var	str = str.replace(/^\s\s*/, ''),
		ws = /\s/,
		i = str.length;
	while (ws.test(str.charAt(--i)));
	return str.slice(0, i + 1);
}

function trim_adv(str, sym) {
	while (sym == str.charAt(0)) str = str.substr(1);
	while (sym == str.charAt(str.length-1)) str = str.substr(0, str.length-1);
	return str;
}



function getElementPosition(elem)
{
	 var w = elem.offsetWidth;
	 var h = elem.offsetHeight;
	 var l = 0;
	 var t = 0;
	 while (elem)
	 {
		  l += elem.offsetLeft;
		  t += elem.offsetTop;
		  elem = elem.offsetParent;
	 }
	 return {"left":l, "top":t, "width": w, "height":h};
}

function ucfirst(str) {
	return str.charAt(0).toUpperCase()+str.substr(1);
}

function uri_clean_params(uri) {
	return uri.replace(/^([^?]*)\?.*$/, function ($0, $1) {return $1;});
}

// Encodes bad chars to display html through js
function html_encode(text) {
	if (typeof(text) != "string") text = text.toString();
	text = text.replace(/&/g, "&amp;").replace(/"/g, "&quot;").replace(/</g, "&lt;").replace(/>/g, "&gt;");
	return text;
}

function open_window(src, width, height, title, scroll) {
	var scroll = scroll || "no";
	var top=0, left=0;
	if(width > screen.width-10 || height > screen.height-28) scroll = "yes";
	if(height < screen.height-28) top = Math.floor((screen.height - height)/2-14);
	if(width < screen.width-10) left = Math.floor((screen.width - width)/2-5);
	width = Math.min(width, screen.width-10);
	height = Math.min(height, screen.height-28);
	window.open(src,title,"scrollbars="+scroll+",resizable=yes,width="+width+",height="+height+",left="+left+",top="+top);
}


function fixpng(element, params) {
	params = params || {};
	if (/MSIE (5\.5|6).+Win/.test(navigator.userAgent)) {
		var src;
		if (element.tagName == 'IMG' || element.tagName == 'INPUT') {
			src = element.src;
			element.src = "/images/px.gif";
		} else {
			src = element.currentStyle.backgroundImage.match(/url\("(.+\.png)"\)/i);
			if (src) {
				src = src[1];
				element.runtimeStyle.backgroundImage = "none";
			}
		}
		if (src) {
			element.runtimeStyle.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" + src + "',sizingMethod='scale')";
		}
	}
}

function cleanInputField(A){
		var B = A.previousSibling;
		if (B) {
			A.onblur = function() {
				if (!A.value) {
					B.style.top=""
				}
			};
			B.style.top="-9999px"
		}
	}

jQuery(function(){
$('#whatis').qtip({ style: { 
		border: {
         width: 3,
         radius: 8,
         color: '#0079c2'
      },
 tip: true } })
});
jQuery(function(){
$('#city').qtip(
	{ style: { 
		border: {
        	width: 3,
        	radius: 8,
        	color: '#0079c2'
      	}, 
      	width: 200,
      	tip: true 
      },
      position: {
      	corner: {
         target: 'bottomLeft',
         tooltip: 'topRight'
      	}
   	  },
      hide: 'unfocus',
      show: 'click',
      content: {
      	title: 'Кабель есть в наличии в городах:'
      }
    });
});
jQuery(function(){
$('.comments').qtip({ style: { 
		border: {
         width: 2,
         radius: 4,
         color: '#0079c2'
      },
 tip: true } })
});