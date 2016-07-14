
				{x2;tree:$question['data'],question,qid}
				<table class="table table-hover">
			        <tr>
			          <td width="100">第{x2;v:qid}题</td>
			          <td>&nbsp;</td>
			        </tr>
			        <tr>
			          <td>标题：</td>
			          <td>{x2;eval: echo html_entity_decode(v:question['question'])}</td>
			        </tr>
			        <tr>
			        	<td>备选项：</td>
			        	<td>
			          	{x2;realhtml:v:question['questionselect']}
						</td>
			        </tr>
			        <tr>
			          <td>答案：</td>
			          <td>{x2;realhtml: v:question['questionanswer']}</td>
			        </tr>
			        <tr>
			          <td>解析：</td>
			          <td>{x2;realhtml: v:question['questiondescribe']}</td>
			        </tr>
				</table>
				{x2;endtree}