<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<!--<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">-->
<title>Charts</title>
<link rel="stylesheet" type="text/css" href="/elmecpq2/extjs/resources/css/ext-all.css" />

    <!-- GC -->
 	<!-- LIBS -->
 	<script type="text/javascript" src="/elmecpq2/extjs/adapter/ext/ext-base.js"></script>
 	<!-- ENDLIBS -->

    <script type="text/javascript" src="/elmecpq2/js/ext-all.js"></script>
    <script type="text/javascript" src="/elmecpq2/js/adapter-extjs.js"></script>
    <script type="text/javascript" src="/elmecpq2/js/highcharts.src.js"></script>
    <script type="text/javascript" src="/elmecpq2/js/modules/exporting.src.js"></script>
    
    <!--[if IE]><script type="text/javascript" src="/elmecpq2/js/excanvas.compiled.js"></script><![endif]-->
    <script type="text/javascript" src="/elmecpq2/js/Ext.ux.HighChart.js"></script>


    <!-- Common Styles for the examples -->
    <link rel="stylesheet" type="text/css" href="/elmecpq2/extjs/shared/examples.css" />

    <style type="text/css">
	body{
			/*background:url(/elmecpq2/extjs/resources/images/default/gradient-bg.gif) top repeat-x;*/	
		}
    .chart {
        background-image: url(chart.gif) !important;
    }
	
	a{ color:#187bb1; outline:none}
	a:hover{text-decoration:none; }
    </style>
</head>
<body>
<script type="text/javascript" src="/elmecpq2/extjs/shared/examples.js"></script><!-- EXAMPLES -->


        <script>
            var chart;
            Ext.onReady(function(){
                chart = new Ext.ux.HighChart({
                    loadMask:true,
                    renderTo: 'container1',
                    xField: 'type',
                    height: 450,
                    width: 800,
                    chartConfig:{
                    chart: {
                	 	margin: [50, 50, 60, 80],
                	 	defaultSeriesType: 'line',
                	 	zoomType: 'xy'                	 	
                    },
                    credits: {
                        enabled: false
                    },
                    title: {
                        	text: 'Load Profile Chart'
                    },
                    subtitle: {
                        text: 'Click and drag in the plot area to zoom in'
                    },
                    xAxis: {
                        type: 'datetime',
                        maxZoom: 12 * 3600000 // 12 hours
                    },
                    yAxis: {
                        title: {
                            text: 'Metric Value'
                        },
                        plotLines: [{
                            value: 0,
                            width: 1,
                            color: '#808080'
                         }]              
                    },
                    tooltip: {
                        formatter: function() {
                            return '<b>'+ (this.series.name) +'</b><br/>'+
                            	this.point.name + ':<br/>'+
                                'Metric Value = '+ Highcharts.numberFormat(this.y, 2);
                        }
                    },
                    plotOptions: {
                        line: {
                            lineWidth: 1,
                            marker: {
                                enabled: false,
                                states: {
                                    hover: {
                                        enabled: true,
                                        radius: 3
                                    }
                                }
                            },
                            shadow: false,
                            states: {
                                hover: {
                                    lineWidth: 1
                                }
                            }
                        }
                    	}
                    },
                    series: [							
							    {
							         name: 'KWh',
							         data: [
									         <?php $i = 0; 
										         	foreach ($data as $value) { 
										         		if ($i == 0) {
										         			echo("[\"". $value['date'] ."\",".$value['kwh']."]");
																													
										         		}else{
										         			echo(",[\"". $value['date'] ."\",".$value['kwh']."]");	
										         		}
										         		$i++; 
										         	}
									         	?>
									         ],
									pointStart: Date.UTC(<?php echo($startdate);?>),
									pointInterval: 15 * 60 * 1000 // 15 min
							      },{
								         name: 'KVAh',
								         data: [
										         <?php $i = 0; 
											         	foreach ($data as $value) { 
											         		if ($i == 0) {
											         			echo("[\"". $value['date'] ."\",".$value['kvah']."]");														
											         		}else{
											         			echo(",[\"". $value['date'] ."\",".$value['kvah']."]");	
											         		}
											         		$i++; 
											         	}
										         	?>
										         ],
										pointStart: Date.UTC(<?php echo($startdate);?>),
										pointInterval: 15 * 60 * 1000 // 15 min
							      },{
								         name: 'Volt PH 1',
								         data: [
										         <?php $i = 0; 
											         	foreach ($data as $value) { 
											         		if ($i == 0) {
											         			echo("[\"". $value['date'] ."\",".$value['Vavg1']."]");														
											         		}else{
											         			echo(",[\"". $value['date'] ."\",".$value['Vavg1']."]");	
											         		}
											         		$i++; 
											         	}
										         	?>
										         ],
										pointStart: Date.UTC(<?php echo($startdate);?>),
										pointInterval: 15 * 60 * 1000 // 15 min
							      },{
								         name: 'Volt PH 2',
								         data: [
										         <?php $i = 0; 
											         	foreach ($data as $value) { 
											         		if ($i == 0) {
											         			echo("[\"". $value['date'] ."\",".$value['Vavg2']."]");														
											         		}else{
											         			echo(",[\"". $value['date'] ."\",".$value['Vavg2']."]");	
											         		}
											         		$i++; 
											         	}
										         	?>
										         ],
										pointStart: Date.UTC(<?php echo($startdate);?>),
										pointInterval: 15 * 60 * 1000 // 15 min
							      },{
								         name: 'Volt PH 3',
								         data: [
										         <?php $i = 0; 
											         	foreach ($data as $value) { 
											         		if ($i == 0) {
											         			echo("[\"". $value['date'] ."\",".$value['Vavg3']."]");														
											         		}else{
											         			echo(",[\"". $value['date'] ."\",".$value['Vavg3']."]");	
											         		}
											         		$i++; 
											         	}
										         	?>
										         ],
										pointStart: Date.UTC(<?php echo($startdate);?>),
										pointInterval: 15 * 60 * 1000 // 15 min
							      }
//							    ----  								
								
                          ]
                })
            });
        </script>

<div id="container1" style="width: 800px; height: 450px">
</div>

</body>
</html>
