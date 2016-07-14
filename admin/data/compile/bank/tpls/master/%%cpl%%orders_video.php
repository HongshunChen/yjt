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
				<li><a href="#">订单管理</a> <span class="divider">/</span></li>
				<li class="active">视频订单</li>
			</ul>
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#">订单列表</a>
				</li>
			</ul>
			<form action="index.php?bank-master-orders-videoorders" method="post">
				<table class="table">
			        <tr>            
                                                <td>
							手机号码：
						</td>
						<td>
							<input name="search[phoneNum]" class="input-small" size="25" type="text" class="number" value="<?php echo $this->tpl_var['search']['phoneNum']; ?>"/>
						</td>
						<td>
							订单编号：
						</td>
						<td>
							<input name="search[ordersn]" class="input-small" size="25" type="text" class="number" value="<?php echo $this->tpl_var['search']['ordersn']; ?>"/>
						</td>
						<td>
							时间范围：
						</td>
						<td>
							<input class="input-small datetimepicker" data-date="<?php echo date('Y-m-d',TIME); ?>" data-date-format="yyyy-mm-dd" type="text" name="search[stime]" size="10" id="stime" value="<?php echo $this->tpl_var['search']['stime']; ?>"/> - <input class="input-small datetimepicker" data-date="<?php echo date('Y-m-d',TIME); ?>" data-date-format="yyyy-mm-dd" size="10" type="text" name="search[etime]" id="etime" value="<?php echo $this->tpl_var['search']['etime']; ?>"/>
						</td>
						<td>
							价格范围：
						</td>
						<td>
							<input class="input-small "  type="text" name="search[sprice]" size="10" id="sprice" value="<?php echo $this->tpl_var['search']['sprice']; ?>"/> - <input class="input-small" size="10" type="text" name="search[eprice]" id="eprice" value="<?php echo $this->tpl_var['search']['eprice']; ?>"/>
						</td>
						<td>
							<button class="btn btn-primary" type="submit">搜索</button>
						</td>
					</tr>
			       
				</table>
				<div class="input">
					<input type="hidden" value="1" name="search[argsmodel]" />
				</div>
			</form>
				<fieldset>
					<table class="table table-hover table-bordered">
						<thead>
							<tr>
								
								<th>订单编号</th>
								<th>订单标题</th>
								<th>订单客户</th>
								<th>是否使用优惠券</th>
								<th>支付价格</th>
								<!-- <th>订单状态</th> -->
								<th>下单时间</th>
								<th>操作</th>
							</tr>
						</thead>
						<tbody>
							<?php $vid = 0;
 foreach($this->tpl_var['orders']['data'] as $key => $val){ 
 $vid++; ?>
							<tr>
								
								<td width="10%"><?php echo $val['ordersn']; ?></td>
								<td><a title="查看订单" class="selfmodal" href="javascript:;" url="index.php?bank-master-orders-ordermodal&id=<?php echo $val['orderid']; ?>" data-target="#modal"><?php echo $val['ordertitle']; ?></a></td>
								<td><?php echo $val['usertruename']; ?></td>
								<td>
								<?php if($val['couponsn'] ==''){ ?>
								未使用
								<?php } else { ?>
								已使用
								<?php } ?>
								</td>
								<td><?php echo $val['orderprice']; ?></td>
								<td><?php echo date('Y-m-d H:i:s',$val['ordercreatetime']); ?></td>
								
								<td>
									<div class="btn-group">
										<a class="btn ajax" href="index.php?bank-master-orders-delectorder&id=<?php echo $val['orderid']; ?>" title="删除订单"><em class="icon-remove"></em></a>
									</div>
								</td>
							</tr>
							<?php } ?>
						
						</tbody>
					</table>
					
					<div class="pagination pagination-right">
						<ul><?php echo $this->tpl_var['orders']['pages']; ?></ul>
					</div>
				</fieldset>
			
			 <div aria-hidden="true" id="modal" class="modal hide fade" role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-header">
					<button aria-hidden="true" class="close" type="button" data-dismiss="modal">×</button>
					<h3 id="myModalLabel">
						订单详情
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