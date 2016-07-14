				<table class="table table-hover">
			        <tr>
			          <td width="15%">题干</td>
			          <td><?php echo html_entity_decode($this->ev->stripSlashes($this->tpl_var['question']['subname'])); ?></td>
			        </tr>
			        <tr>
			        	<td>题型</td>
			        	<td>
			          		<?php echo $this->tpl_var['question']['questype']; ?>
						</td>
			        </tr>
			        <tr>
			        	<td>答题用户</td>
			        	<td><?php echo $this->tpl_var['question']['username']; ?></td>
			        </tr>
			        <tr>
			        	<td>答题时间</td>
			        	<td>
			          		<?php echo date('Y-m-d H:i:s',$this->tpl_var['question']['usertime']); ?>
						</td>
			        </tr>
			        <tr>
			          <td>用户答案</td>
			          <td><?php echo $this->tpl_var['question']['answer_text']; ?></td>
			        </tr>
			        
				</table>

