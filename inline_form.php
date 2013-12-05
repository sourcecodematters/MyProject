<?php
	@$LineId 		= $_REQUEST["LineId"];
	@$PageNo 		= $_REQUEST["PageNo"];
	@$CountryName 	= $_REQUEST["CountryName"];
	@$SmallName 	= $_REQUEST["SmallName"];
	@$FieldName 	= $_REQUEST["FieldName"];
	@$Order 		= $_REQUEST["Order"];
	@$searchtxt		= $_REQUEST["searchtxt"];
?>
<tr class="edit_bg_color">
	<td width="10%" style="cursor:pointer;" align="center"><?php echo $LineId; ?></td>
	<td width="51%" id="txt_c_name_<?php echo $LineId; ?>" style="cursor:pointer;"><input type="text" name="c_name_<?php echo $LineId; ?>" id="c_name_<?php echo $LineId; ?>" value="<?php echo $CountryName; ?>" size="40" maxlength="50" /></td>
	<td width="20%" id="txt_s_name_<?php echo $LineId; ?>" style="cursor:pointer;" align="center"><input type="text" name="s_name_<?php echo $LineId; ?>" id="s_name_<?php echo $LineId; ?>" value="<?php echo $SmallName; ?>" size="5" maxlength="2" /></td>
	<td width="19%">
		<a href="javascript:;" onClick="updateCountryDetails('<?php echo $LineId; ?>',document.getElementById('c_name_'+'<?php echo $LineId; ?>').value,document.getElementById('s_name_'+'<?php echo $LineId; ?>').value,'<?php echo $PageNo; ?>','<?php echo $FieldName; ?>','<?php echo $Order; ?>','<?php echo $searchtxt; ?>');">Save</a>
		&nbsp;
		<a href="javascript:;" onClick="cancelButton('<?php echo $LineId; ?>','<?php echo $PageNo; ?>','<?php echo $FieldName; ?>','<?php echo $Order; ?>','<?php echo $CountryName; ?>','<?php echo $SmallName; ?>','<?php echo $searchtxt; ?>');">Cancel</a>
	</td>
</tr>
