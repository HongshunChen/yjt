<?php if(!$this->tpl_var['userhash']){ ?>
<?php $this->_compileInclude('header'); ?>
<body>
<?php $this->_compileInclude('nav'); ?>
<div class="container-fluid">
	<div class="row-fluid">
		<div class="span2">
			<?php $this->_compileInclude('menu'); ?>
		</div>
		<div class="span10" id="datacontent">
<?php } ?>
			<ul class="breadcrumb">
				<li><a href="index.php?<?php echo $this->tpl_var['_app']; ?>-master"><?php echo $this->tpl_var['apps'][$this->tpl_var['_app']]['appname']; ?></a> <span class="divider">/</span></li>
				
				<li class="active">试题管理</li>
			</ul>
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#">试题管理</a>
				</li>
				<li class="dropdown pull-right">
					<a data-toggle="dropdown" class="dropdown-toggle" href="#">添加试题<strong class="caret"></strong></a>
					<ul class="dropdown-menu">
						<li><a href="index.php?<?php echo $this->tpl_var['_app']; ?>-master-questions-addquestion&page=<?php echo $this->tpl_var['page']; ?><?php echo $this->tpl_var['u']; ?>">单题添加</a></li>
					
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
							<input name="search[questype]" class="input-small" size="25" type="text" class="number" value="<?php echo $this->tpl_var['search']['questype']; ?>"/>
						</td>

						<td>
							题目：
						</td>
						<td>
							<input class="input-big" name="search[question]" size="150" type="text" value="<?php echo $this->tpl_var['search']['question']; ?>"/>
						</td>
						<td>
							录入时间：
						</td>
						<td>
							<input class="input-small datetimepicker" data-date="<?php echo date('Y-m-d',TIME); ?>" data-date-format="yyyy-mm-dd" type="text" name="search[stime]" size="10" id="stime" value="<?php echo $this->tpl_var['search']['stime']; ?>"/> - <input class="input-small datetimepicker" data-date="<?php echo date('Y-m-d',TIME); ?>" data-date-format="yyyy-mm-dd" size="10" type="text" name="search[etime]" id="etime" value="<?php echo $this->tpl_var['search']['etime']; ?>"/>
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
			        		<input class="input-small" name="search[useremail]" size="25" type="text" value="<?php echo $this->tpl_var['search']['useremail']; ?>"/>
			        	</td>
			        	<td>
							用户组：
						</td>
						<td>
							<select name="search[groupid]" class="input-medium">
						  		<option value="0">不限</option>
						  		<?php $gid = 0;
 foreach($this->tpl_var['groups'] as $key => $group){ 
 $gid++; ?>
						  		<option value="<?php echo $group['groupid']; ?>"<?php if($this->tpl_var['search']['groupid'] == $group['groupid']){ ?> selected<?php } ?>><?php echo $group['groupname']; ?></option>
						  		<?php } ?>
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
		                    <?php $qid = 0;
 foreach($this->tpl_var['questions']['data'] as $key => $question){ 
 $qid++; ?>
					        <tr>
								<td><input type="checkbox" name="delids[<?php echo $question['questionid']; ?>]" value="1"></td>
								<td>
									<?php echo $question['questionid']; ?>
								</td>
								<td>
									<?php echo $this->tpl_var['questypes'][$question['questiontype']]['questype']; ?>
								</td>
								<td>
									<a title="查看试题" class="selfmodal" href="javascript:;" url="index.php?exam-master-questions-detail&questionid=<?php echo $question['questionid']; ?>" data-target="#modal"><?php echo $this->G->make('strings')->subString(strip_tags(html_entity_decode($question['question'])),135); ?></a>
								</td>
								<td >
									<?php echo $question['questionusername']; ?>
								</td>
								<td >
									<?php echo date('Y-m-d',$question['questioncreatetime']); ?>
								</td>
								<td >
									<?php if($question['questionlevel']==2){ ?>中<?php } elseif($question['questionlevel']==3){ ?>难<?php } elseif($question['questionlevel']==1){ ?>易<?php } ?>
								</td>
								<td>
									<div class="btn-group">
			                    		<a class="btn" href="index.php?exam-master-questions-modifyquestion&page=<?php echo $this->tpl_var['page']; ?>&questionid=<?php echo $question['questionid']; ?><?php echo $this->tpl_var['u']; ?>" title="修改"><em class="icon-edit"></em></a>
										<a class="btn confirm" href="index.php?exam-master-questions-delquestion&questionparent=0&page=<?php echo $this->tpl_var['page']; ?>&questionid=<?php echo $question['questionid']; ?><?php echo $this->tpl_var['u']; ?>" title="删除"><em class="icon-remove"></em></a>
			                    	</div>
								</td>
					        </tr>
					        <?php } ?>
			        	</tbody>
			        </table>
			        <div class="control-group">
			            <div class="controls">
				            <label class="radio inline">
				                <input type="radio" name="action" value="delete" checked/>删除
				            </label>
				            <?php $sid = 0;
 foreach($this->tpl_var['search'] as $key => $arg){ 
 $sid++; ?>
				            <input type="hidden" name="search[<?php echo $key; ?>]" value="<?php echo $arg; ?>"/>
				            <?php } ?>
				            <label class="radio inline">
				            	<button class="btn btn-primary" type="submit">提交</button>
				            </label>
				            <input type="hidden" name="page" value="<?php echo $this->tpl_var['page']; ?>"/>
				        </div>
			        </div>
			        <div class="pagination pagination-right">
			            <ul><?php echo $this->tpl_var['questions']['pages']; ?></ul>
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
<?php if(!$this->tpl_var['userhash']){ ?>
		</div>
	</div>
</div>
</body>
</html>
<?php } ?>