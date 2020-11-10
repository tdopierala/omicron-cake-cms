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
use SimpleXLSX;

/**
 * Import command.
 */
class ImportCommand extends Command
{
	
	public $modelClass = 'CovidGlobal';

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

	public function put(Arguments $args, ConsoleIo $io)
	{
		for($i=0; $i<5; $i++) {

			$query = $this->CovidGlobal->query();

			$query->insert(['nation', 'infected', 'death', 'recover'])
				->values([
					'nation' => 'abc',
					'infected' => $i,
					'death' => $i,
					'recover' => $i
				])
				->execute();
		}

			$io->out("OK");
	}

	public function show(Arguments $args, ConsoleIo $io)
	{
		//$io->out(html_entity_decode("COTE D&#39;IVOIRE",ENT_QUOTES));
		//strip_tags 
		//$io->out(html_entity_decode(strip_tags('<div class="softmerge-inner" style="width: 193px; left: -1px;">micronesia (fed. states of)</div>'),ENT_QUOTES));

		$io->out(date("Y-m-d H:i:s"));
		$io->out(date_default_timezone_get());
	}

	public function get(Arguments $args, ConsoleIo $io)
	{
		$covidGlobalNationsTable = TableRegistry::getTableLocator()->get('CovidGlobalNations');

		$dom = new Dom;
		$dom->loadFromUrl('https://docs.google.com/spreadsheets/d/e/2PACX-1vQuDj0R6K85sdtI8I-Tc7RCx8CnIxKUQue0TCUdrFOKDw9G3JRtGhl64laDd3apApEvIJTdPFJ9fEUL/pubhtml?gid=0&single=true');
		
		$div = $dom->find('.waffle');

		$dom->load($div->outerHtml);
		$tbody = $dom->find('tr');

		for($i=2; $i<count($tbody); $i++){
			//if($i>47) break;

			$tr = $tbody[$i];

			$dom->load($tr->outerHtml);
			$td = $dom->find('td');

			if(trim($td[1]->innerHtml) == "") continue;
			
			$nation = $td[1]->innerHtml;
			$nation = strip_tags($nation);
			$nation = html_entity_decode($nation,ENT_QUOTES);
			$nation = strtolower($nation);

			$covidItNation = $covidGlobalNationsTable->find()->select(['id'])->where(['name' => $nation])->first();

			if(!empty($covidItNation)) {
				$id = $covidItNation->toArray()['id'];
				$io->out($id . ";" . $nation . ";" . $td[2]->innerHtml . ";" . $td[3]->innerHtml . ";" . $td[4]->innerHtml);
			} else {
				$io->out("\t".$nation);
			}
		}	
	}

	public function ins(Arguments $args, ConsoleIo $io)
	{
		$covidItNationTable = TableRegistry::getTableLocator()->get('CovidGlobalNations');

		$dom = new Dom;
		$dom->loadFromUrl('https://docs.google.com/spreadsheets/d/e/2PACX-1vQuDj0R6K85sdtI8I-Tc7RCx8CnIxKUQue0TCUdrFOKDw9G3JRtGhl64laDd3apApEvIJTdPFJ9fEUL/pubhtml?gid=0&single=true');
		
		$div = $dom->find('.waffle');

		$dom->load($div->outerHtml);
		$tbody = $dom->find('tr');

		for($i=2; $i<count($tbody); $i++){
			//if($i>100) break;

			$tr = $tbody[$i];

			$dom->load($tr->outerHtml);
			$td = $dom->find('td');

			if(trim($td[1]->innerHtml) == "") continue;
			
			$nation = $td[1]->innerHtml;
			$nation = strip_tags($nation);
			$nation = html_entity_decode($nation,ENT_QUOTES);
			$nation = strtolower($nation);

			$covidItNation = $covidItNationTable
				->find()
				->select(['id'])
				->where([
					'name' => $nation
				])
				->first()
				;

			if(!empty($covidItNation)) {
				$nation_id = $covidItNation->toArray()['id'];
				
				$covid = $this->CovidGlobal
					->find()
					->select(['id'])
					->where([
						'date' => date("Y-m-d"),
						'nation_id' => $nation_id
					])
					->first()
					;

				if(!empty($covid)) {
					$id = $covid->toArray()['id'];

					$this->CovidGlobal
						->query()
						->update()
						->set([
							'time'		=> date("H:i:s"),
							'infected'	=> $td[2]->innerHtml,
							'dead'		=> $td[3]->innerHtml,
							'recover'	=> $td[4]->innerHtml
						])
						->where(['id' => $id])
						->execute();
				
				} else {

					$this->CovidGlobal
						->query()
						->insert(['nation_id', 'date', 'time', 'infected', 'dead', 'recover'])
						->values([
							'nation_id'	=> $nation_id,
							'date'		=> date("Y-m-d"),
							'time'		=> date("H:i:s"),
							'infected'	=> $td[2]->innerHtml,
							'dead'		=> $td[3]->innerHtml,
							'recover'	=> $td[4]->innerHtml
						])
						->execute();
				}

				$io->out($nation_id . ";" . $nation . ";" . $td[2]->innerHtml . ";" . $td[3]->innerHtml . ";" . $td[4]->innerHtml);
			}
			//DELETE FROM `covid_it` WHERE `date`="2020-04-03" and time>"22:18:00"
		}
	}

