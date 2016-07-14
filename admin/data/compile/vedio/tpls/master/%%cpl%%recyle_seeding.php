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
				<li><a href="index.php?core-master"><?php echo $this->tpl_var['apps'][$this->tpl_var['_app']]['appname']; ?></a> <span class="divider">/</span></li>
				<li class="active">直播课程回收站列表</li>
			</ul>
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#">直播课程列表</a>
				</li>
				
			</ul>
			<fieldset>
					<table class="table table-hover table-bordered">
						<thead>
							<tr>
								
						<th width="5%" >课程ID</th>
						<th>直播课程名称</th>
						<th>课程价格</th>
						<th>截止时间</th>
						<th>上传时间</th>
						<th>操作</th>
							</tr>
						</thead>
						<tbody>
							<?php $cid = 0;
 foreach($this->tpl_var['pages']['data'] as $key => $val){ 
 $cid++; ?>
					<tr>
				
						<td><?php echo $val['vid']; ?></td>
						<td><a title="查看视频" class="selfmodal" href="javascript:;" url="index.php?vedio-master-seeding-detail&videoid=<?php echo $val['vid']; ?>" data-target="#modal"><?php echo $val['vname']; ?></a></td>
						<td><?php echo $val['vprice']; ?></td>
						<td><?php echo date('Y-m-d H:i:s',$val['endtime']); ?></td>
						<td>
						<?php echo date('Y-m-d H:i:s',$val['createtime']); ?>
			          	</td>
						<td>
							<a class="btn ajax" href="index.php?vedio-master-recyle-regainseeding&catid=<?php echo $val['vid']; ?>" title="恢复"><em class="icon-edit"></em></a>
								<a class="btn ajax" href="index.php?vedio-master-recyle-deletseeding&catid=<?php echo $val['vid']; ?>" title="删除"><em class="icon-remove"></em></a>
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
</div>
</body>
</html>