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
				<li><a href="#">订单管理</a> <span class="divider">/</span></li>
				<li class="active">直播课程订单</li>
			</ul>
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#">订单列表</a>
				</li>
			</ul>
			<form action="index.php?bank-master-orders-seedingorders" method="post">
				<table class="table">
			        <tr>
                                    
                                                 <td>
							手机号码：
						</td>
						<td>
							<input name="search[phoneNum]" class="input-small" size="25" type="text" class="number" value="{x2;$search['phoneNum']}"/>
						</td>
						<td>
							订单编号：
						</td>
						<td>
							<input name="search[ordersn]" class="input-small" size="25" type="text" class="number" value="{x2;$search['ordersn']}"/>
						</td>
						<td>
							时间范围：
						</td>
						<td>
							<input class="input-small datetimepicker" data-date="{x2;date:TIME,'Y-m-d'}" data-date-format="yyyy-mm-dd" type="text" name="search[stime]" size="10" id="stime" value="{x2;$search['stime']}"/> - <input class="input-small datetimepicker" data-date="{x2;date:TIME,'Y-m-d'}" data-date-format="yyyy-mm-dd" size="10" type="text" name="search[etime]" id="etime" value="{x2;$search['etime']}"/>
						</td>
						<td>
							价格范围：
						</td>
						<td>
							<input class="input-small "  type="text" name="search[sprice]" size="10" id="sprice" value="{x2;$search['sprice']}"/> - <input class="input-small" size="10" type="text" name="search[eprice]" id="eprice" value="{x2;$search['eprice']}"/>
						</td>
						<td>
							<button class="btn btn-primary" type="submit">提交</button>
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
							{x2;tree:$orders['data'],val,vid}
							<tr>
								
								<td width="10%">{x2;v:val['ordersn']}</td>
								<td><a title="查看订单" class="selfmodal" href="javascript:;" url="index.php?bank-master-orders-ordermodal&id={x2;v:val['orderid']}" data-target="#modal">{x2;v:val['ordertitle']}</a></td>
								<td>{x2;v:val['username']}</td>
								<td>
								{x2;if:v:val['couponsn'] ==''}
								未使用
								{x2;else}
								已使用
								{x2;endif}
								</td>
								<td>{x2;v:val['orderprice']}</td>
								<td>{x2;date:v:val['ordercreatetime'],'Y-m-d H:i:s'}</td>
								
								<td>
									<div class="btn-group">
										<a class="btn ajax" href="index.php?bank-master-orders-delectorder&id={x2;v:val['orderid']}" title="删除订单"><em class="icon-remove"></em></a>
									</div>
								</td>
							</tr>
							{x2;endtree}
								
							
						</tbody>
					</table>
					
					<div class="pagination pagination-right">
						<ul>{x2;$orders['pages']}</ul>
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
                         <a href="./index.php?download-api-orders&user_type=2" class="btn btn-primary" onclick="">导出直播课报表<a/>
{x2;if:!$userhash}
		</div>
	</div>
</div>

</body>
</html>
{x2;endif}