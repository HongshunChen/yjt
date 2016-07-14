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
                   
                   {x2;tree:$pages['data'],val,cid}
					<tr>
				
						<td>{x2;v:val['courseid']}</td>
						<td>{x2;v:val['coursename']}</td>
						<td>{x2;v:val['courseusername']}</td>
						<td>{x2;date:v:val['coursetime'],'Y-m-d H:i:s'}</td>
						<td>
			          		<div class="btn-group">
								<a class="btn ajax" href="index.php?vedio-master-recyle-regaincourse&catid={x2;v:val['courseid']}" title="恢复该课程"><em class="icon-edit"></em></a>
								<a class="btn ajax" href="index.php?vedio-master-recyle-deecourse&catid={x2;v:val['courseid']}" title="删除"><em class="icon-remove"></em></a>
							</div>
			          	</td>

					</tr>
					{x2;endtree}
				
	        	</tbody>
	        </table>
	         <div class="pagination pagination-right">
			            <ul>{x2;$pages['pages']}</ul>
			        </div>

		</div>
	</div>
</div>
</body>
</html>
