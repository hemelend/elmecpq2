
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
	
	/*!
	 * Ext JS Library 3.3.0
	 * Copyright(c) 2006-2010 Ext JS, Inc.
	 * licensing@extjs.com
	 * http://www.extjs.com/license
	 */
	Ext.onReady(function(){
	    // second tabs built from JS
	    var tabs2 = new Ext.TabPanel({
	        renderTo: document.body,
	        deferredRender: true,
	        activeTab: 0,
	        width:1200,
	        height:650,
	        plain:true,
	        defaults:{autoScroll: true},
	        items:[{
	                title: 'Trend Grid',
	                autoLoad: {url: '../gridmetrics', params: 'foo=bar&wtf=1'}
	            },{
	                title: 'Trend Chart',
	                autoLoad: {url: '../chart', params: 'foo=bar&wtf=1'}
	            },{
	                title: 'Event Grid',
	                autoLoad: {url: '../eventmetrics', params: 'foo=bar&wtf=1'}
	            },{
	                title: 'Event Chart',
	                autoLoad: {url: '../itic_chart', params: 'foo=bar&wtf=1'}
	            },{
	                title: 'Histogram',
	                autoLoad: {url: '../histogram', params: 'foo=bar&wtf=1'}
	            },{
	                title: 'Load Profile',
	                autoLoad: {url: '../loadprofile', params: 'foo=bar&wtf=1'}
	            }
	        ]
	    });
	});
	
	</script>
	</head>
	<body onLoad="init()"></body>
	</html>                  

