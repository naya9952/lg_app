<?php
require_once 'header.php';
require_once 'loginCheck.php';

$ime = $_REQUEST["ime"];
$userID = $_REQUEST["userID"];
$sessID = $_REQUEST["sessID"];
$id = "0";

$sql_ime = "select id, ime from lgu where flg=1;";
$stmt_ime = $conn->prepare($sql_ime);
$stmt_ime->execute();
$row_ime = get_stmt_assoc_array($stmt_ime, false);
$array_ime = array();

if(count($row_ime) > 0) {
    for($i =0; $i <count($row_ime); $i++)
    {
        if(IsNullOrEmptyString($ime)) {
            $ime = $row_ime[$i][1];
        }
        array_push($array_ime, $row_ime[$i][1]);
    }
    
} else {
    //echo "ime 없음";
}
$sql = "select * from (select * from lgu_history where ime=? and dtime > subdate(NOW(), interval 30 day) order by id desc limit 20) as a order by id asc;";
$cnt = 0;
// echo $sql;
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $ime);
$stmt->execute();
$row = get_stmt_assoc_array($stmt, false);
$array = array();
if(count($row) > 0) {
	for($i =0; $i <count($row); $i++)
	{
		array_push($array, $row[$i][5]);
	}
	$id = json_encode($row[count($row)-1][0]);
	error_log($id);
} else {
    //echo "값이 없음";
}
$stmt->free_result();
$stmt->close();
$tt =4;



///////////////////////////////


$stmt_ime->free_result();
$stmt_ime->close();
?>

<!doctype html>
<html>

<head>
	<title>온도 및 신호세기 추세 데이터</title>
	<script src="js/moment.min.js"></script>
	<script src="js/Chart.min.js"></script>
	<script src="js/utils.js"></script>
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<style>
	canvas {
		-moz-user-select: none;
		-webkit-user-select: none;
		-ms-user-select: none;
	}
	
	</style>
</head>

<body>


	<div style="text-align:right; margin-top:20px">
	<select name="select_ime" id="select_ime" class="selectpicker" data-live-search="true" onchange="changeSelect()">
		<?php 
		for($i =0; $i < count($row_ime); $i++ )
		{
		?>
		<option value=<?php echo $array_ime[$i];?> <?php if($array_ime[$i] == $ime)echo "selected"?>  >
		<?php echo $array_ime[$i];
		} 
		?>
	</select>

	</div>
<?php  
    $isMobile = isset($isMobile)?(IsNullOrEmptyString($isMobile)?"true":$isMobile):"true";
    if(strcmp($isMobile, "true") == 0) {
?>
	<div style="width:100%;">
		<canvas id="canvas" width="100%" height="80%"></canvas>
			<!-- 게시물 리스트를 보이기 위한 테이블 -->
	</div>

<?php 
    } else {
?>
		<canvas id="canvas"></canvas>
			<!-- 게시물 리스트를 보이기 위한 테이블 -->

<?php 
    }
