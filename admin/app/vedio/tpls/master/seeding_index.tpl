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
				<li><a href="index.php?core-master">{x2;$apps[$_app]['appname']}</a> <span class="divider">/</span></li>
				<li class="active">直播视频列表</li>
			</ul>
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#">直播管理列表</a>
				</li>
				<li class="pull-right">
					<a href="index.php?vedio-master-seeding-addseeding">添加直播</a>
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
							{x2;tree:$pages['data'],val,cid}
					<tr>
				
						<td>{x2;v:val['vid']}</td>
						<td><a title="查看视频" class="selfmodal" href="javascript:;" url="index.php?vedio-master-seeding-detail&videoid={x2;v:val['vid']}" data-target="#modal">{x2;v:val['vname']}</a></td>
						<td>{x2;v:val['vprice']}</td>
						<td>{x2;date:v:val['endtime'],'Y-m-d H:i:s'}</td>
						<td>
						{x2;date:v:val['createtime'],'Y-m-d H:i:s'}
			          	</td>
						<td>
							<a class="btn" href="index.php?vedio-master-seeding-editseeding&catid={x2;v:val['vid']}" title="修改"><em class="icon-edit"></em></a>
								<a class="btn ajax" href="index.php?vedio-master-seeding-deletseeding&catid={x2;v:val['vid']}" title="删除"><em class="icon-remove"></em></a>
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
</div>
</body>
</html>