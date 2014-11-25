/*!
 * Author: Abdullah A Almsaeed
 * Date: 4 Jan 2014
 * Description:
 *      This file should be included in all pages
 !**/
;$(function(){$("[data-toggle='offcanvas']").click(function(b){b.preventDefault();if($(window).width()<=992){$(".row-offcanvas").toggleClass("active");$(".left-side").removeClass("collapse-left");$(".right-side").removeClass("stretch");$(".row-offcanvas").toggleClass("relative")}else{$(".left-side").toggleClass("collapse-left");$(".right-side").toggleClass("stretch")}});$(".btn").bind("touchstart",function(){$(this).addClass("hover")}).bind("touchend",function(){$(this).removeClass("hover")});$("[data-toggle='tooltip']").tooltip();$("[data-widget='collapse']").click(function(){var c=$(this).parents(".box").first();var b=c.find(".box-body, .box-footer");if(!c.hasClass("collapsed-box")){c.addClass("collapsed-box");b.slideUp()}else{c.removeClass("collapsed-box");b.slideDown()}});$('.btn-group[data-toggle="btn-toggle"]').each(function(){var b=$(this);$(this).find(".btn").click(function(c){b.find(".btn.active").removeClass("active");$(this).addClass("active");c.preventDefault()})});$("[data-widget='remove']").click(function(){var b=$(this).parents(".box").first();b.slideUp()});$(".sidebar .treeview").tree();function a(){var b=$(window).height()-$("body > .header").height();$(".wrapper").css("min-height",b+"px");var c=$(".wrapper").height();if(c>b){$(".left-side, html, body").css("min-height",c+"px")}else{$(".left-side, html, body").css("min-height",b+"px")}}a();$(".wrapper").resize(function(){a()});$("input[type='checkbox'], input[type='radio']").iCheck({checkboxClass:"icheckbox_minimal",radioClass:"iradio_minimal"})});(function(a){a.fn.boxRefresh=function(d){var e=a.extend({trigger:".refresh-btn",source:"",onLoadStart:function(g){},onLoadDone:function(g){}},d);var c=a('<div class="overlay"></div><div class="loading-img"></div>');return this.each(function(){if(e.source===""){if(console){console.log("Please specify a source first - boxRefresh()")}return}var g=a(this);var h=g.find(e.trigger).first();h.click(function(i){i.preventDefault();f(g);g.find(".box-body").load(e.source,function(){b(g)})})});function f(g){g.append(c);e.onLoadStart.call(g)}function b(g){g.find(c).remove();e.onLoadDone.call(g)}}})(jQuery);(function(a){a.fn.tree=function(){return this.each(function(){var b=a(this).children("a").first();var d=a(this).children(".treeview-menu").first();var c=a(this).hasClass("active");if(c){d.show();b.children(".fa-angle-left").first().removeClass("fa-angle-left").addClass("fa-angle-down")}b.click(function(e){e.preventDefault();if(c){d.slideUp();c=false;b.children(".fa-angle-down").first().removeClass("fa-angle-down").addClass("fa-angle-left");b.parent("li").removeClass("active")}else{d.slideDown();c=true;b.children(".fa-angle-left").first().removeClass("fa-angle-left").addClass("fa-angle-down");b.parent("li").addClass("active")}});d.find("li > a").each(function(){var e=parseInt(a(this).css("margin-left"))+10;a(this).css({"margin-left":e+"px"})})})}}(jQuery));(function(a){a.fn.todolist=function(b){var c=a.extend({onCheck:function(d){},onUncheck:function(d){}},b);return this.each(function(){a("input",this).on("ifChecked",function(d){var e=a(this).parents("li").first();e.toggleClass("done");c.onCheck.call(e)});a("input",this).on("ifUnchecked",function(d){var e=a(this).parents("li").first();e.toggleClass("done");c.onUncheck.call(e)})})}}(jQuery));(function(a){jQuery.fn.center=function(b){if(b){b=this.parent()}else{b=window}this.css({position:"absolute",top:(((a(b).height()-this.outerHeight())/2)+a(b).scrollTop()+"px"),left:(((a(b).width()-this.outerWidth())/2)+a(b).scrollLeft()+"px")});return this}}(jQuery));(function(x,l,q){var s=x([]),n=x.resize=x.extend(x.resize,{}),v,u="setTimeout",w="resize",p=w+"-special-event",r="delay",o="throttleWindow";n[r]=250;n[o]=true;x.event.special[w]={setup:function(){if(!n[o]&&this[u]){return false}var a=x(this);s=s.add(a);x.data(this,p,{w:a.width(),h:a.height()});if(s.length===1){m()}},teardown:function(){if(!n[o]&&this[u]){return false}var a=x(this);s=s.not(a);a.removeData(p);if(!s.length){clearTimeout(v)}},add:function(b){if(!n[o]&&this[u]){return false}var c;function a(d,h,g){var f=x(this),e=x.data(this,p);e.w=h!==q?h:f.width();e.h=g!==q?g:f.height();c.apply(this,arguments)}if(x.isFunction(b)){c=b;return a}else{c=b.handler;b.handler=a}}};function m(){v=l[u](function(){s.each(function(){var d=x(this),a=d.width(),b=d.height(),c=x.data(this,p);if(a!==c.w||b!==c.h){d.trigger(w,[c.w=a,c.h=b])}});m()},n[r])}})(jQuery,this);
/*!
 * iCheck v1.0.1, http://git.io/arlzeA
 * =================================
 * Powerful jQuery and Zepto plugin for checkboxes and radio buttons customization
 *
 * (c) 2013 Damir Sultanov, http://fronteed.com
 * MIT Licensed
 */
