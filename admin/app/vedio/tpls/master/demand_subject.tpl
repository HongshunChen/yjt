{x2;include:header}
<body>
{x2;include:nav}
<div class="container-fluid">
	<div class="row-fluid">
		<div class="span2">
			{x2;include:menu}
		</div>
		<div class="span10">
			<ul class="breadcrumb">
				<li><a href="index.php?{x2;$_app}-master">{x2;$apps[$_app]['appname']}</a> <span class="divider">/</span></li>
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
							{x2;tree:$pages['data'],val,cid}
					<tr>
				
						<td>{x2;v:val['videoid']}</td>
						<td><a title="查看视频" class="selfmodal" href="javascript:;" url="index.php?vedio-master-demand-detail&videoid={x2;v:val['videoid']}" data-target="#modal">{x2;v:val['videoname']}</a></td>
						<td>{x2;v:val['duration']}</td>
						<td>{x2;v:val['videovid']}</td>
						<td>
			          		2016-06-08
			          	</td>

					</tr>
					{x2;endtree}
						
						</tbody>
					</table>
					
					<div class="pagination pagination-right">
						<ul>{x2;$pages['pages']}</ul>
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