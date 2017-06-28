<?php
class PowerqsController extends AppController {

	var $name = 'Powerqs';
	var $helpers = array('Ajax', 'Javascript', 'Time');
	var $uses = array('Customer', 'Pqdata', 'Pqevent','Loadprofile');
	
	function index() {
		Configure::write('debug', 0);	
	}

	function trender() {
		$this->layout = null;	
		Configure::write('debug', 0);	
		$this->Customer->recursive = -1;
		
//		debug($this->params['pass'][0]);
		
//		$this->set('emptyval',$this->params['pass'][0]);

		$ph_arr = array();
		$met_arr = array();
		$field_arr = array("Pqdata.date");
		
		$ph_arr = array('1','2','3');
//		array_push($met_arr, array('Urms'));
		
		foreach ($ph_arr as $phs) {
			$minval = "Pqdata.Urms_".$phs."_min";
			$maxval = "Pqdata.Urms_".$phs."_max";
			$avgval = "Pqdata.Urms_".$phs."_avg";
			$stm = "$minval,$avgval,$maxval";
			array_push($field_arr, $stm);
		}

//		debug($field_arr);
		
		$_SESSION['customer_id'] = $this->params['pass'][0];
		$_SESSION['phases'] = $ph_arr;
		$_SESSION['stm'] = $field_arr;		

//		debug($_SESSION['stm']);
		
	}
	
	function report(){
		$this->layout = null;	
		Configure::write('debug', 0);	
		$this->Customer->recursive = -1;
//		
		$ph_arr = array();
		$met_arr = array();
		$field_arr = array("Pqdata.date");
		
//		debug($this->params['pass'][0]);
//		preg_match('/[0-9]+$/', $this->params['pass'][0], $matches);
////		debug($matches);
//		if (isset($matches[0])) {
//			array_push($ph_arr, array('1','2','3'));
//			array_push($met_arr, array('Urms'));
//			$this->set('emptyval',true);
//		}else{
			$keys = array_keys($this->params['form']);
			foreach ($keys as $params){
				if ($params == 'phase-1'){
					$ph = split('-', $params);
					array_push($ph_arr, $ph[1]);
				}elseif ($params == 'phase-2') {
					$ph = split('-', $params);
					array_push($ph_arr, $ph[1]);
				}elseif ($params == 'phase-3') {
					$ph = split('-', $params);
					array_push($ph_arr, $ph[1]);
				}elseif ($params == 'Urms') {
					array_push($met_arr, $params);
				}elseif ($params == 'Irms') {
					array_push($met_arr, $params);
				}elseif ($params == 'PF') {
					array_push($met_arr, $params);
				}elseif ($params == 'Plt') {
					array_push($met_arr, $params);
				}elseif ($params == 'THD') {
					array_push($met_arr, $params);
				}
			}				
//		}
		foreach ($ph_arr as $phs) {
			foreach ($met_arr as $met) {
				if ($met == 'Urms' || $met == 'Irms') {
					$minval = "Pqdata.".$met."_".$phs."_min";
					$maxval = "Pqdata.".$met."_".$phs."_max";
					$avgval = "Pqdata.".$met."_".$phs."_avg";
					$stm = "$minval,$avgval,$maxval";
					array_push($field_arr, $stm);
				}elseif ($met == 'PF'){
					$avgval = "Pqdata.".$met."_".$phs."_avg";
					array_push($field_arr, $avgval);
				}elseif ($met == 'THD') {
					$umaxval = "Pqdata."."THDu_".$phs."_max";
					$imaxval = "Pqdata."."THDi_".$phs."_max";
					$stm = "$umaxval,$imaxval";
					array_push($field_arr, $stm);
				}elseif ($met == 'Plt'){
					$val = "Pqdata.".$met."_".$phs;
					array_push($field_arr, $val);
				}
			}
		}
		$stmvar = join(",", $field_arr);
		
		if (isset($this->params['form']['customer_name'])) {
			$_SESSION['customer_name'] = $this->params['form']['customer_name'];
			$_SESSION['startdate'] = $this->params['form']['startdt'];
			$_SESSION['enddate'] = $this->params['form']['enddt'];
			$_SESSION['phases'] = $ph_arr;
			$_SESSION['stm'] = $field_arr;
		}elseif(isset($this->params['pass'][0])){
			$_SESSION['customer_id'] = $this->params['pass'][0];
//			$_SESSION['startdate'] = $this->params['form']['startdt'];
//			$_SESSION['enddate'] = $this->params['form']['enddt'];
			$_SESSION['phases'] = $ph_arr;
			$_SESSION['stm'] = $field_arr;			
		}
		$customer_names = $this->Customer->find('all', array('fields' => 'DISTINCT Customer.name'));

		$this->set('customer_names', $customer_names);
//		Cache::write('queues', $queue_names);		
	}
	
