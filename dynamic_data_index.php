<?php	session_start();
		$conn = mysql_connect("localhost","root","") or die("Unable to connect database");
		mysql_select_db("test",$conn) or die("Unable to select database");
		//=================================================================================================================
		@$Action = $_REQUEST["Action"];
		$qryStr = '';
		//=================================================================================================================
		//=====		Paging REQUEST variable operations														   	Code Starts
		$PageNo =(! empty($_REQUEST["PageNo"])) ? intval($_REQUEST["PageNo"]) : 1;
		if($PageNo > $_SESSION["ToTaLpAgEs"]) { $PageNo = $_SESSION["ToTaLpAgEs"]; }
		$per_page = 20;
		$startLimit = (($PageNo-1) * $per_page);
		if($startLimit < 0 ) { $startLimit = 0;	}
		//=====		Paging REQUEST variable operations														   	Code Ends
		//=================================================================================================================
		//=====		Header Sortable REQUEST variable operations													Code Starts
		@$FieldName = (isset($_REQUEST["FieldName"])) ? $_REQUEST["FieldName"] : "id";
		@$Order 	= (isset($_REQUEST["Order"])) 	  ? $_REQUEST["Order"] : "ASC";
		//=====		Header Sortable REQUEST variable operations													Code Ends
		//=================================================================================================================
		//=====		Edit Action Procedure																		Code Starts
		if(isset($Action) && $Action == "Edit") {
			$Id = $_REQUEST["Id"];
			$CountryName = $_REQUEST["CountryName"];
			$Smallname = $_REQUEST["Smallname"];
			$updSql = "UPDATE `country` SET `name`='".$CountryName."', `smallname`='".$Smallname."' WHERE `id`='".$Id."'";
			//echo $updSql; exit;
			$rset = mysql_query($updSql);
			if(!$rset) { 
				echo "Unable to update country details"; 
				exit;
			} else {
				echo "Success";
				exit;
			}
		}
		//=====		Edit Action Procedure																		Code Ends
		//=================================================================================================================
		//=====		Add Action Procedure																		Code Starts
		if(isset($Action) && $Action == "Add") {
			$cName = addslashes($_REQUEST["cName"]);
			$sName = addslashes($_REQUEST["sName"]);
			$insSql = "INSERT INTO `country` SET `name`='".$cName."', `smallname`='".$sName."'";
			//echo $insSql; exit;
			$rset = mysql_query($insSql);
			if(!$rset) { 
				echo "Unable to insert country details"; 
				exit;
			} else {
				echo "Success";
				exit;
			}
		}
		//=====		Add Action Procedure																		Code Ends
		//=================================================================================================================
		//=====		Delete Action Procedure																		Code Starts
		if(isset($Action) && $Action == "Delete") {
			$cId = $_REQUEST["cId"];
			$delSql = "DELETE FROM `country` WHERE `id` = '".$cId."'";
			//echo $delSql; exit;
			$rset = mysql_query($delSql);
			if(!$rset) { 
				echo "Unable to delete country details"; 
				exit;
			} else {
				echo "Success";
				exit;
			}
		}
		//=====		Delete Action Procedure																		Code Ends
		//=================================================================================================================
		$searchtxt = $_REQUEST["searchtxt"];
		if(isset($searchtxt) && $searchtxt <> "") { 
			$qryStr = "AND name LIKE '%".$searchtxt."%'";
		}
		$sql = "SELECT SQL_CALC_FOUND_ROWS * FROM `country` WHERE 1=1 ".$qryStr." ORDER BY ".$FieldName." ".$Order." LIMIT $startLimit, $per_page";
		$rs  = mysql_query($sql) or die("Unable to execute query");
		$cnt = mysql_affected_rows();
		//=================================================================================================================
?>
<script language="javascript" type="text/javascript">
	jQuery(document).ready(function(){
		var sortingOperator = "";
		jQuery("#id").click(function(){
			jQuery("#FieldName").val("id");
			if(jQuery("#Order").val() == "ASC") {
				jQuery("#Order").val("DESC");
			} else {
				jQuery("#Order").val("ASC");
			}
			var sortingOperator = sortableHeadersWithPaging('<?php echo $PageNo; ?>',jQuery("#FieldName").val(),jQuery("#Order").val(),'<?php echo $searchtxt; ?>');
		})
		jQuery("#name").click(function(){
			jQuery("#FieldName").val("name");
			if(jQuery("#Order").val() == "ASC") { 
				jQuery("#Order").val("DESC");
			} else {
				jQuery("#Order").val("ASC");
			}
			var sortingOperator = sortableHeadersWithPaging('<?php echo $PageNo; ?>',jQuery("#FieldName").val(),jQuery("#Order").val(),'<?php echo $searchtxt; ?>');
		})
		jQuery("#smallname").click(function(){
			jQuery("#FieldName").val("smallname");
			if(jQuery("#Order").val() == "ASC") { 
				jQuery("#Order").val("DESC");
			} else {
				jQuery("#Order").val("ASC");
			}
			var sortingOperator = sortableHeadersWithPaging('<?php echo $PageNo; ?>',jQuery("#FieldName").val(),jQuery("#Order").val(),'<?php echo $searchtxt; ?>');
		})
		jQuery(".search_button_class").click(function(){
			var searchvalue = jQuery("#searchtxt").val();
			var sortingOperator = sortableHeadersWithPaging('<?php echo $PageNo; ?>','<?php echo $FieldName; ?>','<?php echo $Order; ?>',searchvalue);
		})
	})
