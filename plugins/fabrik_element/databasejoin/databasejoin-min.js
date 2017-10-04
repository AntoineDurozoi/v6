/*! Fabrik */

define(["jquery","fab/element","fab/encoder","fab/fabrik","fab/autocomplete-bootstrap"],function(jQuery,FbElement,Encoder,Fabrik,AutoComplete){return window.FbDatabasejoin=new Class({Extends:FbElement,options:{id:0,formid:0,key:"",label:"",windowwidth:360,displayType:"dropdown",popupform:0,listid:0,listRef:"",joinId:0,isJoin:!1,canRepeat:!1,fullName:"",show_please_select:!1,allowadd:!1,autoCompleteOpts:null,observe:[]},initialize:function(a,b){this.activePopUp=!1,this.activeSelect=!1,this.setPlugin("databasejoin"),this.parent(a,b),this.init()},watchAdd:function(){var a,b;(a=this.getContainer())&&(b=a.getElement(".toggle-addoption"),b.removeEvent("click",this.watchAddEvent),this.watchAddEvent=this.start.bind(this),b.addEvent("click",this.watchAddEvent))},start:function(a,b){if(this.options.editable){var c,d,e=this.getContainer();b=!!b;var f=function(){this.close()};if(c=!1,a&&(a.stop(),f=function(){this.fitToContent(!1)},c=!0,this.activePopUp=!0),d=!0,(!1!==b||0!==this.options.popupform&&!1!==this.options.allowadd)&&null!==this.element&&null!==e){var g=e.getElement(".toggle-addoption"),h="null"===typeOf(g)?a.target.get("href"):g.get("href");h+="&format=partial";var i=this.element.id+"-popupwin";this.windowopts={id:i,title:Joomla.JText._("PLG_ELEMENT_DBJOIN_ADD"),contentType:"xhr",loadMethod:"xhr",contentURL:h,height:320,minimizable:!1,collapsible:!0,visible:c,modalId:this.options.modalId,onContentLoaded:f,destroy:d};var j=this.options.windowwidth;""!==j&&(this.windowopts.width=j,this.windowopts.onContentLoaded=f),this.win=Fabrik.getWindow(this.windowopts)}}},getBlurEvent:function(){return"auto-complete"===this.options.displayType?"change":this.parent()},removeOption:function(a,b){var c=document.id(this.element.id);switch(this.options.displayType){case"dropdown":case"multilist":for(var d=c.options,e=0;e<d.length;e++)if(d[e].value===a){c.remove(e),b&&(c.selectedIndex=0),this.options.advanced&&jQuery("#"+this.element.id).trigger("liszt:updated");break}}},addOption:function(a,b,c){var d,e,f,g;switch(b=Encoder.htmlDecode(b),c=void 0===c||c,this.options.displayType){case"dropdown":case"multilist":f=(jQuery.isArray(this.options.value)?this.options.value:[this.options.value]).contains(a)?"selected":"",d=new Element("option",{value:a,selected:f}).set("text",b),document.id(this.element.id).adopt(d),this.options.advanced&&jQuery("#"+this.element.id).trigger("liszt:updated");break;case"auto-complete":c&&(g=this.element.getParent(".fabrikElement").getElement("input[name*=-auto-complete]"),this.element.value=a,g.value=b);break;case"checkbox":d=this.getCheckboxTmplNode().clone(),e=jQuery(Fabrik.jLayouts["fabrik-element-"+this.getPlugin()+"-form-rowopts"])[0],this._addOption(d,b,a,e);break;case"radio":default:d=jQuery(Fabrik.jLayouts["fabrik-element-"+this.getPlugin()+"-form-radio_"+this.strElement])[0],e=jQuery(Fabrik.jLayouts["fabrik-element-"+this.getPlugin()+"-form-rowopts"])[0],this._addOption(d,b,a,e)}},_addOption:function(a,b,c,d){var e="array"===typeOf(this.options.value)?this.options.value:Array.from(this.options.value),f=a.getElement("input"),g=this.getSubOptions(),h=this.getSubOptsRow(),i=!!e.contains(c),j="radio"===this.options.displayType?"":g.length;this.options.canRepeat?f.name=this.options.fullName+"["+this.options.repeatCounter+"]["+j+"]":f.name=this.options.fullName+"["+j+"]",a.getElement("span").set("html",b),a.getElement("input").set("value",c),0===h.length&&d.inject(this.element,"bottom");var k=jQuery(this.element).children("div[data-role=fabrik-rowopts]").last()[0];jQuery(k).children("div[data-role=suboption]").length>=this.options.optsPerRow&&(d.inject(this.element,"bottom"),k=jQuery(this.element).children("div[data-role=fabrik-rowopts]").last()[0]),a.inject(k,"bottom"),a.getElement("input").checked=i},hasSubElements:function(){var a=this.options.displayType;return"checkbox"===a||"radio"===a||this.parent()},getCheckboxTmplNode:function(){if(Fabrik.bootstrapped&&(this.chxTmplNode=jQuery(Fabrik.jLayouts["fabrik-element-"+this.getPlugin()+"-form-checkbox_"+this.strElement])[0],!this.chxTmplNode&&"checkbox"===this.options.displayType)){var a=this.element.getElements("> .fabrik_subelement");0===a.length?(this.chxTmplNode=this.element.getElement(".chxTmplNode").getChildren()[0].clone(),this.element.getElement(".chxTmplNode").destroy()):this.chxTmplNode=a.getLast().clone()}return this.chxTmplNode},getCheckboxRowOptsNode:function(){if(Fabrik.bootstrapped)this.chxTmplNode=jQuery(Fabrik.jLayouts["fabrik-element-"+this.getPlugin()+"-form-rowopts"])[0];else if(!this.chxTmplNode&&"checkbox"===this.options.displayType){var a=this.element.getElements("> .fabrik_subelement");0===a.length?(this.chxTmplNode=this.element.getElement(".chxTmplNode").getChildren()[0].clone(),this.element.getElement(".chxTmplNode").destroy()):this.chxTmplNode=a.getLast().clone()}return this.chxTmplNode},updateFromServer:function(a){var b=this.form.getFormElementData(),c=this,d={option:"com_fabrik",format:"raw",task:"plugin.pluginAjax",plugin:"databasejoin",method:"ajax_getOptions",element_id:this.options.id,formid:this.options.formid,repeatCounter:this.options.repeatCounter};if(d=Object.append(b,d),"auto-complete"===this.options.displayType&&""===a)return this.addOption("","",!0),this.element.fireEvent("change",new Event.Mock(this.element,"change")),void this.element.fireEvent("blur",new Event.Mock(this.element,"blur"));a&&(d[this.strElement+"_raw"]=a,d[this.options.fullName+"_raw"]=a),Fabrik.loader.start(this.element.getParent(),Joomla.JText._("COM_FABRIK_LOADING")),new Request.JSON({url:"",method:"post",data:d,onSuccess:function(b){Fabrik.loader.stop(c.element.getParent());var d,e=!1,f=c.getOptionValues();if("auto-complete"!==c.options.displayType||""!==a||0!==f.length){var g=[];b.each(function(a){g.push(a.value),f.contains(a.value)||null===a.value||(d=c.options.value===a.value,c.addOption(a.value,a.text,d),e=!0)}),f.each(function(a){g.contains(a)||(d=c.getValue()===a,c.removeOption(a,d),e=!0)}),e&&(c.element.fireEvent("change",new Event.Mock(c.element,"change")),c.element.fireEvent("blur",new Event.Mock(c.element,"blur"))),c.activePopUp=!1,Fabrik.fireEvent("fabrik.dbjoin.update",[c,b])}}}).post()},getSubOptions:function(){var a;switch(this.options.displayType){case"dropdown":case"multilist":a=this.element.getElements("option");break;case"checkbox":a=this.element.getElements("[data-role=suboption] input[type=checkbox]");break;case"radio":default:a=this.element.getElements("[data-role=suboption] input[type=radio]")}return a},getSubOptsRow:function(){var a;switch(this.options.displayType){case"dropdown":case"multilist":default:break;case"checkbox":case"radio":a=this.element.getElements("[data-role=fabrik-rowopts]")}return a},getOptionValues:function(){var a=this.getSubOptions(),b=[];return a.each(function(a){b.push(a.get("value"))}),b.unique()},appendInfo:function(a){var b=a.rowid,c=this,d={formid:this.options.popupform,rowid:b};new Request.JSON({url:"index.php?option=com_fabrik&view=form&format=raw",data:d,onSuccess:function(a){var b=a.data[c.options.key],d=a.data[c.options.label];switch(c.options.displayType){case"dropdown":case"multilist":var e=c.element.getElements("option").filter(function(a,d){if(a.get("value")===b)return"dropdown"===c.options.displayType?c.element.selectedIndex=d:a.selected=!0,!0});0===e.length&&c.addOption(b,d);break;case"auto-complete":case"checkbox":c.addOption(b,d);break;case"radio":default:e=c.element.getElements(".fabrik_subelement").filter(function(a,c){if(a.get("value")===b)return a.checked=!0,!0}),0===e.length&&c.addOption(b,d)}"null"!==typeOf(c.element)&&(c.element.fireEvent("change",new Event.Mock(c.element,"change")),c.element.fireEvent("blur",new Event.Mock(c.element,"blur")))}}).send()},watchSelect:function(){var a,b,c=this;if(a=this.getContainer()){var d=a.getElement(".toggle-selectoption");"null"!==typeOf(d)&&(d.addEvent("click",function(a){c.selectRecord(a)}),Fabrik.addEvent("fabrik.list.row.selected",function(a){c.options.listid.toInt()===a.listid.toInt()&&c.activeSelect&&(c.update(a.rowid),b=c.element.id+"-popupwin-select",Fabrik.Windows[b]&&Fabrik.Windows[b].close(),c.element.fireEvent("change",new Event.Mock(c.element,"change")),c.element.fireEvent("blur",new Event.Mock(c.element,"blur")))}),this.unactiveFn=function(){c.activeSelect=!1},window.addEvent("fabrik.dbjoin.unactivate",this.unactiveFn),this.selectThenAdd()),this.selectThenAdd()}},selectThenAdd:function(){Fabrik.addEvent("fabrik.block.added",function(a,b){b==="list_"+this.options.listid+this.options.listRef&&a.form.addEvent("click:relay(.addbutton)",function(a,b){a.preventDefault();var c=this.selectRecordWindowId();Fabrik.Windows[c].close(),this.start(a,!0)}.bind(this))}.bind(this))},destroy:function(){window.removeEvent("fabrik.dbjoin.unactivate",this.unactiveFn)},selectRecord:function(a){window.fireEvent("fabrik.dbjoin.unactivate"),this.activeSelect=!0,a.stop();var b=this.selectRecordWindowId(),c=this.getContainer().getElement("a.toggle-selectoption").href;c+="&format=partial",c+="&triggerElement="+this.element.id,c+="&resetfilters=1",c+="&c="+this.options.listRef;var d=function(){this.fitToContent(!1)};this.windowopts={id:b,modalId:"db_join_select",title:Joomla.JText._("PLG_ELEMENT_DBJOIN_SELECT"),contentType:"xhr",loadMethod:"xhr",evalScripts:!0,contentURL:c,width:this.options.windowwidth,height:320,minimizable:!1,collapsible:!0,onContentLoaded:d},Fabrik.getWindow(this.windowopts)},selectRecordWindowId:function(){return this.element.id+"-popupwin-select"},numChecked:function(){return"checkbox"!==this.options.displayType?null:this._getSubElements().filter(function(a){return"0"!==a.value&&a.checked}).length},update:function(a){if(this.getElement(),"null"!==typeOf(this.element)){if(!this.options.editable){if(this.element.set("html",""),""===a)return;"string"===typeOf(a)&&(a=JSON.parse(a));var b=this.form.getFormData();return"object"===typeOf(b)&&(b=$H(b)),void a.each(function(a){"null"!==typeOf(b.get(a))?this.element.innerHTML+=b.get(a)+"<br />":this.element.innerHTML+=a+"<br />"}.bind(this))}this.setValue(a)}},setValue:function(a){var b=!1;if("null"!==typeOf(this.element.options))for(var c=0;c<this.element.options.length;c++)if(this.element.options[c].value===a){this.element.options[c].selected=!0,b=!0;break}b||("auto-complete"===this.options.displayType?(this.element.value=a,this.updateFromServer(a)):"dropdown"===this.options.displayType?this.options.show_please_select&&(this.element.options[0].selected=!0):("string"===typeOf(a)&&(a=""===a?[]:JSON.parse(a)),"array"!==typeOf(a)&&(a=[a]),this._getSubElements(),this.subElements.each(function(b){var c=!1;a.each(function(a){a.toString()===b.value&&(c=!0)}.bind(this)),b.checked=c}.bind(this)))),this.options.value=a,this.options.advanced&&jQuery("#"+this.element.id).trigger("liszt:updated")},updateByLabel:function(a){if(this.getElement(),"null"!==typeOf(this.element)){this.options.editable&&"dropdown"===this.options.displayType||this.update(a);this.element.getElements("option").some(function(b){return b.text===a&&(this.update(b.value),!0)}.bind(this))}},showDesc:function(a){var b=a.target.selectedIndex,c=this.getContainer().getElement(".dbjoin-description"),d=c.getElement(".description-"+b);c.getElements(".notice").each(function(a){if(a===d){var b=new Fx.Tween(d,{property:"opacity",duration:400,transition:Fx.Transitions.linear});b.set(0),a.setStyle("display",""),b.start(0,1)}else a.setStyle("display","none")})},getValue:function(){var a=null;if(this.getElement(),!this.options.editable)switch(this.options.displayType){case"multilist":case"checkbox":return this.options.value;case"dropdown":case"auto-complete":case"radio":default:return jQuery.isArray(this.options.value)?0!==this.options.value.length?this.options.value.getLast():"":this.options.value}if("null"===typeOf(this.element))return"";switch(this.options.displayType){case"dropdown":default:return"null"===typeOf(this.element.get("value"))?"":this.element.get("value");case"multilist":var b=[];return this.element.getElements("option").each(function(a){a.selected&&b.push(a.value)}),b;case"auto-complete":return this.element.value;case"radio":return a="",this._getSubElements().each(function(b){return b.checked?a=b.get("value"):null}),a;case"checkbox":return a=[],this.getChxLabelSubElements().each(function(b){b.checked&&a.push(b.get("value"))}),a}},getChxLabelSubElements:function(){return this._getSubElements().filter(function(a){if(!a.name.contains("___id"))return!0})},getCloneName:function(){return this.options.element},getValues:function(){var a=[],b="dropdown"!==this.options.displayType?"input":"option";return document.id(this.element.id).getElements(b).each(function(b){a.push(b.value)}),a},cloned:function(a){this.activePopUp=!1,this.parent(a),this.init(),this.watchSelect(),"auto-complete"===this.options.displayType&&this.cloneAutoComplete()},cloneAutoComplete:function(){var a=this.getAutoCompleteLabelField();a.id=this.element.id+"-auto-complete",a.name=this.element.name.replace("[]","")+"-auto-complete",document.id(a.id).value="",new AutoComplete(this.element.id,this.options.autoCompleteOpts)},watchObserve:function(){var a,b;this.options.observe.each(function(c){""!==c&&(this.form.formElements[c]?this.form.formElements[c].addNewEventAux(this.form.formElements[c].getChangeEvent(),function(a){this.updateFromServer()}.bind(this)):this.options.canRepeat?(b=c+"_"+this.options.repeatCounter,this.form.formElements[b]&&this.form.formElements[b].addNewEventAux(this.form.formElements[b].getChangeEvent(),function(a){this.updateFromServer()}.bind(this))):this.form.repeatGroupMarkers.each(function(d,e){for(b="",a=0;a<d;a++)b="join___"+this.form.options.group_join_ids[e]+"___"+c+"_"+a,this.form.formElements[b]&&this.form.formElements[b].addNewEvent(this.form.formElements[b].getChangeEvent(),function(a){this.updateFromServer()}.bind(this))}.bind(this)))}.bind(this))},attachedToForm:function(){this.options.editable&&this.watchObserve(),this.parent()},init:function(){"null"!==typeOf(this.element)&&(this.options.editable&&this.getCheckboxTmplNode(),!0===this.options.allowadd&&!1!==this.options.editable&&(this.watchAddEvent=this.start.bind(this),this.watchAdd(),Fabrik.addEvent("fabrik.form.submitted",function(a,b){this.options.popupform===a.id&&(this.activePopUp&&(this.options.value=b.rowid),"auto-complete"===this.options.displayType?this.activePopup&&new Request.JSON({url:"index.php?option=com_fabrik&view=form&format=raw",data:{formid:this.options.popupform,rowid:b.rowid},onSuccess:function(a){this.update(a.data[this.options.key])}.bind(this)}).send():this.updateFromServer())}.bind(this))),this.options.editable&&(this.watchSelect(),!0===this.options.showDesc&&this.element.addEvent("change",function(a){this.showDesc(a)}.bind(this))))},getAutoCompleteLabelField:function(){var a=this.element.getParent(".fabrikElement"),b=a.getElement("input[name*=-auto-complete]");return"null"===typeOf(b)&&(b=a.getElement("input[id*=-auto-complete]")),b},addNewEventAux:function(action,js){switch(this.options.displayType){case"dropdown":default:this.element&&this.element.addEvent(action,function(e){e&&e.stop(),"function"===typeOf(js)?js.delay(0,this,this):eval(js)}.bind(this));break;case"checkbox":case"radio":this._getSubElements(),this.subElements.each(function(el){el.addEvent(action,function(){"function"===typeOf(js)?js.delay(0,this,this):eval(js)}.bind(this))}.bind(this));break;case"auto-complete":var f=this.getAutoCompleteLabelField();"null"!==typeOf(f)&&f.addEvent(action,function(e){e&&e.stop(),"function"===typeOf(js)?js.delay(700,this,this):eval(js)}.bind(this)),this.element&&this.element.addEvent(action,function(e){e&&e.stop(),"function"===typeOf(js)?js.delay(0,this,this):eval(js)}.bind(this))}},decreaseName:function(a){if("auto-complete"===this.options.displayType){var b=this.getAutoCompleteLabelField();"null"!==typeOf(b)&&(b.name=this._decreaseName(b.name,a,"-auto-complete"),b.id=this._decreaseId(b.id,a,"-auto-complete"))}return this.parent(a)},updateUsingRaw:function(){return!0}}),window.FbDatabasejoin});