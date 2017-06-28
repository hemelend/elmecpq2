<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Metrics Grid</title>

	    <!-- ** CSS ** -->
    <!-- base library -->
    <link rel="stylesheet" type="text/css" href="/elmecpq2/extjs/resources/css/ext-all.css" />

    <!-- overrides to base library -->
    <link rel="stylesheet" type="text/css" href="/elmecpq2/extjs/ux/gridfilters/css/GridFilters.css" />
    <link rel="stylesheet" type="text/css" href="/elmecpq2/extjs/ux/gridfilters/css/RangeMenu.css" />

    <!-- page specific -->
    <link rel="stylesheet" type="text/css" href="/elmecpq2/extjs/shared/examples.css" />

	<style type="text/css">
    </style>

    <!-- ** Javascript ** -->
    <!-- ExtJS library: base/adapter -->
    <script type="text/javascript" src="/elmecpq2/extjs/adapter/ext/ext-base.js"></script>

    <!-- ExtJS library: all widgets -->
    <script type="text/javascript" src="/elmecpq2/js/ext-all.js"></script>

    <!-- overrides to base library -->

    <!-- extensions -->
	<script type="text/javascript" src="/elmecpq2/extjs/ux/gridfilters/menu/RangeMenu.js"></script>
	<script type="text/javascript" src="/elmecpq2/extjs/ux/gridfilters/menu/ListMenu.js"></script>
	
	<script type="text/javascript" src="/elmecpq2/extjs/ux/gridfilters/GridFilters.js"></script>
	<script type="text/javascript" src="/elmecpq2/extjs/ux/gridfilters/filter/Filter.js"></script>
	<script type="text/javascript" src="/elmecpq2/extjs/ux/gridfilters/filter/StringFilter.js"></script>
	<script type="text/javascript" src="/elmecpq2/extjs/ux/gridfilters/filter/DateFilter.js"></script>
	<script type="text/javascript" src="/elmecpq2/extjs/ux/gridfilters/filter/ListFilter.js"></script>
	<script type="text/javascript" src="/elmecpq2/extjs/ux/gridfilters/filter/NumericFilter.js"></script>
	<script type="text/javascript" src="/elmecpq2/extjs/ux/gridfilters/filter/BooleanFilter.js"></script>

    <!-- page specific -->
