<?php
declare(strict_types=1);

namespace App\Command;

use Cake\Console\Arguments;
use Cake\Command\Command;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use PHPHtmlParser\Dom;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;
use Cake\Log\Log;
use SimpleXLSX;

/**
 * Covid command.
 */
class CovidCommand extends Command
{
	
	public $modelClass = 'CovidPoland';

	/**
	 * Hook method for defining this command's option parser.
	 *
	 * @see https://book.cakephp.org/3.0/en/console-and-shells/commands.html#defining-arguments-and-options
	 *
	 * @param \Cake\Console\ConsoleOptionParser $parser The parser to be defined
	 * @return \Cake\Console\ConsoleOptionParser The built parser.
	 */
	public function buildOptionParser(ConsoleOptionParser $parser): ConsoleOptionParser
	{
		//$parser = parent::buildOptionParser($parser);

		$parser->addArgument('method', [
            'help' => 'What is your name'
        ]);

		return $parser;
	}

	/**
	 * Implement this method with your command's logic.
	 *
	 * @param \Cake\Console\Arguments $args The command arguments.
	 * @param \Cake\Console\ConsoleIo $io The console io
	 * @return null|void|int The exit code or null for success
	 */
	public function execute(Arguments $args, ConsoleIo $io)
	{
		$method = $args->getArgument('method');

		$this->$method($args,$io);
	}

	public function pl_execute(Arguments $args, ConsoleIo $io) {

		$this->pl_download($args, $io, "12CChpbU1KJrMWo3ZhFtcixmqPfWYdJLeSKK1D8LN3uw", "spreadsheet1");
		$this->pl_download($args, $io, "1ierEhD6gcq51HAm433knjnVwey4ZE5DCnu1bW7PRG3E", "spreadsheet2");

	}

	public function pl_download(Arguments $args, ConsoleIo $io, $_gdoc_id = "", $gdoc_name = "covid") {

		if(!empty($_gdoc_id)) {

			$gdoc_domain = "docs.google.com";
			$gdoc_id = $_gdoc_id; //"12CChpbU1KJrMWo3ZhFtcixmqPfWYdJLeSKK1D8LN3uw";
			$gdoc_url = "https://$gdoc_domain/spreadsheets/d/$gdoc_id/";

			$format = "xlsx";

			$spreadsheet_url = $gdoc_url . "export?format=" . $format;

			$filename = $gdoc_name . "_" . date("YmdHis") . "_" . sha1((string)rand()) . "." . $format;
			
			if(file_put_contents("tmp/" . $filename, file_get_contents($spreadsheet_url))) {
				$io->out("$filename => OK");
			}

			$files=[];
			$dir="tmp/";
			if (is_dir($dir)){
				if ($dir_handle = opendir($dir)){
					while (($file = readdir($dir_handle)) !== false){

						if ($file != "." && $file != ".." && preg_match("/^.*\.(xlsx)$/i", $file) && explode("_", $file)[0] == $gdoc_name) {
							$files[filemtime($dir.$file)] = $file;
						}
					}
				}
				closedir($dir_handle);
			}

			if(count($files) > 1)
				unlink($dir.$files[min(array_keys($files))]);
		}
	}

