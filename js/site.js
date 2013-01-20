var app = {};
app.id = -1;
app.merge_fields = [];
var delete_keys = [];
app.add_name = function(thename){
	var random_id = Math.round(Math.random() * 1000);
	var id = $("#base_id").val();
	var preview_jpg = "<a href='/app/finished_invitation/" + id+ "/" + thename + "/jpg/'>(P:J)</a>";
	var preview_html = "<a href='/app/finished_invitation/" + id + "/" + thename + "/html/'>(P:H)</a>";
	var row_id = "element" + random_id;
	$("#names_table").append("<tr class='name_element' id='" + row_id + "'><td>" + thename + "</td><td>" + preview_html + " " + preview_jpg + " <a class='remove close' id='remove_" + random_id + "'>x</a></td></tr>");
	$.post("/app/add_name/" + id + "/" + thename,{},function(return_value){
		alert(return_value);
		delete_keys.push([row_id.substr(7),return_value]);
	});
}
app.delete_name = function(row_id){
	$("#" + row_id).remove();
	var delete_id = "";
	$.each(delete_keys,function(index,row){
		if(row[0] == row_id){
			delete_id = row[1];
		}
	});
	if(delete_id === ""){
		delete_id = row_id;
	}
	var id = $("#base_id").val();
	$.post("/app/delete_name/" + delete_id + "/" + id,{},function(return_value){
	});
	//alert(delete_id);
};
$(function(){
	//user has clicked to remove a name row
	$(".remove").live('click',function(){
	var id = $(this).attr('id').substr(7);
	app.delete_name(id);
	$("#element" + id).remove();
	return false;
	});
	//user has clicked to preview a name row
	$(".name_element").live('click',function(){
		
	});
	//events

		//invitation browse
		$(".invitation_thumb_shell").live('click',function(){
			var url = $(this).attr('data-invitation-url');
			window.location = url;
		});
})
app.clean_user_input_for_id = function(user_input){
	user_input = user_input.replace(":","_");
	user_input = user_input.replace(" ","_");
	return user_input;
}
app.encode_fields_entered = function(){
	var field_defaults = [];
	$(".input").each(function(index,field){
		var original_id = app.get_replace_key($(this).attr('id').substr(6));
		field_defaults.push([original_id,$(this).val()]);

	});
	return field_defaults;
}
/*app.save_user_template = function(){
	if(app.id ==-1){
		return false;
	}
	else{
		$.post("/app/save_personalised_invitation/" + app.id,
		{"fields":app.encode_fields_entered(),
		"invitation_html":$("#invitation_preview_base").html(),
		"08nj43g95u4ngrth":$("#08nj43g95u4ngrth").val()},
		function(data){
		alert(data);
			//window.location ="/app/personalised_invitation/" + app.id;
		})
	}
}
app.get_new_id = function(callback){
	var base_id = -1;
	base_id = $("#base_id").val();
	$.get("/app/get_personalised_id/" + base_id,function(id){
		app.id = id;
		if(typeof(callback) == "function"){
			callback();
		}
	})
}*/
app.merge_preview = function (){
	var debug = true;
	var invitation_html = $("#invitation_html").val();
	$(".invitation").html(invitation_html);
	app.merge_fields = [];
	for(i =0;i < invitation_html.length; i++){
		if(invitation_html[i] == "{"){
			var var_start = i;
			while(invitation_html[i] != "}" && i < invitation_html.length){
				i++;
			}
			var var_end = i;
			var merge_field = invitation_html.substr(var_start+1,var_end - var_start-1);
			debug && console.log("Field found: " + merge_field);
			app.merge_fields.push([merge_field,app.clean_user_input_for_id(merge_field)]);
		}
	}

	//remove input text fields that no longer exist in the template.
	$(".merge_field_input").each(function(index,field){
		var field_pair;
		var field_exists = false;
		for(field_index in app.merge_fields){
			if(app.merge_fields[field_index][1] == $(this).attr('id')){
				field_exists = true;
				break;
			}
		}
		if(!field_exists){
			console.log("removing " + $(this).attr('id'));
			$(this).remove();
		}
		
	});
	//make sure input text fields exist for all merge fields.
	$.each(app.merge_fields,function(index,field_pair){
		field = field_pair[1];
		debug && console.log(field);;
		if($("#" + field).length ==0){
			debug && console.log("adding " +field);
			var new_field_template = $(".field_template").clone();
			var wrapper = new_field_template.children(".control-group");
			wrapper.attr('id',field);
			//alert(field);
			wrapper.addClass('merge_field_input');
			var new_label  =wrapper.children("label");
			new_label.attr('for',field);
			new_label.text(field);
			var new_field = wrapper.children(".controls").children("input");
			new_field.attr('id',"input_" + field);
			new_field.attr('name',"input_" + field);
			new_field.addClass('input');
			$(".variable_fields").append(new_field_template.html());
		}
	});
};
app.get_replace_key = function(value){
		for(field_index in app.merge_fields){
			if(app.merge_fields[field_index][1] == value){
				return app.merge_fields[field_index][0] 
			}
		}
}
app.merge_preview_template = function(){
	var debug = true;
	var invitation_base_html = $("#invitation_preview_base").html();
	//get the value of each input field and merge into text.
	$(".user_template_input").each(function(index,field){
		var replace_name = $(this).attr('id').substr(6);
		replace_name = app.get_replace_key(replace_name);
		var replace_value = $(this).val();
		debug && console.log("Replace name:" + replace_name + " with " + replace_value);
		invitation_base_html = invitation_base_html.replace("{" + replace_name + "}",replace_value);

	});
	$("#invitation_preview_merged").html("");
	$("#invitation_preview_merged").html(invitation_base_html);
}