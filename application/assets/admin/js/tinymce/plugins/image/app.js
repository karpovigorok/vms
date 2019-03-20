$(document).ready(function(){
	
	var originalWidth, originalHeight, loaded = false;
	
	function MySerach(needle, haystack){
		var results = new Array();
		var counter = 0;
		var rgxp = new RegExp(needle, "g");
		var temp = new Array();
		for(i=0;i<haystack.length;i++){
			temp = haystack[i][1].match(rgxp);
			if(temp && temp.length > 0){
				results[counter] = haystack[i];
				counter = counter + 1;
			}
		}
		return results;
	}
	
	function getFileExtension(filename) {
		var re = /(?:\.([^.]+))?$/;
		return re.exec(filename)[1];
	}
	
	function getArray(object){
		var array = [];
		for(var key in object){
			var item = object[key];
			array[parseInt(key)] = (typeof(item) == "object")?getArray(item):item;
		}
		return array;
	}
	
	var search_haystack = new Array();
	
	$("#search").focus(function () {
		$("#lib-back").attr('disabled','disabled');
		$("#newfolder_name").attr('disabled','disabled');
		$("#newfolder_btn").attr('disabled','disabled');
		
		$("#refresh").attr("rel", "searching");
		
		$('#lib-title').empty().append(trans_searching + '... <a href="" id="clear-search">' + trans_clear + '</a>');
		
		$.getJSON('search.php',{}, function(returned){ 
			search_haystack = getArray(returned);
		});
	});
	
	$(document).on('click', 'a#clear-search', function () {
		$('#lib-title').empty().append("Home");
		
		$("#newfolder_name").removeAttr("disabled", "disabled");
		$("#newfolder_btn").removeAttr("disabled", "disabled");
		
		$("#refresh").attr("rel", lib_folder_path);
		
		$("#search").val("");
    			
    	$('#gallery-images').empty().append('<div id="ajax-loader-div"><img src="bootstrap/img/ajax-loader.gif" alt="Loading..." class="ajax-loader"></div>');
		$.getJSON('lib.php' + '?dummy=' + new Date().getTime(),{}, function(returned){ 
			if(returned.success == 1){
				$('#gallery-images').empty().append(returned.html);
			}else{
				$('#gallery-images').empty().append('<center>' + trans_no_images_in_lib + '</center>');
			}
		});
		return false;
	});
	
	$("#search").keyup(function(event) {
    		if(this.value.length > 1){
    			
    			
    		$('#gallery-images').empty().append('<div id="ajax-loader-div"><img src="bootstrap/img/ajax-loader.gif" alt="Loading..." class="ajax-loader"></div>');
			
			var results = MySerach(this.value, search_haystack);
			$('#gallery-images').empty();
			if(results.length > 0){
				for(i=0;i<results.length;i++){
					//$('#gallery-images').append('<a href="" class="img-thumbs" rel="' + results[i][0] + '"><img src="timthumb.php?src=' + results[i][0] + '&w=130&h=90" class="img-polaroid" width="130" height="90"></a>');
					$('#gallery-images').append('<div class="item"><a href="" class="img-thumbs" rel="' + results[i][0] + '" title="' + results[i][1] + '"><img src="timthumb.php?src=' + results[i][0] + '&w=130&h=90" class="img-polaroid" width="130" height="90"></a><div><a href="" class="pull-left transparent change-file" title="' + trans_change_name + '" rel="' + results[i][1] + '"><i class="icon-pencil"></i></a><a href="" class="pull-right transparent delete-file" data-path="'+ results[i][3] +'" rel="'+ results[i][2] +'" title="' + trans_delete + '"><i class="icon-trash"></i></a><div class="clearfix"></div></div></div>');
				}
			}else{
				$('#gallery-images').append('<center>' + trans_no_images_in_search + '</center>');
			}
    		}else if(this.value.length == 0){
    			$('#lib-title').empty().append("Home");
			
			$("#newfolder_name").removeAttr("disabled", "disabled");
			$("#newfolder_btn").removeAttr("disabled", "disabled");
			
			$("#refresh").attr("rel", lib_folder_path);
    			
    			$('#gallery-images').empty().append('<div id="ajax-loader-div"><img src="bootstrap/img/ajax-loader.gif" alt="Loading..." class="ajax-loader"></div>');
			$.getJSON('lib.php' + '?dummy=' + new Date().getTime(),{}, function(returned){ 
				if(returned.success == 1){
					$('#gallery-images').empty().append(returned.html);
				}else{
					$('#gallery-images').empty().append('<center>' + trans_no_images_in_lib + '</center>');
				}
			});
    		}
    	});
	
	$("#preview").bind("load", function () {
		if(newImage){
			if ($("#preview").get(0).naturalWidth) {
				$("#width").val($("#preview").get(0).naturalWidth);
				$("#height").val($("#preview").get(0).naturalHeight);
					
				originalWidth = $("#preview").get(0).naturalWidth;
				originalHeight = $("#preview").get(0).naturalHeight;
			} else if ($("#preview").attr("naturalWidth")) {
				$("#width").val($("#preview").attr("naturalWidth"));
				$("#height").val($("#preview").attr("naturalHeight"));
					
				originalWidth = $("#preview").attr("naturalWidth");
				originalHeight = $("#preview").attr("naturalHeight");
			}
		
			parent.document.getElementById("width").value= originalWidth;
			parent.document.getElementById("height").value= originalHeight;
		}else{
			newImage = true;
			if ($("#preview").get(0).naturalWidth) {
				originalWidth = $("#preview").get(0).naturalWidth;
				originalHeight = $("#preview").get(0).naturalHeight;
			} else if ($("#preview").attr("naturalWidth")) {
				originalWidth = $("#preview").attr("naturalWidth");
				originalHeight = $("#preview").attr("naturalHeight");
			}
		}
	});
	
	$(document).on('click', 'a.mi-close', function () {
		$(this).parent().hide();
		return false;
	});
	
	$(document).on('click', 'a.img-thumbs', function () {
		$(".pdf-fields").hide();
		$(".image-fields").show();
		
		$("#preview").attr("src", "");
		$("#width").val();
		$("#height").val();
		$("#source").val($(this).attr("rel"));
        	$("#preview").attr("src", $(this).attr("rel") + '?dummy=' + new Date().getTime());
        	$('#myTab a[href="#tab1"]').tab('show');
        	parent.document.getElementById("src").value= $(this).attr("rel");
        	$.post("update_recent.php" + "?dummy=" + new Date().getTime(), { src: $(this).attr("rel") } );
		return false;
	});
	
	$(document).on('click', 'a.pdf-thumbs', function () {
		$(".pdf-fields").show();
		$(".image-fields").hide();
		
		$("#preview").attr("src", $(this).data("icon"));
		$("#width").val();
		$("#height").val();
		$("#source_pdf").val($(this).attr("rel"));
        $('#myTab a[href="#tab1"]').tab('show');
        parent.document.getElementById("src").value= $(this).attr("rel");
        $.post("update_recent.php" + "?dummy=" + new Date().getTime(), { src: $(this).attr("rel") } );
		return false;
	});
	
	$("#class_pdf").bind("change", function () {
		parent.document.getElementById("class").value= this.value;
	});
	
	$("#title_pdf").bind("change", function () {
		parent.document.getElementById("title").value= this.value;
	});
	
	$("#target_pdf").bind("change", function () {
		parent.document.getElementById("target").value= this.value;
	});
	
	$("#source").bind("change", function () {
		$.post("update_recent.php" + "?dummy=" + new Date().getTime(), { src: this.value } );
		$("#preview").attr("src", this.value + '?dummy=' + new Date().getTime());
		parent.document.getElementById("src").value= this.value;
	});
	
	$("#alt").bind("change", function () {
		parent.document.getElementById("alt").value= this.value;
	});
	
	$("#class").bind("change", function () {
		parent.document.getElementById("class").value= this.value;
	});
	
	$("#title").bind("change", function () {
		parent.document.getElementById("title").value= this.value;
	});
	
	$("#width").keyup(function(event) {
    		parent.document.getElementById("width").value= this.value;
		if($('#constrain').is(':checked') && this.value != originalWidth){
			parent.document.getElementById("height").value= Math.round((this.value / originalWidth) * originalHeight);
			$("#height").val(Math.round((this.value / originalWidth) * originalHeight));
		}else if(this.value == originalWidth){
			parent.document.getElementById("height").value= originalHeight;
			$("#height").val(originalHeight);
		}
    	});
    	
    	$("#height").keyup(function(event) {
    		parent.document.getElementById("height").value= this.value;
		if($('#constrain').is(':checked') && this.value != originalHeight){
			parent.document.getElementById("width").value= Math.round((this.value / originalHeight) * originalWidth);
			$("#width").val(Math.round((this.value / originalHeight) * originalWidth));
		}else if(this.value == originalHeight){
			parent.document.getElementById("width").value= originalWidth;
			$("#width").val(originalWidth);
		}
    	});
    	
    	$("#width").bind("change", function () {
    		parent.document.getElementById("width").value= this.value;
		if($('#constrain').is(':checked') && this.value != originalWidth){
			parent.document.getElementById("height").value= Math.round((this.value / originalWidth) * originalHeight);
			$("#height").val(Math.round((this.value / originalWidth) * originalHeight));
		}else if(this.value == originalWidth){
			parent.document.getElementById("height").value= originalHeight;
			$("#height").val(originalHeight);
		}
    	});
    	
    	$("#height").bind("change", function () {
    		parent.document.getElementById("height").value= this.value;
		if($('#constrain').is(':checked') && this.value != originalHeight){
			parent.document.getElementById("width").value= Math.round((this.value / originalHeight) * originalWidth);
			$("#width").val(Math.round((this.value / originalHeight) * originalWidth));
		}else if(this.value == originalHeight){
			parent.document.getElementById("width").value= originalWidth;
			$("#width").val(originalWidth);
		}
    	});
    	
	$(".dimensions").keydown(function(event) {
		if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || 
			// Allow: Ctrl+A
			(event.keyCode == 65 && event.ctrlKey === true) || 
			// Allow: home, end, left, right
			(event.keyCode >= 35 && event.keyCode <= 39)) {
			// let it happen, don't do anything
			return;
		}else {
            // Ensure that it is a number and stop the keypress
			if ((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
				event.preventDefault(); 
			} 
		}
    	});
    	
	$("#do_link").bind("change", function () {
		if($(this).is(':checked')){
			$("#link_url").removeAttr('disabled'); 
			$("#target").removeAttr('disabled'); 
		}else{
			$("#link_url").attr('disabled','disabled');
			parent.document.getElementById("linkURL").value= "";
			
			$("#target").attr('disabled','disabled');
			parent.document.getElementById("target").value= "";
		}
	});
	
	$("#link_url").bind("change", function () {
		parent.document.getElementById("linkURL").value= this.value;
	});
	
	$("#target").bind("change", function () {
		parent.document.getElementById("target").value= this.value;
	});
	
	$("#float").bind("change", function () {
		parent.document.getElementById("align").value= this.value;
	});
	
	
	$("#get-recent").bind("click", function () {
		$('#recent-images').empty().append('<div id="ajax-loader-div"><img src="bootstrap/img/ajax-loader.gif" alt="Loading..." class="ajax-loader"></div>');
		$.getJSON('recent.php',{}, function(returned){ 
			if(returned.success == 1){
				$('#recent-images').empty().append(returned.html);
			}else{
				$('#recent-images').empty().append('<center>' + trans_no_images_in_recent + '</center>');
			}
		});
	});
	
	$("#refresh").bind("click", function () {
		if($(this).attr("rel") == 'searching'){
			return false;
		}
		
		$('#gallery-images').empty().append('<div id="ajax-loader-div"><img src="bootstrap/img/ajax-loader.gif" alt="Loading..." class="ajax-loader"></div>');
		$.getJSON('lib.php' + '?dummy=' + new Date().getTime(),{path: $(this).attr("rel")}, function(returned){ 
			if(returned.success == 1){
				$('#gallery-images').empty().append(returned.html);
			}else{
				$('#gallery-images').empty().append('<center>' + trans_no_images_in_folder + '</center>');
			}
		});
		
		
		
		return false;
	});
	
	$("#toggle-layout").bind("click", function () {
		if($(this).attr("rel") == 'searching'){
			return false;
		}
		
		$('#gallery-images').empty().append('<div id="ajax-loader-div"><img src="bootstrap/img/ajax-loader.gif" alt="Loading..." class="ajax-loader"></div>');
		$.getJSON('lib.php' + '?dummy=' + new Date().getTime(),{path: $(this).attr("rel"), toggle: 1}, function(returned){ 
			if(returned.success == 1){
				$('#gallery-images').empty().append(returned.html);
			}else{
				$('#gallery-images').empty().append('<center>' + trans_no_images_in_folder + '</center>');
			}
		});
		
		
		
		return false;
	});
	
	$("#get-lib").bind("click", function () {
		if(loaded == false){
			$('#gallery-images').empty().append('<div id="ajax-loader-div"><img src="bootstrap/img/ajax-loader.gif" alt="Loading..." class="ajax-loader"></div>');
			$.getJSON('lib.php' + '?dummy=' + new Date().getTime(),{}, function(returned){ 
				if(returned.success == 1){
					$('#gallery-images').empty().append(returned.html);
				}else{
					$('#gallery-images').empty().append('<center>' + trans_no_images_in_lib + '</center>');
				}
			});
			loaded = true;
		}else{
			$('#gallery-images').empty().append('<div id="ajax-loader-div"><img src="bootstrap/img/ajax-loader.gif" alt="Loading..." class="ajax-loader"></div>');
			$.getJSON('lib.php' + '?dummy=' + new Date().getTime(),{path: $("#refresh").attr("rel")}, function(returned){ 
				if(returned.success == 1){
					$('#gallery-images').empty().append(returned.html);
				}else{
					$('#gallery-images').empty().append('<center>' + trans_no_images_in_folder + '</center>');
				}
			});
		}
	});
	
	$("#uploaded-images").bind("click", function () {
		$('#uploaded-images').empty();
	});
	
	$(document).on('click', '#newfolder_btn', function () {
		if($('#newfolder_name').val() == ""){
			alert(trans_please_provide_name_for_new_folder);
			return false;
		}
		
		$('#new-folder-msg').empty().append(trans_creating + '...&nbsp;&nbsp;&nbsp;');
		
		$.getJSON('new_folder.php' + '?dummy=' + new Date().getTime(),{path: $("#refresh").attr("rel"), folder: $('#newfolder_name').val()}, function(returned){ 
			if(returned.success == 1){
				$('#newfolder_name').val("");
				$('#gallery-images').empty().append(returned.html);
				$('#new-folder-msg').empty().append('<span style="color: green;">' + trans_done + '...&nbsp;&nbsp;&nbsp;</span>');
				setTimeout(function(){ $('#new-folder-msg').empty() }, 5000);
			}else{
				$('#new-folder-msg').empty().append('<span style="color: red;">' + trans_error + '...&nbsp;&nbsp;&nbsp;</span>');
				setTimeout(function(){ $('#new-folder-msg').empty() }, 5000);
				if(returned.msg != ""){
					alert(returned.msg);
				}
			}
		});
		
		
		
		return false;
	});
	
	$(document).on('click', 'a.delete-file', function () {
		var content = $(this).parent().parent().html();
		var the_parent = $(this).parent().parent();
		var r=confirm(trans_are_you_sure_file);
		if(r==false){
			return false;
		}
		$(this).parent().parent().empty().append('<p>Deleting...</p>');
		$.getJSON('delete_file.php' + '?dummy=' + new Date().getTime(),{path: $(this).data("path"),file: $(this).attr("rel")}, function(returned){ 
			if(returned.success == 1){
				$('#gallery-images').empty().append(returned.html);
			}else{
				the_parent.empty();
				the_parent.html(content);
				if(returned.msg != ""){
					alert(returned.msg);
				}
			}
		});
		return false;
	});
	
	$(document).on('click', 'a.delete-folder', function () {
		var content = $(this).parent().parent().html();
		var the_parent = $(this).parent().parent();
		var r=confirm(trans_are_you_sure_folder);
		if(r==false){
			return false;
		}
		$(this).parent().parent().empty().append('<p>' + trans_deleting + '...</p>');
		$.getJSON('delete_folder.php' + '?dummy=' + new Date().getTime(),{path: $("#refresh").attr("rel"),folder: $(this).attr("rel")}, function(returned){ 
			if(returned.success == 1){
				$('#gallery-images').empty().append(returned.html);
			}else{
				the_parent.empty();
				the_parent.html(content);
				if(returned.msg != ""){
					alert(returned.msg);
				}
			}
		});
		return false;
	});
	
	
	$(document).on('click', 'a.change-folder', function () {
		var current_value = $(this).attr("rel");
		var content = $(this).parent().parent().html();
		var the_parent = $(this).parent().parent();
		var r=prompt(trans_please_enter_new_name,current_value);
		if(r==null || r==""){
			return false;
		}
		
		if(r==current_value){
			return false;
		}
		
		$(this).parent().parent().empty().append('<p>' + trans_saving + '...</p>');
		
		
		$.getJSON('rename_folder.php' + '?dummy=' + new Date().getTime(),{path: $("#refresh").attr("rel"),new_name: r,current_name: current_value}, function(returned){ 
			if(returned.success == 1){
				$('#gallery-images').empty().append(returned.html);
			}else{
				the_parent.empty();
				the_parent.html(content);
				if(returned.msg != ""){
					alert(returned.msg);
				}
			}
		});
		return false;
	});
	
	function getExtension(filename) {
		return filename.split('.').pop().toLowerCase();
	}
	
	$(document).on('click', 'a.change-file', function () {
		var current_value = $(this).attr("rel");
		var content = $(this).parent().parent().html();
		var the_parent = $(this).parent().parent();
		var extension = getExtension(current_value);
		var current_file_name = current_value.substr(0, current_value.lastIndexOf('.')) || current_value;
		
		var r=prompt(trans_please_enter_new_name,current_file_name);
		if(r==null || r==""){
			return false;
		}
		
		if((r + "." + extension) ==current_value){
			return false;
		}
		
		$(this).parent().parent().empty().append('<p>' + trans_saving + '...</p>');
		
		$.getJSON('rename_file.php' + '?dummy=' + new Date().getTime(),{path: $("#refresh").attr("rel"),new_name: (r + "." + extension),current_name: current_value}, function(returned){ 
			if(returned.success == 1){
				$('#gallery-images').empty().append(returned.html);
			}else{
				the_parent.empty();
				the_parent.html(content);
				if(returned.msg != ""){
					alert(returned.msg);
				}
			}
		});
		return false;
	});
	
	$(document).on('click', '#refresh-dirs', function () {
		$('#select-dir-msg').empty().append(trans_loading + '...&nbsp;&nbsp;&nbsp;');
		
		$.getJSON('refresh_dir_list.php' + '?dummy=' + new Date().getTime(),{}, function(returned){ 
			if(returned.success == 1){
				$('#select-dir-msg').empty().append('<span style="color: green;">Done...&nbsp;&nbsp;&nbsp;</span>');
				setTimeout(function(){ $('#select-dir-msg').empty() }, 5000);
				$('#select-dir').empty().append(returned.html);
			}
		});
		return false;
	});
	
	$(document).on('change', '#select-dir', function () {
		$('#select-dir-msg').empty().append(trans_sending + '...&nbsp;&nbsp;&nbsp;');
		
		$.getJSON('set_upload_directory.php' + '?dummy=' + new Date().getTime(),{path:$(this).val() }, function(returned){ 
			if(returned.success == 1){
				$('#select-dir-msg').empty().append('<span style="color: green;">Done...&nbsp;&nbsp;&nbsp;</span>');
				setTimeout(function(){ $('#select-dir-msg').empty() }, 5000);
			}
		});
		return false;
	});
	
	$(document).on('click', 'a.lib-folder', function () {
		var str =  decodeURIComponent($(this).attr("rel"));
			
		var stringArray = str.split("/");
			
		stringArray.pop();
			
			
		var current_folder = stringArray[stringArray.length-1];
		if((current_folder + "/") == lib_folder_path){
			current_folder = "Home";
		}
		$('#lib-title').empty().append(current_folder);
		
		$("#refresh").attr("rel", $(this).attr("rel"));
		
		if($("#lib-back").is(":disabled")){
			$("#lib-back").removeAttr('disabled'); 
			
		}else{
			stringArray.pop();
			
			$("#lib-back").attr('rel', stringArray.join("/") + "/");
			
			
			
		}
		$('#gallery-images').empty().append('<div id="ajax-loader-div"><img src="bootstrap/img/ajax-loader.gif" alt="Loading..." class="ajax-loader"></div>');
		$.getJSON('lib.php' + '?dummy=' + new Date().getTime(),{path: $(this).attr("rel")}, function(returned){ 
			if(returned.success == 1){
				$('#gallery-images').empty().append(returned.html);
			}else{
				$('#gallery-images').empty().append('<center>' + trans_no_images_in_folder + '</center>');
			}
		});
		
		
		
		return false;
	});
	
	$(document).on('click', 'a.page-link', function () {
		$('#gallery-images').empty();
		$('#gallery-images').append('<div id="ajax-loader-div"><img src="bootstrap/img/ajax-loader.gif" alt="Loading..." class="ajax-loader"></div>');
		$.getJSON('lib.php' + '?dummy=' + new Date().getTime(),{path: $(this).data("path"),page: $(this).data("page")}, function(returned){ 
			if(returned.success == 1){
				$('#gallery-images').empty().append(returned.html);
			}else{
				$('#gallery-images').empty().append('<center>' + trans_no_images_in_folder + '</center>');
			}
		});
		
		return false;
	});
	
	$(document).on('click', 'button#lib-back', function () {
		if($(this).is(":disabled")){
			return false;
		}
		
		if($(this).attr("rel") == lib_folder_path){
			$(this).attr('disabled','disabled');
		}
		
		$("#refresh").attr("rel", $(this).attr("rel"));
		
		$('#gallery-images').empty().append('<div id="ajax-loader-div"><img src="bootstrap/img/ajax-loader.gif" alt="Loading..." class="ajax-loader"></div>');
		$.getJSON('lib.php' + '?dummy=' + new Date().getTime(),{path: $(this).attr("rel")}, function(returned){ 
			if(returned.success == 1){
				$('#gallery-images').empty().append(returned.html);
			}else{
				$('#gallery-images').empty().append('<center>' + trans_no_images_in_folder + '</center>');
			}
		});
		
		var str =  $(this).attr("rel");
		var stringArray = str.split("/");
		
		stringArray.pop();
		
		var current_folder = stringArray.pop();
		
		if((current_folder + "/") == lib_folder_path){
			current_folder = "Home";
			$(this).attr("rel", lib_folder_path);
		}else{
			$(this).attr("rel", stringArray.join("/") + "/");
		}
		
		$('#lib-title').empty().append(current_folder);
		
		return false;
	});
});