/*! Fabrik */

define(["jquery","fab/fileelement"],function(jQuery,FbFileElement){return window.FbImage=new Class({Extends:FbFileElement,initialize:function(e,t){this.setPlugin("image"),this.folderlist=[],this.parent(e,t),this.options.rootPath=t.rootPath,t.editable&&(this.getMyElements(),this.imageFolderList=[],this.selectedImage="",this.imageDir&&(0!==this.imageDir.options.length&&(this.selectedImage=this.imageDir.get("value")),this.imageDir.addEvent("change",function(e){this.showImage(e)}.bind(this))),!0===this.options.canSelect&&(this.ajaxFolder(),this.element=this.hiddenField,this.selectedFolder=this.getFolderPath()))},getMyElements:function(){this.options.element;var e=this.getContainer();e&&(this.image=e.getElement(".imagedisplayor"),this.folderDir=e.getElement(".folderselector"),this.imageDir=e.getElement(".imageselector"))},cloned:function(e){this.getMyElements(),this.ajaxFolder(),this.parent(e)},hasSubElements:function(){return!0},getFolderPath:function(){return this.options.rootPath+this.folderlist.join("/")},doAjaxBrowse:function(e){this.parent(e),this.changeFolder(e)},changeFolder:function(dir){var folder=this.imageDir;this.selectedFolder=this.getFolderPath(),folder.empty();var myAjax=new Request({url:"",method:"post",data:{option:"com_fabrik",format:"raw",task:"plugin.pluginAjax",g:"element",plugin:"image",method:"ajax_files",folder:dir},onComplete:function(r){var newImages=eval(r);newImages.each(function(e){folder.adopt(new Element("option",{value:e.value}).appendText(e.text))}),this.showImage()}.bind(this)}).send()},showImage:function(e){this.imageDir&&(0===this.imageDir.options.length?(this.image.src="",this.selectedImage=""):(this.selectedImage=this.imageDir.get("value"),this.image.src=Fabrik.liveSite+this.selectedFolder+"/"+this.selectedImage),this.hiddenField.value=this.getValue())},getValue:function(){return this.folderlist.join("/")+"/"+this.selectedImage},update:function(e){if(!this.hiddenField){var t=this.element.getParent(".fabrikElement");this.hiddenField=t.getElement(".folderpath")}this.hiddenField&&(this.hiddenField.value=e),""!==e?(this.image.src=Fabrik.liveSite+"/"+e,this.image.alt=e):(this.image.src="",this.image.alt="")}}),window.FbImage});