	function rawdata(){
		Configure::write('debug', '0');
		$this->Customer->recursive = -1;
		
		if(isset($_SESSION['customer_name'])){
			$cust = $this->Customer->findByName($_SESSION['customer_name']);
			$customer = $cust['Customer']['id'];
			$startdate = $_SESSION['startdate'];
			$enddate = $_SESSION['enddate'];
		}elseif (isset($_SESSION['customer_id'])){
			$customer = $_SESSION['customer_id'];
		}
		$stm = join(',', $_SESSION['stm']);
		
		if(isset($customer)){
			$table_data = $this->Pqdata->find('all',array('fields' => array($stm), 'conditions' => array('Pqdata.customer_id = ?' => array($customer)), 'order'=>array('Pqdata.date ASC')));
		}else{
			$table_data = array();
		}	
		
		$rawdata = array();
		$textcolor = "187b77";
		$headcolor = "187b77";

		$lastdate = '';
		$timebegin = '';

		$keys_arr = split(',', $stm);
		
		$mykeys = array();
		
		foreach ($keys_arr as $narr) {
			$ext = array();
			$ext = split("\.", $narr);
			array_push($mykeys, $ext[1]);
		}
		
		foreach($table_data as $datarow){
			$value = array();
			foreach ($datarow['Pqdata'] as $item) {
				array_push($value, $item);
			}
			
			$rowdata = array_combine($mykeys, $value);
			array_push($rawdata, $rowdata);			
		}

		$start = isset($_POST['start'])?$_POST['start']:0;
		$limit = isset($_POST['limit'])?$_POST['limit']:30;

		$paging = array(
		'success'=>true,
		'total'=>count($rawdata),
		'data'=> array_splice($rawdata,$start,$limit),
		);
		
		$this->autoRender = false;

		e(json_encode($paging));		
	}
	