?>


	<div>
		<div id="section2" class="label" style="float:right;">
			<tr>
				<td><font id="postnTab">Event History 펼치기▼</font></td>
			</tr>
		</div>

		<div style="width:100%; display: none;" class="elements">
			<table id="stock_table" width="100%" border=0 cellpadding=2 cellspacing=1 bgcolor=#777777>
				<thead id='stock_thead'> 
					<!-- 리스트 타이틀 부분 -->
					<tr height=20 bgcolor=#999999 id ="postnTr" class="hide">
						<td width=120 align=center>
							<font color=white>날짜</font>
						</td>
						<td width=80 align=center>
							<font color=white>상태</font>
						</td>
						<td width=150 align=center>
							<font color=white>비고</font>
						</td>
					</tr>
					<!-- 리스트 타이틀 끝 -->
				</thead>
				<tbody id='stock_tbody'> 
			
				</tbody>
			</table>
		</div>
		
	</div>

	
	<script type="text/javascript">
		var elements = document.getElementsByTagName("div");
		// 모든 영역 접기
		for (var i = 0; i < elements.length; i++) {
			if (elements[i].className == "elements") {
				elements[i].style.display="none";
			} else if (elements[i].className == "label") {
				elements[i].onclick=switchDisplay;
			}
// 			elements[i].style.display="none";
		}

		// 콤보박스 선택
		function changeSelect() {
			var temp = $("#select_ime option:selected").val();
			var isMobile = <?php  echo isset($isMobile)?(IsNullOrEmptyString($isMobile)?"true":$isMobile):"true"?>;
			if(isMobile) {
				location.replace("statusChart.php?ime="+temp +"&userID=" + "<?php echo $userID?>" + "&sessID=" + "<?php echo $sessID?>" );
			} else {
				location.replace("statusChartPC2.php?ime="+temp +"&userID=" + "<?php echo $userID?>" + "&sessID=" + "<?php echo $sessID?>" );
			}
		}
		////////////




		// 상태에 따라 접거나 펼치기
		function switchDisplay() {
			var parent = this.parentNode;
			var target = parent.getElementsByTagName("div")[1];
			if (target.style.display == "none") {
				target.style.display="block";
				$('#postnTab').text("Event History 접기▲");
			} else {
				target.style.display="none";
				$('#postnTab').text("Event History 펼치기▼");
			}
			return false;
		}
		////////////

		////그래프 그리기 시작
		var event_id =0;
		var temp2;
		var cnt =0;
		var id_temp = <?php echo $id ?>;
		var MONTHS = <?php echo json_encode($array)?>;
		var lineChartData = {
			labels: <?php echo json_encode($array)?>,
			datasets: [{
				label: '온도',
				borderColor: window.chartColors.red,
				backgroundColor: window.chartColors.red,
				fill: false,
				data: [
					<?php
						for($i =0; $i <count($row); $i++)
						{
							echo ($row[$i][3])/10;
							echo ',';
						}
					?>
				],
				yAxisID: 'y-axis-temp',
				pointRadius: 3
			}, {
				label: '신호세기',
				borderColor: window.chartColors.blue,
				backgroundColor: window.chartColors.blue,
				fill: false,
				data: [
					<?php
						for($i =0; $i <count($row); $i++)
						{
							echo $row[$i][4];
							echo ',';
						}
					?>
				],
				yAxisID: 'y-axis-rssi',
				pointRadius: 3
			}]
		};

		window.onload = function() {
			var ctx = document.getElementById('canvas').getContext('2d');
			window.myLine = Chart.Line(ctx, {
				data: lineChartData,
				options: {
					responsive: true,
					hoverMode: 'index',
					stacked: false,
					title: {
						display: true,
						//text: '온도 및 신호세기 추세 데이터'
					},
					scales: {
						xAxes: [{
						type: 'time',
						display: true,
						scaleLabel: {
							display: true,
							//labelString: 'Date'
						}
					}],
						yAxes: [{
							type: 'linear', // only linear but allow scale type registration. This allows extensions to exist solely for log scale for instance
							display: true,
							position: 'left',
							id: 'y-axis-temp',
							ticks: {
								min: -20,
								max: 50,
								stepSize: 10,
							}
						}, {
							type: 'linear', // only linear but allow scale type registration. This allows extensions to exist solely for log scale for instance
							display: true,
							position: 'right',
							id: 'y-axis-rssi',
							// grid line settings
							gridLines: {
								drawOnChartArea: false, // only want the grid lines for one axis to show up
							},
							beginAtZero: false,
							ticks: {
								min:-110,
								max: -60,
								stepSize: 5
							}
						}],
					}
				}
			});
			////그래프 그리기 끝


					///////자동 refresh
					ajax();
					finit();

					var timer = 0;

					function finit() {
						window.ref = window.setInterval(function() { draww(); }, 10000);
					}

					function draww() {
						ajax();
						clearInterval(window.ref);
						finit();
					}


					function ajax() {
						//그래프 데이터 가지고오기 시작
						var xhr = new XMLHttpRequest();
						xhr.open("GET", "./refresh_back.php?ime="+
						<?php 
						
						if(count($ime) ==0)
						{
							echo "-";
						}
						else
						{
							echo $ime;
						}
						?>+"&id="+id_temp);
						xhr.addEventListener("load", ajax_callback);
						xhr.send();
						xhr = null;
						//그래프 데이터 가지고오기 끝

						//이벤트 테이블 데이터 가지고오기 시작
						var xhr2 = new XMLHttpRequest();
						xhr2.open("GET", "./eventTable.php?ime="+
						<?php
						if(count($ime) ==0)
						{
							echo "-";
						}
						else
						{
							echo $ime;
						}
						?>+"&id="+event_id);
						xhr2.addEventListener("load", ajax_callback_table);
						xhr2.send();
						xhr2 = null;
						//이벤트 테이블 데이터 가지고오기 끝
					}


					function ajax_callback(e) {
			 			var i;
						var xhr = e.target;
						//alert(lineChartData.datasets[0].data[7]);
						var array = JSON.parse(xhr.responseText);
						
						if(array != null)
						{
							if (lineChartData.datasets.length > 0) {
								for(i =0; i < array.length; i ++)
								{
								lineChartData.datasets[0].data.pop();
								lineChartData.datasets[1].data.pop(); 
								lineChartData.labels.pop();
								}
								for(i =0; i < array.length; i ++)
								{
								lineChartData.datasets[0].data.push((array[i][3])/10);
								lineChartData.datasets[1].data.push(array[i][4]); 
								lineChartData.labels.push(array[i][5]);
								}
							window.myLine.update();
							id_temp = id_temp +1;
							}
						}
					}


					function ajax_callback_table(e) {
			 			var i;
						var xhr = e.target;
						var array = JSON.parse(xhr.responseText);
						///

						var stock_table = document.getElementById('stock_table'); 
						var stock_thead = document.getElementById('stock_thead'); 
						var stock_tbody = document.getElementById('stock_tbody'); 
						var stock_tr = null; 
						var stock_td = null; 
						var stock_x = 0; 
						//var stock_y = 0; 
						var msg = document.getElementById('msg'); 

						if(array != null){
							event_id=array[0][0];
						}
							if(array != null)
							{
								for(i =0; i<array.length; i++)
								{
									stock_tbody.deleteRow( stock_tbody.rows.length-1 );
									//array의 내용이 있다면 기본 테이블 내용을 지우고 다시 작성
								}
								
								for(i =0; i<array.length; i ++)
								{
									// 행 제목 추가 
									stock_tr = document.createElement('tr'); 
									stock_tbody.appendChild(stock_tr); 
									stock_td = document.createElement('td'); 
									stock_td.setAttribute('height', '20'); 
									stock_td.setAttribute('bgcolor', 'white'); 
									stock_td.setAttribute('align', 'center'); 
									stock_td.innerHTML=array[i][4];
									stock_tr.appendChild(stock_td); 
									//stock_y++; 

									// 열의 갯수에 따라 추가된 행의 열 추가 
									var stock_thead_td = stock_thead.getElementsByTagName('td'); 

									for (j=0; j<stock_thead_td.length-1; j++) 
									{ 
										stock_td = document.createElement('td'); 
										stock_td.setAttribute('height', '20'); 
										stock_td.setAttribute('bgcolor', 'white'); 
										stock_td.setAttribute('align', 'center'); 
										stock_td.innerHTML=array[i][j+2];
										stock_tr.appendChild(stock_td); 
									} 

								}//for(i =0; i<array.length; i ++)
							}	
					}
		}; //window.onload = function()


		
	</script>
</body>
</html>

<?php
require_once 'footer.php';
?>