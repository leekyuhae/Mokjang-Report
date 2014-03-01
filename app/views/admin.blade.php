	<!doctype html>
	<html>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

	<head>
		<script src="angular/angular.js"></script>
		<script src="jQuery/jquery-1.10.2.js"></script>
		<script src="jQuery/jquery-ui-1.10.4.custom/js/jquery-ui-1.10.4.custom.js"></script>
		<script src="bootstrap-3.1.1/js/bootstrap.js"></script>
		<script src="bootstrap-3.1.1/js/bootstrap-datepicker.js"></script>
		<script src="bootstrap-3.1.1/js/ui-bootstrap-tpls-0.10.0.js"></script>
  		<link rel="stylesheet" href="bootstrap-3.1.1/css/bootstrap-datepicker.css">
		<link rel="stylesheet" href="bootstrap-3.1.1/css/bootstrap.css">
		<link rel="stylesheet" href="jQuery/jquery-ui-1.10.4.custom/css/mokjang-theme/jquery-ui-1.10.4.custom.css">
		<link rel="stylesheet" href="admin-styles.css">
		<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Droid+Sans">

		<script type="text/javascript">

		/*
		function buildTermTable() {
			$('.term-table-row').remove();
			$('.term-table-page-button').remove();

			var pageNumber = 1;
			var count = 0;

			$.getJSON( "admin/all-terms", function(data) {
				$.each(data, function(key,val) {
					$.each(val,function(key,val) {

						$('#term-table-header').after(
							'<tr id="term-table-tr' + val.id +'" class="term-table-page' + pageNumber + ' term-table-row">'
								+ '<td>' + val.term_name + '</td>'
								+ '<td>' + val.starting_sunday + '</td>'
								+ '<td>' + val.ending_sunday + '</td>'
							+ '</tr>');


						$('#term-table-tr' + val.id).click(function() {
							$('#term-name').val(val.term_name);
							$('#starting-sunday').val(val.starting_sunday);
							$('#ending-sunday').val(val.ending_sunday);

							$('#create-term-title').html("모임 기간 수정하기");

							$('#create-term-modal')
								.data('from', "edit")
								.data('termId', val.id)
								.modal('show');
						});

						count++;

						if (count == 1) {
							if(pageNumber != 1) {
								$('.term-table-page'+pageNumber).hide();
							}
							count = 0;
							pageNumber++;
						}
					});
				});

				return pageNumber;
			};
		}
		*/


		function groupNameTranslator(groupName) {
			var retGroupName="";
			if(groupName == "crossway") {
				retGroupName = "크로스웨이";
			} else if (groupName == "jesuslove") {
				retGroupName = "예수사모";
			} else if (groupName == "cornerstone") {
				retGroupName = "코너스톤"
			} else if (groupName == "regualr") {
				retGroupName = "일반";
			} else {
				retGroupName = "안알랴쥼";
			}

			return retGroupName;
		}

		function addMokjangButtonScript(mokjangId) {
			$( '#mokjang_button' + mokjangId )
			.click(function() {

				$.post("{{url('report/admin/find-mokjang')}}",
				{
					mokjangId: mokjangId
				},
				function(data) {
					$('#display-mokjang-name').html(data.mokjangName);
					$('#display-mokja-name').html(data.mokjaName);
					$('#display-mokja-id').html(data.mokjaId);
					$('#display-mokjang-group').html(groupNameTranslator(data.groupName));
					$('#display-form-modal')
					.data( "groupName", data.groupName )
					.data( "mokjangId", mokjangId );
				}
				);
			}
			);
		}

		$(document).ready(function() {
			var groupMap = {};
			groupMap["crossway"] = 0;
			groupMap["jesuslove"] = 0;
			groupMap["cornerstone"] = 0;
			groupMap["regular"] = 0;

			$.getJSON( "admin/all-mokjangs", function(data) {
				$.each(data, function(key,val) {
					$.each(val,function(key,val) {
						groupMap[val.group_name]++;

						var buttonString = $(
							'<button class="mokjang_button btn btn-default btn-lg" id="mokjang_button' + val.id +'" data-toggle="modal" data-target="#display-form-modal">' 
							+ '<div class="mokjang_name" id="mokjang_name' + val.id + '">' + val.mokjang_name + '</div>'
							+ '</button>');


						var containerName = val.group_name + "-container";
						$('#'+containerName).append(buttonString);
						addMokjangButtonScript(val.id);
					});
				});

				$.each(groupMap, function(key,val) {
					if(val != 0) {
						var containerName = key + "-container";
						$('#'+containerName).find('#no-registered-mokjang').hide();
					}
				});

				addMokjangButtonScript(".mokjang_button");
			});

			$( "#tabs" ).tabs();

			$( "#create-mokjang" ).click(function() {
				$("#create-form-title").html("목장만들기");
				$('#mokjangName').val("");
				$('#mokjaName').val("");
				$('#mokjaId').val("");
				$('#groupName').val("crossway");
				$("#create-mokjang-modal").data("type", "create");
			});

			$('#create-mokjang-cancel').click(function() {

			});

			$( "#create-mokjang-confirm" ).click(function() {
				var mokjangName = $( "#mokjangName" ).val();
				var mokjaName = $( "#mokjaName" ).val();
				var mokjaId = $( "#mokjaId" ).val();
				var groupName = $( "#groupName" ).val();
				var type = $("#create-mokjang-modal").data("type");
				var mokjangId;
				var status;
				var postUrl;

				if(type == "create") {
					postUrl = "report/admin/add-mokjang";
				} else {
					mokjangId = $("#create-mokjang-modal").data("mokjangId");
					postUrl = "report/admin/update-mokjang";
				}

				$.post("{{url('" + postUrl + "')}}", 
				{ 
					mokjangName: mokjangName, 
					mokjaName: mokjaName,
					mokjaId: mokjaId,
					groupName: groupName,
					mokjangId: mokjangId
				}, 
				function(data) {
					status = data.status;

					if( (status == true) && (type == "create") ) {
						mokjangId = data.id;
						var buttonString = $(
							'<button class="mokjang_button btn btn-default btn-lg" id="mokjang_button'
								+ mokjangId + '" data-toggle="modal" data-target="#display-form-modal">'
								+ '<div class="mokjang_name" id="mokjang_name' + mokjangId + '">' 
									+ '<b>' + mokjangName + '</b>' 
								+ '</div>' 
							+ '</button>');

						groupMap[groupName]++;

						var containerName = groupName + "_container";
						$('#'+containerName).append(buttonString);
						$('#'+containerName).find('#no-registered-mokjang').hide();

						addMokjangButtonScript(mokjangId);

					} else if ( (status == true ) && (type == "edit") ) {
						$('#mokjang_name' + mokjangId).html("<b>" + mokjangName + "</b>");

						if( ($('#mokjang_button' + mokjangId).closest("div").attr("id")) != (groupName + '_container') ) {
							$("#" + groupName + "_container").append($('#mokjang_button'+mokjangId));
						}

					} else {

					} 
				});

				$( "#create-mokjang-modal" ).modal('hide');

				$('#display-mokjang-name').html(mokjangName);
				$('#display-mokja-name').html(mokjaName);
				$('#display-mokja-id').html(mokjaId);
				$('#display-mokjang-group').html(groupNameTranslator(groupName));

				$( "#display-form-modal" )
					.data( "mokjangId", mokjangId )
					.modal( "show" );
			});

			$('#create-mokjang-cancel').click(function() {
				var type = $("#create-mokjang-modal").data("type");
				if(type == "edit") {
					var mokjangId = $("#create-mokjang-modal").data("mokjangId");
					$.post("{{url('report/admin/find-mokjang')}}",
					{
						mokjangId: mokjangId
					},
					function(data) {
						$('#display-mokjang-name').html(data.mokjangName);
						$('#display-mokja-name').html(data.mokjaName);
						$('#display-mokja-id').html(data.mokjaId);
						$('#display-mokjang-group').html(groupNameTranslator(data.groupName));
					}
					);

					$('#display-form-modal')
					.data('mokjangId', mokjangId )
					.modal('show');
				}
			});

			$('#display-edit-button').click(function() {
				var mokjangId = $('#display-form-modal').data('mokjangId');

				$.post("{{url('report/admin/find-mokjang')}}",
				{
					mokjangId: mokjangId
				},
				function(data) {
					$('#mokjangName').val(data.mokjangName);
					$('#mokjaName').val(data.mokjaName);
					$('#mokjaId').val(data.mokjaId);
					$('#groupName').val(data.groupName);
				});

				$('#display-form-modal').modal('hide');

				$('#create-form-title').html("목장프로필 수정");

				$('#create-mokjang-modal')
				.data('mokjangId', $('#display-form-modal').data("mokjangId"))
				.data('type', "edit")
				.modal('show');
			});

			$('#display-delete-button').click(function() {
				$('#display-form-modal').modal('hide');

				$('#delete-confirm-modal')
					.data('mokjangId', $('#display-form-modal').data('mokjangId'))
					.data('groupName', $('#display-form-modal').data('groupName'))
					.data('from', "mokjang")
					.modal('show');
			});

			$('#delete-confirm-button').click(function() {
				var from = $('#delete-confirm-modal').data('from');
				if(from == "mokjang") {
					var mokjangId = $('#delete-confirm-modal').data("mokjangId");

					$.post("{{url('report/admin/delete-mokjang')}}",
					{
						mokjangId: mokjangId
					},
					function(data) {
						if (data.status == 1) {
							var groupName = $("#delete-confirm-modal").data("groupName");
							groupMap[groupName]--;

							if(groupMap[groupName] == 0) {

								var containerName = groupName + "_container";
								$('#'+containerName).find('#no-registered-mokjang').show();
							}

							$('#mokjang_button' + mokjangId).hide();
						}
						else {
							console.log( "failed.." );
						}
					});
				}
				else if(from == "term") {
					var termId = $('#delete-confirm-modal').data('termId');

					$.post("{{url('report/admin/delete-term')}}",
					{
						termId: termId
					},
					function(data) {
						if (data.status == 1) {
							buildTermTable();
						}
						else {
							//failed.. alert maybe?
						}
					});

				}
				else {
					// meh
				}

				$('#delete-confirm-modal').modal("hide");
			});


			$('#term-explain-panel').hide();

			$('#term-help-close').hide();

			$('#term-help-open').click(function() {
				$('#term-help-open').hide();
				$('#term-help-close').show();
				$('#term-explain-panel').show();
			});

			$('#term-help-close').click(function() {
				$('#term-help-open').show();
				$('#term-help-close').hide();
				$('#term-explain-panel').hide();
			});

			$('#create-term').click(function() {
				$('#create-term-delete').hide();
				$('#create-term-modal').data('from',"create");
			});

			$('#create-term-confirm').click(function() {
				var from = $('#create-term-modal').data('from');
				var url = "";
				var termId = "";
				if(from == "create") {
					console.log("here?");
					url = "report/admin/add-term";
				} else if(from == "edit") {
					termId = $('#create-term-modal').data('termId');
					url = "report/admin/update-term";
				} else {
					console.log("really not supposed to happen.");

				}

				console.log("Yeah!");
				$.post("{{url('" + url + "')}}",
					{
						termId: termId,
						termName: $('#term-name').val(),
						startingSunday: $('#starting-sunday').val(),
						endingSunday: $('#ending-sunday').val()
					},
					function(data) {
						if(data.status == 1) {
							//buildTermTable();
						}
					}
				);

				$('#term-name').val(""),
				$('#starting-sunday').val(""),
				$('#ending-sunday').val("")

				$('#create-term-modal').modal('hide');
			});

			$('#create-term-delete').click(function() {
				var termId = $('#create-term-modal').data('termId');

				$('#create-term-modal').modal('hide');

				$('#delete-confirm-modal')
					.data('termId', termId)
					.data('from', "term")
					.modal('show');
			});

			/*
			pageNumber = buildTermTable();


			$('#no-terms-row').hide();
			console.log("here? " + pageNumber);

			if( pageNumber > 2 ) {
				console.log("here?!!");
				if( count == 0) {
					pageNumber--;
				}

				var page = 1;
				while(page <= pageNumber) {
					$('#term-table-pagination').append(
						'<li>' 
						+ '<a href="#" id="term-table-page-button' + page + '" class="term-table-page-button">' 
						+ page 
						+ '</a>'
						+ '</li>'
						);

					page++;
				}
			}

			for(var i=1;i<=pageNumber;i++) {
				console.log(i);

				$('#term-table-page-button'+i).click(function() {
					var j = i;
					console.log(j);
				});
			}
			*/

			$('#term-table-pagination').show();

			$( "#datepicker" ).datepicker({
				autoclose: true,
				daysOfWeekDisabled: "1,2,3,4,5,6",
				format: "yyyy-mm-dd"
			});

			$('#term-table-page').hide();
		});
		

	</script>	