	function event_rawdata() {
		$this->Pqevent->recursive = 0;
		Configure::write('debug', '0');
		$this->Customer->recursive = -1;
		
		$rawdata = array();
		
		if(isset($_SESSION['customer_name'])){
			$cust = $this->Customer->findByName($_SESSION['customer_name']);
			$customer = $cust['Customer']['id'];
			$startdate = $_SESSION['startdate'];
			$enddate = $_SESSION['enddate'];
			$phs = join(",", $_SESSION['phases']);
		}elseif (isset($_SESSION['customer_id'])){
			$customer = $_SESSION['customer_id'];
			$phs = join(",", $_SESSION['phases']);
		}
		
//		$eventfields = $this->Pqevent->_schema;
		
//		debug($_SESSION);

		if(isset($customer)){
//			$table_data = $this->Pqevent->find('all',array('conditions' => array('Pqevent.customer_id = ? and Pqevent.phase in (?)' => array($customer,$phs)), 'order'=>array('Pqevent.phase','Pqevent.datetime ASC')));
			$table_data = $this->Pqevent->query("select * from pqevents where customer_id = $customer and phase in ($phs) order by phase, datetime");
			
		}else{
//			$table_data = $this->Pqevent->find('all');
			$table_data = array();
		}
		
//		debug($table_data);
	
		foreach($table_data as $datarow){
			$date = $datarow['pqevents']['datetime'];
			$cycle = $datarow['pqevents']['cycle'];
			$type = $datarow['pqevents']['type'];
			$phase = $datarow['pqevents']['phase'];
			$duration = $datarow['pqevents']['duration'];
			$volttrigger = $datarow['pqevents']['volttrigger'];
			$vrms = $datarow['pqevents']['vrms'];
			$vavg = $datarow['pqevents']['vavg'];
			$irms = $datarow['pqevents']['irms'];
			$iavg = $datarow['pqevents']['iavg'];
			
			array_push($rawdata,array('datetime' => $date, 
									'cycle' => $cycle, 
									'type' => $type,
									'phase' => $phase,
									'duration' => $duration,
									'volttrigger' => $volttrigger,
									'vrms' => $vrms,
									'vavg' => $vavg,
									'irms' => $irms,
									'iavg' => $iavg,
			));
		}
		
		$start = isset($_POST['start'])?$_POST['start']:0;
		$limit = isset($_POST['limit'])?$_POST['limit']:30;

		$paging = array(
		'success'=>true,
		'total'=>count($rawdata),
		'data'=> array_splice($rawdata,$start,$limit),
		);
		
//		debug($table_data);
		$this->autoRender = false;
		
		e(json_encode($paging));
	}
	
	function chart() {
		$this->layout = null;
		$this->Pqdata->recursive = 0;
		$this->Customer->recursive = -1;
		Configure::write('debug', '0');

		debug($this->params);

		if (isset($_SESSION['customer_id'])) {
			$customer = $_SESSION['customer_id'];
		}else{
			$cust = $this->Customer->findByName($_SESSION['customer_name']);
			$customer = $cust['Customer']['id'];
			$startdate = $_SESSION['startdate'];
			$enddate = $_SESSION['enddate'];
		}

		$stm = join(',', $_SESSION['stm']);

		$pq_data= array();
		if(isset($customer)){
			$pq_data = $this->Pqdata->find('all',array('fields' => array($stm), 'conditions' => array('Pqdata.customer_id = ?' => array($customer)), 'order'=>array('Pqdata.date ASC')));
		}else{
			$pq_data = array();
		}

		$keys_arr = split(',', $stm);
		$mykeys = array();
		foreach ($keys_arr as $narr) {
			$ext = array();
			$ext = split("\.", $narr);
			array_push($mykeys, $ext[1]);
		}		

		$data = array();
		foreach ($pq_data as $value) {
			foreach ($mykeys as $key) {
				if($key != 'date'){
					if (empty($data[$key])) {
						$data[$key] = array();
					}
					$pattern = "/THD/";
//					if(preg_match($pattern, $key)){$value['Pqdata'][$key] = floatval($value['Pqdata'][$key]) * 100;}
					if(preg_match($pattern, $key)){$value['Pqdata'][$key] = floatval($value['Pqdata'][$key]);}
					array_push($data[$key], array($value['Pqdata']['date'],floatval($value['Pqdata'][$key])));
				}
			}
		}		
		$ddate = split(' ', $pq_data[0]['Pqdata']['date']);
		$ttime = split(':', $ddate[1]);
		$rdate = split('-', $ddate[0]);
		$rdate[1] = $rdate[1] - 1; //this is to fix the UTC issue
		$fdt = array_merge($rdate,$ttime);
		$mydate = join(',', $fdt);
		
		$this->set('data' , $data);
		$this->set('startdate', $mydate);
	}
	
	function gridmetrics() {
		$this->layout = null;
		Configure::write('debug', '0');
		$this->Pqdata->recursive = 0;
//		debug($this->params);

		$stm = join(',', $_SESSION['stm']);
		$keys_arr = split(',', $stm);
		$mykeys = array();
		foreach ($keys_arr as $narr) {
			$ext = split("\.", $narr);
			array_push($mykeys, $ext[1]);
		}
		
		$dateval = array_shift($mykeys);
		$this->set("fields",$mykeys);
		$this->set("date",$dateval);
	}
	
