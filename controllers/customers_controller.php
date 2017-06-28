<?php
class CustomersController extends AppController {

	var $name = 'Customers';
	var $uses = array('Customer', 'Pqdata', 'System', 'Equipment', 'Loadprofile', 'Outvalue', 'Threhold');
	var $helpers = array('Ajax', 'Javascript');
	var $components = array('RequestHandler');
	
	function index() {
		$this->Customer->recursive = 0;
		$this->set('customers', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid customer', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('customer', $this->Customer->read(null, $id));
	}

	function add() {
		$this->System->recursive = -1;
		$this->Equipment->recursive = -1;
		if (!empty($this->data)) {
			$this->Customer->create();
			if ($this->Customer->save($this->data)) {
				$this->Session->setFlash(__('The customer has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The customer could not be saved. Please, try again.', true));
			}
		}else{
			$syst = $this->System->find('all');
			$equip = $this->Equipment->find('all');
			$system_arr  = array();
			$equip_arr = array();

			foreach ($syst as $key => $value) {
				$system_arr[$value['System']['id']] = $value['System']['name'];
			}
			foreach ($equip as $key => $value) {
				$equip_arr[$value['Equipment']['id']] = $value['Equipment']['mark']."-".$value['Equipment']['model']."-".$value['Equipment']['serialnumber'];
			}
		$this->set("systems", $system_arr);
		$this->set("equipments", $equip_arr);
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid customer', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Customer->save($this->data)) {
				$this->Session->setFlash(__('The customer has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The customer could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Customer->read(null, $id);
			
			$syst = $this->System->find('all');
			$equip = $this->Equipment->find('all');
			$system_arr  = array();
			$equip_arr = array();

			foreach ($syst as $key => $value) {
				$system_arr[$value['System']['id']] = $value['System']['name'];
			}
			foreach ($equip as $key => $value) {
				$equip_arr[$value['Equipment']['id']] = $value['Equipment']['mark']."-".$value['Equipment']['model']."-".$value['Equipment']['serialnumber'];
			}
			$this->set("systems", $system_arr);
			$this->set("equipments", $equip_arr);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for customer', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Customer->delete($id,true)) {
			
			$this->Session->setFlash(__('Customer deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Customer was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
	
	function uploader() {
		$this->layout = null;
		$this->render('/customers/uploader');
	}
	
	function loadfile() {
		App::import('Vendor','parsecsv');
		$this->Equipment->recursive = -1;
		
		$locdir = 'C:/wamp/tmp';
		$myfile = '';
		$tempfile = "$locdir/tempfile_".rand(1,999).".csv";
		$tmphandle = fopen($tempfile, "w");

	    fwrite($tmphandle, fread(fopen($this->data['customers']['dataoutput']['tmp_name'], "r"), $this->data['customers']['dataoutput']['size']));
		fclose($tmphandle);
		sleep(1);
		
		$filename = $datafile = $dataevent = $eventfile = '';
		
		$equip = $this->Equipment->findById($this->data['customers']['equipment_id']);
//		debug($equip);
		if ($equip['Equipment']['mark'] == 'Enetics') {
//=====================================		
			$csv = new parseCSV();
			$csv->delimiter = ",";
	
			$csv->parse("$tempfile");
			$filename = "$locdir/pre-procfile_".rand(1,999).".csv";
			$eventfile = "$locdir/pre-eventfile_".rand(1,999).".csv";
			$handle = fopen($filename, "w");
			$handleevent = fopen($eventfile, "w");
			
			$flag = false;
			$flagevent = false;
			$data = array();
			foreach ($csv->data as $row)
			{
				if ($row['Enetics PowerNode Data'] == 'Interval Raw Data') {
					$flag = true;
				}elseif ($row['Enetics PowerNode Data'] == ''){
					$flag = false;
				}elseif ($flag == true) {
					fwrite($handle, join(',', $row));
					fwrite($handle, "\n");
				}elseif ($row['Enetics PowerNode Data'] == 'Event Raw Data'){
					$flagevent = true;
				}elseif ($row['Enetics PowerNode Data'] == 'Recorder Log'){
					$flagevent = false;				
				}elseif ($flagevent == true){
					fwrite($handleevent, join(',', $row));
					fwrite($handleevent, "\n");
				}
			}
			fclose($handle);
			fclose($handleevent);
			
			$precsv = new parseCSV();
			$precsv->delimiter = ",";
			$precsv->parse($filename);	
//			debug($precsv->titles);
			$titles = $precsv->titles;
			$phs1 = $phs2 = $phs3 = false;
			if (count($titles) <= 8) {
				$phs1 = true;
			}elseif ( count($titles) > 8 ){
//				debug('estoy en phase 2');
				$phs2 = true;
			}
			if ( count($titles) > 14 ) {
//				debug('estoy en pahse 3');
				$phs3 = true;
			}
			$datafile = "$locdir/procfile_".rand(1,999).".csv";
			$handle2 = fopen($datafile, "w");
			$null = 'NULL';
			foreach ($precsv->data as $col) {
				$thdia = doubleval($col['Phase A Harmonic Current (A)'])/doubleval($col['Phase A Avg Amps']);
				($phs2 == true) ? $thdib = doubleval($col['Phase B Harmonic Current (A)'])/doubleval($col['Phase B Avg Amps']) :  $thdib = $null;
				($phs3 == true) ? $thdic = doubleval($col['Phase C Harmonic Current (A)'])/doubleval($col['Phase C Avg Amps']) :  $thdic = $null;
				
				$dt = split(" ", $col['Time']);
				$date = split("-", $dt[0]);
				switch ($date[1]) {
				    case 'Jan':
				        $month = 01;
				        break;
				    case 'Feb':
				        $month = 02;
				        break;
				    case 'Mar':
				        $month = 03;
				        break;
				    case 'Apr':
				        $month = 04;
				        break;
				    case 'May':
				        $month = 05;
				        break;
				    case 'Jun':
				        $month = 06;
				        break;
				    case 'Jul':
				        $month = 07;
				        break;
				    case 'Aug':
				        $month = 08;
				        break;
				    case 'Set':
				        $month = 09;
				        break;
				    case 'Oct':
				        $month = 10;
				        break;
				    case 'Nov':
				        $month = 11;
				        break;
				    case 'Dec':
				        $month = 12;
				        break;		        		        		        
				}
	
				$time = $dt[1];
				$datetime = $date[2]."-".$month."-".$date[0]." ".$time;
				
				$vmina = $col['Phase A-N Min Volts'];
				$vavga = $col['Phase A-N Avg Volts'];
				$vmaxa = $col['Phase A-N Max Volts'];
				($phs2) ? $vminb = $col['Phase B-N Min Volts'] : $vminb = $null;
				($phs2) ? $vavgb = $col['Phase B-N Avg Volts'] : $vavgb = $null;
				($phs2) ? $vmaxb = $col['Phase B-N Max Volts'] : $vmaxb = $null;
				($phs3) ? $vminc = $col['Phase C-N Min Volts'] : $vminc = $null;
				($phs3) ? $vavgc = $col['Phase C-N Avg Volts'] : $vavgc = $null;
				($phs3) ? $vmaxc = $col['Phase C-N Max Volts'] : $vmaxc = $null;								
				$imina = $col['Phase A Min Amps'];
				$iavga = $col['Phase A Avg Amps'];
				$imaxa = $col['Phase A Max Amps'];
				($phs2) ? $iminb = $col['Phase B Min Amps'] : $iminb = $null;
				($phs2) ? $iavgb = $col['Phase B Avg Amps'] : $iavgb = $null;
				($phs2) ? $imaxb = $col['Phase B Max Amps'] : $imaxb = $null;
				($phs3) ? $iminc = $col['Phase C Min Amps'] : $iminc = $null;
				($phs3) ? $iavgc = $col['Phase C Avg Amps'] : $iavgc = $null;
				($phs3) ? $imaxc = $col['Phase C Max Amps'] : $imaxc = $null;
				$pfa = $col['Phase A Total PF (Lagging is +)'];
				($phs2) ? $pfb = $col['Phase B Total PF (Lagging is +)'] : $pfb = $null;
				($phs3) ? $pfc = $col['Phase C Total PF (Lagging is +)'] : $pfc = $null;
				$thdva = $col['Phase A-N Voltage THD'];
				($phs2) ? $thdvb = $col['Phase B-N Voltage THD'] : $thdvb = $null;
				($phs3) ? $thdvc = $col['Phase C-N Voltage THD'] : $thdvc = $null;
				
				
				$datarow = $this->data['customers']['id'].",".
				$this->data['customers']['equipment_id'].",".
				$datetime.",".
				$vmina.",".
				$vavga.",".
				$vmaxa.",".
				$vminb.",".
				$vavgb.",".
				$vmaxb.",".
				$vminc.",".
				$vavgc.",".
				$vmaxc.",".						
				$imina.",".
				$iavga.",".
				$imaxa.",".
				$iminb.",".
				$iavgb.",".
				$imaxb.",".
				$iminc.",".
				$iavgc.",".
				$imaxc.",".						
				$pfa.",".
				$pfb.",".
				$pfc.",".
				$thdva.",".
				$thdvb.",".
				$thdvc.",".
				$thdia.",".
				$thdib.",".
				$thdic.",".
				$col['Min Frequency (Hz)'].",".
				$col['Avg Frequency (Hz)'].",".
				$col['Max Frequency (Hz)'].									
				"\r\n";
				fwrite($handle2, $datarow);
			}
			fclose($handle2);
			
			$precsv2 = new parseCSV();
			$precsv2->delimiter = ",";
			$precsv2->parse($eventfile);	
			$dataevent = "$locdir/procevent_".rand(1, 999).".csv";
			$handleevent2 = fopen($dataevent, "w");	
			
			foreach ($precsv2->data as $col) {
				$dt = split(" ", $col['Time']);
				$date = split("-", $dt[0]);
				switch ($date[1]) {
				    case 'Jan':
				        $month = 01;
				        break;
				    case 'Feb':
				        $month = 02;
				        break;
				    case 'Mar':
				        $month = 03;
				        break;
				    case 'Apr':
				        $month = 04;
				        break;
				    case 'May':
				        $month = 05;
				        break;
				    case 'Jun':
				        $month = 06;
				        break;
				    case 'Jul':
				        $month = 07;
				        break;
				    case 'Aug':
				        $month = 08;
				        break;
				    case 'Set':
				        $month = 09;
				        break;
				    case 'Oct':
				        $month = 10;
				        break;
				    case 'Nov':
				        $month = 11;
				        break;
				    case 'Dec':
				        $month = 12;
				        break;		        		        		        
				}
				
				if ($col['Phase A-N Threshold (V)'] != '') {
					$phase = 1;
					$duration = $col['Phase A-N Duration (secs)'];
					$volttrigger = $col['Phase A-N Threshold (V)'];
					$vrms = $col['Phase A-N Worst (V)'];
					$vavg = $col['Phase A-N Avg (V)'];
					$irms = $col['Phase A Current At Worst Voltage (A)'];
					$iavg = $col['Phase A Avg (A)'];
				}elseif ($col['Phase B-N Threshold (V)'] != '') {
					$phase = 2;
					$duration = $col['Phase B-N Duration (secs)'];
					$volttrigger = $col['Phase B-N Threshold (V)'];
					$vrms = $col['Phase B-N Worst (V)'];
					$vavg = $col['Phase B-N Avg (V)'];
					$irms = $col['Phase B Current At Worst Voltage (A)'];
					$iavg = $col['Phase B Avg (A)'];
				}elseif ($col['Phase C-N Threshold (V)'] != '') {
					$phase = 3;
					$duration = $col['Phase C-N Duration (secs)'];
					$volttrigger = $col['Phase C-N Threshold (V)'];
					$vrms = $col['Phase C-N Worst (V)'];
					$vavg = $col['Phase C-N Avg (V)'];
					$irms = $col['Phase C Current At Worst Voltage (A)'];
					$iavg = $col['Phase C Avg (A)'];
				}
	
				$time = $dt[1];
				$datetime = $date[2]."-".$month."-".$date[0]." ".$time;		
				$datarow = $this->data['customers']['id'].",".
				$datetime.",".
				$col['Cycle (secs)'].",".
				$col['Event Type'].",".
				$phase.",".
				$duration.",".
				$volttrigger.",".
				$vrms.",".
				$vavg.",".
				$irms.",".
				$iavg.
				"\r\n";
				
				if ($col['Complete'] == 'Y') {
					fwrite($handleevent2, $datarow);
				}
			}
			fclose($handleevent2);
		}elseif ($equip['Equipment']['mark'] == 'Dewetron') {
//	=============DEWETRON==================	
			;
		}elseif ($equip['Equipment']['mark'] == 'Elster') {
//	=============ELSTER==================		
			$csv = new parseCSV();
			$csv->delimiter = " ";
			$null = 'NULL';
			$csv->parse("$tempfile");
			$datafile = "$locdir/procfile_".rand(1,999).".csv";
			$handle = fopen($datafile, "w");
			
			$titles = $csv->titles;
			$phs1 = $phs2 = $phs3 = false;
			
			debug(count($titles));
			
			if (count($titles) <= 8) {
				$phs1 = true;
			}elseif ( count($titles) > 9 ){
//				debug('estoy en phase 2');
				$phs2 = true;
			}
			if ( count($titles) > 13 ) {
//				debug('estoy en pahse 3');
				$phs3 = true;
			}

			

				
			foreach ($csv->data as $col) {
				$date_arr = split("/", $col['Date']);
				if ($col['Time'] == '24:00') {
					$col['Time'] = '23:59:59';
				}
				$datetime = $date_arr[2]."-".$date_arr[1]."-".$date_arr[0]." ".$col['Time'];
				
				$vavga = $col['Promedio Phase A voltage'];
				($phs2) ? $vavgb = $col['Promedio Phase B voltage'] : $vavgb = $null;
				($phs3) ? $vavgc = $col['Promedio Phase C voltage'] : $vavgc = $null;
				$iavga = $col['Promedio Phase A current'];
				($phs2) ? $iavgb = $col['Promedio Phase B current'] : $iavgb = $null;
				($phs3) ? $iavgc = $col['Promedio Phase C current'] : $iavgc = $null;
				$pfa = $col['Final Phase A PF'];
				($phs2) ? $pfb = $col['Final Phase B PF'] : $pfb = $null;
				($phs3) ? $pfc = $col['Final Phase C PF'] : $pfc = $null;
				$thdva = $col['Final Phase A voltage % THD'];
				($phs2) ? $thdvb = $col['Final Phase B voltage % THD'] : $thdvb = $null;
				($phs3) ? $thdvc = $col['Final Phase C voltage % THD'] : $thdvc = $null;			
				$thdia = $col['Final Phase A current % THD'];
				($phs2) ? $thdib = $col['Final Phase B current % THD'] : $thdib = $null;
				($phs3) ? $thdic = $col['Final Phase C current % THD'] : $thdic = $null;					
				
				$datarow = $this->data['customers']['id'].",".
				$this->data['customers']['equipment_id'].",".
				$datetime.",".
				$null.",".
				str_replace(",", ".", $vavga).",".
				$null.",".
				$null.",".
				str_replace(",", ".", $vavgb).",".
				$null.",".
				$null.",".
				str_replace(",", ".", $vavgc).",".
				$null.",".						
				$null.",".
				str_replace(",", ".", $iavga).",".
				$null.",".
				$null.",".
				str_replace(",", ".", $iavgb).",".
				$null.",".
				$null.",".
				str_replace(",", ".", $iavgc).",".
				$null.",".						
				str_replace(",", ".", $pfa).",".
				str_replace(",", ".", $pfb).",".
				str_replace(",", ".", $pfc).",".
				str_replace(",", ".", $thdva).",".
				str_replace(",", ".", $thdvb).",".
				str_replace(",", ".", $thdvc).",".
				str_replace(",", ".", $thdia).",".
				str_replace(",", ".", $thdib).",".
				str_replace(",", ".", $thdic).	
//				$null.",".
//				$null.",".
//				$null.",".
//				$null.",".
//				$null.",".
//				$null.",".							
				"\r\n";
				fwrite($handle, $datarow);
				
			}
			fclose($handle);
		}
//==================================		

		$loadsql = 'LOAD DATA INFILE '."'".$datafile."'".' INTO TABLE pqdatas FIELDS TERMINATED BY "," OPTIONALLY ENCLOSED BY """" LINES TERMINATED BY "\r\n" IGNORE 0 LINES';
		$loading =  $this->Pqdata->query($loadsql);
		
		if($equip['Equipment']['mark'] == 'Enetics'){
			$loadsql2 = 'LOAD DATA INFILE '."'".$dataevent."'".' INTO TABLE pqevents FIELDS TERMINATED BY "," OPTIONALLY ENCLOSED BY """" LINES TERMINATED BY "\r\n" IGNORE 0 LINES';
			$loading2 =  $this->Pqdata->query($loadsql2);		
		}
		if ($loading) {
			$this->Customer->updateAll(array('Customer.status' => "'DataFile Loaded'"),array('Customer.id' => $this->data['customers']['id']));
			unlink($tempfile);
			
			unlink($filename);
			unlink($datafile);
			
			unlink($eventfile);
			unlink($dataevent);			
			$this->Session->setFlash(__('The file has been loaded successfully', true));
		}else{
			$this->Session->setFlash(__('Something was wrong! The data was not loaded', true));
			
		}
		$this->redirect(array('action' => 'index'));
		
	}

	function addloadprofile() {
		$this->layout = null;
		$this->render('/customers/loadprofiler');
	}
	
	function loadprofile(){
		App::import('Vendor','parsecsv');
		$this->Equipment->recursive = -1;
		
		$locdir = 'C:/wamp/tmp';
		$myfile = '';
		$profile_tempfile = "$locdir/tempprofile_".rand(1,999).".csv";
		$profile_tmphandle = fopen($profile_tempfile, "w");

	    fwrite($profile_tmphandle, fread(fopen($this->data['customers']['loadprofile']['tmp_name'], "r"), $this->data['customers']['loadprofile']['size']));
		fclose($profile_tmphandle);
		sleep(1);
		
		$datafile = '';
		
		$equip = $this->Equipment->findById($this->data['customers']['equipment_id']);	
		
		$csv = new parseCSV();
//		$csv->delimiter = ",";# debe ser por espacios
		$csv->delimiter = " ";
//		$csv->heading = false;// should have headers
		
		$csv->parse("$profile_tempfile");
		$datafile = "$locdir/proc_loadprofile_".rand(1,999).".csv";
		$handle = fopen($datafile, "w");
		
		foreach ($csv->data as $row) {
			$date_arr = split("/", $row['Date']);
			if ($row['Time'] == '24:00') {
				$row['Time'] = '23:59:59';
			}
			$datetime = $date_arr[2]."-".$date_arr[1]."-".$date_arr[0]." ".$row['Time'];
			
//			debug($row);
			str_replace(",", ".", $row['kWh-Del']);
			str_replace(",", ".", $row['kVAh-Del']);
//			    [kWh-Del] => 1,222200000000000
//    			[kVAh-Del] => 1,261200000000000
			
//			$kwh_tmp = $row[4].".".$row[5];
			$kwh = floatval($row['kWh-Del']/0.9);
//			$kvah_tmp = $row[6].".".$row[7];
			$kvah = floatval($row['kVAh-Del']/0.9);

			
			
			$datarow = $this->data['customers']['id'].",".
			$this->data['customers']['equipment_id'].",".
			$datetime.",".$row['Int.Len'].",".$kwh.",".$kvah."\r\n";
			fwrite($handle, $datarow);
		}
		fclose($handle);
		
		$loadsql = 'LOAD DATA INFILE '."'".$datafile."'".' INTO TABLE loadprofiles FIELDS TERMINATED BY "," OPTIONALLY ENCLOSED BY """" LINES TERMINATED BY "\r\n" IGNORE 0 LINES';
		$loading =  $this->Loadprofile->query($loadsql);
		
		if ($loading) {
			unlink($profile_tempfile);
			unlink($datafile);		
			$this->Session->setFlash(__('The Loadprofile file has been loaded successfully', true));
		}else{
			$this->Session->setFlash(__('Something was wrong! The data was not loaded', true));
			
		}
		$this->redirect(array('action' => 'index'));		
		
	}
	
	function analysis($id = null) {
		
		
		$this->Threhold->recursive = -1;
		$this->Pqdata->recursive = -1;
		$this->Outvalue->recursive = -1;
		Configure::write('debug', '0');	
		
		$cust = $this->Customer->find($id);

		$system_tri = false;
		if ($cust['System']['name'] != 'Monofasico bifilar' && $cust['System']['name'] != 'Monofasico trifilar') {
			$system_tri = true;
		}
		$systemid = $cust['System']['id'];
		$threholds = $this->Threhold->find($systemid);
		$outvalues = array();
		$outvals = array();
		$table_data = array();
		$flag = false;
		
		if ($id && !$this->Outvalue->findByCustomerId($id)) {
			$flag = true;
			$table_data = $this->Pqdata->find('all',array('conditions' => array('Pqdata.customer_id = ?' => array($id)), 'order'=>array('Pqdata.date ASC')));
			$fisrtdate = $this->Pqdata->find('first', array('order' => array('Pqdata.date ASC')));
		}else{
			$datacnt = $this->Pqdata->find('count', array('conditions' => array('Pqdata.customer_id = ?' => array($id))));
			$outV1 = $this->Outvalue->find('all', array('conditions' => array('Outvalue.customer_id = ? and Outvalue.metric = ?' => array($id, 'V1'))));
			$outV2 = $this->Outvalue->find('all', array('conditions' => array('Outvalue.customer_id = ? and Outvalue.metric = ?' => array($id, 'V2'))));
			$outV3 = $this->Outvalue->find('all', array('conditions' => array('Outvalue.customer_id = ? and Outvalue.metric = ?' => array($id, 'V3'))));
			if ($system_tri) {
//				$outTHDU1 = $this->Outvalue->find('all', array('conditions' => array('Outvalue.customer_id = ? and Outvalue.metric = ?' => array($id, 'THDu1'))));
//				$outTHDU2 = $this->Outvalue->find('all', array('conditions' => array('Outvalue.customer_id = ? and Outvalue.metric = ?' => array($id, 'THDu2'))));
//				$outTHDU3 = $this->Outvalue->find('all', array('conditions' => array('Outvalue.customer_id = ? and Outvalue.metric = ?' => array($id, 'THDu3'))));
//				$outTHDI1 = $this->Outvalue->find('all', array('conditions' => array('Outvalue.customer_id = ? and Outvalue.metric = ?' => array($id, 'THDi1'))));
//				$outTHDI2 = $this->Outvalue->find('all', array('conditions' => array('Outvalue.customer_id = ? and Outvalue.metric = ?' => array($id, 'THDi2'))));
//				$outTHDI3 = $this->Outvalue->find('all', array('conditions' => array('Outvalue.customer_id = ? and Outvalue.metric = ?' => array($id, 'THDi3'))));
//				$outPLT1 = $this->Outvalue->find('all', array('conditions' => array('Outvalue.customer_id = ? and Outvalue.metric = ?' => array($id, 'Plt1'))));
//				$outPLT2 = $this->Outvalue->find('all', array('conditions' => array('Outvalue.customer_id = ? and Outvalue.metric = ?' => array($id, 'Plt2'))));
//				$outPLT3 = $this->Outvalue->find('all', array('conditions' => array('Outvalue.customer_id = ? and Outvalue.metric = ?' => array($id, 'Plt3'))));				
			}
		}
		
		$V1 = $V2 = $V3 = array();

		foreach ($table_data as $value) {
			if(isset($value['Pqdata']['Urms_1_avg'])){
				if($value['Pqdata']['Urms_1_avg'] > $threholds['Threhold']['max'] || $value['Pqdata']['Urms_1_avg'] < $threholds['Threhold']['min']){
					array_push($outvalues, array( 'customer_id' => $id, 'metric' =>'V1', 'value' => $value['Pqdata']['Urms_1_avg'], 'date' => $value['Pqdata']['date']));
					array_push($V1, $value['Pqdata']['Urms_1_avg']);
				}
			}
			if(isset($value['Pqdata']['Urms_2_avg'])){
				if($value['Pqdata']['Urms_2_avg'] > $threholds['Threhold']['max'] || $value['Pqdata']['Urms_2_avg'] < $threholds['Threhold']['min']){
					array_push($outvalues, array( 'customer_id' => $id, 'metric' =>'V2', 'value' => $value['Pqdata']['Urms_2_avg'], 'date' => $value['Pqdata']['date']));
					array_push($V2, $value['Pqdata']['Urms_2_avg']);
				}
			}
			if(isset($value['Pqdata']['Urms_3_avg'])){
				if($value['Pqdata']['Urms_3_avg'] > $threholds['Threhold']['max'] || $value['Pqdata']['Urms_3_avg'] < $threholds['Threhold']['min']){
					array_push($outvalues, array( 'customer_id' => $id, 'metric' =>'V3', 'value' => $value['Pqdata']['Urms_3_avg'], 'date' => $value['Pqdata']['date']));
					array_push($V3, $value['Pqdata']['Urms_3_avg']);
				}
			}
			if ($system_tri) {
				if(isset($value['Pqdata']['Frec_1_avg'])){
					if(floatval($value['Pqdata']['Frec_1_avg']) > floatval(60.3) || floatval($value['Pqdata']['Frec_1_avg']) < floatval(59.7)){
						array_push($outvalues, array( 'customer_id' => $id, 'metric' =>'F1', 'value' => $value['Pqdata']['Frec_1_avg'], 'date' => $value['Pqdata']['date']));
					}
				}
				if(isset($value['Pqdata']['Frec_2_avg'])){
					if(floatval($value['Pqdata']['Frec_2_avg']) > floatval(60.3) || floatval($value['Pqdata']['Frec_2_avg']) < floatval(59.7)){
						array_push($outvalues, array( 'customer_id' => $id, 'metric' =>'F2', 'value' => $value['Pqdata']['Frec_2_avg'], 'date' => $value['Pqdata']['date']));
					}
				}
				if(isset($value['Pqdata']['Frec_3_avg'])){
					if(floatval($value['Pqdata']['Frec_3_avg']) > floatval(60.3) || floatval($value['Pqdata']['Frec_3_avg']) < floatval(59.7)){
						array_push($outvalues, array( 'customer_id' => $id, 'metric' =>'F3', 'value' => $value['Pqdata']['Frec_3_avg'], 'date' => $value['Pqdata']['date']));
					}										
				}
				if(isset($value['Pqdata']['THDu_1_max'])){
					if(floatval($value['Pqdata']['THDu_1_max']) > floatval(3)){
						array_push($outvalues, array( 'customer_id' => $id, 'metric' =>'THDu1', 'value' => $value['Pqdata']['THDu_1_max'], 'date' => $value['Pqdata']['date']));
					}										
				}
				if(isset($value['Pqdata']['THDu_2_max'])){
					if(floatval($value['Pqdata']['THDu_2_max']) > floatval(3)){
						array_push($outvalues, array( 'customer_id' => $id, 'metric' =>'THDu2', 'value' => $value['Pqdata']['THDu_2_max'], 'date' => $value['Pqdata']['date']));
					}
				}	
				if(isset($value['Pqdata']['THDu_3_max'])){
					if(floatval($value['Pqdata']['THDu_3_max']) > floatval(3)){
						array_push($outvalues, array( 'customer_id' => $id, 'metric' =>'THDu3', 'value' => $value['Pqdata']['THDu_3_max'], 'date' => $value['Pqdata']['date']));
					}
				}
				if(isset($value['Pqdata']['THDi_1_max'])){
					if(floatval($value['Pqdata']['THDi_1_max']) > floatval(3)){
						array_push($outvalues, array( 'customer_id' => $id, 'metric' =>'THDi1', 'value' => $value['Pqdata']['THDi_1_max'], 'date' => $value['Pqdata']['date']));
					}										
				}
				if(isset($value['Pqdata']['THDi_2_max'])){
					if(floatval($value['Pqdata']['THDi_2_max']) > floatval(3)){
						array_push($outvalues, array( 'customer_id' => $id, 'metric' =>'THDi2', 'value' => $value['Pqdata']['THDi_2_max'], 'date' => $value['Pqdata']['date']));
					}
				}	
				if(isset($value['Pqdata']['THDi_3_max'])){
					if(floatval($value['Pqdata']['THDi_3_max']) > floatval(3)){
						array_push($outvalues, array( 'customer_id' => $id, 'metric' =>'THDi3', 'value' => $value['Pqdata']['THDi_3_max'], 'date' => $value['Pqdata']['date']));
					}
				}
				if(isset($value['Pqdata']['Plt_1'])){
					if(floatval($value['Pqdata']['Plt_1']) > floatval(1)){
						array_push($outvalues, array( 'customer_id' => $id, 'metric' =>'Plt1', 'value' => $value['Pqdata']['Plt_1'], 'date' => $value['Pqdata']['date']));
					}										
				}
				if(isset($value['Pqdata']['Plt_2'])){
					if(floatval($value['Pqdata']['Plt_2']) > floatval(1)){
						array_push($outvalues, array( 'customer_id' => $id, 'metric' =>'Plt2', 'value' => $value['Pqdata']['Plt_2'], 'date' => $value['Pqdata']['date']));
					}
				}	
				if(isset($value['Pqdata']['Plt_3'])){
					if(floatval($value['Pqdata']['Plt_3']) > floatval(1)){
						array_push($outvalues, array( 'customer_id' => $id, 'metric' =>'Plt3', 'value' => $value['Pqdata']['Plt_3'], 'date' => $value['Pqdata']['date']));
					}
				}
			}
		}
		if($flag){
			foreach ($outvalues as $value) {
				$this->Outvalue->query("Insert into outvalues values ('','".$value['customer_id']."','".$value['metric']."','".$value['value']."','".$value['date']."')");
			}
			if (!$system_tri) {
				if ((sizeof($V1)/sizeof($table_data) > 0.005)) {
					$result = 'No Cumple';
				}elseif ((sizeof($V2)/sizeof($table_data) > 0.005)){
					$result = 'No Cumple';
				}elseif ((sizeof($V3)/sizeof($table_data) > 0.005)){
					$result = 'No Cumple';
				}else {
					$result = 'Cumple';
				}
			}else{
				if ((sizeof($V1)/sizeof($table_data) > 0.005)) {
					$result = 'No Cumple';
				}elseif ((sizeof($V2)/sizeof($table_data) > 0.005)){
					$result = 'No Cumple';
				}elseif ((sizeof($V3)/sizeof($table_data) > 0.005)){
					$result = 'No Cumple';
				}else {
					$result = 'Cumple';
				}
			}
			
			$this->Customer->updateAll(array('Customer.status' => "'Analized: $result'",'Customer.date' => "$fisrtdate"),array('Customer.id' => $id));
			
		}else {
			if ((sizeof($outV1)/$datacnt) > 0.05) {
				$result = 'No Cumple';
//				debug($result);
			}elseif ((sizeof($outV2)/$datacnt) > 0.05) {
				$result = 'No Cumple';
//				debug($result);
			}elseif ((sizeof($outV3)/$datacnt) > 0.05) {
				$result = 'No Cumple';
//				debug($result);
			}else{
				$result = 'Cumple';
//				debug($result);			
			}
		}
		
		$this->set('id', $id);
		$this->set('result', $result);
	}
	
	function gridanalysis($id = null) {
		$this->layout = null;
		Configure::write('debug', '0');
		
//		debug($id);
		$cntdata = $this->Pqdata->find('count',array('conditions' => array('Pqdata.customer_id = ?' => array($id))));
		$this->set('total', $cntdata);
		$this->set('result', $this->params['pass'][1]);
		$this->set('id',$id);
	}	
	
	function analysis_rawdata($id = null) {
		$this->Outvalue->recursive = -1;
		Configure::write('debug', '0');
		$this->Customer->recursive = -1;
		
		$rawdata = array();
		
//		debug($id);//		$cust = $this->Customer->find($_SESSION['customer_id']);
		$cust = $this->Customer->findById($id);
		
//		debug($cust);
		$table_data = array();
		
		if(isset($cust)){
//			$table_data = $this->Pqevent->find('all',array('conditions' => array('Pqevent.customer_id = ? and Pqevent.phase in (?)' => array($customer,$phs)), 'order'=>array('Pqevent.phase','Pqevent.datetime ASC')));
			$table_data = $this->Outvalue->find('all',array('conditions' => array('Outvalue.customer_id = ?' => array($id))));	
		}
		
//		debug($table_data);
	
		foreach($table_data as $datarow){
			$date = $datarow['Outvalue']['date'];
			$metric = $datarow['Outvalue']['metric'];
			$value = $datarow['Outvalue']['value'];
			$customer = $cust['Customer']['name'];
			
			array_push($rawdata,array('datetime' => $date, 
									'metric' => $metric, 
									'value' => $value,
									'customer' => $customer,
			));
		}
		
		$start = isset($_POST['start'])?$_POST['start']:0;
//		$limit = isset($_POST['limit'])?$_POST['limit']:20;
		$limit = isset($_POST['limit'])?$_POST['limit']:20000;

		$paging = array(
		'success'=>true,
		'total'=>count($rawdata),
		'data'=> array_splice($rawdata,$start,$limit),
		);
		
//		debug($table_data);
		$this->autoRender = false;
		
		e(json_encode($paging));
	}

	function reportform() {
		;
	}
	
	function reportsummary($id = null){
	//	if (!$id)
        //{
        //    $this->Session->setFlash('no has seleccionado ningun pdf.');
        //    $this->redirect(array('action'=>'index'));
        //}

        // Sobrescribimos para que no aparezcan los resultados de debuggin
        // ya que sino daria un error al generar el pdf.
        
	Configure::write('debug',0);
        
	if(!$id){
		debug($this->data);
	
		$startdate = $this->data['year1']['year'] . "-" . $this->data['month1']['month'] . "-" . $this->data['day1']['day'];
		$enddate = $this->data['year2']['year'] . "-" . $this->data['month2']['month'] . "-" . $this->data['day2']['day'];
		debug($startdate);
		debug($enddate);
		$resultado = $this->Customer->query("select * from customers where date between '$startdate' and '$enddate' order by date");
		debug($resultado);
	}else{	
		$resultado = $this->Customer->findById('$id');
	}

        $this->set("datos_pdf",$resultado);
        $this->layout = 'pdf'; //esto usara el layout pdf.ctp
        $this->render();
		
	}
	
}
?>