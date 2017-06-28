<html>
<head>
  <title>Power Quality ELMEC Domains Portal</title>
  	<link rel="shortcut icon" href="/elmecpq2/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" type="text/css" href="/elmecpq2/extjs/resources/css/ext-all.css" />
    <link rel="shortcut icon" href="/elmecpq2/favicon.ico" type="image/x-icon" />
<!--    <script type="text/javascript" src="/elmecpq2/js/progress.js"></script> 	-->
    
    <style type="text/css">
    html, body {
        font:normal 12px verdana;
        margin:0;
        padding:0;
        border:0 none;
        overflow:hidden;
        height:100%;
    }
    p {
        margin:5px;
    }
    .settings {
        background-image:url(/elmecpq2/extjs/shared/icons/fam/folder_wrench.png);
    }
    .nav {
        background-image:url(/elmecpq2/extjs/shared/icons/fam/folder_go.png);
    }
    a{ color:#187bb1; outline:none}
	a:hover{text-decoration:none; }
    </style>

    <!-- GC -->
    <!-- LIBS -->
    <script type="text/javascript" src="/elmecpq2/extjs/adapter/ext/ext-base.js"></script>
    <!-- ENDLIBS -->

    <script type="text/javascript" src="/elmecpq2/js/ext-all.js"></script>

    <!-- EXAMPLES -->
    <script type="text/javascript" src="/elmecpq2/extjs/shared/examples.js"></script>
    
  
    <script type="text/javascript">
    Ext.onReady(function(){
    
        // NOTE: This is an example showing simple state management. During development,
        // it is generally best to disable state management as dynamically-generated ids
        // can change across page loads, leading to unpredictable results.  The developer
        // should ensure that stable state ids are set for stateful components in real apps.
        Ext.state.Manager.setProvider(new Ext.state.CookieProvider());   
        
        var viewport = new Ext.Viewport({
            layout: 'border',
            items: [
            // create instance immediately
            new Ext.BoxComponent({
                region: 'north',
                height: 0
                 // give north and south regions a height
//                autoEl: {
//                    tag: 'div',
//                    html:'<p><img src="../../css/images/san_usage.png" /></p>'
//                }
            }), {
                // lazily created panel (xtype:'panel' is default)
                region: 'south',
                contentEl: 'custom-query',
                split: true,
                height: 0,
                collapsible: false,
                margins: '0 0 0 0'
            },
            new Ext.TabPanel({
                region: 'center', // a center region is ALWAYS required for border layout
                deferredRender: true,
                xtype: 'tabpanel',
                activeTab: 0,     // first tab initially active
//                bbar: [
//                      	'->',
//               		{text: '<img src="../../resources/images/icons/img01.png" align="absmiddle" /> Low (Less than 30%)'},
//               		{text: '<img src="../../resources/images/icons/img02.png" align="absmiddle" /> Normal (Between 30% to 60%)'},     
//               	],
                items: [
                {
                    contentEl: 'trend-data',
                    title: 'Analysis',
                    autoScroll: true
                }, {
                    contentEl: 'chart-data',
                    title: 'Chart',
                    autoScroll: true
                }, {
                    contentEl: 'event-data',
                    title: 'Events',
                    autoScroll: true
                }, {
                    contentEl: 'itic-data',
                    title: 'EventChart',
                    autoScroll: true
                }, {
                    contentEl: 'histogram',
                    title: 'Histogram',
                    autoScroll: true
                }, {
                    contentEl: 'loadprofile',
                    title: 'Load Profile',
                    autoScroll: true
                }]
            })]
        });

   });
    </script>
    
<!--    <script type ="text/javascript">-->
<!--Ext.onReady(function(){-->
<!--  Ext.get('okButton').on('click', function(){-->
<!--    var msg = Ext.get("msg");-->
<!--    msg.load({-->
<!--      url: [server url], // <-- replace with your url-->
<!--        params: "name=" + Ext.get('name').dom.value,-->
<!--        text: "Updating..."-->
<!--    });-->
<!--    msg.show();-->
<!--  });-->
<!--});-->
<!--</script>-->
    
</head>
<body onLoad="init()">
<div id="loading" style="position:absolute; width:100%; text-align:center; top:195px;"><img src="/elmecpq2/img/loading.gif" border=0>
</div>
<script>
var ld=(document.all);
var ns4=document.layers;
var ns6=document.getElementById&&!document.all;
var ie4=document.all;
if (ns4)
ld=document.loading;
else if (ns6)
ld=document.getElementById("loading").style;
else if (ie4)
ld=document.all.loading.style;
function init()
{
if(ns4){ld.visibility="hidden";}
else if (ns6||ie4) ld.display="none";
}
</script>

    <!-- use class="x-hide-display" to prevent a brief flicker of the content -->
    
   <div id="chart-data" class="x-hide-display">  
        <iframe id="blockrandom"
		    name="iframe"
			src="../chart"
		    width="100%"
		    height="100%"
		    scrolling="auto"
		    frameborder="0">
		    This option will not work correctly. Unfortunately, your browser does not support inline frames.                   
		</iframe>
    </div>

	<div id="trend-data" class="x-hide-display">  
        <iframe id="blockrandom"
		    name="iframe"
			src="../gridmetrics"
		    width="100%"
		    height="100%"
		    scrolling="auto"
		    frameborder="0">
		    This option will not work correctly. Unfortunately, your browser does not support inline frames.                   
		</iframe>
    </div>
    
	<div id="event-data" class="x-hide-display">
        <iframe id="blockrandom"
		    name="iframe"
			src="../eventmetrics"
		    width="100%"
		    height="100%"
		    scrolling="auto"
		    frameborder="0">
		    This option will not work correctly. Unfortunately, your browser does not support inline frames.                
		</iframe>
    </div>
    
	<div id="itic-data" class="x-hide-display">
        <iframe id="blockrandom"
		    name="iframe"
			src="../itic_chart"
		    width="100%"
		    height="100%"
		    scrolling="auto"
		    frameborder="0">
		    This option will not work correctly. Unfortunately, your browser does not support inline frames.                   
		</iframe>	
    </div>
    
    <div id="histogram" class="x-hide-display">
        <iframe id="blockrandom"
		    name="iframe"
			src="../histogram"
		    width="100%"
		    height="100%"
		    scrolling="auto"
		    frameborder="0">
		    This option will not work correctly. Unfortunately, your browser does not support inline frames.                   
		</iframe>	
    </div>
    <div id="loadprofile" class="x-hide-display">
        <iframe id="blockrandom"
		    name="iframe"
			src="../loadprofile"
		    width="100%"
		    height="100%"
		    scrolling="auto"
		    frameborder="0">
		    This option will not work correctly. Unfortunately, your browser does not support inline frames.                   
		</iframe>	
    </div>

    <div id="custom-query" class="x-hide-display">
    </div>

    <div id="props-panel" class="x-hide-display" style="width:200px;height:200px;overflow:hidden;">
    </div>
    
    <div id="south" class="x-hide-display">
        <p>south - generally for informational stuff, also could be for status bar</p>
    </div>
</body>
</html>
