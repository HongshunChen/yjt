<?php if(!$this->tpl_var['userhash']){ ?>
<?php $this->_compileInclude('header'); ?>
<body>
<?php $this->_compileInclude('nav'); ?>
<div class="container-fluid">
	<div class="row-fluid">
		<div class="span2">
			<?php $this->_compileInclude('menu'); ?>
		</div>
		<div class="span10" id="datacontent">
<?php } ?>
			<ul class="breadcrumb">
				<li><a href="index.php?<?php echo $this->tpl_var['_app']; ?>-master"><?php echo $this->tpl_var['apps'][$this->tpl_var['_app']]['appname']; ?></a> <span class="divider">/</span></li>
				
				<li class="active">课程回收站管理 </li>
				
			</ul>
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#">课程回收管理</a>
				</li>
				
			</ul>
	        <table class="table table-hover" style="width:85%">
	            <thead>
	                <tr>
	                    <th>课程ID</th>
						<th>课程名称</th>
						<th>主讲名师</th>
						<th>发布时间</th>
						<th>操作</th>
	                </tr>
	            </thead>
	            <tbody>
                   
                   <?php $cid = 0;
 foreach($this->tpl_var['pages']['data'] as $key => $val){ 
 $cid++; ?>
					<tr>
				
						<td><?php echo $val['courseid']; ?></td>
						<td><?php echo $val['coursename']; ?></td>
						<td><?php echo $val['courseusername']; ?></td>
						<td><?php echo date('Y-m-d H:i:s',$val['coursetime']); ?></td>
						<td>
			          		<div class="btn-group">
								<a class="btn ajax" href="index.php?vedio-master-recyle-regaincourse&catid=<?php echo $val['courseid']; ?>" title="恢复该课程"><em class="icon-edit"></em></a>
								<a class="btn ajax" href="index.php?vedio-master-recyle-deecourse&catid=<?php echo $val['courseid']; ?>" title="删除"><em class="icon-remove"></em></a>
							</div>
			          	</td>

					</tr>
					<?php } ?>
				
	        	</tbody>
	        </table>
	         <div class="pagination pagination-right">
			            <ul><?php echo $this->tpl_var['pages']['pages']; ?></ul>
			        </div>

		</div>
	</div>
</div>
</body>
</html>
