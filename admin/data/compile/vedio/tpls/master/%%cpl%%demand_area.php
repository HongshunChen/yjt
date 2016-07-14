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
				<li><a href="#">课程管理</a> <span class="divider">/</span></li>
				<li class="active">课程分类</li>
				
			</ul>
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#">管理分类</a>
				</li>
				<li class="pull-right">
					<a href="index.php?vedio-master-demand-addarea">添加分类</a>
				</li>
			</ul>
			 <table class="table table-hover" style="width:75%">
	            <thead>
	                <tr>
	                    <th>类型ID</th>
						<th>视频分类</th>
						<th>父级ID</th>
						<th>操作</th>
	                </tr>
	            </thead>
	            <tbody>
                   	<?php $key = 0;
 foreach($this->tpl_var['cat'] as $key => $val){ 
 $key++; ?>
                   	<?php if($val['catpid'] ==0){ ?>
					<tr>
				
						<td><?php echo $val['catid']; ?></td>
						<td><?php echo $val['catname']; ?></td>
					
						
						
						<td><?php echo $val['catpid']; ?></td>
					
							
						
						<td>
			          		<div class="btn-group">
			          		
			          		<a class="btn" href="index.php?vedio-master-demand-addarea_fenlei&catid=<?php echo $val['catid']; ?>" title="增加下级分类"><em class="icon-pencil"></em></a>
								<a class="btn" href="index.php?vedio-master-demand-editarea&catid=<?php echo $val['catid']; ?>" title="修改"><em class="icon-edit"></em></a>
								<a class="btn ajax" href="index.php?vedio-master-demand-deearea&catid=<?php echo $val['catid']; ?>" title="删除"><em class="icon-remove"></em></a>
							</div>
			          	</td>

					</tr>
					<?php } ?>
					<?php } ?>
					<?php $key = 0;
 foreach($this->tpl_var['cat'] as $key => $val){ 
 $key++; ?>
                   	<?php if($val['catpid'] !=0){ ?>
						<tr>
				
						<td><?php echo $val['catid']; ?></td>
						<td><?php echo $val['catname']; ?></td>
					
						
						
						<td><?php echo $val['catpid']; ?></td>
					
							
						
						<td>
			          		<div class="btn-group">
			          		
								<a class="btn" href="index.php?vedio-master-demand-editarea&catid=<?php echo $val['catid']; ?>" title="修改"><em class="icon-edit"></em></a>
								<a class="btn ajax" href="index.php?vedio-master-demand-deearea&catid=<?php echo $val['catid']; ?>" title="删除"><em class="icon-remove"></em></a>
							</div>
			          	</td>

					</tr>

					<?php } ?>
				<?php } ?>
	        	</tbody>
	        </table>
	       
	        <div class="pagination pagination-right">
        		<ul></ul>
	        </div>

		</div>
	</div>
</div>
</body>
</html>
