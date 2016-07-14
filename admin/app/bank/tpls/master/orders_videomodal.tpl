<table class="table table-hover table-bordered">
			        <tr>
			          <td width="100">编号</td>
			          <td>{x2;$orders['ordersn']}</td>
			        </tr>
			        <tr>
			          <td>标题：</td>
			          <td>
						{x2;if:$orders['ordertype'] ==1}
						<a title="点击管理课程视频" href="index.php?vedio-master-demand-vedio&catid={x2;$orders['courseid']}">
			          {x2;$orders['ordertitle']}</a>
						{x2;elseif:$orders['ordertype'] ==3}
						<a title="点击批改" href="index.php?document-master-subjective-addsubject&catid={x2;$orders['subid']}"> {x2;$orders['ordertitle']}</a>
						{x2;else}
							 {x2;$orders['ordertitle']}
							 {x2;endif}


						
			          </td>
			        </tr>
			        <tr>
			        	<td>订单客户</td>
			        	<td>
			          	{x2;$orders['usertruename']}
						</td>
			        </tr>
			        {x2;if:$orders['couponsn'] !=''}
			        <tr>
			          <td>优惠券抵用价格</td>
			          <td>{x2;$orders['couponsn']}</td>
			        </tr>
			        {x2;endif}
			        <tr>
			          <td>支付价格</td>
			          <td>{x2;$orders['orderprice']}</td>
			        </tr>
			         <tr>
			          <td>完整价格</td>
			          <td>{x2;$orders['orderfullprice']}</td>
			        </tr>
			        <tr>
			          <td>下单时间</td>
			          <td>{x2;date:$orders['ordercreatetime'],'Y-m-d H:i:s'}</td>
			        </tr>
			        <tr>
			          <td>备注</td>
			          <td>{x2;$orders['orderfaq']}</td>
			        </tr>
				</table>