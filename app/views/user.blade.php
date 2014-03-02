<!doctype html>
<html>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

	<head>
		<script src="jQuery/jquery-1.10.2.js"></script>
		<script src="dateJS/date-en-US.min.js"></script>
  		<script src="jQuery/jquery-ui-1.10.4.custom/js/jquery-ui-1.10.4.custom.js"></script>
  		<script src="autosize/jquery.autosize.js"></script>
  		<script src="bootstrap-3.1.1/js/bootstrap.js"></script>
  		<script src="bootstrap-3.1.1/js/bootstrap-datepicker.js"></script>
  		<link rel="stylesheet" href="bootstrap-3.1.1/css/bootstrap-datepicker.css">
		<link rel="stylesheet" href="bootstrap-3.1.1/css/bootstrap.css">
  		<link rel="stylesheet" href="jQuery/jquery-ui-1.10.4.custom/css/mokjang-theme/jquery-ui-1.10.4.custom.css">
  		<link rel="stylesheet" href="user-styles.css">
  		<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Droid+Sans">
  	</head>
  	<script type="text/javascript">
		function addMokoneAccordion (id, husbandName, wifeName) {
			var title = "";
			if(!husbandName) {
				title = wifeName;
			}
			else if(!wifeName) {
				title = husbandName;
			}
			else {
				title = husbandName + " / " + wifeName;
			}

			var mokoneAccordion = $('<div class="panel-group" id="accordion' + id +'">' 
										+ '<div class="panel panel-default">' 
											+ '<div class="panel-heading">'
												+ '<h4 class="panel-title">'
													+ '<a data-toggle="collapse" data-parent="#accordion' + id + '" href="#collapse' + id +'">' + title + '</a>'
													+ '<span class="label label-danger mokone-label" id="prayer-text' + id + '">기도</span>' 
													+ '<span class="label label-warning mokone-label" id="news-text' + id + '">소식</span>'
													+ '<span class="label label-success mokone-label" id="pastor-visit-text' + id + '">심방</span>'
													+ '<span class="label label-primary mokone-label" id="attended-text' + id + '">참석</span>'
													+ '<button type="button" class="btn btn-danger btn-xs mokone-delete-button"'
														+ ' id ="mokone-delete-button' + id + '" data-toggle="modal" data-target="#delete-confirm-modal">'
														+ '<span class="glyphicon glyphicon-remove"></span>'
													+ '</button>'
												+ '</h4>'
											+ '</div>'

										+ '<div id="collapse' + id + '" class="panel-collapse collapse">'
											+ '<div class="panel-body">'
												+ '<div class="accordion-checkbox-div">'
													+ '<div class="margin-right inline-block">'
														+ '<label for="attendance' + id + '">모임 참석 </label>'
														+ '<input type="checkbox" name="attendance' + id + '" id="attendance' + id + '">'
													+ '</div>'
													+ '<div class="inline-block">'
														+ '<label for="pastor-visit' + id + '">심방 요청</label>'
														+ '<input type="checkbox" name="pastor-visit' + id + '" id="pastor-visit' + id + '">'
													+ '</div>'
												+ '</div>'
												+ '<div class="accordion-textarea-label"><label for="news' + id + '" class="inline-block">목원 소식: </label></br></div>'
												+ '<div class="accordion-textarea"><textarea name="news' + id + '" id="news' + id + '" '
													+ 'class="text ui-widget-content ui-corner-all"></textarea></div>'
												+ '<div class="accordion-textarea-label"><label for="prayer-request' + id + '" class="inline-block">기도 제목: </label></div>'
												+ '<div class="accordion-textarea"><textarea name="prayer-request' + id + '" id="prayer-request' + id + '" ' 
													+ 'class="text ui-widget-content ui-corner-all"></textarea></div>'
											+ '</div>'
								   		+ '</div>'
									+ '</div>');

			$('#attended-mokone-report-box').append(mokoneAccordion);

			$('#mokone-delete-button' + id).hide();

			$('#mokone-delete-button' + id).click(function() {
				$('#delete-confirm-modal').data('id', id);
			});

			$('#attended-text' + id).hide();

			$('#attendance' + id).change(function(){
				if (this.checked) {
					$('#attended-text' + id).show();
				}
				else {
					$('#attended-text' + id).hide();
				}
			});

			$('#pastor-visit-text' + id).hide();

			$('#pastor-visit' + id).change(function(){
				if (this.checked) {
					$('#pastor-visit-text' + id).show();
				}
				else {
					$('#pastor-visit-text' + id).hide();
				}
			});

			$('#news-text' + id).hide();

			$('#news' + id).change(function() {
				var newsText = $.trim($('#news' + id).val());
				if(newsText.length == 0) {
					$('#news-text' + id).hide();
				} else {
					$('#news-text' + id).show();
				}
			});

			$('#prayer-text' + id).hide();

			$('#prayer-request' + id).change(function() {
				var newsText = $.trim($('#prayer-request' + id).val());
				if(newsText.length == 0) {
					$('#prayer-text' + id).hide();
				} else {
					$('#prayer-text' + id).show();
				}
			});

			$('.text').autosize();

		}


  		$(document).ready(function() {
			var mokjangName = "<?php echo $mokjangName?>";
			var groupName = "<?php echo $groupName?>";
			var titleString = mokjangName + '목장 모임';
			var mokoneCount = 0;
			$('#delete-mokone').hide();

			$.getJSON( "user/mokones", 
				{
					mokjangName: mokjangName
				}, function(data) {
					if(data.mokoneList != "") {
						$('#no-registered-mokone-text').hide();

						$.each(data, function(key,val) {
							$.each(val,function(key,val) {
								console.log(key, val.husband_name, val.wife_name);
								addMokoneAccordion(val.id, val.husband_name, val.wife_name);
								mokoneCount++;
							});
						});

						$('#delete-mokone').show();
					} else {
						$('#no-registered-mokone-text').show();
					}
				}
			);

			// Getting the currentWeek and making currentWeek String
			var currentWeekText = "The week of " + Date.parse("monday").toString('MMMM dS, yyyy');

			var pageHeader = $('<h2><b>' + titleString + '</b><br><small><i>' + currentWeekText + '</i></small>' + '</h2>');
			$('#page-header').append(pageHeader);

			var thisMonday = Date.parse("monday");
			var thisSunday = Date.parse("monday").add(6).days();


			// Adding jQuery DatePicker for meetingTime
			$( "#datepicker" ).datepicker({
				autoclose: true,
				startDate: thisMonday, 
				endDate: thisSunday 
			});

			// This is a button for adding a mokone
  			$( "#participant-add-family" )
			    .button()
			    .click(function() {
			   		$( ".add-form" ).dialog( "open" );
			   	}
			);

			$('#delete-button-box').hide();

			// This is 목원줄이기 button functionality
			$( "#delete-mokone" )
			    .click(function() {
			    	$('.mokone-delete-button').show();
			    	$('#delete-button-box').show();
			    	$('#normal-button-box').hide();
				}
			);

			$('#delete-done-mokone')
				.click(function() {
					$('.mokone-delete-button').hide();
					$('#normal-button-box').show();
					$('#delete-button-box').hide();
				});

			$('#create-confirm-button').click(function() {
				var mokoneName = $("#mokoneName").val();
		  		var husbandName = $("#husbandName").val();
		  		var wifeName = $("#wifeName").val();
		  		var status = $('#register-mokone-modal').data('status');
		  		var sex=$('#register-mokone-modal').data('sex');
		  		
				$.post("{{url('report/user/add-mokone')}}", 
					{ 
						mokoneName: mokoneName,
						husbandName: husbandName,
						wifeName: wifeName,
						mokjangName: mokjangName,
						groupName: groupName,
						status: status,
						sex: sex
					}, 
					function(data) {
						if(data.status == true)
						{
							mokoneCount++;
							if (mokoneCount == 1) {
								$('#no-registered-mokone-text').hide();
								$('#delete-mokone').show();
							}

							if (status == "single")
								addMokoneAccordion(data.id, mokoneName, "");
							else
								addMokoneAccordion(data.id, husbandName, wifeName);

						}
						else
						{
							console.log("oh... no good");
						}
					}
				);

				$('#register-mokone-modal').modal('hide');
			});
	
			$('#button-single').click(function() {
				$('#button-married').removeClass('active');
				$(this).addClass('active');
				$('.family-form').hide();
				$('.single-form').show();
				$('#register-mokone-modal').data('status', 'single');
			});

			$('#button-married').click(function() {
				$('#button-single').removeClass('active');
				$(this).addClass('active');
				$('.family-form').show();
				$('.single-form').hide();
				$('#register-mokone-modal').data('status', 'married');
			});

			$('.family-form').hide();

			$('#button-male').click(function() {
				$(this).addClass('active');
				$('#button-female').removeClass('active');
				$('#register-mokone-modal').data('sex', 'male');
			});

			$('#button-female').click(function() {
				$(this).addClass('active');
				$('#button-male').removeClass('active');
				$('#register-mokone-modal').data('sex', 'female');
			});


			$('#delete-confirm-button').click(function(){
				var id = $('#delete-confirm-modal').data("id");

		  		$.post( "user/delete-mokone", {id: id}, function(data) {
					if (data.result == 1) {
						mokoneCount--;
						if(mokoneCount == 0) {
							$('#no-registered-mokone-text').show();
							$('#delete-mokone').hide();

						}

						$( '#accordion' + id).hide();
					}
				});

				$('#delete-confirm-modal').modal('hide');
			});

			$('#create-mokone').click(function() {
				$('#mokoneName').val("");
				$('#husbandName').val("");
				$('#wifeName').val("");
				$('#button-single').addClass("active");
				$('#button-married').removeClass("active");
				$('#button-male').removeClass("active");
				$('#button-female').removeClass("active");
				$('#family-form').hide();
				$('#single-form').show();
			});

			var mokjangId = "<?php echo $mokjangId?>";
			$('#submit-button')
				.button()
				.click(function() {
					$('<input />').attr('type', 'hidden')
						.attr('name', 'mokjangId')
						.attr('value', mokjangId)
						.appendTo('#report-form');

					$('<input />').attr('type', 'hidden')
						.attr('name', 'mokjangName')
						.attr('value', mokjangName)
						.appendTo('#report-form');

					$('<input />').attr('type', 'hidden')
						.attr('name', 'week')
						.attr('value', thisMonday.toString('MM/dd/yyyy'))
						.appendTo('#report-form');

					$('#report-form').submit();
				}
			);

		});
				
  	</script>

	<body>
		<div id="report-container">
			<div id="page-header">
			</div>

			<div id="report-form-div">
			  	<form id="report-form" action="user/process-form" method="post">
			  		<fieldset> 

			  			<div class="report-item-box inline-block margin-right">
					    	<label class="report-label" for="meetingDate">모임 날짜:</label>
					    	<div class="report-text-short">
					    		<input type="text" name="meetingDate" id="datepicker" class="text ui-widget-content ui-corner-all">
					    	</div>
				    	</div>
				    	<div class="report-item-box inline-block">
				    		<label id="report-label" for="meetingPlace">모임 장소:</label>
				    		<div class="report-text-short">
				    			<input type="text" name="meetingPlace" class="text ui-widget-content ui-corner-all">
				    		</div>
				    	</div>

				    	<div id="attended-mokone-report-box">
				    		<div id="mokone-box-header">등록된 목원:</div>
				    		<div id="no-registered-mokone-text" class="panel panel-default">
  								<div class="panel-heading">등록된 목원이 없습니다.</div>
							</div>
				    	</div>
				    	<div id="end-bar"></div>
				    	<div id="normal-button-box">
				    		<button type="submit" id="submit-button" class="btn btn-primary">보내기</button>
				    		<button type="button" id="create-mokone" class="btn btn-default" data-toggle="modal" data-target="#register-mokone-modal">새 목원 등록하기</button>
				    		<button type="button" id="delete-mokone" class="btn btn-danger">떠난 목원 등록하기</button>
			    		</div>
			    		<div id="delete-button-box">
    						<button type="button" id="delete-done-mokone" class="btn btn-primary">떠난 목원을 다 등록하였습니다</button>
						</div>
			  		</fieldset>
			  	</form>
			</div>
		</div>

		<div class="modal fade" id="delete-confirm-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog" id="delete-confirm-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="delete-confirm-title">목원 줄이기</h4>
					</div>
					<div class="modal-body">
						<p> 정말로 시스템에서 지우시겠습니까? </p>
					</div>
					<div class="modal-footer">
						<button id="delete-confirm-button" type="button" class="btn btn-danger">확인</button>
						<button id="delete-cancel-button" type="button" class="btn btn-default" data-dismiss="modal">취소</button>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="register-mokone-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog" id="register-mokone-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="delete-confirm-title">목원 등록하기</h4>
					</div>
					<div class="modal-body">
						<form>
							<div class="btn-group btn-group-justified margin-bottom">
								<div class="btn-group">
									<button type="button" id="button-single" class="btn btn-primary active">싱글</button>
								</div>
								<div class="btn-group">
									<button type="button" id="button-married" class="btn btn-primary">부부</button>
								</div>
							</div>

							<div class="single-form">
								<fieldset>
									<label for="mokoneName" class="inline-block">이름:</label>
									<input type="text" name="mokoneName" id="mokoneName" class="text ui-widget-content ui-corner-all">
										<div class="btn-group">
											<button type="button" id="button-male" class="btn btn-default">남자</button>
											<button type="button" id="button-female" class="btn btn-default">여자</button>
										</div>

								</fieldset>
							</div>

							<div class="family-form">
								<fieldset>
									<label for="husbandName">남편 이름:</label>
									<input type="text" name="husbandName" id="husbandName" class="text ui-widget-content ui-corner-all">
									<label for="wifeName">아내 이름:</label>
									<input type="text" name="wifeName" id="wifeName" class="text ui-widget-content ui-corner-all">
								</fieldset>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button id="create-confirm-button" type="button" class="btn btn-primary">확인</button>
						<button id="create-cancel-button" type="button" class="btn btn-default" data-dismiss="modal">취소</button>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>