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
                            
		var myQueue = [
		       		<?php 
		       		$i = 0;
		       		foreach($customer_names as $row){
		       			if($i == 0){
		       		?>
		       				['<?php echo $row['Customer']['name']; ?>','<?php echo $row['Customer']['name']; ?>']
		       		<?php  }else{?>
		       				,['<?php echo $row['Customer']['name']; ?>','<?php echo $row['Customer']['name']; ?>']
			       	<?php }$i++;}?>
		       	];      
        
        var viewport = new Ext.Viewport({
            layout: 'border',
            items: [
            // create instance immediately
            new Ext.BoxComponent({
                region: 'north',
                height: 0, // give north and south regions a height
                autoEl: {
//                    tag: 'div',
//                    html:'<p><img src="../../css/images/san_usage.png" /></p>'
                }
            }), {
                // lazily created panel (xtype:'panel' is default)
                region: 'south',
                contentEl: 'custom-query',
                split: true,
                height: 0,
                collapsible: false,
                margins: '0 0 0 0'
            }, {
                region: 'west',
                title: 'PowerQuality Form',
                collapsible: true,
                split: true,
                width: 318, // give east and west regions a width
                margins: '0 5 0 0',
                layout: 'fit', // specify layout manager for items
                items:            // this TabPanel is wrapped by another Panel so the title will be applied
                	 new Ext.FormPanel({
                        labelWidth: 75, // label settings here cascade unless overridden
                        url:'report',
                        standardSubmit: true,
//                        update:'trend-data',
//                        waitMsgTarget: true,
                        frame:true,
                        id: 'formPanel',
//                        renderTo: 'formPanel',
//                        title: 'Simple Form',
                        bodyStyle:'padding:5px 5px 0',
                        width: 290,
                        defaults: {width: 290},
						defaultType: 'datefield',
					      items: [
					            new Ext.form.FieldSet({
					                autoHeight: true,
					                items: [
										new Ext.form.ComboBox({
									    	  fieldLabel: 'Customers',
									    	  width: 185,
											  store: myQueue,
											  name: 'customer_name',
									          typeAhead: true,
									          forceSelection: true,
				//					          triggerAction: 'all',
									          emptyText:'Select a customer...',
									          selectOnFocus:true,
									          allowBlank:false
									    }),
					                    new Ext.form.DateField({
					                        fieldLabel: 'Start Date',
					                        name: 'startdt',
					                        width:120,
					                        format:'Y-m-d',
					                        allowBlank:true
					                    }),
					                    new Ext.form.DateField({
					                        fieldLabel: 'End Date',
					                        name: 'enddt',
					                        width:120,
					                        format:'Y-m-d',
					                        allowBlank:true
					                    }),
					                    new Ext.form.CheckboxGroup({
					                        id:'myGroupPhases',
					                        name:'phases',
					                        xtype: 'checkboxgroup',
					                        fieldLabel: 'Phases',
					                        itemCls: 'x-check-group-alt',
					                        // Put all controls in a single column with width 100%
					                        allowBlank:false,
					                        items: [
					                            {boxLabel: '1', name: 'phase-1', checked: true},
					                            {boxLabel: '2', name: 'phase-2'},
					                            {boxLabel: '3', name: 'phase-3'}
					                        ]
					                    }),
					                    new Ext.form.CheckboxGroup({
					                        id:'myGroupMetrics',
					                        name:'metrics',
					                        xtype: 'checkboxgroup',
					                        fieldLabel: 'Metrics',
					                        itemCls: 'x-check-group-alt',
					                        // Put all controls in a single column with width 100%
					                        columns: 1,
					                        allowBlank:false,
					                        items: [
					                            {boxLabel: 'Voltage', name: 'Urms', checked: true},
					                            {boxLabel: 'Current', name: 'Irms'},
					                            {boxLabel: 'PowerFactor', name: 'PF'},
					                            {boxLabel: 'Harmonics', name: 'THD'},
					                            {boxLabel: 'Flickers', name: 'Plt'}
					                        ]
					                    })
					      ]})]			
						,
                        buttons: [{
                            text: 'Submit',
                            type: 'submit',
                            handler: function(){
								var form = Ext.getCmp('formPanel').getForm();
								if(form.isValid()){
									  form.submit({
				                            waitMsg:'Loading...',
				                            success: function(form,action) {
//												  Ext.Element.fly('trend-data').update(action.response.responseText,true);

//											    var msg = Ext.get("trend-data");
//											    msg.load({
//											      url: "http://localhost:8080/elmecpq2/powerqs", // <-- replace with your url
//											        params: "name=" + Ext.get('name').dom.value,
//											        text: "Updating..."
//											    });
//											    msg.show();	
//												  Ext.Updater.formupdate({
////													  form: 'formPanel',
//												        url: "test",
////												        params: {param1: "foo", param2: "bar"}, // or a URL encoded string
////												        callback: {el:'trend-data'}
////												        scope: yourObject, //(optional scope)
////												        discardUrl: true,
////												        nocache: true,
////												        text: "Loading...",
////												        timeout: 60,
////												        scripts: false // Save time by avoiding RegExp execution.
//												    });
												    
												    
//				                            	Ext.Ajax.request({
//				                            		   url: 'ajax_demo/sample.json',
//				                            		   success: function(response, opts) {
//				                            		      var obj = Ext.decode(response.responseText);
//				                            		      console.dir(obj);
//				                            		   },
//				                            		   failure: function(response, opts) {
//				                            		      console.log('server-side failure with status code ' + response.status);
//				                            		   }
//				                            		});
				                            },
				                            failure: function(form,action){
				                                Ext.MessageBox.alert('Error',action.response.responseText);
				                            }
				                        }
				                        );
									}
	                            }  
	                        }
                        ]
                    })            
            }, 
            // in this instance the TabPanel is not wrapped by another panel
            // since no title is needed, this Panel is added directly
            // as a Container
            new Ext.TabPanel({
                region: 'center', // a center region is ALWAYS required for border layout
                deferredRender: true,
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
			src="chart"
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
			src="gridmetrics"
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
			src="eventmetrics"
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
			src="itic_chart"
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
			src="histogram"
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
			src="loadprofile"
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