	public function download_spreadsheet_pl(Arguments $args, ConsoleIo $io) {

		$gdoc_domain = "docs.google.com";
		$gdoc_id = "12CChpbU1KJrMWo3ZhFtcixmqPfWYdJLeSKK1D8LN3uw";
		$gdoc_url = "https://$gdoc_domain/spreadsheets/d/$gdoc_id/";

		$format = "xlsx";

		$spreadsheet_url = $gdoc_url . "export?format=" . $format;

		$filename = "covid19_" . date("YmdHis") . "_" . sha1((string)rand()) . "." . $format;
		
		if(file_put_contents("tmp/" . $filename, file_get_contents($spreadsheet_url))) {
			echo "File downloaded successfully"; 
		}
		
	}

	public function parse_spreadsheet_pl(Arguments $args, ConsoleIo $io) {

		//require_once __DIR__.'/../../SimpleXLSX.php';

		$dir = "tmp/";

		if (is_dir($dir)){
			if ($dh = opendir($dir)){
			  while (($file = readdir($dh)) !== false){

				if(substr($file, -4) != "xlsx") {
					continue;
				} else {

					if ( $xlsx = SimpleXLSX::parse($dir . $file) ) {
						
						//print_r( $xlsx->sheetNames() );

						/*
						$rows = $xlsx->rows(5);
						for($i=0; $i<count($rows); $i++) {
							\print_r($xlsx->rows(5)[$i]);
							readline("Continue? ");
						}
						*/
						
						//echo "\n" . $xlsx->getCell(5, 'Q29');

						$q_cell = "AB23";
						$_map = str_split("abcdefghijklmnopqrstuvwxyz");
						$_row = "";
						$_col = 0;

						foreach(str_split($q_cell) as $q) {
							if(is_numeric($q)) { 
								$_row .= (string) $q; 
								echo "\n" . $_row . " is a number"; 
							}
							elseif(is_string ($q)) {
								$_col += array_search(strtolower($q), $_map) +1;
								echo "\n" . $q . " is a char";
								echo "\n" . (array_search(strtolower($q), $_map)+1) . " from map";
							}
						}

						$_row = 1 + (int) $_row;
						echo "\n" . $_row . "/" . $_col;

						$row=31;
						$col=26;

						$_xlsx = $xlsx->rowsEx(5);

						echo "\n\n";
						print_r($_xlsx[$row-1][$col]);

						/*
						echo "\n";
						foreach($_xlsx[$row-1] as $cell) {
							echo $cell['f'] . " | ";
						}
						echo "\n";
						*/

						break;
					}

				}


			  }
			  closedir($dh);
			}
		  }

		/*if ( $xlsx = SimpleXLSX::parse( 'xlsx/books.xlsx' ) ) {
			print_r( $xlsx->sheetNames() );
		}*/
		
	}


}
