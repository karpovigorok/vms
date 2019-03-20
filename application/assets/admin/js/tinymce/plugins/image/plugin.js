/*global tinymce:true */

tinymce.PluginManager.add('image', function(editor, url) {
	function showDialog() {
		var win, data, dom = editor.dom, imgElm = editor.selection.getNode();
		var width, height, query_str = "";

		if(imgElm.nodeName == "IMG" && !imgElm.getAttribute('data-mce-object')){
			query_str = "?title=" + dom.getAttrib(imgElm, 'title') + "&alt=" + dom.getAttrib(imgElm, 'alt') + "&width=" + dom.getAttrib(imgElm, 'width') + "&height=" + dom.getAttrib(imgElm, 'height') + "&src=" + encodeURIComponent(dom.getAttrib(imgElm, 'src'));
			if(dom.getStyle(imgElm, 'float')){
				query_str += "&align=" + dom.getStyle(imgElm, 'float');
			}
			
			if(dom.getAttrib(imgElm, 'class')){
				query_str += "&class=" + dom.getAttrib(imgElm, 'class');
			}

		}else{
			imgElm = null;
		}

		function GetTheHtml(){
			var html = '';
			if(imgElm){
				html += '<input type="hidden" name="src" id="src" value="' + dom.getAttrib(imgElm, "src") + '"/>';
				html += '<input type="hidden" name="alt" id="alt" value="' + dom.getAttrib(imgElm, "alt") + '"/>';
				html += '<input type="hidden" name="title" id="title" value="' + dom.getAttrib(imgElm, "title") + '"/>';
				html += '<input type="hidden" name="width" id="width" value="' + dom.getAttrib(imgElm, "width") + '"/>';
				html += '<input type="hidden" name="height" id="height" value="' + dom.getAttrib(imgElm, "height") + '"/>';
				html += '<input type="hidden" name="class" id="class" value="' + dom.getAttrib(imgElm, "class") + '"/>';
				html += '<input type="hidden" name="linkURL" id="linkURL" />';
				html += '<input type="hidden" name="target" id="target" />';
				html += '<input type="hidden" name="align" id="align" value="' + dom.getStyle(imgElm, 'float') + '"/>';
				html += '<iframe src="'+ url + '/image.php'+ query_str + '&' + new Date().getTime() + '" frameborder="0"></iframe>';
			}else{
				html += '<input type="hidden" name="src" id="src" />';
				html += '<input type="hidden" name="alt" id="alt" />';
				html += '<input type="hidden" name="title" id="title" />';
				html += '<input type="hidden" name="width" id="width" />';
				html += '<input type="hidden" name="height" id="height" />';
				html += '<input type="hidden" name="linkURL" id="linkURL" />';
				html += '<input type="hidden" name="target" id="target" />';
				html += '<input type="hidden" name="align" id="align" />';
				html += '<input type="hidden" name="class" id="class" />';
				html += '<iframe src="'+ url + '/image.php'+ '?' + new Date().getTime() + '" frameborder="0"></iframe>';
			}
			
			
			return html;
		}
		
		function getFileExtension(filename) {
			var re = /(?:\.([^.]+))?$/;
			return re.exec(filename)[1];
		}

        function is_image_extension(extension) {
            var fruits = ["gif", "jpg", "jpeg", "png", "jpe"];
            var a = fruits.indexOf(extension.toLowerCase());
            if (a <= -1) {
                return false;
            }
            return true;
        }
		
		function BuildDom(src, alt, w, h, title, linkURL, target, float, class_var){
			if(imgElm){
				if(src){
					dom.setStyle(imgElm, 'float', float);
					
					dom.setAttribs(imgElm, {
						'src': src,
						'alt': alt ? alt : null,
						'width': w ? w : null,
						'height': h ? h : null,
						'title': title ? title : null
					});
					
					if(class_var){
						dom.setAttribs(imgElm, {
							'class': class_var
						});
					}
					
				}
			}else{
				var markup = '';
				if(src){
					if(!is_image_extension(getFileExtension(src))){
						markup += '<a href="' + src + '"';
							
						if(target){
							markup += ' target="' + target + '"';
						}
						
						if(class_var){
							markup += ' class="' + class_var + '"';
						}
							
						markup += '>';
						
						if(title){
							markup += title;
						}else{
							markup += src;
						}
						
						markup += '</a>';
					}else{
						markup += '<img src="' + src + '"';
						if(alt){
							markup += ' alt="' + alt + '"';
						}
						if(title){
							markup += ' title="' + title + '"';
						}
						if(h){
							markup += ' height="' + h + '"';
						}
						if(w){
							markup += ' width="' + w + '"';
						}
						
						if(class_var){
							markup += ' class="' + class_var + '"';
						}
						
						if(float){
							if(!linkURL){
								markup += ' style="float: ' + float + '"';
							}
						}
						
						markup += ' />';
						
						if(linkURL){
							var thelink = '<a href="' + linkURL + '"';
							
							if(target){
								thelink += ' target="' + target + '"';
							}
							
							if(float){
								thelink += ' style="float: ' + float + '"';
							}
							
							thelink += '>';
							markup = thelink + markup + '</a>';
						}
					}
					
					editor.insertContent(markup);
				}
			}
		}

		win = editor.windowManager.open({
			title: "Manage Image",
			width : 885,
			height : 475,
			html: GetTheHtml(),
			buttons: [
				{
				text: 'Insert Image',
				subtype: 'primary',
				onclick: function(e) {
					BuildDom(document.getElementById("src").value, 
							document.getElementById("alt").value, 
							document.getElementById("width").value, 
							document.getElementById("height").value, 
							document.getElementById("title").value,
							document.getElementById("linkURL").value,
							document.getElementById("target").value,
							document.getElementById("align").value,
							document.getElementById("class").value);
					this.parent().parent().close();
				}
				},	
				{
				text: 'Cancel',
				onclick: function() {
					this.parent().parent().close();
				}
			}]
		});
	}
	
	editor.addButton('image', {
		icon: 'image',
		tooltip: 'Insert/edit image',
		onclick: showDialog,
		stateSelector: 'img:not([data-mce-object])'
	});

	editor.addMenuItem('image', {
		icon: 'image',
		text: 'Insert image',
		onclick: showDialog,
		context: 'insert',
		prependToContext: true
	});
});