	function eventmetrics() {
		$this->layout = null;
		Configure::write('debug', '0');
		
		
	}

	function itic_chart() {
		$this->layout = null;
		$this->Pqevent->recursive = 0;
		$this->Customer->recursive = 0;
		Configure::write('debug', '0');

//		debug($vnom);
		if (isset($_SESSION['customer_id'])) {
			$customer = $_SESSION['customer_id'];
			$cust = $this->Customer->findById($customer);
			
		}else{
			$cust = $this->Customer->findByName($_SESSION['customer_name']);
			$customer = $cust['Customer']['id'];
		}
		
		$vnom =  $cust['System']['vnominal'];
		$phs = join(",", $_SESSION['phases']);
		
		$pq_data= array();
		if(isset($customer)){
			$table_data = $this->Pqevent->query("select * from pqevents where customer_id = $customer and phase in ($phs) order by phase, datetime");
		}else{
			$table_data = array();
		}
//		debug($table_data);
		$rawdata = array();
		$lastvalue = 0.0;
		foreach($table_data as $datarow){
			$phase = $datarow['pqevents']['phase'];
			$duration = $datarow['pqevents']['duration'];
			$volttrigger = $datarow['pqevents']['volttrigger'];
			$vrms = $datarow['pqevents']['vrms'];
			
			$volt = floatval(($vrms/$vnom)*100);
			
			if ($lastvalue < $duration) {
				$lastvalue = $duration;
			}
//			debug($lastvalue);
			if (empty($rawdata[$phase])) {
				$rawdata[$phase] = array();
			}
			
			array_push($rawdata[$phase],array(
					'duration' => $duration,
					'vrms' => $volt
				)
			);

			

		}
		$this->set('vnominal', $vnom);
		$this->set("data", $rawdata);
		$this->set("lastpoint", $lastvalue);
//		debug($rawdata);
	}
	
