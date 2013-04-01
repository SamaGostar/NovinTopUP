<?php if(isset($transactions) && !empty($transactions)): ?>
<?php $this->Html->script('amcharts.min', array('inline' => false)); ?>
<?php foreach($transactions as $key => $value){
	      $value['Transaction']['created_date'] = $this->Persiandate->pdate('m/d', strtotime($value['Transaction']['created_date']));
          $trans[$key] = $value['Transaction'] ;
	  }
	  $trans = json_encode($trans);
?>
<script type="text/javascript">
            var chart;
			
            var chartData = <?php echo $trans; ?>

            AmCharts.ready(function () {

					chart = new AmCharts.AmSerialChart();
					chart.zoomOutButton = {backgroundColor: '#000000',backgroundAlpha: 0.15};
					chart.dataProvider = chartData;
					chart.marginTop = 10;
					chart.categoryField = "created_date";
					var categoryAxis = chart.categoryAxis;
					categoryAxis.gridAlpha = 0.07;
					categoryAxis.axisColor = "#DADADA";
					categoryAxis.startOnAxis = false;
					var valueAxis = new AmCharts.ValueAxis();
					valueAxis.stackType = "regular"; // this line makes the chart "stacked"
					valueAxis.gridAlpha = 0.1;
					valueAxis.title = "نمودار فروش هفته";
					chart.addValueAxis(valueAxis);
					
					var graph = new AmCharts.AmGraph();
                    graph.valueField = "total_amount";
                    graph.balloonText = "[[category]] : [[value]]";
                    graph.type = "column";
                    graph.lineAlpha = 0.8;
                    graph.fillAlphas = 0.9;
					graph.lineThickness = 0;
					graph.pointPosition = "middle";
					graph.lineColor = '#a71411';
                    chart.addGraph(graph);
					
					chart.write("Chart");
		});
	</script>
<?php endif; ?>
<h2 class="h2title">آمار فروش</h2>
<p class="Tdescrip">در این قسمت می توانید میزان فروش هقته را بروی نمودار مشاهده فرمائید .</p>
<div class="main-box">
		<div id="Chart" style="width:100%; height:300px; direction:ltr;"></div>
</div>
