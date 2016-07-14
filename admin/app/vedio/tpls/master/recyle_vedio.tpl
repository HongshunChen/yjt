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
				<li class="active">视频回收站</li>
				
			</ul>
				<ul class="nav nav-tabs">
				<li class="active">
					<a href="#">视频管理</a>
				</li>
				
			</ul>
			<div class="row-fluid">
					
<table class="table table-hover" style="width:85%">
	            <thead>
	                <tr>
	                    <th>视频ID</th>
						<th>视频名称</th>
						<th>视频时长</th>
						<th>视频vid</th>
						<th>操作</th>
	                </tr>
	            </thead>
	            <tbody>
                   
                   {x2;tree:$pages['data'],val,cid}
					<tr>
				
						<td>{x2;v:val['videoid']}</td>
						<td><a title="查看试题" class="selfmodal" href="javascript:;" url="index.php?vedio-master-demand-detail&videoid={x2;v:val['videoid']}" data-target="#modal">{x2;v:val['videoname']}</a></td>
						<td>{x2;v:val['duration']}</td>
						<td>{x2;v:val['videovid']}</td>
						<td>
			          		<div class="btn-group">
								<a class="btn ajax" href="index.php?vedio-master-recyle-editvedio&catid={x2;v:val['videoid']}" title="恢复视频"><em class="icon-edit"></em></a>
								<a class="btn ajax" href="index.php?vedio-master-recyle-deevedio&catid={x2;v:val['videoid']}" onclick="show('{x2;v:val['videovid']}');" title="删除"><em class="icon-remove"></em></a>
							</div>
			          	</td>
		<script type="text/javascript">
			function show(vid){
				alert(vid);
		 			$.post("http://v.polyv.net/uc/services/rest?method=delVideoById",{
						"writetoken":"{x2;c:WRITETOKEN}",
						"vid":vid,
					},function (data) {
						
					});
				}
		</script>
					</tr>
					{x2;endtree}
				
	        	</tbody>
	        </table>
	          <div aria-hidden="true" id="modal" class="modal hide fade" role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-header">
					<button aria-hidden="true" class="close" type="button" data-dismiss="modal">×</button>
					<h3 id="myModalLabel">
						视频详情
					</h3>
				</div>
				<div class="modal-body"></div>
				<div class="modal-footer">
					 <button aria-hidden="true" class="btn" data-dismiss="modal">关闭</button>
				</div>
			</div>
	         <div class="pagination pagination-right">
			            <ul>{x2;$pages['pages']}</ul>
			        </div>

			</div>
		</div>
	</div>
</div>
</body>
</html>