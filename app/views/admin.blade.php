<!doctype html>
<html>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

	<head>
		<script src="jQuery/jquery-1.10.2.js"></script>
  		<script src="jQuery/jquery-ui-1.10.4.custom/js/jquery-ui-1.10.4.custom.js"></script>
  		<link rel="stylesheet" href="jQuery/jquery-ui-1.10.4.custom/css/mokjang-theme/jquery-ui-1.10.4.custom.css">
  		<link rel="stylesheet" href="styles.css">
		<script type="text/javascript">
			function addButtonScript(identifier) {
				$( identifier )
				    .button()
				    .click(function() {
				    	var mokjangName = $(this).find('.mokjang_name').text();
				    	var mokjaName;
				    	var mokjaId;
				    	var groupName;
				    	$.get("{{url('report/admin/find-mokjang')}}",
				    		{
				    			mokjangName: mokjangName
				    		},
				    		function(data) {
				    			mokjaName = data.mokjaName;
				    			mokjaId = data.mokjaId;
				    			groupName = data.groupName;
				    			console.log("mokjaName: " + mokjaName);
				    		}
				    	);

				        $( "#edit-form" )
				        .data('mokjaName', mokjaName)
				        .data('mokjaId', mokjaId)
				        .data('groupName', groupName)
				        .dialog( "open" );
				    });
			}

			$(document).ready(function() {
				$.getJSON( "report/admin/mokjangs", function(data) {
					var groupMap = {};
					groupMap["crossway"] = "false";
					groupMap["jesuslove"] = "false";
					groupMap["cornerstone"] = "false";
					groupMap["regular"] = "false";

					$.each(data, function(key,val) {
						$.each(val,function(key,val) {
							groupMap[val.group_name] = "true";
							
							var buttonString = $(
								'<button class="mokjang_box">' +
								'<div class="mokjang_name"><b>' + val.mokjang_name + '</b></div>' +
								'<div class="mokja_name">' + val.mokja_name + '</div>' +
								'</button>');
							

							var containerName = val.group_name + "_container";
							$('#'+containerName).append(buttonString);
							console.log(key + ", " + containerName);
						});
					});

					$.each(groupMap, function(key,val) {
						if(val == "false") {
							var infoText = $(
								'<div id="no-registered-mokjang">등록된 목장이 없습니다.</div>');

							var containerName = key + "_container";
							$('#'+containerName).append(infoText);
						}
					})

					addButtonScript(".mokjang_box");
				});
			
		  		$( "#tabs" ).tabs();

			    $( "#create-form" ).dialog({
			      	autoOpen: false,
			     	height: 400,
			      	width: 300,
			      	modal: true,
			      	buttons: {
				        "확인": function() {
					  		var mokjangName = $( "#mokjangName" );
					  		var mokjaName = $( "#mokjaName" );
					  		var mokjaId = $( "#mokjaId" );
					  		var groupName = $( "#groupName" );

							$.post("{{url('report/admin/add-mokjang')}}", 
								{ 
									mokjangName: mokjangName.val(), 
									mokjaName: mokjaName.val(),
									mokjaId: mokjaId.val(),
									groupName: groupName.val()
								}, 
								function(data) {
									if(data.status == true)
									{
										var buttonString = $(
											'<button class="mokjang_box" id=' + mokjangName.val() + '>' +
											'<div class="mokjang_name"><b>' + mokjangName.val() + '</b></div>' +
											'<div class="mokja_name">' + mokjaName.val() + '</div>' +
											'</button>');

										var containerName = groupName.val() + "_container";
										$('#'+containerName).append(buttonString);
										$('#'+containerName).find('#no-registered-mokjang').hide();
										
										var buttonNameText = "#"+mokjangName.val();										
										addButtonScript(buttonNameText);
									}
									else
									{
										console.log("oh... no good");
									}
								}
							);
			            	$( this ).dialog( "close" );
				        },
				        "취소": function() {
				          	$( this ).dialog( "close" );
				        }
			    	},
			    	close: function() {
			    	}
				});
			    	
			    $( "#create-mokjang" )
			    .button()
			    .click(function() {
			        $( "#create-form" ).dialog( "open" );
			    });
			});

  		</script>	
	</head>

	<body>
		<div id="tabs">
	  		<ul>
	    		<li><a href="#tabs-1">목장관리</a></li>
	    		<li><a href="#tabs-2">주간 보고</a></li>
	  		</ul>
	  		<div id="tabs-1">
	  			<div id="admin-tool">
	  				<button id="create-mokjang" class="admin-tool-icon">목장만들기</button>
	  			</div>

	  			<div id="create-form" class="admin-form" title="새 목장 만들기">
				  	<form>
				  		<fieldset>
					    	<label for="mokjangName">목장이름:</label>
					    	<input type="text" name="mokjangName" id="mokjangName" class="text ui-widget-content ui-corner-all">
					    	<label for="mokjaName">목자이름:</label>
					    	<input type="text" name="mokjaName" id="mokjaName" value="" class="text ui-widget-content ui-corner-all">
					    	<label for="mokjaId">목자 교회 홈페이지 ID:</label>
					    	<input type="text" name="mokjaId" id="mokjaId" value="" class="text ui-widget-content ui-corner-all">
				  			<label for="groupName">소속 부서:</label><br>
							<select name="groupName" id="groupName">
							 	<option value="crossway">크로스웨이</option>
							  	<option value="jesuslove">예수사모</option>
							  	<option value="cornerstone">코너스톤</option>
							  	<option value="regular">일반</option>
							</select>
				  		</fieldset>
				  	</form>
				</div>

		
				<div id="mokjang_container" class="center">
						<div class="report-title"><i><b>크로스웨이</b></i></div>
						<div class="report-bar"></div>
						<div class="group-box">
							<div id="crossway_container" class="group_container"></div>
						</div>
						<div class="report-title">예수사모</div>
						<div class="report-bar"></div>
						<div class="group-box">
							<div id="jesuslove_container" class="group_container"></div>
						</div>
						<div class="report-title">코너스톤</div>
						<div class="report-bar"></div>
						<div class="group-box">
							<div id="cornerstone_container" class="group_container"></div>
						</div>
						<div class="report-title">일반</div>
						<div class="report-bar"></div>
						<div class="group-box">
							<div id="regular_container" class="group_container"></div>
						</div>
					</div>
					
				</div>
		  	<div id="tabs-2">
	    		<p>Morbi tincidunt, dui sit amet facilisis feugiat, odio metus gravida ante, ut pharetra massa metus id nunc. Duis scelerisque molestie turpis. Sed fringilla, massa eget luctus malesuada, metus eros molestie lectus, ut tempus eros massa ut dolor. Aenean aliquet fringilla sem. Suspendisse sed ligula in ligula suscipit aliquam. Praesent in eros vestibulum mi adipiscing adipiscing. Morbi facilisis. Curabitur ornare consequat nunc. Aenean vel metus. Ut posuere viverra nulla. Aliquam erat volutpat. Pellentesque convallis. Maecenas feugiat, tellus pellentesque pretium posuere, felis lorem euismod felis, eu ornare leo nisi vel felis. Mauris consectetur tortor et purus.</p>
	  		</div>
		</div>
	</body>
</html>


				