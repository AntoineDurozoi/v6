/*! Fabrik */

function geolocateLoad(){document.body?window.fireEvent("google.geolocate.loaded"):console.log("no body")}define(["jquery","fab/element","components/com_fabrik/libs/masked_input/jquery.maskedinput"],function(a,b,c){return window.FbField=new Class({Extends:b,options:{use_input_mask:!1,input_mask_definitions:"",input_mask_autoclear:!1,geocomplete:!1,mapKey:!1},initialize:function(b,c){var d;this.setPlugin("fabrikfield"),this.parent(b,c),this.options.use_input_mask&&(""!==this.options.input_mask_definitions&&(d=JSON.parse(this.options.input_mask_definitions),a.extend(a.mask.definitions,d)),a("#"+b).mask(this.options.input_mask,{autoclear:this.options.input_mask_autoclear})),this.options.geocomplete&&(this.gcMade=!1,this.loadFn=function(){if(!1===this.gcMade){var b=this;a("#"+this.element.id).geocomplete().bind("geocode:result",function(a,c){Fabrik.fireEvent("fabrik.element.field.geocode",b)}),this.gcMade=!0}}.bind(this),window.addEvent("google.geolocate.loaded",this.loadFn),Fabrik.loadGoogleMap(this.options.mapKey,"geolocateLoad"))},select:function(){this.getElement()&&this.getElement().select()},focus:function(){this.getElement()&&this.getElement().focus(),this.parent()},cloned:function(b){var c=this.getElement();if(this.options.use_input_mask&&c){if(""!==this.options.input_mask_definitions){var d=JSON.parse(this.options.input_mask_definitions);$H(d).each(function(b,c){a.mask.definitions[c]=b})}a("#"+c.id).mask(this.options.input_mask,{autoclear:this.options.input_mask_autoclear})}this.options.geocomplete&&c&&a("#"+c.id).geocomplete(),this.parent(b)}}),window.FbField});