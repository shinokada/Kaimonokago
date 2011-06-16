<?php 
if (isset($analytics_error)){
    echo $analytics_error;
}  elseif  (isset($analytic_visits) OR isset($analytic_views)){
  
    ?>

<script type="text/javascript">

	jQuery(function($) {
		var visits = <?php echo isset($analytic_visits) ? $analytic_visits : 0; ?>;
		var views = <?php echo isset($analytic_views) ? $analytic_views : 0; ?>;

		$('#analytics').css({
			height: '300px',
			width: '95%'
		});

		$.plot($('#analytics'), [{ label: 'Visits', data: visits },{ label: 'Page views', data: views }], {
			lines: { show: true },
			points: { show: true },
			grid: { hoverable: true, backgroundColor: '#fffaff' },
			series: {
				lines: { show: true, lineWidth: 1 },
				shadowSize: 0
			},
			xaxis: { mode: "time" },
			yaxis: { min: 0},
			selection: { mode: "x" }
		});

		function showTooltip(x, y, contents) {
			$('<div id="tooltip">' + contents + '</div>').css( {
				position: 'absolute',
				display: 'none',
				top: y + 5,
				left: x + 5,
				border: '1px solid #fdd',
				padding: '2px',
				'background-color': '#fee',
				opacity: 0.80
			}).appendTo("body").fadeIn(200);
		}

		var previousPoint = null;

		$("#analytics").bind("plothover", function (event, pos, item) {
			$("#x").text(pos.x.toFixed(2));
			$("#y").text(pos.y.toFixed(2));

				if (item) {
					if (previousPoint != item.dataIndex) {
						previousPoint = item.dataIndex;

						$("#tooltip").remove();
						var x = item.datapoint[0],
							y = item.datapoint[1];

						showTooltip(item.pageX, item.pageY,
									item.series.label + " : " + y);
					}
				}
				else {
					$("#tooltip").remove();
					previousPoint = null;
				}
		});

	});
</script>

<div id="analytics" class="line" style="padding-bottom: 10px"></div>

<?php
}
?>