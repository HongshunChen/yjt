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
				<li class="active">试卷管理</li>
			</ul>
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#">组卷管理</a>
				</li>
				<li class="dropdown pull-right">
					<a data-toggle="dropdown" class="dropdown-toggle" href="#">添加组卷规则<strong class="caret"></strong></a>
					<ul class="dropdown-menu">
						<li><a href="index.php?{x2;$_app}-master-assem-addassembly">添加组卷规则</a></li>
					
					</ul>
				</li>
			</ul>
	       
	        <table class="table table-hover">
	            <thead>
	                <tr>
	                    <th>ID</th>
				        <th>组卷规则名称</th>
				        <th>规则定义人</th>
				        <th>试卷总分</th>
				        <th>操作</th>
	                </tr>
	            </thead>
	            <tbody>
                    
			        <tr>
						<td>
							1
						</td>
						<td>
							山东考场的组卷规则
						</td>
						<td>
							admin
						</td>
						<td>
							100分
						</td>
						
						<td>
							<div class="btn-group">
	                    		{x2;if:v:exam['examtype'] != 1}
	                    		<a class="btn" target="_blank" href="index.php?{x2;$_app}-master-exams-preview&examid={x2;v:exam['examid']}{x2;$u}" title="查看试卷"><em class="icon-list-alt"></em></a>
	                    		{x2;endif}
	                    		<a class="btn" href="index.php?{x2;$_app}-master-exams-modify&page={x2;$page}&examid={x2;v:exam['examid']}{x2;$u}" title="修改"><em class="icon-edit"></em></a>
								<a class="btn confirm" href="index.php?{x2;$_app}-master-exams-del&page={x2;$page}&examid={x2;v:exam['examid']}{x2;$u}" title="删除"><em class="icon-remove"></em></a>
	                    	</div>
						</td>
			        </tr>
			      
	        	</tbody>
	        </table>
	        <div class="pagination pagination-right">
	            <ul>{x2;$exams['pages']}</ul>
	        </div>
{x2;if:!$userhash}
		</div>
	</div>
</div>
</body>
</html>
{x2;endif}