/*! Fabrik */

!function(a,b,c,d){function e(a){return b.getElementById(a)}c.runtimes.Html4=c.addRuntime("html4",{getFeatures:function(){return{multipart:!0,triggerDialog:c.ua.gecko&&a.FormData||c.ua.webkit}},init:function(d,f){d.bind("Init",function(f){function g(){var a,h,i,j;k=c.guid(),r.push(k),a=b.createElement("form"),a.setAttribute("id","form_"+k),a.setAttribute("method","post"),a.setAttribute("enctype","multipart/form-data"),a.setAttribute("encoding","multipart/form-data"),a.setAttribute("target",f.id+"_iframe"),a.style.position="absolute",h=b.createElement("input"),h.setAttribute("id","input_"+k),h.setAttribute("type","file"),h.setAttribute("accept",t),h.setAttribute("size",1),j=e(f.settings.browse_button),f.features.triggerDialog&&j&&c.addEvent(e(f.settings.browse_button),"click",function(a){h.click(),a.preventDefault()},f.id),c.extend(h.style,{width:"100%",height:"100%",opacity:0,fontSize:"999px"}),c.extend(a.style,{overflow:"hidden"}),i=f.settings.shim_bgcolor,i&&(a.style.background=i),s&&c.extend(h.style,{filter:"alpha(opacity=0)"}),c.addEvent(h,"change",function(b){var i,l=b.target,m=[];l.value&&(e("form_"+k).style.top="-1048575px",i=l.value.replace(/\\/g,"/"),i=i.substring(i.length,i.lastIndexOf("/")+1),m.push(new c.File(k,i)),f.features.triggerDialog?c.removeEvent(j,"click",f.id):c.removeAllEvents(a,f.id),c.removeEvent(h,"change",f.id),g(),m.length&&d.trigger("FilesAdded",m))},f.id),a.appendChild(h),p.appendChild(a),f.refresh()}function h(){var d=b.createElement("div");d.innerHTML='<iframe id="'+f.id+'_iframe" name="'+f.id+'_iframe" src="'+q+':&quot;&quot;" style="display:none"></iframe>',i=d.firstChild,p.appendChild(i),c.addEvent(i,"load",function(b){var d,e,g=b.target;if(j){try{d=g.contentWindow.document||g.contentDocument||a.frames[g.id].document}catch(a){return void f.trigger("Error",{code:c.SECURITY_ERROR,message:c.translate("Security error."),file:j})}e=d.body.innerHTML,e&&(j.status=c.DONE,j.loaded=1025,j.percent=100,f.trigger("UploadProgress",j),f.trigger("FileUploaded",j,{response:e}))}},f.id)}var i,j,k,l,m,n,o,p=b.body,q="javascript",r=[],s=/MSIE/.test(navigator.userAgent),t=[],u=f.settings.filters;a:for(l=0;l<u.length;l++)for(m=u[l].extensions.split(/,/),o=0;o<m.length;o++){if("*"===m[o]){t=[];break a}n=c.mimeTypes[m[o]],n&&t.push(n)}t=t.join(","),f.settings.container&&(p=e(f.settings.container),"static"===c.getStyle(p,"position")&&(p.style.position="relative")),f.bind("UploadFile",function(a,d){var f,g;d.status!=c.DONE&&d.status!=c.FAILED&&a.state!=c.STOPPED&&(f=e("form_"+d.id),g=e("input_"+d.id),g.setAttribute("name",a.settings.file_data_name),f.setAttribute("action",a.settings.url),c.each(c.extend({name:d.target_name||d.name},a.settings.multipart_params),function(a,d){var e=b.createElement("input");c.extend(e,{type:"hidden",name:d,value:a}),f.insertBefore(e,f.firstChild)}),j=d,e("form_"+k).style.top="-1048575px",f.submit(),f.parentNode.removeChild(f))}),f.bind("FileUploaded",function(a){a.refresh()}),f.bind("StateChanged",function(b){b.state==c.STARTED&&h(),b.state==c.STOPPED&&a.setTimeout(function(){c.removeEvent(i,"load",b.id),i.parentNode&&i.parentNode.removeChild(i)},0)}),f.bind("Refresh",function(a){var d,f,g,h,i,j,l,m;(d=e(a.settings.browse_button))&&(i=c.getPos(d,e(a.settings.container)),j=c.getSize(d),l=e("form_"+k),e("input_"+k),c.extend(l.style,{top:i.y+"px",left:i.x+"px",width:j.w+"px",height:j.h+"px"}),a.features.triggerDialog&&("static"===c.getStyle(d,"position")&&c.extend(d.style,{position:"relative"}),m=parseInt(d.style.zIndex,10),isNaN(m)&&(m=0),c.extend(d.style,{zIndex:m}),c.extend(l.style,{zIndex:m-1})),g=a.settings.browse_button_hover,h=a.settings.browse_button_active,f=a.features.triggerDialog?d:l,g&&(c.addEvent(f,"mouseover",function(){c.addClass(d,g)},a.id),c.addEvent(f,"mouseout",function(){c.removeClass(d,g)},a.id)),h&&(c.addEvent(f,"mousedown",function(){c.addClass(d,h)},a.id),c.addEvent(b.body,"mouseup",function(){c.removeClass(d,h)},a.id)))}),d.bind("FilesRemoved",function(a,b){var c,d;for(c=0;c<b.length;c++)(d=e("form_"+b[c].id))&&d.parentNode.removeChild(d)}),d.bind("Destroy",function(a){var d,f,g,h={inputContainer:"form_"+k,inputFile:"input_"+k,browseButton:a.settings.browse_button};for(d in h)(f=e(h[d]))&&c.removeAllEvents(f,a.id);c.removeAllEvents(b.body,a.id),c.each(r,function(a,b){(g=e("form_"+a))&&p.removeChild(g)})}),g()}),f({success:!0})}})}(window,document,plupload);