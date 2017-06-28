<div id=tabs-wrapper class="clear-block"> 
<ul class="tabs primary">
	<ul class="tabs primary">
		<li  class="active">
			<span>
				<span>
					<?php echo $html->link(__('Power Quality Statistics', true), array('controller' => 'powerqs', 'action' => 'index')); ?>
				</span>
			</span>
		</li>
	</ul>
</ul>
</div>
			
		<script>
			function showhide(id){
		//		if (document.getElementById){
					obj = document.getElementById(id);
					if (obj.style.display == "none"){
						obj.style.display = "block";
					} else {
						obj.style.display = "none";
					}
		//		}
			}
		</script> 
		<!-- 
		<div id="cont-col" class="ind-top">
			<div class="ind">
				<div class="border-left2">
					<div class="border-right2">	
						<div class="border-top2">
							<div class="border-bot2">	
								<div class="corner-top-left2">	
									<div class="corner-top-right2">	
										<div class="corner-bot-left2">	
											<div class="corner-bot-right2">	
												<div class="inner">
													<div id="dataContent" class="node">
			-->											
<!--						table content								-->
											
<iframe id="blockrandom"
    name="iframe"
    src="powerqs/report"
    width="1203"
    height="535"
    scrolling="auto"
    frameborder="0">
    This option will not work correctly. Unfortunately, your browser does not support inline frames.                   
</iframe>

   	
														
<!--						end table content								-->
													<!-- 	
													</div>
												</div>
											</div>											
										</div>												
									</div>											
								</div>					
							</div>	
						</div>
					</div>						
				</div>
			</div>
		</div>
		 -->
<div class="clear"></div>