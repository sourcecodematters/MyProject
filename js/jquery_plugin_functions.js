// JavaScript Document
//======================================================================================================================
function showInlineForm(LineId,PageNo,CountryName,SmallName,FieldName,Order,searchtxt){
	jQuery.ajax({
		type: "POST",
		url: "inline_form.php",
		data: "LineId=" + LineId + "&PageNo=" + PageNo + "&CountryName=" + CountryName + "&SmallName=" + SmallName + "&FieldName=" + FieldName + "&Order=" + Order + "&searchtxt=" + searchtxt,
		async: false,
		success:function(text){
			response = text;
			jQuery("#showForm_"+LineId).html(response);
			jQuery("#EditingProcess").val("1");
		}
	});
}
//======================================================================================================================
function cancelButton(LineId,PageNo,FieldName,Order,CountryName,SmallName,searchtxt){
	jQuery("#EditingProcess").val("0");
	/*jQuery("#txt_c_name_"+LineId).html(CountryName);
	jQuery("#txt_s_name_"+LineId).html(SmallName);
	jQuery("#showForm_"+LineId).removeClass("edit_bg_color");*/
	sortableHeadersWithPaging(PageNo,FieldName,Order,searchtxt)
}
//======================================================================================================================
function sortableHeadersWithPaging(PageNo,FieldName,Order,searchtxt){
	if(jQuery("#EditingProcess").val() == 1) { 
		alert("Editing Process is continue, So currently you can not sort data");
		return false;
	}
	jQuery.ajax({
		type: "POST",
		url: "dynamic_data_index.php",
		data: "PageNo=" + PageNo + "&FieldName=" + FieldName + "&Order=" + Order + "&searchtxt=" + searchtxt,
		async: false,
		success:function(text){
			
			response = text;
			jQuery("div#sortabledata").html(response);
			
			//==========================================================================================================
			if(FieldName == "id" && Order == "DESC") { 
				jQuery("#IDOrderImage").addClass("descOrderClass");
			} else if(FieldName == "id" && Order == "ASC") {
				jQuery("#IDOrderImage").addClass("ascOrderClass");
				jQuery("#CountryNameOrderImage").removeClass("ascOrderClass");
				jQuery("#CountryNameOrderImage").removeClass("descOrderClass");
				jQuery("#ShortNameOrderImage").removeClass("ascOrderClass");
				jQuery("#ShortNameOrderImage").removeClass("descOrderClass");
				
			}
			if(FieldName == "name" && Order == "DESC") { 
				jQuery("#CountryNameOrderImage").addClass("descOrderClass");
			} else if(FieldName == "name" && Order == "ASC") {
				jQuery("#CountryNameOrderImage").addClass("ascOrderClass");
				jQuery("#IDOrderImage").removeClass("ascOrderClass");
				jQuery("#IDOrderImage").removeClass("descOrderClass");
				jQuery("#ShortNameOrderImage").removeClass("ascOrderClass");
				jQuery("#ShortNameOrderImage").removeClass("descOrderClass");
			}
			if(FieldName == "smallname" && Order == "DESC") { 
				jQuery("#ShortNameOrderImage").addClass("descOrderClass");
			} else if(FieldName == "smallname" && Order == "ASC") {
				jQuery("#ShortNameOrderImage").addClass("ascOrderClass");
				jQuery("#CountryNameOrderImage").removeClass("ascOrderClass");
				jQuery("#CountryNameOrderImage").removeClass("descOrderClass");
				jQuery("#IDOrderImage").removeClass("ascOrderClass");
				jQuery("#IDOrderImage").removeClass("descOrderClass");
			}
			//==========================================================================================================
		}
	});
}
//======================================================================================================================
function updateCountryDetails(Id,CountryName,Smallname,PageNo,FieldName,Order,searchtxt){
	if(document.getElementById("c_name_"+Id).value == "") {
		alert("Please enter country name");
		document.getElementById("c_name_"+Id).focus();
		return false;
	}
	if(document.getElementById("s_name_"+Id).value == "") {
		alert("Please enter abbreviated country name");
		document.getElementById("s_name_"+Id).focus();
		return false;
	}
	jQuery.ajax({
		type: "POST",
		url: "dynamic_data_index.php",
		data: "Id=" + Id + "&CountryName=" + CountryName + "&Smallname=" + Smallname + "&Action=Edit",
		async: false,
		success:function(text){
			response = text;
			if(response == "Success") {
				jQuery("#EditingProcess").val("0");
				sortableHeadersWithPaging(PageNo,FieldName,Order,searchtxt)
				jQuery("#ActionMessage").html("Country Details Edited Successfully");
			} else {
				alert(response);
			}
		}
	});
}
//======================================================================================================================
function addNewCountry(cName,sName){
	if(cName == "") {
		alert("Please enter country name");
		document.getElementById("cname").focus();
		return false;
	}
	if(sName == "") {
		alert("Please enter abbreviated country name");
		document.getElementById("sname").focus();
		return false;
	}
	jQuery.ajax({
		type: "POST",
		url: "dynamic_data_index.php",
		data: "cName=" + cName + "&sName=" + sName + "&Action=Add",
		async: false,
		success:function(text){
			response = text;
			if(response == "Success") { 
				sortableHeadersWithPaging('1','id','DESC','');
				jQuery("#ActionMessage").html("Country Details Added Successfully");
			} else {
				alert(response);
			}
		}
	});
}
//======================================================================================================================
function deleteCountry(cId,PageNo,FieldName,Order,searchtxt,msg){
	if (confirm(msg)){
		jQuery.ajax({
			type: "POST",
			url: "dynamic_data_index.php",
			data: "cId=" + cId + "&Action=Delete",
			async: false,
			success:function(text){
				response = text;
				if(response == "Success") { 
					sortableHeadersWithPaging(PageNo,FieldName,Order,searchtxt);
					jQuery("#ActionMessage").html("Country Details Deleted Successfully");
				} else {
					alert(response);
				}
			}
		});
	}
}
//======================================================================================================================