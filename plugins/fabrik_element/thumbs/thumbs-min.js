/*! Fabrik */

define(["jquery","fab/element"],function(a,b){return window.FbThumbs=new Class({Extends:b,initialize:function(a,b,c){this.field=document.id(a),this.parent(a,b),this.thumb=c,this.spinner=new Spinner(this.getContainer()),Fabrik.bootstrapped?this.setupj3():(this.thumbup=document.id("thumbup"),this.thumbdown=document.id("thumbdown"),this.options.canUse?(this.imagepath=Fabrik.liveSite+"plugins/fabrik_element/thumbs/images/",this.thumbup.addEvent("mouseover",function(a){this.thumbup.setStyle("cursor","pointer"),this.thumbup.src=this.imagepath+"thumb_up_in.gif"}.bind(this)),this.thumbdown.addEvent("mouseover",function(a){this.thumbdown.setStyle("cursor","pointer"),this.thumbdown.src=this.imagepath+"thumb_down_in.gif"}.bind(this)),this.thumbup.addEvent("mouseout",function(a){this.thumbup.setStyle("cursor",""),"up"===this.options.myThumb?this.thumbup.src=this.imagepath+"thumb_up_in.gif":this.thumbup.src=this.imagepath+"thumb_up_out.gif"}.bind(this)),this.thumbdown.addEvent("mouseout",function(a){this.thumbdown.setStyle("cursor",""),"down"===this.options.myThumb?this.thumbdown.src=this.imagepath+"thumb_down_in.gif":this.thumbdown.src=this.imagepath+"thumb_down_out.gif"}.bind(this)),this.thumbup.addEvent("click",function(a){this.doAjax("up")}.bind(this)),this.thumbdown.addEvent("click",function(a){this.doAjax("down")}.bind(this))):(this.thumbup.addEvent("click",function(a){a.stop(),this.doNoAccess()}.bind(this)),this.thumbdown.addEvent("click",function(a){a.stop(),this.doNoAccess()}.bind(this))))},setupj3:function(){var a=this.getContainer(),b=a.getElement("button.thumb-up"),c=a.getElement("button.thumb-down");b.addEvent("click",function(a){if(a.stop(),this.options.canUse){var d=!b.hasClass("btn-success");this.doAjax("up",d),d?(b.addClass("btn-success"),"null"!==typeOf(c)&&c.removeClass("btn-danger")):b.removeClass("btn-success")}else this.doNoAccess()}.bind(this)),"null"!==typeOf(c)&&c.addEvent("click",function(a){if(a.stop(),this.options.canUse){var d=!c.hasClass("btn-danger");this.doAjax("down",d),d?(c.addClass("btn-danger"),b.removeClass("btn-success")):c.removeClass("btn-danger")}else this.doNoAccess()}.bind(this))},doAjax:function(a,b){if(b=!!b,!1===this.options.editable){this.spinner.show();var c={option:"com_fabrik",format:"raw",task:"plugin.pluginAjax",plugin:"thumbs",method:"ajax_rate",g:"element",element_id:this.options.elid,row_id:this.options.row_id,elementname:this.options.elid,userid:this.options.userid,thumb:a,listid:this.options.listid,formid:this.options.formid,add:b};new Request({url:"",data:c,onComplete:function(a){if(a=JSON.decode(a),this.spinner.hide(),a.error)console.log(a.error);else if(""!==a)if(Fabrik.bootstrapped){var b=this.getContainer();b.getElement("button.thumb-up .thumb-count").set("text",a[0]),"null"!==typeOf(b.getElement("button.thumb-down"))&&b.getElement("button.thumb-down .thumb-count").set("text",a[1])}else{var c=document.id("count_thumbup"),d=document.id("count_thumbdown"),e=document.id("thumbup"),f=document.id("thumbdown");c.set("html",a[0]),d.set("html",a[1]),this.getContainer().getElement("."+this.field.id).value=a[0].toFloat()-a[1].toFloat(),"1"===a[0]?(e.src=this.imagepath+"thumb_up_in.gif",f.src=this.imagepath+"thumb_down_out.gif"):(e.src=this.imagepath+"thumb_up_out.gif",f.src=this.imagepath+"thumb_down_in.gif")}}.bind(this)}).send()}},doNoAccess:function(){""!==this.options.noAccessMsg&&window.alert(this.options.noAccessMsg)}}),window.FbThumbs});