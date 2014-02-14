<!doctype html>
<html>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

	<head>
		<script src="jQuery/jquery-1.10.2.js"></script>
		<script src="dateJS/date-en-US.min.js"></script>
  		<script src="jQuery/jquery-ui-1.10.4.custom/js/jquery-ui-1.10.4.custom.js"></script>
  		<script src="iCheck/icheck.js"></script>
  		<script src="autosize/jquery.autosize.js"></script>
  		<link rel="stylesheet" href="iCheck/skins/minimal/minimal.css">
  		<link rel="stylesheet" href="jQuery/jquery-ui-1.10.4.custom/css/mokjang-theme/jquery-ui-1.10.4.custom.css">
  		<link rel="stylesheet" href="styles.css">
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

			var mokoneAccordion = $('<div class="accordion" id="accordion' + id +'">' 
										+ '<h3 class="accordion-header">' 
											+ '<div class="accordion-header-left inline-block" id="accordion-header-left' + id + '">'
												+ '<div class="accordion-control-button-div inline-block">'
													+ '<button type="button" class="accordion-control-button"' 
														+ ' id="accordion-control-button' + id + '">'
													+ '</button>'
												+ '</div>'
												+ '<div class="attendance-mokone-name inline-block">' + title + '</div>'
												+ '<div class="attended-text inline-block" id="attended-text' + id + '">[참석]</div>'
												+ '<div class="pastor-visit-text inline-block" id="pastor-visit-text' + id + '">[심방]</div>'
												+ '<div class="news-text inline-block" id="news-text' + id + '">[소식]</div>'
												+ '<div class="prayer-text inline-block" id="prayer-text' + id + '">[기도]</div>' 
											+ '</div>'
											+ '<div class="accordion-delete-button-div inline-block">'
													+ '<button type="button" class="accordion-delete-button"'
														+ ' id ="accordion-delete-button' + id + '">'
													+ '</button>'
											+ '</div>'
										+ '</h3>'
										+ '<div class="accordion-body">'
											+ '<div class="accordion-checkbox-div">'
												+ '<label for="attendance' + id + '" class="inline-block">모임 참석 </label>'
												+ '<input type="checkbox" class="attendance-checkbox"' 
													+ 'name="attendance' + id + '" id="attendance' + id + '">'
												+ '<label for="pastor-visit' + id + '" class="inline-block">심방 요청</label>'
												+ '<input type="checkbox" name="pastor-visit' + id + '" id="pastor-visit' + id + '">'
											+ '</div>'
											+ '<div class="accordion-textarea-label"><label for="news' + id + '" class="inline-block">목원 소식: </label></br></div>'
											+ '<div class="accordion-textarea"><textarea name="news' + id + '" id="news' + id + '" '
												+ 'class="text ui-widget-content ui-corner-all"></textarea></div>'
											+ '<div class="accordion-textarea-label"><label for="prayer-request' + id + '" class="inline-block">기도 제목: </label></div>'
											+ '<div class="accordion-textarea"><textarea name="prayer-request' + id + '" id="prayer-request' + id + '" ' 
												+ 'class="text ui-widget-content ui-corner-all"></textarea></div>'
								   		+ '</div>'
									+ '</div>');

			$('#attended-mokone-report-box').append(mokoneAccordion);

			$('#accordion-header-left'+id).css({
				"width": "94%",
			});

			$('#accordion-control-button'+id).css({
				"font-size": "70%",
				"height": "25px",
			    "width": "25px",
				"margin-right": "10px"
			});

			$( "#accordion-delete-button"+id).css({
				"font-size": "70%",
				"height": "25px",
				"width": "25px",
			});

			$(function() {
				$('#accordion' + id).accordion({
					collapsible:true,
					icons: null,
					disabled:true,
					heightStyle: "content",
					active:false
				});
			});

			$('#accordion-control-button'+id).button({
				text: false,
				label: "open",
      			icons: {
        			primary: "ui-icon-triangle-1-e"
      			}
			}).click(function() {
      			var options;
      			if ( $( this ).text() === "open" ) {
      				$(this).closest('.accordion').accordion("option", "active", 0);
        			options = {
          				label: "close",
          				icons: {
            				primary: "ui-icon-triangle-1-s"
          				}
        			};
      			} else {
      				$(this).closest('.accordion').accordion("option", "active", false);
        			options = {
          				label: "open",
          				icons: {
            				primary: "ui-icon-triangle-1-e"
          				}
        			};
      			}
      			$( this ).button( "option", options );
    		});	

			$( '#accordion-delete-button'+id).button({
				text: false,
				icons: {
	        		primary: "ui-icon-circle-close"
	        	}
			}).click(function() {
				$('#delete-confirmation-form').data("id", id);
				$('#delete-confirmation-form').dialog('open');
			});

			$( ".accordion-delete-button" ).hide();

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
			var titleString = $('<div>' + mokjangName + '목장 모임 보고서</div>');
			var mokoneCount = 0;

			$.getJSON( "/report/user/mokones", 
				{
					mokjangName: mokjangName
				}, function(data) {
					if(data.mokoneList != "") {
						$('#no-attended-mokone-info-text').hide();
						$('#attended-mokone-info-text').show();

						$.each(data, function(key,val) {
							$.each(val,function(key,val) {
								console.log(key, val.husband_name, val.wife_name);
								addMokoneAccordion(val.id, val.husband_name, val.wife_name);
								mokoneCount++;
							});
						});
					} else {
						$('#no-attended-mokone-info-text').show();
						$('#attended-mokone-info-text').hide();
					}
				}
			);
			$(this).find('.report-title').append(titleString);

			// Getting the currentWeek and making currentWeek String
			var currentWeekText = "The week of " + Date.parse("monday").toString('MMMM dS, yyyy');
			var currentWeekHTML = $('<i>' + currentWeekText + '</i>');
			$(this).find('.report-time').append(currentWeekHTML);

			var thisMonday = Date.parse("monday");
			var thisSunday = Date.parse("monday").add(6).days();


			// Adding jQuery DatePicker for meetingTime
			$(function() {
    			$( "#datepicker" ).datepicker({ minDate: thisMonday, maxDate: thisSunday });
  			});

			// This is a button for adding a mokone
  			$( "#participant-add-family" )
			    .button()
			    .click(function() {
			   		$( ".add-form" ).dialog( "open" );
			   	}
			);


			// This is 목원줄이기 button functionality
			$( "#participant-delete-family" )
			    .button()
			    .click(function() {
			    	if ( this.checked ) {
			    		$( ".accordion-delete-button").show();
			    		
			    	}
			    	else {
			    		$( ".accordion-delete-button").hide();
			    	}
				}
			);

			$( ".add-form" ).dialog({
		      	autoOpen: false,
		     	height: 330,
		      	width: 220,
		      	modal: true,
		      	buttons: {
			        "확인": function() {
				  		var mokoneName = $("#mokoneName").val();
				  		var husbandName = $("#husbandName").val();
				  		var wifeName = $("#wifeName").val();
				  		var status = "";
				  		var sex="";
				  		var statusCheckSingle = $('#status-single:checked').length;
				  		var statusSex = $('#sex-male:checked').length;

				  		if(statusSex > 0) {
				  			sex = "male";
				  		} else {
				  			sex = "female";
				  		}

				  		if(statusCheckSingle > 0) {
				  			status = "single";
				  			console.log(mokoneName, sex);
				  		} else {
				  			status = "married";
				  			console.log(husbandName, wifeName);
				  		}
				  		
						$.post("{{url('user/add-mokone')}}", 
							{ 
								status: status,
								mokoneName: mokoneName,
								husbandName: husbandName,
								wifeName: wifeName,
								mokjangName: mokjangName,
								groupName: groupName,
								sex: sex
							}, 
							function(data) {
								if(data.status == true)
								{
									mokoneCount++;
									if (mokoneCount == 1) {
										$( '#no-attended-mokone-info-text' ).hide();
										$( '#attended-mokone-info-text' ).show();
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

		            	$( this ).dialog( "close" );
			        },
			        "취소": function() {
			          	$( this ).dialog( "close" );
			        }
		    	},
		    	close: function() {
		    	}
			});

			$( "#delete-confirmation-form" ).dialog({
		      	autoOpen: false,
		     	height: 180,
		      	width: 250,
		      	modal: true,
		      	buttons: {
			        "확인": function() {
			        	var id = $(this).data("id");
				  		$.post( "/report/user/delete-mokone", {id: id}, function(data) {
							if (data.result == 1) {
								mokoneCount--;
								if(mokoneCount == 0) {
									$( '#no-attended-mokone-info-text' ).show();
									$( '#attended-mokone-info-text' ).hide();
								}

								$( '#accordion' + id).hide();
							}
						});

						$( this ).dialog( "close" );
			        },
			        "취소": function() {
			          	$( this ).dialog( "close" );
			        }
		    	},
		    	close: function() {
		    	}
			});
			
			$('.radio-married').on('ifChecked', function(event){
				$('.family-form').show();
  				$('.single-form').hide();
			});

			$('.radio-single').on('ifChecked', function(event){
				$('.single-form').show();
  				$('.family-form').hide();
			});

			$('.icheck-radio-minimal').iCheck({
				checkboxClass: 'icheckbox_minimal',
				radioClass: 'iradio_minimal'
			});

			$('.radio-single').iCheck('check');

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
				});
		});
  	</script>

	<body>
		<div id="report-container">
			<div id="report-title-box">
				<div class="report-title"></div>
				<div class="report-time"></div>
				<div class="report-bar"></div>
			</div>

			<div id="report-form-div">
			  	<form id="report-form" action="/report/user/process-form" method="post">
			  		<fieldset> 
			  			<div class="report-item-box">
					    	<label class="report-label" for="meetingDate">모임 날짜:</label>
					    	<div class="report-text-short">
					    		<input type="text" name="meetingDate" id="datepicker" class="text ui-widget-content ui-corner-all">
					    	</div>
				    	</div>
				    	<div class="report-item-box add-margin-left-percent">
				    		<label id="report-label" for="meetingPlace">모임 장소:</label>
				    		<div class="report-text-short">
				    			<input type="text" name="meetingPlace" class="text ui-widget-content ui-corner-all">
				    		</div>
				    	</div>
				    	<div id="participant-box">
				    		<div id="participant-title">모임에 함께한 목원을 선택해주세요.</div>
				    		
				    		<div id="participant-tool-box">
					    		<div id="participant-tool-text">다음 버튼을 눌러 새로온 목원을 추가하거나 떠난 목원을 지워주세요.</div>
					    		<div class="participant-button"><button type="button" id="participant-add-family">목원늘리기</button></div>
					    		<div class="participant-button"><input type="checkbox" id="participant-delete-family"><label for="participant-delete-family">목원줄이기</label></div>
					    		<div class="add-form" title="목원 늘리기">
								  	<form>
								  		<div class="marital-status-radio-box">
									  		<div class="icheck-radio-minimal radio-single inline-block">
									  			<input type="radio" name="status" id="status-single" value="single">
									  			<label class="radio-text">Single</label>
									  		</div>

									  		<div class="icheck-radio-minimal radio-married inline-block add-margin-left-percent">
									  			<input type="radio" name="status" id="status-married" value="married">
									  			<label class="radio-text">Married</label>
									  		</div>
								  		</div>
								  		
								  		<div class="family-form">
									  		<fieldset>
										    	<label for="husbandName">남편 이름:</label>
										    	<input type="text" name="husbandName" id="husbandName" class="text ui-widget-content ui-corner-all">
										    	<label for="wifeName">아내 이름:</label>
										    	<input type="text" name="wifeName" id="wifeName" class="text ui-widget-content ui-corner-all">
									  		</fieldset>
								  		</div>
								  		<div class="single-form">
								  			<fieldset>
										    	<label for="mokoneName">이름:</label>
										    	<input type="text" name="mokoneName" id="mokoneName" class="text ui-widget-content ui-corner-all">
										   		<div class="choose-sex inline-block">
										    		<div class="icheck-radio-minimal inline-block">
										  				<input type="radio" name="sex" id="sex-male" class="inline-block" value="single">
										  				<label class="radio-text inline-block">남자</label>
										  			</div>
										  			<div class="icheck-radio-minimal inline-block add-margin-left-percent">
										  				<input type="radio" name="sex" id="sex-female" class="inline-block" value="married">
										  				<label class="radio-text inline-block">여자</label>
										  			</div>
										  		</div>
									  		</fieldset>
									  	</div>
								  	</form>
								</div>

								<div id="delete-confirmation-form" title="목원지우기">
								  	<form>
								  		<fieldset>
								  			<div><p>정말로 지우시겠습니까?</p></div>
								  		</fieldset>
								  	</form>
								</div>

					    	</div>
					    	<div id="attended-mokone-report-box">
					    		<div id="attended-mokone-info-text">지금까지 등록된 목원입니다.</div>
					    		<div id="no-attended-mokone-info-text">지금까지 등록된 목원이 없습니다.</div>
					    	</div>
					    	<div id="end-bar"></div>
					    	<div id="submit-button-box">
					    		<div class="submit-button-div"><button type="submit" id="submit-button">보내기</button></div>	
				    		</div>
			  		</fieldset>
			  	</form>
			</div>
		</div>
	</body>
</html>