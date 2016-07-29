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
				<li class="active">{x2;$sd2}</li>
			</ul>
			<ul>
				<li><a   href="./index.php?download-api-index&user_type=2" />导出管理员</li>
			</ul>
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#">用户列表</a>
				</li>
				<li class="dropdown pull-right">
					<a  class="dropdown-toggle" href="index.php?user-master-adminuser-adminlist">添加管理员<strong class="caret"></strong></a>
					
				</li>
			</ul>
		
			<form action="index.php?user-master-user-batdel" method="post">
				<table class="table table-hover">
					<thead>
						<tr>
							<th><input type="checkbox" class="checkall" target="delids"/></th>
							<th>ID</th>
							<th>用户名</th>
							<th>用户昵称</th>
							<th>手机号</th>
							<th>注册IP</th>
							<!-- <th>积分点数</th> -->
							<th>角色</th>
							<th>注册时间</th>
							<th>操作</th>
						</tr>
					</thead>
					<tbody>
						{x2;tree:$users['data'],user,uid}
						<tr>
							<td>{x2;if:v:user['userid'] != $_user['userid']}<input type="checkbox" name="delids[{x2;v:user['userid']}]" value="1">{x2;endif}</td>
							<td>{x2;v:user['userid']}</td>
							<td>{x2;v:user['username']}</td>
							<td>{x2;v:user['usertruename']}</td>
							<td>{x2;v:user['userphone']}</td>
							<td>{x2;v:user['userregip']}</td>
							<!-- <td>{x2;v:user['usercoin']}</td> -->
							<td>{x2;$groups[v:user['usergroupid']]['groupname']}</td>
							<td>{x2;date:v:user['userregtime'],'Y-m-d'}</td>
							<td>
								<div class="btn-group">
									<a class="btn" href="index.php?user-master-user-modify&userid={x2;v:user['userid']}&page={x2;$page}{x2;$u}"><em class="icon-edit"></em></a>
									{x2;if:v:user['userid'] != $_user['userid']}
									<a class="btn ajax" href="index.php?user-master-user-del&userid={x2;v:user['userid']}&page={x2;$page}{x2;$u}" target="datacontent"><em class="icon-remove"></em></a>
									{x2;endif}
								</div>
							</td>
						</tr>
						{x2;endtree}
					</tbody>
				</table>
				<div class="control-group">
		            <div class="controls">
			            <label class="radio inline">
			                <input type="radio" name="action" value="delete" checked/>删除
			            </label>
			            {x2;tree:$search,arg,sid}
			            <input type="hidden" name="search[{x2;v:key}]" value="{x2;v:arg}"/>
			            {x2;endtree}
			            <label class="radio inline">
			            	<button class="btn btn-primary" type="submit">提交</button>
			            </label>
			            
			        </div>
		        </div>
			</form>
			<div class="pagination pagination-right">
				<ul>{x2;$users['pages']}</ul>
			</div>
{x2;if:!$userhash}
		</div>
	</div>
</div>
</body>
</html>
{x2;endif}