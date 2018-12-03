/*! Fabrik */

var FloatingTips=new Class({Implements:[Options,Events],options:{fxProperties:{transition:Fx.Transitions.linear,duration:500},position:"top",showOn:"mouseenter",hideOn:"mouseleave",content:"title",distance:50,tipfx:"Fx.Transitions.linear",duration:500,fadein:!1,showFn:function(t){return t.stop(),!0},hideFn:function(t){return t.stop(),!0}},initialize:function(elements,options){this.setOptions(options),this.options.fxProperties={transition:eval(this.options.tipfx),duration:this.options.duration},window.addEvent("tips.hideall",function(t,e){"element"===typeOf(t)&&(e=t),this.hideOthers(e)}.bind(this)),elements&&this.attach(elements)},attach:function(t){this.elements=$$(t),this.elements.each(function(t){var e={};t.get("opts","{}").opts&&JSON.validate(t.get("opts","{}").opts)&&(e=JSON.parse(t.get("opts","{}").opts));var i=Object.merge(Object.clone(this.options),e),n=t.retrieve("opts",{});if(t.erase("opts"),!n[i.showOn]){n[i.showOn]=i,t.store("opts",n);var o=this.getTipContent(t,i.showOn),s=new Element("div.floating-tip.tip"+i.position),r=new Element("div.floating-tip-wrapper");"string"===typeOf(o)?(o=Encoder.htmlDecode(o),s.set("html",o)):s.adopt(o),r.adopt(s),r.inject(document.body).hide(),r.addEvent("mouseleave",function(t){"mouseleave"===i.hideOn&&r.hide()}.bind(this));var a=t.retrieve("tip",{});a[i.showOn]=r,t.store("tip",a);var h=Object.merge({onComplete:function(t){this.hideMe&&this.tip.hide()},onStart:function(t){this.hideMe=!1}},Object.clone(this.options.fxProperties)),p=new Fx.Morph(r,h);p.tip=r;var d=t.retrieve("fx",{});d[i.showOn]=p,t.store("fxs",d),this.addStartEvent(t,i.showOn),this.addEndEvent(t,i.showOn)}}.bind(this))},addStartEvent:function(n,o){var s=n.retrieve("opts");s=s[o],n.addEvent(s.showOn,function(t){if("click"===s.showOn){var e=n.retrieve("active",!1),i=!e;if(n.store("active",i),e)return}s.showFn(t,n)&&(window.fireEvent("tips.hideall",[n]),this.show(n,o))}.bind(this))},addEndEvent:function(e,i){var n=e.retrieve("opts");n=n[i],e.addEvent(n.hideOn,function(t){e.retrieve("tip")[n.showOn];n.hideFn(t)&&this.hide(e,i)}.bind(this))},getTipContent:function(t,e){var i,n=t.retrieve("opts"),o=(n=n[e]).content;switch(typeOf(o)){case"string":i=t.get(o),t.set(o,"");break;case"element":i=o;break;default:i=o(t)}return i},show:function(t,e){var i=t.retrieve("tip"),n=t.retrieve("opts"),o=i[(n=n[e]).showOn];if(1!==o.getStyle("opacity")||"none"===o.getStyle("display")||"null"===typeOf(o.getParent())){o.setStyle("opacity",0),o.show(),"null"===typeOf(n.position)&&(n.position="left");var s=n.distance;switch(n.position){case"top":var r=o.getStyle("border-top").toInt()+o.getStyle("border-bottom").toInt(),a={x:0,y:-1*s-2*r};edge="top";break;case"bottom":edge="top",a={x:0,y:s+(r=o.getStyle("border-top").toInt()+o.getStyle("border-bottom").toInt())};break;case"right":a={x:s+(r=o.getStyle("border-left").toInt()+o.getStyle("border-right").toInt()),y:0},edge="left";break;default:case"left":a={x:-1*s-(r=o.getStyle("border-left").toInt()+o.getStyle("border-right").toInt()),y:0},edge="right"}var h={relativeTo:t,position:n.position,edge:edge,offset:a};o.position(h),this.options.fadein||o.setStyle("opacity",1);var p=this.options.fadein?{opacity:[0,1]}:{};o.getCoordinates(),t.getCoordinates();switch(n.position){case"top":var d=o.getStyle("top").toInt()-o.getStyle("height").toInt();p.top=[d,d+s];break;case"bottom":d=o.getStyle("top").toInt(),p.top=[d,d-s];break;case"right":l=o.getStyle("left").toInt(),p.left=[l,l-s];break;case"left":l=o.getStyle("left").toInt(),p.left=[l,l+s]}var c=t.retrieve("fxs")[n.showOn];c.isRunning()||c.start(p)}},hide:function(t,e){var i=t.retrieve("opts");i=i[e];var n=t.retrieve("tip")[i.showOn],o=t.retrieve("fxs")[i.showOn];this.hideOthers(t),o.isRunning()&&"mouseenter"!==i.showOn&&"mouseleave"!==i.hideOn||(o.hideMe=!0,n.hide(),t.store("active",!1))},hideOthers:function(i){this.element&&this.elements.each(function(t){if(t!==i){var e=t.retrieve("tip");$H(e).each(function(t){t.hide()})}})},hideAll:function(){this.elements.each(function(t){var e=t.retrieve("tip");$H(e).each(function(t){t.hide()})})}});