	function histogram() {
		$this->layout = null;
		$this->Pqdata->recursive = 0;
		$this->Customer->recursive = 0;
		Configure::write('debug', 0);
		
		if(isset($_SESSION['customer_name'])){
//			$customer = $_SESSION['customer_name'];
			$cust = $this->Customer->findByName($_SESSION['customer_name']);
			$vnom =  $cust['System']['vnominal'];
			$customer = $cust['Customer']['id'];
			$startdate = $_SESSION['startdate'];
			$enddate = $_SESSION['enddate'];
		}elseif (isset($_SESSION['customer_id'])){
			$customer = $_SESSION['customer_id'];
			$cust = $this->Customer->findById($customer);
			$vnom =  $cust['System']['vnominal'];
			
		}
//		debug($_SESSION);
		$volt_fields = array();
		foreach ($_SESSION['stm'] as $field) {
			if ($field == 'Pqdata.Urms_1_min,Pqdata.Urms_1_avg,Pqdata.Urms_1_max' || $field == 'Pqdata.Urms_2_min,Pqdata.Urms_2_avg,Pqdata.Urms_2_max' || $field == 'Pqdata.Urms_3_min,Pqdata.Urms_3_avg,Pqdata.Urms_3_max') {
//				debug($field);
				array_push($volt_fields, $field);
			}
		}
//		debug($volt_fields);
		$stm = join(',', $volt_fields);
//				debug($stm);
		if(isset($customer)){
			$table_data = $this->Pqdata->find('all',array('fields' => array($stm), 'conditions' => array('Pqdata.customer_id = ?' => array($customer)), 'order'=>array('Pqdata.date ASC')));
		}else{
			$table_data = array();
		}
		$hist_data = array();
		
		$a1 = $b1 = $c1 = $d1 = $e1 = $f1 = $g1 = 0;
		$a2 = $b2 = $c2 = $d2 = $e2 = $f2 = $g2 = 0;
		$a3 = $b3 = $c3 = $d3 = $e3 = $f3 = $g3 = 0;

		foreach ($table_data as $value) {
//			debug($value['Pqdata']);
			if(isset($value['Pqdata']['Urms_1_avg'])){
				if (empty($hist_data['1'])) {
					$hist_data['1'] = array();
				}
				$clase = floatval(($value['Pqdata']['Urms_1_avg']/$vnom)*100);
				if ($clase < 84) {
					$a1 = $a1 + 1;
				}elseif ($clase >= 84 && $clase < 93 ) {
					$b1 = $b1 + 1;
				}elseif ($clase >= 93 && $clase < 95) {
					$c1 = $c1 + 1;
				}elseif ($clase >= 95 && $clase < 106) {
					$d1 = $d1 + 1;
				}elseif ($clase >= 106 && $clase < 109) {
					$e1 = $e1 + 1;
				}elseif ($clase >= 109 && $clase < 113) {
					$f1 = $f1 + 1;
				}elseif ($clase >= 113) {
					$g1 = $g1 + 1;
				}
			}
			if (isset($value['Pqdata']['Urms_2_avg'])) {
				if (empty($hist_data['2'])) {
					$hist_data['2'] = array();
				}
//				debug($value['Pqdata']['Urms_2_avg']);
				$clase = floatval(($value['Pqdata']['Urms_2_avg']/$vnom)*100);
				if ($clase < 84) {
					$a2 = $a2 + 1;
				}elseif ($clase >= 84 && $clase < 93 ) {
					$b2 = $b2 + 1;
				}elseif ($clase >= 93 && $clase < 95) {
					$c2 = $c2 + 1;
				}elseif ($clase >= 95 && $clase < 106) {
					$d2 = $d2 + 1;
				}elseif ($clase >= 106 && $clase < 109) {
					$e2 = $e2 + 1;
				}elseif ($clase >= 109 && $clase < 113) {
					$f2 = $f2 + 1;
				}elseif ($clase >= 113) {
					$g2 = $g2 + 1;
				}				
			}
			if (isset($value['Pqdata']['Urms_3_avg'])) {
				if (empty($hist_data['3'])) {
					$hist_data['3'] = array();
				}
//				debug($value['Pqdata']['Urms_3_avg']);
				$clase = floatval(($value['Pqdata']['Urms_3_avg']/$vnom)*100);
				if ($clase < 84) {
					$a3 = $a3 + 1;
				}elseif ($clase >= 84 && $clase < 93 ) {
					$b3 = $b3 + 1;
				}elseif ($clase >= 93 && $clase < 95) {
					$c3 = $c3 + 1;
				}elseif ($clase >= 95 && $clase < 106) {
					$d3 = $d3 + 1;
				}elseif ($clase >= 106 && $clase < 109) {
					$e3 = $e3 + 1;
				}elseif ($clase >= 109 && $clase < 113) {
					$f3 = $f3 + 1;
				}elseif ($clase >= 113) {
					$g3 = $g3 + 1;
				}
			}
		}
		if (isset($hist_data['1'])) {
			$hist_data['1'] = array($a1, $b1, $c1, $d1, $e1, $f1, $g1);
		}
		if (isset($hist_data['2'])) {
			$hist_data['2'] = array($a2, $b2, $c2, $d2, $e2, $f2, $g2);
		}
		if (isset($hist_data['3'])) {
			$hist_data['3'] = array($a3, $b3, $c3, $d3, $e3, $f3, $g3);
		}
//		debug($hist_data);

		$this->set('histdata', $hist_data);
	}
	