(function(a){jQuery.fn.extend({slimScroll:function(c){var b=a.extend({width:"auto",height:"250px",size:"7px",color:"#000",position:"right",distance:"1px",start:"top",opacity:0.4,alwaysVisible:!1,disableFadeOut:!1,railVisible:!1,railColor:"#333",railOpacity:0.2,railDraggable:!0,railClass:"slimScrollRail",barClass:"slimScrollBar",wrapperClass:"slimScrollDiv",allowPageScroll:!1,wheelStep:20,touchScrollStep:200,borderRadius:"0px",railBorderRadius:"0px"},c);this.each(function(){function e(g){if(G){g=g||window.event;var k=0;g.wheelDelta&&(k=-g.wheelDelta/120);g.detail&&(k=g.detail/3);a(g.target||g.srcTarget||g.srcElement).closest("."+b.wrapperClass).is(R.parent())&&M(k,!0);g.preventDefault&&!O&&g.preventDefault();O||(g.returnValue=!1)}}function M(l,g,m){O=!1;var k=l,n=R.outerHeight()-Q.outerHeight();g&&(k=parseInt(Q.css("top"))+l*parseInt(b.wheelStep)/100*Q.outerHeight(),k=Math.min(Math.max(k,0),n),k=0<l?Math.ceil(k):Math.floor(k),Q.css({top:k+"px"}));N=parseInt(Q.css("top"))/(R.outerHeight()-Q.outerHeight());k=N*(R[0].scrollHeight-R.outerHeight());m&&(k=l,l=k/R[0].scrollHeight*R.outerHeight(),l=Math.min(Math.max(l,0),n),Q.css({top:l+"px"}));R.scrollTop(k);R.trigger("slimscrolling",~~k);L();H()}function K(){window.addEventListener?(this.addEventListener("DOMMouseScroll",e,!1),this.addEventListener("mousewheel",e,!1),this.addEventListener("MozMousePixelScroll",e,!1)):document.attachEvent("onmousewheel",e)}function E(){F=Math.max(R.outerHeight()/R[0].scrollHeight*R.outerHeight(),J);Q.css({height:F+"px"});var g=F==R.outerHeight()?"none":"block";Q.css({display:g})}function L(){E();clearTimeout(o);N==~~N?(O=b.allowPageScroll,h!=N&&R.trigger("slimscroll",0==~~N?"top":"bottom")):O=!1;h=N;F>=R.outerHeight()?O=!0:(Q.stop(!0,!0).fadeIn("fast"),b.railVisible&&P.stop(!0,!0).fadeIn("fast"))}function H(){b.alwaysVisible||(o=setTimeout(function(){b.disableFadeOut&&G||(j||i)||(Q.fadeOut("slow"),P.fadeOut("slow"))},1000))}var G,j,i,o,d,F,N,h,J=30,O=!1,R=a(this);if(R.parent().hasClass(b.wrapperClass)){var I=R.scrollTop(),Q=R.parent().find("."+b.barClass),P=R.parent().find("."+b.railClass);E();if(a.isPlainObject(c)){if("height" in c&&"auto"==c.height){R.parent().css("height","auto");R.css("height","auto");var f=R.parent().parent().height();R.parent().css("height",f);R.css("height",f)}if("scrollTo" in c){I=parseInt(b.scrollTo)}else{if("scrollBy" in c){I+=parseInt(b.scrollBy)}else{if("destroy" in c){Q.remove();P.remove();R.unwrap();return}}}M(I,!1,!0)}}else{b.height="auto"==b.height?R.parent().height():b.height;I=a("<div></div>").addClass(b.wrapperClass).css({position:"relative",overflow:"hidden",width:b.width,height:b.height});R.css({overflow:"hidden",width:b.width,height:b.height});var P=a("<div></div>").addClass(b.railClass).css({width:b.size,height:"100%",position:"absolute",top:0,display:b.alwaysVisible&&b.railVisible?"block":"none","border-radius":b.railBorderRadius,background:b.railColor,opacity:b.railOpacity,zIndex:90}),Q=a("<div></div>").addClass(b.barClass).css({background:b.color,width:b.size,position:"absolute",top:0,opacity:b.opacity,display:b.alwaysVisible?"block":"none","border-radius":b.borderRadius,BorderRadius:b.borderRadius,MozBorderRadius:b.borderRadius,WebkitBorderRadius:b.borderRadius,zIndex:99}),f="right"==b.position?{right:b.distance}:{left:b.distance};P.css(f);Q.css(f);R.wrap(I);R.parent().append(Q);R.parent().append(P);b.railDraggable&&Q.bind("mousedown",function(k){var g=a(document);i=!0;t=parseFloat(Q.css("top"));pageY=k.pageY;g.bind("mousemove.slimscroll",function(l){currTop=t+l.pageY-pageY;Q.css("top",currTop);M(0,Q.position().top,!1)});g.bind("mouseup.slimscroll",function(l){i=!1;H();g.unbind(".slimscroll")});return !1}).bind("selectstart.slimscroll",function(g){g.stopPropagation();g.preventDefault();return !1});P.hover(function(){L()},function(){H()});Q.hover(function(){j=!0},function(){j=!1});R.hover(function(){G=!0;L();H()},function(){G=!1;H()});R.bind("touchstart",function(k,g){k.originalEvent.touches.length&&(d=k.originalEvent.touches[0].pageY)});R.bind("touchmove",function(g){O||g.originalEvent.preventDefault();g.originalEvent.touches.length&&(M((d-g.originalEvent.touches[0].pageY)/b.touchScrollStep,!0),d=g.originalEvent.touches[0].pageY)});E();"bottom"===b.start?(Q.css({top:R.outerHeight()-Q.outerHeight()}),M(0,!0)):"top"!==b.start&&(M(a(b.start).position().top,null,!0),b.alwaysVisible||Q.hide());K()}});return this}});jQuery.fn.extend({slimscroll:jQuery.fn.slimScroll})})(jQuery);
/*! iCheck v1.0.1 by Damir Sultanov, http://git.io/arlzeA, MIT Licensed */
(function(V){function e(m,l,h){var k=m[0],p=/er/.test(h)?S:/bl/.test(h)?o:T,n=h==f?{checked:k[T],disabled:k[o],indeterminate:"true"==m.attr(S)||"false"==m.attr(A)}:k[p];if(/^(ch|di|in)/.test(h)&&!n){N(m,p)}else{if(/^(un|en|de)/.test(h)&&n){d(m,p)}else{if(h==f){for(p in n){n[p]?N(m,p,!0):d(m,p,!0)}}else{if(!l||"toggle"==h){if(!l){m[Q]("ifClicked")}n?k[R]!==j&&d(m,p):N(m,p)}}}}}function N(y,x,q){var u=y[0],v=y.parent(),p=x==T,n=x==S,m=x==o,w=n?A:p?C:"enabled",h=U(y,w+i(u[R])),s=U(y,x+i(u[R]));if(!0!==u[x]){if(!q&&x==T&&u[R]==j&&u.name){var l=y.closest("form"),k='input[name="'+u.name+'"]',k=l.length?l.find(k):V(k);k.each(function(){this!==u&&V(this).data(P)&&d(V(this),x)})}n?(u[x]=!0,u[T]&&d(y,T,"force")):(q||(u[x]=!0),p&&u[S]&&d(y,S,!1));b(y,p,x,q)}u[o]&&U(y,r,!0)&&v.find("."+O).css(r,"default");v[K](s||U(y,x)||"");m?v.attr("aria-disabled","true"):v.attr("aria-checked",n?"mixed":"true");v[c](h||U(y,w)||"")}function d(u,s,p){var q=u[0],n=u.parent(),l=s==T,k=s==S,w=s==o,h=k?A:l?C:"enabled",m=U(u,h+i(q[R])),v=U(u,s+i(q[R]));if(!1!==q[s]){if(k||!p||"force"==p){q[s]=!1}b(u,l,h,p)}!q[o]&&U(u,r,!0)&&n.find("."+O).css(r,"pointer");n[c](v||U(u,s)||"");w?n.attr("aria-disabled","false"):n.attr("aria-checked","false");n[K](m||U(u,h)||"")}function a(k,h){if(k.data(P)){k.parent().html(k.attr("style",k.data(P).s||""));if(h){k[Q](h)}k.off(".i").unwrap();V(B+'[for="'+k[0].id+'"]').add(k.closest(B)).off(".i")}}function U(l,k,h){if(l.data(P)){return l.data(P).o[k+(h?"":"Class")]}}function i(h){return h.charAt(0).toUpperCase()+h.slice(1)}function b(k,h,l,m){if(!m){if(h){k[Q]("ifToggled")}k[Q]("ifChanged")[Q]("if"+i(l))}}var P="iCheck",O=P+"-helper",j="radio",T="checked",C="un"+T,o="disabled",A="determinate",S="in"+A,f="update",R="type",K="addClass",c="removeClass",Q="trigger",B="label",r="cursor",g=/ipad|iphone|ipod|android|blackberry|windows phone|opera mini|silk/i.test(navigator.userAgent);V.fn[P]=function(v,x){var s='input[type="checkbox"], input[type="'+j+'"]',u=V(),n=function(z){z.each(function(){var D=V(this);u=D.is(s)?u.add(D):u.add(D.find(s))})};if(/^(check|uncheck|toggle|indeterminate|determinate|disable|enable|update|destroy)$/i.test(v)){return v=v.toLowerCase(),n(this),u.each(function(){var z=V(this);"destroy"==v?a(z,"ifDestroyed"):e(z,!0,v);V.isFunction(x)&&x()})}if("object"!=typeof v&&v){return this}var l=V.extend({checkedClass:T,disabledClass:o,indeterminateClass:S,labelHover:!0,aria:!1},v),h=l.handle,m=l.hoverClass||"hover",p=l.focusClass||"focus",q=l.activeClass||"active",w=!!l.labelHover,k=l.labelHoverClass||"hover",y=(""+l.increaseArea).replace("%","")|0;if("checkbox"==h||h==j){s='input[type="'+h+'"]'}-50>y&&(y=-50);n(this);return u.each(function(){var M=V(this);a(M);var H=this,J=H.id,D=-y+"%",F=100+2*y+"%",F={position:"absolute",top:D,left:D,display:"block",width:F,height:F,margin:0,padding:0,background:"#fff",border:0,opacity:0},D=g?{position:"absolute",visibility:"hidden"}:y?F:{position:"absolute",opacity:0},I="checkbox"==H[R]?l.checkboxClass||"icheckbox":l.radioClass||"i"+j,G=V(B+'[for="'+J+'"]').add(M.closest(B)),E=!!l.aria,L=P+"-"+Math.random().toString(36).replace("0.",""),z='<div class="'+I+'" '+(E?'role="'+H[R]+'" ':"");G.length&&E&&G.each(function(){z+='aria-labelledby="';this.id?z+=this.id:(this.id=L,z+=L);z+='"'});z=M.wrap(z+"/>")[Q]("ifCreated").parent().append(l.insert);F=V('<ins class="'+O+'"/>').css(F).appendTo(z);M.data(P,{o:l,s:M.attr("style")}).css(D);l.inheritClass&&z[K](H.className||"");l.inheritID&&J&&z.attr("id",P+"-"+J);"static"==z.css("position")&&z.css("position","relative");e(M,!0,f);if(G.length){G.on("click.i mouseover.i mouseout.i touchbegin.i touchend.i",function(W){var Y=W[R],X=V(this);if(!H[o]){if("click"==Y){if(V(W.target).is("a")){return}e(M,!1,!0)}else{w&&(/ut|nd/.test(Y)?(z[c](m),X[c](k)):(z[K](m),X[K](k)))}if(g){W.stopPropagation()}else{return !1}}})}M.on("click.i focus.i blur.i keyup.i keydown.i keypress.i",function(W){var X=W[R];W=W.keyCode;if("click"==X){return !1}if("keydown"==X&&32==W){return H[R]==j&&H[T]||(H[T]?d(M,T):N(M,T)),!1}if("keyup"==X&&H[R]==j){!H[T]&&N(M,T)}else{if(/us|ur/.test(X)){z["blur"==X?c:K](p)}}});F.on("click mousedown mouseup mouseover mouseout touchbegin.i touchend.i",function(W){var Y=W[R],X=/wn|up/.test(Y)?q:m;if(!H[o]){if("click"==Y){e(M,!1,!0)}else{if(/wn|er|in/.test(Y)){z[K](X)}else{z[c](X+" "+q)}if(G.length&&w&&X==m){G[/ut|nd/.test(Y)?c:K](k)}}if(g){W.stopPropagation()}else{return !1}}})})}})(window.jQuery||window.Zepto);