	public function pl_get_infected(Arguments $args, ConsoleIo $io) {

		$files=[];
		$dir="tmp/";
		if (is_dir($dir)){
			if ($dir_handle = opendir($dir)){
				while (($file = readdir($dir_handle)) !== false){

					if ($file != "." && $file != ".." && preg_match("/^.*\.(xlsx)$/i", $file) && explode("_", $file)[0] == "spreadsheet1") {
						$files[filemtime($dir.$file)] = $file;
					}
				}
			}
			closedir($dir_handle);
		}

		$spreadsheet = $files[max(array_keys($files))];

		$covidPolandTable = TableRegistry::getTableLocator()->get('CovidPoland');
		$covidPolandInfectedTable = TableRegistry::getTableLocator()->get('CovidPolandInfected');

		if(file_exists($dir.$spreadsheet)){
			if($xlsx = SimpleXLSX::parse($dir.$spreadsheet)){

				$_xlsx = $xlsx->rowsEx(5);

				for($i=3; $i<count($_xlsx); $i++){

					$output="";
					$vmax = 6;
					$dsum = 0;

					$date = date("Y-m-d",strtotime($_xlsx[$i][0]['value']));

					$covidPoland = $covidPolandTable
						->find()
						//->select(['id', 'date', 'region_id', 'cell', 'infected', 'infected_f'])
						->where(['date' => $date])
						->first()
					;

					$output .= $_xlsx[$i][21]['value'];

					$infected = null;
					$covidPolandInfected = $covidPolandInfectedTable
						->find()
						->select(['id', 'date', 'region_id', 'cell', 'infected', 'infected_f'])
						->where(['date' => $date]);
					
					if(!is_null($covidPolandInfected)) {
						foreach($covidPolandInfected as $row) {
							$infected[$row['region_id']] = $row;
						}
					}

					for($j=0; $j<=16; $j++){
						$value = (string) $_xlsx[$i][$j]['value'];
						$cell = $_xlsx[$i][$j]['name'];
						$fomula = $_xlsx[$i][$j]['f'];
						
						if(empty($value)) $value = 0;

						$_value = $value;

						// ---------------------- spreadsheet table display ----------------------
						
						$value = str_replace(["ą","ć","ę","ł","ń","ó","ś","ź","ż"], ["a","c","e","l","n","o","s","z","z"], $value);
						$vlen = strlen($value);

						if($j == 0) $_vmax = 10;
						else $_vmax = $vmax;

						if($vlen > $_vmax) {
							$value = substr($value,0,$_vmax);
						}

						if($vlen < $_vmax){
							for($a=1; $a<=$_vmax-$vlen; $a++) $value = " ".$value;
						}

						$value .= " | ";

						if($i>1 && $j>0) $dsum += (int) $value;

						//$output .= $value;

						// ---------------------- databse check ----------------------

						if($i>1 && $j>0) {
							if(isset($infected[$j])) {

								if($infected[$j]->infected != $_value) {

									$query = $covidPolandInfectedTable->query()
									->update()
									->set([
										'infected'	=> (int) $_value,
										'cell'		=> (string) $cell,
										'infected_f'=> (string) $fomula,
										'changed'	=> date("Y-m-d H:i:s")
									])
									->where(['id' => $infected[$j]->id ]);
									
									if($query->execute()){

										Log::write('debug', "UPDATE covid_poland_infected date=$date, region=$j, infected_old=".$infected[$j]->infected.", infected_new=$_value, cell=$cell, infected_f=$fomula", ['covidQueries']);
										//$io->out("UPDATE date=$date, region=$j, infected_old=".$infected[$j]->infected.", infected_new=$_value, cell=$cell, infected_f=$fomula");

									} else {

										Log::write('error', "UPDATE covid_poland_infected date=$date, region=$j, infected_old=".$infected[$j]->infected.", infected_new=$_value, cell=$cell, infected_f=$fomula", ['covidQueries']);
									}
								}

							} else {

								if($_value != 0) {

									$query = $covidPolandInfectedTable->query()
									->insert(['date', 'region_id', 'cell', 'infected', 'infected_f', 'changed'])
									->values([
										'date'		=> $date,
										'region_id'	=> $j,
										'cell'		=> $cell,
										'infected'	=> $_value,
										'infected_f'=> $fomula,
										'changed'	=> date("Y-m-d H:i:s")
									]);
									
									if($query->execute()) {

										Log::write('debug', "INSERT covid_poland_infected date=$date, region=$j, infected=$_value, cell=$cell, infected_f=$fomula", ['covidQueries']);
										//$io->out("INSERT date=$date, region=$j, infected=$_value, cell=$cell, infected_f=$fomula");

									} else {

										Log::write('error', "INSERT covid_poland_infected date=$date, region=$j, infected=$_value, cell=$cell, infected_f=$fomula", ['covidQueries']);

									}
								}
							}
						}
					}

					//$output.=$dsum;
					$io->out($output);
				}
			}
		}

		$io->out("OK");
	}

