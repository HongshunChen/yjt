<div>
	<div ><embed width="520" height="350" src="<?php echo $this->tpl_var['cat']['remoteurl']; ?>" id="VEDIO_IMG" />	
				</div>
				<table class="table table-hover">
			        <tr>
			          <td width="30%">视频名称</td>
			          <td><?php echo $this->tpl_var['cat']['videoname']; ?></td>
			        </tr>
			        <tr>
			        	<td>视频时长</td>
			        	<td>
			          	<?php echo $this->tpl_var['cat']['duration']; ?>
						</td>
			        </tr>
			        <tr>
			          <td>视频简介</td>
			          <td><?php echo $this->tpl_var['cat']['content']; ?></td>
			        </tr>
			        <tr>
			          <td>视频第三方Vid</td>
			          <td><?php echo $this->tpl_var['cat']['videovid']; ?></td>
			        </tr>
				</table>

</div>