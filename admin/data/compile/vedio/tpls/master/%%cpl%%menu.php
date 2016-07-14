<div class="accordion" id="accordion-13465">
	<div class="accordion-group">
		<div class="accordion-heading">
			<a class="accordion-toggle" data-parent="#accordion-13465" data-toggle="collapse" href="#accordion-element-707348">课程管理</a>
		</div>
		<div class="accordion-body<?php if($this->tpl_var['method'] == 'demand'){ ?> in<?php } ?> collapse" id="accordion-element-707348">
			<div class="accordion-inner">
				<ul class="unstyled">
					<!-- <li><a href="?<?php echo $this->tpl_var['_app']; ?>-master-demand-vedio">视频列表</a></li> -->
		    		<li><a href="?<?php echo $this->tpl_var['_app']; ?>-master-demand-area">课程分类</a></li>
		    		<li><a href="?<?php echo $this->tpl_var['_app']; ?>-master-demand-subject">视频列表</a></li>
		    		<li><a href="?<?php echo $this->tpl_var['_app']; ?>-master-demand-course">课程管理</a></li>
				</ul>
			</div>
		</div>
	</div>
	

	<div class="accordion-group">
		<div class="accordion-heading">
			<a class="accordion-toggle" data-parent="#accordion-13465" data-toggle="collapse" href="#accordion-element-212090">直播管理 </a>
		</div>
		<div class="accordion-body<?php if($this->tpl_var['method'] == 'seeding'){ ?> in<?php } ?> collapse" id="accordion-element-212090">
			<div class="accordion-inner">
				<ul class="unstyled">
					<li><a href="index.php?<?php echo $this->tpl_var['_app']; ?>-master-seeding">直播列表</a></li>
					
				</ul>
			</div>
		</div>
	</div>
	<div class="accordion-group">
		<div class="accordion-heading">
			<a class="accordion-toggle" data-parent="#accordion-13465" data-toggle="collapse" href="#accordion-element-212091">回收站</a>
		</div>
		<div class="accordion-body<?php if($this->tpl_var['method'] == 'recyle'){ ?> in<?php } ?> collapse" id="accordion-element-212091">
			<div class="accordion-inner">
				<ul class="unstyled">
					<li><a href="index.php?vedio-master-recyle-course">课程回收站</a></li>
					<li><a href="index.php?vedio-master-recyle-vedio">视频回收站</a></li>
					<li><a href="index.php?vedio-master-recyle-seeding">直播课程回收站</li>
					
				</ul>
			</div>
		</div>
	</div>
</div>