<!--    <script type="text/javascript" src="/elmecpq2/extjs/shared/examples.js"></script>-->
    <script type="text/javascript" src="/elmecpq2/extjs/ux/RowExpander.js"></script>
	
	<style>
        body .x-panel {
            margin-bottom:20px;
        }
        .icon-grid {
            background-image:url(/elmecpq2/extjs/shared/icons/fam/grid.png) !important;
        }
        #button-grid .x-panel-body {
            border:1px solid #99bbe8;
            border-top:0 none;
        }
        .add {
            background-image:url(/elmecpq2/img/report3.png) !important;
        }
        .option {
            background-image:url(/elmecpq2/img/search_16.png) !important;
        }
        .remove {
            background-image:url(/elmecpq2/img/excel.png) !important;
        }
        .save {
            background-image:url(/elmecpq2/extjs/shared/icons/save.gif) !important;
        }	
		a{ color:#187bb1; outline:none}
		a:hover{text-decoration:none; }
	</style>
</head>

<body>
<div id="grid-example" style="margin: 10px;"></div>

	<script>
	/*!
	 * Ext JS Library 3.1.0
	 * Copyright(c) 2006-2009 Ext JS, LLC
	 * licensing@extjs.com
	 * http://www.extjs.com/license
	 */

	Ext.onReady(function(){

	    Ext.QuickTips.init();

	    var xg = Ext.grid;

	    var store = new Ext.data.GroupingStore({
			proxy: new Ext.data.HttpProxy({
				url:'event_rawdata'
			}),
			
			reader: new Ext.data.JsonReader({
				//id:   'id',
				totalProperty: 'total',
				root: 'data'
			}, Ext.data.Record.create([
			     {name:'datetime'}
				,{name:'cycle'}
				,{name:'type'}
				,{name:'phase'}
				,{name:'duration'}
				,{name:'volttrigger'}
				,{name:'vrms'}
				,{name:'vavg'}
				,{name:'irms'}
				,{name:'iavg'}
				])),
			
			sortInfo: {field:'datetime', direction:'ASC'},
			groupField: 'phase',
			remoteSort: true
				});

		store.load();

		var filters = new Ext.ux.grid.GridFilters({
	        // encode and local configuration options defined previously for easier reuse
	        encode: true, // json encode the filter query
	        local: true,   // defaults to false (remote filtering)
	        filters: [
	                  {type:'string', dataIndex:'datetime'}
						,{type:'numeric', dataIndex:'cycle'}
						,{type:'string', dataIndex:'type'}
						,{type:'numeric', dataIndex:'phase'}
						,{type:'numeric', dataIndex:'duration'}
						,{type:'numeric', dataIndex:'volttrigger'}
						,{type:'numeric', dataIndex:'vrms'}
						,{type:'numeric', dataIndex:'vavg'}
						,{type:'numeric', dataIndex:'irms'}
						,{type:'numeric', dataIndex:'iavg'}
					 ]
	    });  

	    // shared reader
	    var reader = new Ext.data.ArrayReader({}, [
				{name:'datetime'}                    	    
				,{name:'cycle'}
				,{name:'type'}
				,{name:'phase'}
				,{name:'duration'}
				,{name:'volttrigger'}
				,{name:'vrms'}
				,{name:'vavg'}
				,{name:'irms'}
				,{name:'iavg'}
	    ]);

	    ////////////////////////////////////////////////////////////////////////////////////////
	    // Grid 1
	    ////////////////////////////////////////////////////////////////////////////////////////

	    var pager = new Ext.PagingToolbar({
	    	store: store,
	    	plugins: filters,
	    	displayInfo: true,
	    	displayMsg: '{0} - {1} of {2} Rows',
	    	emptyMsg: 'No Events to display',
	    	pageSize: 30
	    });

	    var grid1 = new xg.GridPanel({
	    	store: store,
	    	view: new Ext.grid.GroupingView(
	    			{	forceFit: true,
	    	    		startCollapsed: true,
	    	    		groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Events" : "Event"]})'
		    	    }
	    	    	),	
	    	columns: [
	    	          {header:'Datetime', dataIndex:'datetime', width:120,sortable: true}
						,{header:'Cycle', dataIndex:'cycle', width:70,sortable: true}
						,{header:'Type', dataIndex:'type', width:60,sortable: true}
						,{header:'Phase', dataIndex:'phase', width:50,sortable: true}
						,{header:'Duration', dataIndex:'duration', width:90,sortable: true}
						,{header:'Volt Trigger', dataIndex:'volttrigger', width:90,sortable: true}
						,{header:'Volt rms', dataIndex:'vrms', width:90,sortable: true}
						,{header:'Volt avg', dataIndex:'vavg', width:90,sortable: true}
						,{header:'Curr rms', dataIndex:'irms', width:90,sortable: true}
						,{header:'Curr avg', dataIndex:'iavg', width:90,sortable: true}
		            ], 
	        bbar: pager,
	        tbar:[
	        {
	            text:'Export to Excel',
	            tooltip:'Export grid to excel file',
	            iconCls:'remove',
	            handler: function(){ window.location='export2xls';}
	        }],
	        stripeRows: true,      
	        plugins: [filters],
	        collapsible: false,
	        animCollapse: false,
	        iconCls: 'icon-grid',
	        renderTo: document.body
	    });

	    var win = new Ext.Window({
			layout: 'fit',
			width: 800,
			height:600,
			closable: false,
			maximized :  true,
			items: grid1
		});

		win.show();
		
	});		
	
	</script>
 
 </body>
</html>