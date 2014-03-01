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
  		#login-box {
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
  		#login-form {
  			
  		}
  		.text {
  			padding: 4px;
  			font-size: 100%;
  		}
  		.input-item {
  			margin: 5px;
  		}
  		.title {
  			font-size: 140%;
  			padding-bottom: 5px;
  		}
  		.input-container {
  			border-top: 2px solid #A84D4D;
  			border-bottom: 2px solid #A84D4D;
  			padding-top: 10px;
  			padding-bottom: 10px;
  			margin-bottom: 10px;
  		}
  		#submit-button {
  			position: relative;
  			left: 70%;
  		}
  		.info-text {
  			padding: 3px;
  			margin-bottom: 5px;
  		}
  	</style>
	<body>
		<div id="login-box">
			<div class="title"> 로그인 </div>
			<div class="info-text"> 교회 홈페이지 아이디와 패스워드로 로그인하세요. </div>
			<form id="login-form" action="home/login" method="post">
				<div class="input-container">
					<div class="input-item">
						<label class="label" for="username">아이디: </label>
						<input type="text" name="username" class="text padding ui-widget-content ui-corner-all">
					</div>
					<div class="input-item">
						<label class="label" for="password">패스워드: </label>
						<input type="password" name="password" class="text ui-widget-content ui-corner-all">
					</div>
				</div>
				<div class="submit-button-div">
					<button type="submit" id="submit-button">로그인</button>
				</div>
			</form>
		</div>
	</body>
</html>
