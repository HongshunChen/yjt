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
				<li class="active">主观题批改</li>
			</ul>
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#">主观题批改</a>
				</li>
				<!-- <li class="pull-right">
					<a href="index.php?<?php echo $this->tpl_var['_app']; ?>-master-attachtype-add">添加文件类型</a>
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
		               <?php $cid = 0;
 foreach($this->tpl_var['pages']['data'] as $key => $cal){ 
 $cid++; ?>
				        <tr>
						<!-- 	<td>
								<input type="checkbox" name="delids[<?php echo $type['atid']; ?>]" value="1"/>
							</td> -->
							<td>
								<span><?php echo $cal[subid]; ?></span>
							</td>
							<td>
                                                            <?php if($cal[videourl] !=''){ ?>
								<a title="点击预览题目" class="selfmodal"  style="color: #DDD"  href="javascript:;" url="index.php?<?php echo $this->tpl_var['_app']; ?>-master-subjective-modal&catid=<?php echo $cal[subid]; ?>" data-target="#modal">
								<?php echo html_entity_decode($this->ev->stripSlashes($cal[subname])); ?>
								</a>
                                                            <?php } else { ?>
                                                                <a title="点击预览题目" class="selfmodal"    href="javascript:;" url="index.php?<?php echo $this->tpl_var['_app']; ?>-master-subjective-modal&catid=<?php echo $cal[subid]; ?>" data-target="#modal">
								<?php echo html_entity_decode($this->ev->stripSlashes($cal[subname])); ?>
								</a>
                                                            <?php } ?>
							</td>
							<td><?php echo $cal[questype]; ?></td>
							<td>
								<?php if($cal[usertruename] ==''){ ?>
									<?php echo $cal[username]; ?>
								<?php } else { ?>
									<?php echo $cal[usertruename]; ?>
								<?php } ?>
							</td>
							<td>
								<div class="btn-group">
									<a class="btn" href="index.php?document-master-subjective-addsubject&catid=<?php echo $cal[subid]; ?>" title="批改"><em class="icon-edit"></em></a>
									<!-- <a class="btn confirm" href="" title="删除"><em class="icon-remove"></em></a> -->
								</div>
							</td>
							<td></td>
				        </tr>
				     <?php } ?>
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
				<ul><?php echo $this->tpl_var['pages']['pages']; ?></ul>
	        </div>
<?php if(!$this->tpl_var['userhash']){ ?>
		</div>
	</div>
</div>
</body>
</html>
<?php } ?>