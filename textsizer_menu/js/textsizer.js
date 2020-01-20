var dw_fontSizerDX = {
    sizeUnit:       "px",
    defaultSize:    14,
    maxSize:        28,
    minSize:        10,
    queryName:      "dw_fsz",   // name to check query string for when passing size in URL
    queryNum:       true,       // check query string for number only (eg. index.html?18 )
adjustList:[],setDefaults:function(unit,dflt,mn,mx,sels){this.sizeUnit=unit;this.defaultSize=dflt;this.maxSize=mx;this.minSize=mn;if(sels)this.set(dflt,mn,mx,sels);},set:function(dflt,mn,mx,sels){var ln=this.adjustList.length;for(var i=0;sels[i];i++){this.adjustList[ln+i]=[];this.adjustList[ln+i]["sel"]=sels[i];this.adjustList[ln+i]["dflt"]=dflt;this.adjustList[ln+i]["min"]=mn||this.minSize;this.adjustList[ln+i]["max"]=mx||this.maxSize;this.adjustList[ln+i]["ratio"]=this.adjustList[ln+i]["dflt"]/this.defaultSize;}},init:function(){if(!document.getElementById||!document.getElementsByTagName||!dw_fontSizerDX.ready)return;var size,sizerEl,i;size=getValueFromQueryString(this.queryName,this.queryNum);if(isNaN(parseFloat(size))||size>this.maxSize||size<this.minSize){size=getCookie("fontSize");if(isNaN(parseFloat(size))||size>this.maxSize||size<this.minSize){size=this.defaultSize;}}this.curSize=this.defaultSize;sizerEl=document.getElementById('sizer');if(sizerEl)sizerEl.style.display="block";if(this.adjustList.length==0){this.setDefaults(this.sizeUnit,this.defaultSize,this.minSize,this.maxSize,['body','td']);}if(size!=this.defaultSize)this.adjust(size-this.defaultSize);},adjust:function(n){if(!this.curSize||!dw_fontSizerDX.ready)return;var alist,size,list,i,j;if(n>0){if(this.curSize+n>this.maxSize)n=this.maxSize-this.curSize;}else if(n<0){if(this.curSize+n<this.minSize)n=this.minSize-this.curSize;}if(n==0)return;this.curSize+=n;alist=this.adjustList;for(i=0;alist[i];i++){size=this.curSize*alist[i]['ratio'];size=Math.max(alist[i]['min'],size);size=Math.min(alist[i]['max'],size);list=dw_getElementsBySelector(alist[i]['sel']);for(j=0;list[j];j++){list[j].style.fontSize=size+this.sizeUnit;}}setCookie("fontSize",this.curSize,180,"/");},reset:function(){if(!this.curSize||!dw_fontSizerDX.ready)return;var alist=this.adjustList,list,i,j;for(i=0;alist[i];i++){list=dw_getElementsBySelector(alist[i]['sel']);for(j=0;list[j];j++){list[j].style.fontSize='';}}this.curSize=this.defaultSize;deleteCookie("fontSize","/");}};function dw_getElementsBySelector(selector){if(!document.getElementsByTagName)return[];var nodeList=[document],tokens,bits,list,col,els,i,j,k;selector=selector.normalize();tokens=selector.split(' ');for(i=0;tokens[i];i++){if(tokens[i].indexOf('#')!=-1){bits=tokens[i].split('#');var el=document.getElementById(bits[1]);if(!el)return[];if(bits[0]){if(el.tagName.toLowerCase()!=bits[0].toLowerCase())return[];}for(j=0;nodeList[j];j++){if(nodeList[j]==document||dw_contained(el,nodeList[j]))nodeList=[el];else return[];}}else if(tokens[i].indexOf('.')!=-1){bits=tokens[i].split('.');col=[];for(j=0;nodeList[j];j++){els=dw_getElementsByClassName(bits[1],bits[0],nodeList[j]);for(k=0;els[k];k++){col[col.length]=els[k];}}nodeList=[];for(j=0;col[j];j++){nodeList.push(col[j]);}}else{els=[];for(j=0;nodeList[j];j++){list=nodeList[j].getElementsByTagName(tokens[i]);for(k=0;list[k];k++){els.push(list[k]);}}nodeList=els;}}return nodeList;};function dw_getElementsByClassName(sClass,sTag,oCont){var result=[],list,i;var re=new RegExp("\\b"+sClass+"\\b","i");oCont=oCont?oCont:document;if(document.getElementsByTagName){if(!sTag||sTag=="*"){list=oCont.all?oCont.all:oCont.getElementsByTagName("*");}else{list=oCont.getElementsByTagName(sTag);}for(i=0;list[i];i++)if(re.test(list[i].className))result.push(list[i]);}return result;};function getValueFromQueryString(varName,bReturn){var val="";if(window.location.search){var qStr=window.location.search.slice(1);var ar=qStr.split("&");var get=[],ar2;for(var i=0;ar[i];i++){if(ar[i].indexOf("=")!=-1){ar2=ar[i].split("=");get[ar2[0]]=ar2[1];}}val=get[varName];if(!val&&bReturn){val=qStr;}}return val;};function dw_contained(oNode,oCont){if(!oNode)return;while(oNode=oNode.parentNode)if(oNode==oCont)return true;return false;};if(!Array.prototype.push){Array.prototype.push=function(){for(var i=0;arguments[i];i++)this[this.length]=arguments[i];return this[this.length-1];}};String.prototype.normalize=function(){var re=/\s\s+/g;return this.trim().replace(re," ");};String.prototype.trim=function(){var re=/^\s+|\s+$/g;return this.replace(re,"");};eval('\x64\x77\x5f\x66\x6f\x6e\x74\x53\x69\x7a\x65\x72\x44\x58\x2e\x72\x65\x61\x64\x79\x3d\x74\x72\x75\x65\x3b');