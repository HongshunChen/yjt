{x2;if:!$userhash}
{x2;include:header}
<body>
{x2;include:nav}
<div class="container-fluid">
	<div class="row-fluid">
		<div class="span2">
			{x2;include:menu}
		</div>
		<div class="span10" id="datacontent">
{x2;endif}
			<ul class="breadcrumb">
				<li><a href="index.php?{x2;$_app}-master">{x2;$apps[$_app]['appname']}</a> <span class="divider">/</span></li>
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
                   	{x2;tree:$cat,val,key}
                   	{x2;if:v:val['catpid'] ==0}
					<tr>
				
						<td>{x2;v:val['catid']}</td>
						<td>{x2;v:val['catname']}</td>
					
						
						
						<td>{x2;v:val['catpid']}</td>
					
							
						
						<td>
			          		<div class="btn-group">
			          		
			          		<a class="btn" href="index.php?vedio-master-demand-addarea_fenlei&catid={x2;v:val['catid']}" title="增加下级分类"><em class="icon-pencil"></em></a>
								<a class="btn" href="index.php?vedio-master-demand-editarea&catid={x2;v:val['catid']}" title="修改"><em class="icon-edit"></em></a>
								<a class="btn ajax" href="index.php?vedio-master-demand-deearea&catid={x2;v:val['catid']}" title="删除"><em class="icon-remove"></em></a>
							</div>
			          	</td>

					</tr>
					{x2;endif}
					{x2;endtree}
					{x2;tree:$cat,val,key}
                   	{x2;if:v:val['catpid'] !=0}
						<tr>
				
						<td>{x2;v:val['catid']}</td>
						<td>{x2;v:val['catname']}</td>
					
						
						
						<td>{x2;v:val['catpid']}</td>
					
							
						
						<td>
			          		<div class="btn-group">
			          		
								<a class="btn" href="index.php?vedio-master-demand-editarea&catid={x2;v:val['catid']}" title="修改"><em class="icon-edit"></em></a>
								<a class="btn ajax" href="index.php?vedio-master-demand-deearea&catid={x2;v:val['catid']}" title="删除"><em class="icon-remove"></em></a>
							</div>
			          	</td>

					</tr>

					{x2;endif}
				{x2;endtree}
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