	public function pl_get_details(Arguments $args, ConsoleIo $io) {

		$files=[];
		$dir="tmp/";
		if (is_dir($dir)){
			if ($dir_handle = opendir($dir)){
				while (($file = readdir($dir_handle)) !== false){

					if ($file != "." && $file != ".." && preg_match("/^.*\.(xlsx)$/i", $file) && explode("_", $file)[0] == "spreadsheet1") {
						$files[filemtime($dir.$file)] = $file;
					}
				}
			}
			closedir($dir_handle);
		}

		$spreadsheet = $files[max(array_keys($files))];

		$covidPolandTable = TableRegistry::getTableLocator()->get('CovidPoland');

		if(file_exists($dir.$spreadsheet)){
			if($xlsx = SimpleXLSX::parse($dir.$spreadsheet)){

				$_xlsx = $xlsx->rowsEx(5);

				for($i=3; $i<count($_xlsx); $i++){

					$output = "";

					$date = date("Y-m-d", strtotime($_xlsx[$i][0]['value']));

					// ---------------------- spreadsheet table display ----------------------

					$covid = [
						'date'			=> $date,
						'tests'			=> $_xlsx[$i][21]['value'], //tests
						'surveyed'		=> $_xlsx[$i][22]['value'], //surveyed
						'hospitalized'	=> $_xlsx[$i][23]['value'], //hospitalized
						'respirator'	=> $_xlsx[$i][24]['value'], //respirator
						'quarantined'	=> $_xlsx[$i][25]['value'], //quarantined
						'quarantined2'	=> $_xlsx[$i][26]['value'], //quarantined2
						'surveillance'	=> $_xlsx[$i][27]['value'], //surveillance
						'recover'		=> $_xlsx[$i][28]['value'], //recover
					];

					$_vmax=10;
					foreach($covid as $value) {
						$value = str_replace(["ą","ć","ę","ł","ń","ó","ś","ź","ż"], ["a","c","e","l","n","o","s","z","z"], $value);
						$vlen = strlen((string) $value);

						if($vlen > $_vmax) {
							$value = substr($value,0,$_vmax);
						}
	
						if($vlen < $_vmax){
							for($a=1; $a<=$_vmax-$vlen; $a++) $value = " ".$value;
						}

						$output .= $value . " | ";
					}

					// ---------------------- databse check ----------------------

					$covidPoland = $covidPolandTable
						->find()
						->select(['id', 'tests', 'surveyed', 'hospitalized', 'respirator', 'quarantined', 'quarantined2', 'surveillance', 'recover'])
						->where(['date' => $date])
						->first()
					;

					if(empty($covidPoland)) {

						$fields = [];
						$values = [];

						$fields[] = 'date';
						$values['date'] = $date;

						foreach($covid as $name => $val) {
							if(!empty($val) && is_numeric($val) && $val!=0) {
								$fields[] = $name;
								$values[$name] = $val;
							}
						}

						$query = $covidPolandTable->query()
							->insert($fields)
							->values($values);

						$log="INSERT covid_poland";
						foreach($values as $name => $val) $log .= " $name=$val";
						
						if($query->execute()) {
							Log::write('debug', $log, ['covidQueries']);
							//$io->out($log);
						} else {
							Log::write('error', $log, ['covidQueries']);
						}

					} else {

						$update = [];
						$_update = [];

						foreach($covid as $name => $val) {
							if(is_numeric($covid[$name]) && $covid[$name] != $covidPoland->$name) {
								$update['changed'] = date("Y-m-d H:i:s");
								$update[$name] = $covid[$name];

								$_update["date"] = $date;
								$_update[$name."_old"] = $covidPoland->$name;
								$_update[$name."_new"] = $covid[$name];
							}
						}
						
						if(!empty($_update)) {

							$query = $covidPolandTable->query()
								->update()
								->set($update)
								->where(['id' => $covidPoland->id ]);
							
							$log="UPDATE covid_poland id=$covidPoland->id";
							foreach($update as $name => $val) $log .= ", $name=$val";
							
							if($query->execute()){
								Log::write('debug', $log, ['covidQueries']);
								//$io->out($log);
							} else {
								Log::write('error', $log, ['covidQueries']);
							}
						}
					}

					//$io->out($output);
				}
			}
		}

		$io->out("OK");
	}

	public function pl_get_deaths2(Arguments $args, ConsoleIo $io) {

		$files=[];
		$dir="tmp/";
		if (is_dir($dir)){
			if ($dir_handle = opendir($dir)){
				while (($file = readdir($dir_handle)) !== false){

					if ($file != "." && $file != ".." && preg_match("/^.*\.(xlsx)$/i", $file) && explode("_", $file)[0] == "spreadsheet2") {
						$files[filemtime($dir.$file)] = $file;
					}
				}
			}
			closedir($dir_handle);
		}

		$spreadsheet = $files[max(array_keys($files))];

		if(file_exists($dir.$spreadsheet)){
			if($xlsx = SimpleXLSX::parse($dir.$spreadsheet)){

				$_xlsx = $xlsx->rows(9);

				/* $out="";
				for($i=4; $i<50; $i++){
					$io->out($_xlsx[$i][0]['value'] . " | " . $_xlsx[$i][1]['value'] . " | " . $_xlsx[$i][2]['value'] . " | " . $_xlsx[$i][3]['value'] . " | " . $_xlsx[$i][4]['value']);
				} */

				//$io->out($out);
			}
		}
	}

