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
                    height: 450,
                    width: 800,
                    xField: 'type',
                    chartConfig:{
                    chart: {
                	 	margin: [50, 50, 60, 80],
                	 	defaultSeriesType: 'column',
                	 	zoomType: 'xy'              	 	
                    },
                    credits: {
                        enabled: false
                    },
                    title: {
                        	text: 'Class Histogram'
                    },
                    subtitle: {
                        text: 'Click and drag in the plot area to zoom in'
                    },
                    xAxis: {
                        categories: [
                                     'A', 
                                     'B', 
                                     'C', 
                                     'D', 
                                     'E', 
                                     'F', 
                                     'G'
                                  ]
                    },
                    legend: {
                        layout: 'vertical',
                        backgroundColor: '#FFFFFF',
                        align: 'left',
                        verticalAlign: 'top',
                        x: 100,
                        y: 70
                     },
                                   
                    yAxis: {
//                        title: {
//                            text: 'Porcentaje Voltage Nominal(120 Vrms)'
//                        },
//                        plotLines: [{
//                            value: 0,
//                            width: 1,
//                            color: '#808080'
//                         }]     
                        min: 0,
                        title: {
                           text: 'Numbers of data'
                        }
                    },
                    tooltip: {
                        formatter: function() {
                            return '<b>'+ (this.series.name) +'</b><br/>'+
                            	'Class '+ this.x + '<br/>'+
                                'Ocurriences '+ this.y;
                        }
                    },
                    plotOptions: {
                        series: {
                        	pointPadding: 0.2,
                        	borderWidth: 0,
                        	borderColore: '#303030'
                     		}
                    	}
                    },
                    series: [
//							----
							<?php $ph = 1;foreach ($histdata as $phase) { if ($ph != 1) {
								echo ",";
							}?>
						    {
						         name: 'Phase <?php echo $ph;?>',
						         data: [
								         <?php $i = 0; 
									         	foreach ($phase as $value) { 
									         		if ($i == 0) {
									         			echo($value);														
									         		}else{
									         			echo(",".$value);	
									         		}
									         		$i++; 
									         	}
								         	?>
								         ],
					         		visible: false
						      }
							<?php $ph++;}?>
//						    ----  
						    ]
                })
            });
        </script>

<div id="container1" style="width: 800px; height: 450px">
</div>

</body>
</html>
