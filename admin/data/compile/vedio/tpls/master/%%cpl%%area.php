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
				<li><a href="index.php?<?php echo $this->tpl_var['_app']; ?>-master">全局</a> <span class="divider">/</span></li>
				<li><a href="index.php?<?php echo $this->tpl_var['_app']; ?>-master-demand-vedio">视频分类</a> <span class="divider">/</span></li>
				
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
	                    <th>题型ID</th>
						<th>题型</th>
						<th>题型分类</th>
						<th>操作</th>
	                </tr>
	            </thead>
	            <tbody>
                   	<?php $key = 0;
 foreach($this->tpl_var['cat'] as $key => $val){ 
 $key++; ?>
					<tr>
				
						<td><?php echo $val['catid']; ?></td>
						<td><?php echo $val['catname']; ?></td>
						<td><?php echo $val['catparent']; ?></td>
						<td>
			          		<div class="btn-group">
								<a class="btn" href="index.php?vedio-master-demand-editarea&catid=<?php echo $val['catid']; ?>" title="修改"><em class="icon-edit"></em></a>
								<a class="btn ajax" href="index.php?vedio-master-demand-deearea&catid=<?php echo $val['catid']; ?>" title="删除"><em class="icon-remove"></em></a>
							</div>
			          	</td>

					</tr>
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
