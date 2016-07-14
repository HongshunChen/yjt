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
				
				<li class="active">试题管理</li>
			</ul>
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#">试题管理</a>
				</li>
				<li class="dropdown pull-right">
					<a data-toggle="dropdown" class="dropdown-toggle" href="#">添加试题<strong class="caret"></strong></a>
					<ul class="dropdown-menu">
						<li><a href="index.php?{x2;$_app}-master-questions-addquestion&page={x2;$page}{x2;$u}">单题添加</a></li>
					
					</ul>
				</li>
			</ul>
			<form action="index.php?exam-master-questions" method="post">
				<table class="table">
			        <tr>
						<td>
							题型：
						</td>
						<td>
							<input name="search[questype]" class="input-small" size="25" type="text" class="number" value="{x2;$search['questype']}"/>
						</td>

						<td>
							题目：
						</td>
						<td>
							<input class="input-big" name="search[question]" size="150" type="text" value="{x2;$search['question']}"/>
						</td>
						<td>
							录入时间：
						</td>
						<td>
							<input class="input-small datetimepicker" data-date="{x2;date:TIME,'Y-m-d'}" data-date-format="yyyy-mm-dd" type="text" name="search[stime]" size="10" id="stime" value="{x2;$search['stime']}"/> - <input class="input-small datetimepicker" data-date="{x2;date:TIME,'Y-m-d'}" data-date-format="yyyy-mm-dd" size="10" type="text" name="search[etime]" id="etime" value="{x2;$search['etime']}"/>
						</td>
						<td>
							<button class="btn btn-primary" type="submit">查询</button>
						</td>
					</tr>
			        <tr>
						<!-- <td>
							电子邮箱：
						</td>
			        	<td>
			        		<input class="input-small" name="search[useremail]" size="25" type="text" value="{x2;$search['useremail']}"/>
			        	</td>
			        	<td>
							用户组：
						</td>
						<td>
							<select name="search[groupid]" class="input-medium">
						  		<option value="0">不限</option>
						  		{x2;tree:$groups,group,gid}
						  		<option value="{x2;v:group['groupid']}"{x2;if:$search['groupid'] == v:group['groupid']} selected{x2;endif}>{x2;v:group['groupname']}</option>
						  		{x2;endtree}
					  		</select>
						</td> -->
						
						<td></td>
			        </tr>
				</table>
				<div class="input">
					<input type="hidden" value="1" name="search[argsmodel]" />
				</div>
			</form>
			<form action="index.php?exam-master-questions-batdel" method="post">
				<fieldset>
					<table class="table table-hover">
			            <thead>
			                <tr>
			                    <th><input type="checkbox" class="checkall" target="delids"/></th>
			                    <th>ID</th>
						        <th>试题类型</th>
						        <th>试题内容</th>			      
						        <th>录入人</th>
						        <th >录入时间</th>
						        <th >难度</th>
						        <th>操作</th>
			                </tr>
			            </thead>
			            <tbody>
		                    {x2;tree:$questions['data'],question,qid}
					        <tr>
								<td><input type="checkbox" name="delids[{x2;v:question['questionid']}]" value="1"></td>
								<td>
									{x2;v:question['questionid']}
								</td>
								<td>
									{x2;$questypes[v:question['questiontype']]['questype']}
								</td>
								<td>
									<a title="查看试题" class="selfmodal" href="javascript:;" url="index.php?exam-master-questions-detail&questionid={x2;v:question['questionid']}" data-target="#modal">{x2;substring:strip_tags(html_entity_decode(v:question['question'])),135}</a>
								</td>
								<td >
									{x2;v:question['questionusername']}
								</td>
								<td >
									{x2;date:v:question['questioncreatetime'],'Y-m-d'}
								</td>
								<td >
									{x2;if:v:question['questionlevel']==2}中{x2;elseif:v:question['questionlevel']==3}难{x2;elseif:v:question['questionlevel']==1}易{x2;endif}
								</td>
								<td>
									<div class="btn-group">
			                    		<a class="btn" href="index.php?exam-master-questions-modifyquestion&page={x2;$page}&questionid={x2;v:question['questionid']}{x2;$u}" title="修改"><em class="icon-edit"></em></a>
										<a class="btn confirm" href="index.php?exam-master-questions-delquestion&questionparent=0&page={x2;$page}&questionid={x2;v:question['questionid']}{x2;$u}" title="删除"><em class="icon-remove"></em></a>
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
				            <input type="hidden" name="page" value="{x2;$page}"/>
				        </div>
			        </div>
			        <div class="pagination pagination-right">
			            <ul>{x2;$questions['pages']}</ul>
			        </div>
		        </fieldset>
			</form>
	        <div aria-hidden="true" id="modal" class="modal hide fade" role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-header">
					<button aria-hidden="true" class="close" type="button" data-dismiss="modal">×</button>
					<h3 id="myModalLabel">
						试题详情
					</h3>
				</div>
				<div class="modal-body"></div>
				<div class="modal-footer">
					 <button aria-hidden="true" class="btn" data-dismiss="modal">关闭</button>
				</div>
			</div>
{x2;if:!$userhash}
		</div>
	</div>
</div>
</body>
</html>
{x2;endif}