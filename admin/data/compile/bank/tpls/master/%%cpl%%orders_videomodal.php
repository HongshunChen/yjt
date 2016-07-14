<table class="table table-hover table-bordered">
			        <tr>
			          <td width="100">编号</td>
			          <td><?php echo $this->tpl_var['orders']['ordersn']; ?></td>
			        </tr>
			        <tr>
			          <td>标题：</td>
			          <td>
						<?php if($this->tpl_var['orders']['ordertype'] ==1){ ?>
						<a title="点击管理课程视频" href="index.php?vedio-master-demand-vedio&catid=<?php echo $this->tpl_var['orders']['courseid']; ?>">
			          <?php echo $this->tpl_var['orders']['ordertitle']; ?></a>
						<?php } elseif($this->tpl_var['orders']['ordertype'] ==3){ ?>
						<a title="点击批改" href="index.php?document-master-subjective-addsubject&catid=<?php echo $this->tpl_var['orders']['subid']; ?>"> <?php echo $this->tpl_var['orders']['ordertitle']; ?></a>
						<?php } else { ?>
							 <?php echo $this->tpl_var['orders']['ordertitle']; ?>
							 <?php } ?>


						
			          </td>
			        </tr>
			        <tr>
			        	<td>订单客户</td>
			        	<td>
			          	<?php echo $this->tpl_var['orders']['usertruename']; ?>
						</td>
			        </tr>
			        <?php if($this->tpl_var['orders']['couponsn'] !=''){ ?>
			        <tr>
			          <td>优惠券抵用价格</td>
			          <td><?php echo $this->tpl_var['orders']['couponsn']; ?></td>
			        </tr>
			        <?php } ?>
			        <tr>
			          <td>支付价格</td>
			          <td><?php echo $this->tpl_var['orders']['orderprice']; ?></td>
			        </tr>
			         <tr>
			          <td>完整价格</td>
			          <td><?php echo $this->tpl_var['orders']['orderfullprice']; ?></td>
			        </tr>
			        <tr>
			          <td>下单时间</td>
			          <td><?php echo date('Y-m-d H:i:s',$this->tpl_var['orders']['ordercreatetime']); ?></td>
			        </tr>
			        <tr>
			          <td>备注</td>
			          <td><?php echo $this->tpl_var['orders']['orderfaq']; ?></td>
			        </tr>
				</table>