	public function pl_get_deaths(Arguments $args, ConsoleIo $io) {

		$files=[];
		$dir="tmp/";
		if (is_dir($dir)){
			if ($dir_handle = opendir($dir)){
				while (($file = readdir($dir_handle)) !== false){

					if ($file != "." && $file != ".." && preg_match("/^.*\.(xlsx)$/i", $file) && explode("_", $file)[0] == "spreadsheet2") {
						$files[filemtime($dir.$file)] = $file;
					}
				}
			}
			closedir($dir_handle);
		}

		$spreadsheet = $files[max(array_keys($files))];

		$covidPolandDeadTable = TableRegistry::getTableLocator()->get('CovidPolandDead');

		if(file_exists($dir.$spreadsheet)){
			if($xlsx = SimpleXLSX::parse($dir.$spreadsheet)){

				$_xlsx = $xlsx->rowsEx(9);

				for($i=5; $i<count($_xlsx); $i++){

					//if(empty($_xlsx[$i][21]['value']) || empty($_xlsx[$i][23]['value']) || empty($_xlsx[$i][24]['value']) || empty($_xlsx[$i][25]['value'])) continue;

					if(!empty($_xlsx[$i][0]['value']) && is_numeric($_xlsx[$i][3]['value']) && !empty($_xlsx[$i][5]['value'])) {

						$date = date("Y-m-d", strtotime((string) $_xlsx[$i][3]['value']));

						$covid = [
							'no'			=> $_xlsx[$i][0]['value'],
							'date'			=> date("Y-m-d", strtotime((string) $_xlsx[$i][3]['value'])),
							'region_name'	=> $_xlsx[$i][4]['value'],
							'location'		=> $_xlsx[$i][5]['value'],
							'age'			=> $_xlsx[$i][1]['value'],
							'sex'			=> $_xlsx[$i][2]['value'],
							'description'	=> $_xlsx[$i][26]['value'],
						];

						$out=""; 
						foreach($covid as $row) {
							$row = str_replace(["ą","ć","ę","ł","ń","ó","ś","ź","ż","Ą","Ć","Ę","Ł","Ń","Ó","Ś","Ź","Ż"], ["a","c","e","l","n","o","s","z","z","A","C","E","L","N","O","S","Z","Z"], (string) $row);
							$out .= strlen($row) > 10 ? substr($row, 0, 10) . " | " : str_repeat(" ", 10-strlen($row)) .$row . " | ";
						}
						$io->out($out);

						/* $dead = $covidPolandDeadTable
							->find()
							->select(['id'])
							->where(['no' => $covid['no'], 'date' => $covid['date']])
							->first();

						//var_dump($dead);

						if(is_null($dead)) {

							$query = $covidPolandDeadTable->query()
								->insert(['no','date','age','sex','region_name','location','description'])
								->values($covid);

							$log="INSERT covid_poland_dead";
							foreach($covid as $name => $val) $log .= " $name=$val";
								
							if($query->execute()) {
								Log::write('debug', $log, ['covidQueries']);
								//$io->out($log);
							} else {
								Log::write('error', $log, ['covidQueries']);
							}
						} */
					}

					/* $deaths = $covidPolandDeadTable
						->find()
						->select(['id', 'date', 'age', 'sex', 'region_id', 'location', 'description', 'removed', 'checked'])
						->where(['date' => $date, 'age' => $covid['age'], 'sex' => $covid['sex'], 'location' => $covid['location'], 'checked' => 0])
						->first();

					if($deaths && empty($deaths)) {

						$_deaths = $covidPolandDeadTable
							->find()
							->select(['id', 'date', 'age', 'sex', 'region_id', 'location', 'description', 'removed'])
							->where(['date' => $date]);

						if($_deaths && !empty($_deaths)) {

							$io->out("--- not exists exist --- ");
							$io->out("date: " . $date . ", age: " . $covid['age'] . ", sex: " . $covid['sex'] . ", location: " . $covid['location']);
							$io->out("------------------------ ");

							foreach($_deaths as $d) {
								$io->out("date: " . $d->date . ", age: " . $d->age . ", sex: " . $d->sex . ", location: " . $d->location);
							}

						}
						
						$io->out(" ");

					} elseif(!empty($deaths)) {

						//$io->out("id:$deaths->id checked:$deaths->checked");

						$query = $covidPolandDeadTable->query()
							->update()
							->set(['checked' => $deaths->checked+1])
							->where(['id' => $deaths->id])
							->execute();
					} */

					//$row=""; foreach($covid as $r) { $row .= "$r | "; } $io->out($row);
				}
			}
		}
	}

}
