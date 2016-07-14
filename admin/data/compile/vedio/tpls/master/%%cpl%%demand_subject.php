<?php $this->_compileInclude('header'); ?>
<body>
<?php $this->_compileInclude('nav'); ?>
<div class="container-fluid">
	<div class="row-fluid">
		<div class="span2">
			<?php $this->_compileInclude('menu'); ?>
		</div>
		<div class="span10">
			<ul class="breadcrumb">
				<li><a href="index.php?<?php echo $this->tpl_var['_app']; ?>-master"><?php echo $this->tpl_var['apps'][$this->tpl_var['_app']]['appname']; ?></a> <span class="divider">/</span></li>
				<li><a href="#">课程管理</a> <span class="divider">/</span></li>
				<li class="active">视频列表 </li>
				
			</ul>
		
				<fieldset>
					<table class="table table-hover table-bordered">
						<thead>
							<tr>
								
						<th>视频ID</th>
						<th>视频名称</th>
						<th>视频时长</th>
						<th>视频vid</th>
						<th>上传时间</th>
							</tr>
						</thead>
						<tbody>
							<?php $cid = 0;
 foreach($this->tpl_var['pages']['data'] as $key => $val){ 
 $cid++; ?>
					<tr>
				
						<td><?php echo $val['videoid']; ?></td>
						<td><a title="查看视频" class="selfmodal" href="javascript:;" url="index.php?vedio-master-demand-detail&videoid=<?php echo $val['videoid']; ?>" data-target="#modal"><?php echo $val['videoname']; ?></a></td>
						<td><?php echo $val['duration']; ?></td>
						<td><?php echo $val['videovid']; ?></td>
						<td>
			          		2016-06-08
			          	</td>

					</tr>
					<?php } ?>
						
						</tbody>
					</table>
					
					<div class="pagination pagination-right">
						<ul><?php echo $this->tpl_var['pages']['pages']; ?></ul>
					</div>
				</fieldset>
			
			 <div aria-hidden="true" id="modal" class="modal hide fade" role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-header">
					<button aria-hidden="true" class="close" type="button" data-dismiss="modal">×</button>
					<h3 id="myModalLabel">
						订单详情
					</h3>
				</div>
				<div class="modal-body"></div>
				<div class="modal-footer">
					 <button aria-hidden="true" class="btn" data-dismiss="modal">关闭</button>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>