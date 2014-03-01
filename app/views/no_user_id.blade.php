<!doctype html>
<html>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

	<head>
		<script src="jQuery/jquery-1.10.2.js"></script>
  		<script src="jQuery/jquery-ui-1.10.4.custom/js/jquery-ui-1.10.4.custom.js"></script>
  		<link rel="stylesheet" href="jQuery/jquery-ui-1.10.4.custom/css/mokjang-theme/jquery-ui-1.10.4.custom.css">
  		<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Droid+Sans">
  		<script type="text/javascript">
  			$(document).ready(function() {
  				$( '#submit-button' )
  					.button()
  					.click(function() {
  						$( '#login-form').submit();
  					});
  			});
  		</script>
  	</head>
  	<style>
  		#error-box {
  			font-family: Droid Sans;
  			font-size:100%;
  			border: 1px solid #CCCCCC;
  			-moz-box-shadow: 5px 5px 5px #888;
			-webkit-box-shadow: 5px 5px 5px #888;
			box-shadow: 5px 5px 5px #888;
	  		background: #fff;
  			width: 270px;
  			position: relative;
  			left: 50%;
  			margin-left: -150px;
  			padding: 20px;
  		}
  		.title {
  			font-size: 140%;
  			padding-bottom: 5px;
  		}
  		.info-text {
  			padding: 3px;
  			margin-bottom: 5px;
  		}
  	</style>
	<body>
		<div id="error-box">
			<div class="title"> 에러! </div>
			<div class="info-text"> 
				<p>등록되어있지 않은 유저입니다. <br>
					목자시면 목사님께 의뢰하여 시스템에 등록하시기 바랍니다.</p>
			</div>
		</div>
	</body>
</html>

