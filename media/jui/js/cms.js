Joomla=window.Joomla||{},function(t,a){"use strict";Joomla.setcollapse=function(a,e,n){t.getElementById("collapse-"+e)||(t.getElementById("container-collapse").innerHTML='<div class="collapse fade" id="collapse-'+e+'"><iframe class="iframe" src="'+a+'" height="'+n+'" width="100%"></iframe></div>')},Array.prototype.indexOf||(Array.prototype.indexOf=function(a){var e=this.length>>>0,n=Number(arguments[1])||0;for((n=n<0?Math.ceil(n):Math.floor(n))<0&&(n+=e);n<e;n++)if(n in this&&this[n]===a)return n;return-1}),window.jQuery&&function(h){function d(a,e){for(var n,t,o,i,r=!0,l=a.data("showon")||[],d=0,s=l.length;d<s;d++)o=(t=l[d]||{}).field,i=h('[name="'+o+'"], [name="'+o+'[]"]'),t.valid=0,i.each(function(){var a=h(this);if(-1!==["checkbox","radio"].indexOf(a.attr("type"))){if(!a.prop("checked"))return;n=a.val()}else null==(n=a.val())&&"select"==a.prop("tagName").toLowerCase()&&(n=[]);for(var e in"object"!=typeof n&&(n=JSON.parse('["'+n+'"]')),n)n.propertyIsEnumerable(e)&&("="==l[d].sign&&-1!==l[d].values.indexOf(n[e])&&(l[d].valid=1),"!="==l[d].sign&&-1===l[d].values.indexOf(n[e])&&(l[d].valid=1))}),""===t.op?0===t.valid&&(r=!1):("AND"===t.op&&t.valid+l[d-1].valid<2&&(r=!1,t.valid=0),"OR"===t.op&&0<t.valid+l[d-1].valid&&(r=!0,t.valid=1));if(a.is("option")){a.toggle(r),a.attr("disabled",!r);var f=a.parent();h("#"+f.attr("id")+"_chzn").length&&(f.trigger("liszt:updated"),f.trigger("chosen:updated"))}(e=e&&!a.hasClass("no-animation")&&!a.hasClass("no-animate")&&!a.find(".no-animation, .no-animate").length)?r?a.slideDown():a.slideUp():a.toggle(r)}function p(a){for(var r=h(a=a||t).find("[data-showon]"),l=0,e=r.length;l<e;l++)!function(){for(var a,e=h(r[l]),n=e.data("showon")||[],t=h(),o=0,i=n.length;o<i;o++)a=n[o].field,t=t.add(h('[name="'+a+'"], [name="'+a+'[]"]'));d(e),t.on("change keyup",function(){d(e,!0)})}()}h(t).ready(function(){p(),h(t).on("subform-row-add",function(a,e){for(var n,t,o=h(e),i=o.find("[data-showon]"),r=o.data("baseName"),l=o.data("group"),d=new RegExp("\\["+r+"\\]\\["+r+"X\\]","g"),s="["+r+"]["+l+"]",f=0,c=i.length;f<c;f++)t=(n=h(i[f])).attr("data-showon").replace(d,s),n.attr("data-showon",t);p(e)})})}(jQuery)}(document);
