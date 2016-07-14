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
				<li class="active">试卷管理</li>
			</ul>
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#">组卷管理</a>
				</li>
				<li class="dropdown pull-right">
					<a data-toggle="dropdown" class="dropdown-toggle" href="#">添加组卷规则<strong class="caret"></strong></a>
					<ul class="dropdown-menu">
						<li><a href="index.php?<?php echo $this->tpl_var['_app']; ?>-master-assem-addassembly">添加组卷规则</a></li>
					
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
	                    		<?php if($exam['examtype'] != 1){ ?>
	                    		<a class="btn" target="_blank" href="index.php?<?php echo $this->tpl_var['_app']; ?>-master-exams-preview&examid=<?php echo $exam['examid']; ?><?php echo $this->tpl_var['u']; ?>" title="查看试卷"><em class="icon-list-alt"></em></a>
	                    		<?php } ?>
	                    		<a class="btn" href="index.php?<?php echo $this->tpl_var['_app']; ?>-master-exams-modify&page=<?php echo $this->tpl_var['page']; ?>&examid=<?php echo $exam['examid']; ?><?php echo $this->tpl_var['u']; ?>" title="修改"><em class="icon-edit"></em></a>
								<a class="btn confirm" href="index.php?<?php echo $this->tpl_var['_app']; ?>-master-exams-del&page=<?php echo $this->tpl_var['page']; ?>&examid=<?php echo $exam['examid']; ?><?php echo $this->tpl_var['u']; ?>" title="删除"><em class="icon-remove"></em></a>
	                    	</div>
						</td>
			        </tr>
			      
	        	</tbody>
	        </table>
	        <div class="pagination pagination-right">
	            <ul><?php echo $this->tpl_var['exams']['pages']; ?></ul>
	        </div>
<?php if(!$this->tpl_var['userhash']){ ?>
		</div>
	</div>
</div>
</body>
</html>
<?php } ?>