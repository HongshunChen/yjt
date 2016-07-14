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
				<li class="active"><?php echo $this->tpl_var['sd2']; ?></li>
			</ul>
			<ul>
				<li><a href="./index.php?download-api-index&user_type=2" />导出管理员</li>
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
						<?php $uid = 0;
 foreach($this->tpl_var['users']['data'] as $key => $user){ 
 $uid++; ?>
						<tr>
							<td><?php if($user['userid'] != $this->tpl_var['_user']['userid']){ ?><input type="checkbox" name="delids[<?php echo $user['userid']; ?>]" value="1"><?php } ?></td>
							<td><?php echo $user['userid']; ?></td>
							<td><?php echo $user['username']; ?></td>
							<td><?php echo $user['usertruename']; ?></td>
							<td><?php echo $user['userphone']; ?></td>
							<td><?php echo $user['userregip']; ?></td>
							<!-- <td><?php echo $user['usercoin']; ?></td> -->
							<td><?php echo $this->tpl_var['groups'][$user['usergroupid']]['groupname']; ?></td>
							<td><?php echo date('Y-m-d',$user['userregtime']); ?></td>
							<td>
								<div class="btn-group">
									<a class="btn" href="index.php?user-master-user-modify&userid=<?php echo $user['userid']; ?>&page=<?php echo $this->tpl_var['page']; ?><?php echo $this->tpl_var['u']; ?>"><em class="icon-edit"></em></a>
									<?php if($user['userid'] != $this->tpl_var['_user']['userid']){ ?>
									<a class="btn ajax" href="index.php?user-master-user-del&userid=<?php echo $user['userid']; ?>&page=<?php echo $this->tpl_var['page']; ?><?php echo $this->tpl_var['u']; ?>" target="datacontent"><em class="icon-remove"></em></a>
									<?php } ?>
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
			            
			        </div>
		        </div>
			</form>
			<div class="pagination pagination-right">
				<ul><?php echo $this->tpl_var['users']['pages']; ?></ul>
			</div>
<?php if(!$this->tpl_var['userhash']){ ?>
		</div>
	</div>
</div>
</body>
</html>
<?php } ?>