	function loadprofile() {
		$this->layout = null;
		$this->Customer->recursive = -1;
		$this->Loadprofile->recursive = -1;
		$this->Pqdata->recursive = -1;
		Configure::write('debug', '0');
		
		if (isset($_SESSION['customer_id'])) {
			$cust = $this->Customer->findById($_SESSION['customer_id']);
		}else{
			$cust = $this->Customer->findByName($_SESSION['customer_name']);
		}
		
//		debug($cust);
		if(isset($cust)){
			$table_data = $this->Loadprofile->find('all',array('conditions' => array('Loadprofile.customer_id = ?' => $cust['Customer']['id']), 'order' => array('Loadprofile.date ASC')));
			$table_power = $this->Pqdata->find('all',array('conditions' => array('Pqdata.customer_id = ?' => $cust['Customer']['id']), 'order' => array('Pqdata.date ASC')));
		}else{
			$table_data = array();
			$table_power = array();
		}
		$rawdata = array();
		$datedata = array();
		$powerdata = array();
//$avgval = "Pqdata.Urms_".$phs."_avg";		
		foreach ($table_power as $powerrow) {
			$datearr = split(' ', $powerrow['Pqdata']['date']);
			$timearr = split(':', $datearr[1]);
			debug($timearr[1]);
			if ($timearr[1] == '00') {
				if (!empty($powerdata)) {
					$var1 = floatval(($var1a+$var2a)/2);
					$var2 = floatval(($var1b+$var2b)/2);
					$var3 = floatval(($var1c+$var2c)/2);
					array_push($powerdata, array($var1,$var2,$var3));
				}
				array_push($powerdata, array($powerrow['Pqdata']['Urms_1_avg'],$powerrow['Pqdata']['Urms_2_avg'],$powerrow['Pqdata']['Urms_3_avg']));
			}elseif ($timearr[1] == '10' ){
				$var1a = $powerrow['Pqdata']['Urms_1_avg'];
				$var1b = $powerrow['Pqdata']['Urms_2_avg'];
				$var1c = $powerrow['Pqdata']['Urms_3_avg'];
			}elseif ($timearr[1] == '20'){
				$var2a = $powerrow['Pqdata']['Urms_1_avg'];
				$var2b = $powerrow['Pqdata']['Urms_2_avg'];
				$var2c = $powerrow['Pqdata']['Urms_3_avg'];	
			}elseif ($timearr[1] == '30'){
				$var1 = floatval(($var1a+$var2a)/2);
				$var2 = floatval(($var1b+$var2b)/2);
				$var3 = floatval(($var1c+$var2c)/2);
				array_push($powerdata, array($var1,$var2,$var3));
				array_push($powerdata, array($powerrow['Pqdata']['Urms_1_avg'],$powerrow['Pqdata']['Urms_2_avg'],$powerrow['Pqdata']['Urms_3_avg']));
			}elseif ($timearr[1] == '40'){
				$var1a = $powerrow['Pqdata']['Urms_1_avg'];
				$var1b = $powerrow['Pqdata']['Urms_2_avg'];
				$var1c = $powerrow['Pqdata']['Urms_3_avg'];
			}elseif ($timearr[1] == '50'){
				$var2a = $powerrow['Pqdata']['Urms_1_avg'];
				$var2b = $powerrow['Pqdata']['Urms_2_avg'];
				$var2c = $powerrow['Pqdata']['Urms_3_avg'];
			}
		}
		$index = 0;
		foreach($table_data as $datarow){
			$kwh = $datarow['Loadprofile']['KWh'];
			$kvah = $datarow['Loadprofile']['KVAh'];
			if (!isset($date)) {
				$date = $datarow['Loadprofile']['date'];
			}
			
			array_push($rawdata,array(
					'kwh' => $kwh,
					'kvah' => $kvah,
					'date' => $datarow['Loadprofile']['date'],
					'Vavg1' => $powerdata[$index]['1'],
					'Vavg2' => $powerdata[$index]['2'],
					'Vavg3' => $powerdata[$index]['3']
				)
			);
			$index++;
		}

		$ddate = split(' ', $date);
		$ttime = split(':', $ddate[1]);
		$rdate = split('-', $ddate[0]);
		$rdate[1] = $rdate[1] - 1; //this is to fix the UTC issue
		$fdt = array_merge($rdate,$ttime);
		$mydate = join(',', $fdt);
		$this->set('data',$rawdata);
		$this->set('startdate',$mydate);		
		
	}

}
?>