</script>
<table border="0" cellpadding="0" cellspacing="0" width="70%" align="center">
	<tr>
		<td style="font-size:18px;">jQuery Sorting &amp; Inline Edit Record</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td class="search_border_class">
			<table border="0" cellpadding="5" cellspacing="5" width="80%" align="center">
				<tr>
					<td width="33%" align="right">Search By Country Name</td>
					<td width="6%" align="center"> : </td>
			  	  <td width="47%"><input type="text" name="searchtxt" id="searchtxt" value="<?php echo $searchtxt; ?>" size="35" /></td>
			  	  <td width="14%" align="center"><input type="button" name="Search" id="Search" value="" class="search_button_class" /></td>
				</tr>	
			</table>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td align="right" height="20" style="padding-right:1px;"><a href="#dialog1" name="modal" class="add_rec_link_class">Add New Country</a></td>
	</tr>
	<tr>
		<td>
			<input type="hidden" name="FieldName" id="FieldName" value="<?php echo $FieldName; ?>" />
			<input type="hidden" name="Order" id="Order" value="<?php echo $Order; ?>" />
			<input type="hidden" name="EditingProcess" id="EditingProcess" value="0" />
				<table border="0" cellpadding="3" cellspacing="1" width="100%" align="center">
					<tr>
						<td width="100%" height="1" align="center" colspan="4" id="ActionMessage" style="font-size:12px; font-weight:bold; color:#009933;"></td>
					</tr>
					<?php if($cnt > 0) { ?>
					<tr style="background:#333333; color:#FFFFFF;">
						<td width="10%" class="header_class" style="cursor:pointer;" id="id" align="center">
							<table border="0" cellpadding="0" cellspacing="0" width="100%">
								<tr>
									<td align="right" width="65%">ID</td>
									<td align="right" width="35%" id="IDOrderImage"></td>
								</tr>	
							</table>
						</td>
						<td width="51%" class="header_class" style="cursor:pointer;" id="name">
							<table border="0" cellpadding="0" cellspacing="0" width="100%">
								<tr>
									<td align="left" width="50%">Country Name</td>
									<td align="right" width="50%" id="CountryNameOrderImage"></td>
								</tr>	
							</table>
						</td>
						<td width="20%" class="header_class" style="cursor:pointer;" id="smallname" align="center">
							<table border="0" cellpadding="0" cellspacing="0" width="100%">
								<tr>
									<td align="right" width="80%">Short Name</td>
									<td align="right" width="20%" id="ShortNameOrderImage"></td>
								</tr>	
							</table>
						</td>
						<td width="19%" class="header_class">Options</td>
					</tr>
					<?php $i=0;	while($row = mysql_fetch_assoc($rs)){	?>
					<tbody id="showForm_<?php echo $row["id"];?>" >
						<tr bgcolor="<?php if($i%2==0){ echo "#F3F2F2";} else { echo "#EAEAEA";}?>">
							<td align="center"><?php echo stripslashes($row["id"]);?></td>
							<td id="name_<?php echo $row["id"];?>"><?php echo stripslashes($row["name"]);?></td>
							<td id="smallname_<?php echo $row["id"];?>" align="center"><?php echo stripslashes($row["smallname"]);?></td>
							<td id="options_<?php echo $row["id"];?>">
								<a href="javascript:;" onclick="showInlineForm('<?php echo $row["id"];?>',
																			   '<?php echo $PageNo; ?>',
																			   '<?php echo stripslashes($row["name"]);?>',
																			   '<?php echo stripslashes($row["smallname"]);?>',
																			   '<?php echo $FieldName; ?>',
																			   '<?php echo $Order; ?>',
																			   '<?php echo $searchtxt; ?>');">Edit</a>
								&nbsp;&nbsp;
								<a href="javascript:;" onclick="deleteCountry('<?php echo $row["id"];?>',
																			  '<?php echo $PageNo; ?>',
																			  '<?php echo $FieldName; ?>',
																			  '<?php echo $Order; ?>',
																			  '<?php echo $searchtxt; ?>',
																			  'Are you sure you want to delete this country details?');">Delete</a>
							</td>
						</tr>
					</tbody>	
					<?php	$i++; }	?>
					<tr>
						<td colspan="4" >
							<div style="display:block; border:0px solid red; text-align:center">
								<div style="display:block; margin-left:auto; margin-right:auto; border:0px solid blue; width:270px">
									<?php
										/*
										 * Paging - HTML for paging form
										 */
										$s = mysql_query("SELECT FOUND_ROWS() as rows") or die("Unable to found rows");
										$r = mysql_fetch_assoc($s);
										$cnt = $r["rows"];
										$paging_html = ""; 
										$total_pages = 1;
										$StartRow =0;
										$item_count = (!empty($cnt)) ? intval($cnt) : 0;
										$per_page = 20;
										$PageNo = (!empty($_REQUEST["PageNo"])) ? intval($_REQUEST["PageNo"]) :  1;
										if($PageNo <=0) {$PageNo =1;}
										if(empty($PageNo)) 		{$PageNo=1; $StartRow = (($PageNo-1) * $per_page);}
										if($item_count > $per_page)	{	$total_pages = intval(ceil($item_count/$per_page)); $_SESSION["ToTaLpAgEs"] = $total_pages;	}
										if($PageNo > $total_pages) { $PageNo = $total_pages; }
										if($total_pages < 1){}
										else{
											$paging_html .= '<ul class="paging" style="display:inline;" >';
											 if($PageNo>1) { 
												$PrevPageNo = $PageNo -1; 
												$paging_html .= '<li><a href="javascript:;" onClick="sortableHeadersWithPaging('.$PrevPageNo.',\''.$FieldName.'\',\''.$Order.'\',\''.$searchtxt.'\')">Previous</a></li>';
											 }		
											if($PageNo<=10) {
												for($i=1;$i<=$total_pages,$i<=10;$i++) {
													if($i>10 || $i>$total_pages)
														break;
													if($PageNo==$i) {
														$paging_html .= '<li><a class="paging_active_page_class" href="#">'.$i.'</a></li>';
													} else { 
														$paging_html .= '<li><a href="javascript:;" onClick="sortableHeadersWithPaging('.$i.',\''.$FieldName.'\',\''.$Order.'\',\''.$searchtxt.'\')">'.$i.'</a></li>';
													}
												} 
											} else {
												$temp=$PageNo-($PageNo%10);
												if($PageNo%10==0){	$temp=$PageNo-9;	}
												else {	$temp=$temp+1;	}
												if($temp+9>$total_pages){	$temp1=$total_pages; }
												else{	$temp1=$temp+9; }
													
												for($i=$temp;$i<=$temp1;$i++) {
													if($i>$total_pages)
														break;
													if($PageNo==$i) {
														$paging_html .= '<li><a class="paging_active_page_class" href="#">'.$i.'</a></li>';
													} else {
														$paging_html .= '<li><a href="javascript:;" onClick="sortableHeadersWithPaging('.$i.',\''.$FieldName.'\',\''.$Order.'\',\''.$searchtxt.'\')">'.$i.'</a></li>';
													} 
												} 
											} 
						
											if($PageNo<$total_pages) {
												$NextPageNo = $PageNo + 1; 
												$paging_html .= '<li><a href="javascript:;" onClick="sortableHeadersWithPaging('.$NextPageNo.',\''.$FieldName.'\',\''.$Order.'\',\''.$searchtxt.'\')">Next</a></li>';
											}
											$paging_html .= '</ul></form>';
										}
										echo $paging_html;
									?>
								</div>
							</div>
						</td>
					</tr>
					<?php	
						} else {
					?>
					<tr>
						<td width="100%" align="center" colspan="4">Records Not Found...!!</td>
					</tr>
					<?php	}	?>
				</table>
		</td>
	</tr>
</table>
<script language="javascript" type="text/javascript" src="js/jquery_popup.js"></script>
<div id="boxes">
	<div id="dialog1" class="window modalBorderClass">
		<p align="right"><a class="close" href="#" style="color:#000;text-decoration:underline;">Click Here</a> to close</p>
		<h2 style="border-bottom:1px dashed #521908;">Add New Country</h2>
		<form name="AddForm" id="AddForm" method="post">
			<table border="0" cellpadding="3" cellspacing="3" width="100%">
				<tr>
					<td align="right">Country Name</td>
					<td align="center"> : </td>
					<td><input type="text" name="cname" id="cname" value="" maxlength="50" /></td>
				</tr>
				<tr>
					<td align="right">Small Name</td>
					<td align="center"> : </td>
					<td><input type="text" name="sname" id="sname" value="" maxlength="2" /></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td><input type="button" name="SubmitButtn" id="SubmitButtn" value="Add" onclick="addNewCountry(document.getElementById('cname').value,document.getElementById('sname').value);" /></td>
				</tr>
			</table>
		</form>	
	</div>
	<div id="mask"></div>
</div>