</head>

<body>
	<div id="report-container">

		<div class="page-header font-size-130">
			<h1>목장리포트</h1>
		</div>

		<ul class="nav nav-tabs">
			<li class="active"><a href="#mokjang" data-toggle="tab">목장관리</a></li>
			<li><a href="#report" data-toggle="tab">주간 보고</a></li>
		</ul>

		<div class="tab-content">
			<div class="tab-pane active" id="mokjang">
				<div class="admin-tool">
					<button id="create-mokjang" class="btn btn-primary font-size-100" data-toggle="modal" data-target="#create-mokjang-modal">목장만들기</button>
				</div>

				<div class="modal fade" id="create-mokjang-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog create-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h4 class="modal-title" id="create-form-title"></h4>
							</div>
							<div class="modal-body">
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
							<div class="modal-footer">
								<button id="create-mokjang-confirm" type="button" class="btn btn-primary">확인</button>
								<button id="create-mokjang-cancel" type="button" class="btn btn-default" data-dismiss="modal">취소</button>
							</div>
						</div>
					</div>
				</div>

				<div class="modal fade" id="display-form-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog display-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h4 class="modal-title" id="display-form-title">목장 프로필</h4>
							</div>
							<div class="modal-body">
								<div id="display-content">
									<div class="display-form-box">
										<div id="display-mokjang-name-label" class="display-label inline-block">목장 </div>
										<div id="display-mokjang-name" class="inline-block"></div>
									</div>
									<div class="display-form-box">
										<div id="display-mokja-name-label" class="display-label inline-block">목자 </div>
										<div id="display-mokja-name" class="inline-block"></div>
									</div>
									<div class="display-form-box">
										<div id="display-mokja-id-label" class="display-label inline-block">아이디 </div>
										<div id="display-mokja-id" class="inline-block"></div>
									</div>
									<div class="display-form-box">
										<div id="display-mokjang-group-label" class="display-label inline-block">부서 </div>
										<div id="display-mokjang-group" class="inline-block"></div>
									</div>
								</div>
							</div>
							<div class="modal-footer">
								<button id="display-confirm-button" type="button" class="btn btn-primary" data-dismiss="modal">확인</button>
								<button id="display-edit-button" type="button" class="btn btn-default">수정</button>
								<button id="display-delete-button" type="button" class="btn btn-danger">지우기</button>
							</div>
						</div>
					</div>
				</div>

				<div id="mokjang_container" class="center">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">크로스웨이</h3>
						</div>
						<div class="panel-body" id="crossway-container">
							<div id="no-registered-mokjang">등록된 목장이 없습니다.</div>
						</div>
					</div>
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">예수사모</h3>
						</div>
						<div class="panel-body" id="jesuslove-container">
							<div id="no-registered-mokjang">등록된 목장이 없습니다.</div>
						</div>
					</div>
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">코너스톤</h3>
						</div>
						<div class="panel-body" id="cornerstone-container">
							<div id="no-registered-mokjang">등록된 목장이 없습니다.</div>
						</div>
					</div>
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">일반</h3>
						</div>
						<div class="panel-body" id="regular-container">
							<div id="no-registered-mokjang">등록된 목장이 없습니다.</div>
						</div>
					</div>
				</div>

			</div>
			<div class="tab-pane" id="report">
				
				<div class="admin-tool">
					<button id="create-term" class="btn btn-primary font-size-100" data-toggle="modal" data-target="#create-term-modal">목장 모임 기간 등록하기</button>
					<button id="term-help-open" class="btn btn-default font-size-100">목장 모임 기간 설명 열기</button>
					<button id="term-help-close" class="btn btn-default font-size-100">목장 모임 기간 설명 닫기</button>
				</div>

				<div id="term-explain-panel" class="panel panel-info margin-top">
					<div class="panel-heading">
						<h3 class="panel-title">목장 모임 기간 설명 </h3>
					</div>
					<div class="panel-body" id="regular-container">
						<p>
							목장은 주마다 한번씩 모이고 있습니다. <br> 
							그렇기 때문에 모임 기간의 기본 단위를 주로 정하였습니다. <br>
							일요일 설교 말씀으로 모임에서 성경공부를 하기 때문에 <br>
							한 주의 시작을 일요일 그리고 마지을 토요일로 정하였습니다. <br>
							주간 보고는 모임 기간 별로 보관이 되기 때문에, 모임 기간을 등록해주셔야합니다.
							어떤식으로 등록하는지는 다음 보기를 참고주세요.<br><br>
							보기:
						</p>
						<table class="table table-hover font-size-90">
							<tr>
								<th>이름</th>
								<th>시작하는 주</th>
								<th>마지막 주</th>
							</tr>
							<tr>
								<td>2014년 봄학기</td>
								<td>2014/02/16</td>
								<td>2014/05/25</td>
							</tr>
						</table>
					</div>
				</div>

				<table class="table table-hover margin-top">
					<tr id="term-table-header" class="active">
						<th>이름</th>
						<th>시작하는 주</th>
						<th data-toggle="tooltip">마지막 주</th>
					</tr>
					<tr id="no-terms-row">
						<td colspan=3>등록된 기간이 없습니다.</td>
					</tr>
				</table>

				<ul id="term-table-pagination" class="pagination">

				</ul>

				<div class="modal fade" id="create-term-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog create-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h4 class="modal-title" id="create-term-title">
									목장 모임 기간 등록
								</h4>
							</div>
							<div class="modal-body">
								<form role="form">
									<div class="form-group">
										<label for="term-name">목장 모임 기간 이름:</label>
										<input type="text" name="term-name" id="term-name" class="form-control">
									</div>
									<div class="form-group">
										<label for="starting-sunday">기간을 정해주세요.</label>
										<div class="input-daterange input-group" id="datepicker">
											<input type="text" class="form-control" name="starting-sunday" id="starting-sunday" />
											<span class="input-group-addon">to</span>
											<input type="text" class="form-control" name="ending-sunday" id="ending-sunday" />
										</div>
									</div>
								</form>
							</div>
							<div class="modal-footer">
								<button id="create-term-confirm" type="button" class="btn btn-primary font-size-100">확인</button>
								<button id="create-term-cancel" type="button" class="btn btn-default font-size-100" data-dismiss="modal">취소</button>
								<button id="create-term-delete" type="button" class="btn btn-danger">지우기</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="delete-confirm-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog display-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="delete-confirm-title">목장 지우기</h4>
					</div>
					<div class="modal-body">
						<p> 정말로 지우시겠습니까? </p>
					</div>
					<div class="modal-footer">
						<button id="delete-confirm-button" type="button" class="btn btn-danger" data-dismiss="modal">확인</button>
						<button id="delete-cancel-button" type="button" class="btn btn-default">취소</button>
					</div>
				</div>
			</div>
		</div>

	</div>
</body>
</html>


