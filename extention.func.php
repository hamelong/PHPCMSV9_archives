
function archives_date(){
	/**
	 * 获取指定日期段内每个有
	 * @param   $starttime 开始日期
	 * @param   $starttime 结束日期
	 * @return Array
	 */
	function firstday_lastday($linyufan_date){
		//本方法用于获取指定月份第1天和最后1天
		//$linyufan_date 是时间戳格式
		$today = date('Y-m-d',$linyufan_date);
		$firstday = date('Y-m-01', strtotime($today));//本月第一天
		$lastday = date('Y-m-d', strtotime("$firstday +1 month -1 day"));//本月最后一天
		$month_days_strtime = strtotime($firstday);
		$month_end_strtime = strtotime($lastday);
		//return $firstday_lastday = array($month_days_strtime,$month_end_strtime);
		return array($month_days_strtime,$month_end_strtime);
		}
	
	
	$linyufan_mysql_con = mysql_connect("localhost","","");
	mysql_select_db("");
	mysql_query("set names utf-8");		
	$starttime = strtotime('2012-01-01'); // 自动为00:00:00 时分秒
	$endtime = strtotime(date('y-m-d',time()));
	$monarr = array();
	while( ($starttime = strtotime('+1 month', $starttime)) <= $endtime){
	$monarr[] = date('Y年m月',$starttime); // 取得递增月;		
	$monarrs[] = strtotime(date('Y-m-d',$starttime)); // 判断年份用;
	rsort($monarr);
	rsort($monarrs);
	}
	//print_r($monarr);
	$month_count = count($monarr);
	//在列表页显示		
	for($month_counts=0;$month_counts<$month_count;$month_counts++){
		//指定月份有没有数据
		list($month_days_strtime,$month_end_strtime) = firstday_lastday($monarrs[$month_counts]); //函数使用方法
	$linyufan_result = mysql_query("select * from v9_news where inputtime between '$month_days_strtime' and '$month_end_strtime' order by 'inputtime' DESC");
	
		//输出所有月份
		if(mysql_num_rows($linyufan_result)=='0'){
			//没有数据的月份不用显示出来
		}else{
			$linyufan_date_list[] = $linyufan_years_style.'<li><a title="'.$monarr[$month_counts].'('.mysql_num_rows($linyufan_result).')" href="https://www.linyufan.com/archives-'.$monarrs[$month_counts].'.html">'.$monarr[$month_counts].'</a></li>';		
			$linyufan_months_substr = substr($monarr[$month_counts],7);
			if($linyufan_months_substr == '01月'){
				$linyufan_years_style = intval(mb_substr($monarr[$month_counts],0,4,'utf-8'))-1;	
				$linyufan_years_style = '<li style="width:92%;text-align: center;"><a style="width:100%;background:#338A9C;color:#fff;display:block;">'.$linyufan_years_style.'年</a></li>';
				}else{$linyufan_years_style='';}				
			
		}
			
				
	}
	return $linyufan_date_list;
}
