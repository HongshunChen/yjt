<?php
	/**
	 * paginate 类辅助函数, 转化成数组
	 */
	function page_helper ($paginate) {
		$json = $paginate->toJson();
		$arr = json_decode($json);
		$res['total_count'] = $arr->total;
		$res['list'] = $arr->data;
		return $res;
	}
