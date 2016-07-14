				<table class="table table-hover">
			        <tr>
			          <td width="65">标题：</td>
			          <td><?php echo html_entity_decode($this->ev->stripSlashes($this->tpl_var['question']['question'])); ?></td>
			        </tr>
			        <tr>
			        	<td>备选项：</td>
			        	<td>
			          	<?php echo html_entity_decode($this->ev->stripSlashes($this->tpl_var['question']['questionselect'])); ?>
						</td>
			        </tr>
			        <tr>
			          <td>答案：</td>
			          <td><?php echo html_entity_decode($this->ev->stripSlashes($this->tpl_var['question']['questionanswer'])); ?></td>
			        </tr>
			        <tr>
			          <td>解析：</td>
			          <td><?php echo html_entity_decode($this->ev->stripSlashes($this->tpl_var['question']['questiondescribe'])); ?>&nbsp;</td>
			        </tr>
			        <tr>
			          <td>难度：</td>
			          <td><?php if($this->tpl_var['question']['questionlevel']==1){ ?>易<?php } elseif($this->tpl_var['question']['questionlevel']==2){ ?>中<?php } elseif($this->tpl_var['question']['questionlevel']==3){ ?>难<?php } ?>&nbsp;</td>
			        </tr>
				</table>