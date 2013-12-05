<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
			<title>jQuery Sorting And Inline Edit</title>
			<link type="text/css" href="css/site.styles.css" rel="stylesheet" media="screen" />
		</head>
		<body>
			<div id="sortabledata"></div>
		</body>
		<script language="javascript" type="text/javascript" src="js/jquery.js"></script>
		<script language="javascript" type="text/javascript" src="js/jquery_plugin_functions.js"></script>
		<script language="javascript" type="text/javascript">
			jQuery(document).ready(function(){
				sortableHeadersWithPaging('1','id','ASC','');
			})
		</script>
	</html>