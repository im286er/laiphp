<!doctype html>
<html>
<head>
	<meta charset="UTF-8" />
	<title>调试页面</title>
	<style type="text/css">
	   *{
	       margin:0px;
	       padding: 0px;
	    }
        body {
            margin: 20px;
        }
        #debug{
            width:880px;
            border:solid 1px #dcdcdc;
            margin-top: 20px;
            padding: 10px;
        }
        fieldset {
            padding:10px;
        }
        legend {
            padding: 5px;
        }
	</style>
</head>
<body>
	<div id="debug">
		<h2>DEBUG</h2>
		<?php if(isset($err['message'])){?>
		<fieldset>
			<legend>ERROR</legend>
			<?php echo $err['message']?>
		</fieldset>
		<?php } ?>
		
		<?php if(isset($err['info'])){?>
		<fieldset>
			<legend>TRACE</legend>
			<?php echo $err['info']?>
		</fieldset>
		<?php } ?>
	</div>
</body>
</html>