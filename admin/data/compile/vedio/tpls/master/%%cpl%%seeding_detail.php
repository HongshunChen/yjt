<div>
	<div ><embed width="520" height="350" src="<?php echo $this->tpl_var['cat']['vurl']; ?>" id="VEDIO_IMG" />	
				</div>
				<table class="table table-hover">
			        <tr>
			          <td width="30%">直播名称</td>
			          <td><?php echo $this->tpl_var['cat']['vname']; ?></td>
			        </tr>
			        <tr>
			        	<td>截止时间</td>
			        	<td>
			          	<?php echo date('Y-m-d H:i:s',$this->tpl_var['cat']['endtime']); ?>
						</td>
			        </tr>
			        <tr>
			          <td>直播价格</td>
			          <td><?php echo $this->tpl_var['cat']['vprice']; ?></td>
			        </tr>
			        <tr>
			          <td>直播简介</td>
			          <td><?php echo $this->tpl_var['cat']['vintro']; ?></td>
			        </tr>
			        
				</table>

</div>