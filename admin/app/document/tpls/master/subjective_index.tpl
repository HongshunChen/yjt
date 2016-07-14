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
				<li class="active">主观题批改</li>
			</ul>
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#">主观题批改</a>
				</li>
				<!-- <li class="pull-right">
					<a href="index.php?{x2;$_app}-master-attachtype-add">添加文件类型</a>
				</li> -->
			</ul>
	        
		        <table class="table table-hover">
		            <thead>
		                <tr>
		                   <!--  <th><input type="checkbox" class="checkall"/></th> -->
		                    <th>题目ID</th>
					        <th>题目标题</th>
					        <th>题目类型</th>
					        <th>答题用户</th>
					        <th>操作</th>
		                </tr>
		            </thead>
		            <tbody>
		               {x2;tree:$pages['data'],cal,cid}
				        <tr>
						<!-- 	<td>
								<input type="checkbox" name="delids[{x2;v:type['atid']}]" value="1"/>
							</td> -->
							<td>
								<span>{x2;v:cal[subid]}</span>
							</td>
							<td>
								<a title="点击预览题目" class="selfmodal" href="javascript:;" url="index.php?{x2;$_app}-master-subjective-modal&catid={x2;v:cal[subid]}" data-target="#modal">
								{x2;realhtml:v:cal[subname]}
								</a>
							</td>
							<td>{x2;v:cal[questype]}</td>
							<td>
								{x2;if:v:cal[usertruename] ==''}
									{x2;v:cal[username]}
								{x2;else}
									{x2;v:cal[usertruename]}
								{x2;endif}
							</td>
							<td>
								<div class="btn-group">
									<a class="btn" href="index.php?document-master-subjective-addsubject&catid={x2;v:cal[subid]}" title="批改"><em class="icon-edit"></em></a>
									<!-- <a class="btn confirm" href="" title="删除"><em class="icon-remove"></em></a> -->
								</div>
							</td>
							<td></td>
				        </tr>
				     {x2;endtree}
		        	</tbody>
		        </table>
		        <!-- <div class="control-group">
		            <div class="controls">
		            	<button class="btn btn-primary" type="submit">删除</button>
		            </div>
				</div> -->
			
			<div aria-hidden="true" id="modal" class="modal hide fade" role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-header">
					<button aria-hidden="true" class="close" type="button" data-dismiss="modal">×</button>
					<h3 id="myModalLabel">
						主观题预览
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
{x2;if:!$userhash}
		</div>
	</div>
</div>
</body>
</html>
{x2;endif}