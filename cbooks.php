<?php
/**
 * CBooks (100 Books)
 *
 * 100 Top books wikipedia API.
 * Get list of top literay books from wikipedia list.
 *
 * Copyright (c) 2013 - 92 Bond Street, Yassine Azzout
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 *	The above copyright notice and this permission notice shall be included in
 *	all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package CBooks
 * @version 1.0
 * @copyright 2013 - 92 Bond Street, Yassine Azzout
 * @author Yassine Azzout
 * @link http://www.92bondstreet.com CBooks
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */

// SwissCode plugin
// Download on https://github.com/92bondstreet/swisscode
require_once('swisscode.php');	

define("MOST_INFLUENTIAL_BOOKS_EVER_WRITTEN", 	'http://en.wikipedia.org/wiki/The_100_Most_Influential_Books_Ever_Written');
define("BOOKS_OF_THE_CENTURY", 					'http://en.wikipedia.org/wiki/Le_Monde%27s_100_Books_of_the_Century');
define("BEST_BOOKS_OF_ALL_TIME", 				'http://en.wikipedia.org/wiki/The_100_Best_Books_of_All_Time');
define("ENGLISH_LANGUAGE_BOOKS_OF_FICTION", 	'http://en.wikipedia.org/wiki/20th_Century%27s_Greatest_Hits:_100_English-Language_Books_of_Fiction');
define("ENGLISH_LANGUAGE_BOOKS_OF_FICTION", 	'http://en.wikipedia.org/wiki/20th_Century%27s_Greatest_Hits:_100_English-Language_Books_of_Fiction');

define("TABLE_TITLE", 		'title');
define("TABLE_AUTHOR", 		'author');
define("TABLE_DATE", 		'date');
define("TABLE_ORIGIN", 		'origin');
 
//Report all PHP errors
error_reporting(E_ALL);
set_time_limit(0);



class Book { 	
	public $title = "";
	public $author = "";
	public $date = "";
	public $origin = "";
	public $toplist = "";
}


class CBooks{
		
	// file dump to log
	private  $enable_log;
	private  $log_file_name = "cbooks.log";
	private  $log_file;
	
	
	/**
	 * Constructor, used to input the data
	 *
	 * @param bool $log
	 */
	public function __construct($log=false){
					
		$this->enable_log = $log;
		if($this->enable_log)
			$this->log_file = fopen($this->log_file_name, "w");
		else
			$this->log_file = null;
			
	}
	
	/**
	 * Destructor, free datas
	 *
	 */
	public function __destruct(){
	
		// and now we're done; close it
		if(isset($this->log_file))
			fclose($this->log_file);
	}
	
	/**
	 * Write to log file
	 *
	 * @param $value string to write 
	 *
	 */
	function dump_to_log($value){
		fwrite($this->log_file, $value."\n");
	}

	/**
	 * Get top 100 books
	 *
	 * @param 	$list 			name of top 100	
	 *
	 * @return array|null
	 */
	
	
	function get_top_100($list){
		
		$results = array();
		$wikipedia_url = null;

		// Step 0. Get table index books informations
		$table_index = $this->get_index($list);
		if(!isset($table_index) || count($table_index)===0)
			return null;
		
		$html = MacG_connect_to($list);
		$html = str_get_html($html);
	
		// Step 1. Get wikipedia table
		$table = $html->find('.wikitable',0);

		if(!isset($table))
			return null;

		// Step 2. Parse according index
		$books_list = $table->find('tr');
		foreach($books_list as $book){
			
			if(strcmp($book->first_child()->tag,'th')==0)
				continue;
			
			$current_book = new Book();

			// 1. title	
			if(array_key_exists(TABLE_TITLE,$table_index)){
				$title = $book->find('td', $table_index[TABLE_TITLE])->plaintext;
				$title = addslashes($title);				
				$current_book->title = mb_convert_encoding($title, 'HTML-ENTITIES', 'UTF-8');	;;
			}
						
			// 2. author
			if(array_key_exists(TABLE_AUTHOR,$table_index)){
				$author = $book->find('td', $table_index[TABLE_AUTHOR]);
				$span = $author->find("span[style*=display:none]", 0);
				if(isset($span)){
					$span->outertext = "";	
					$author = $author->last_child()->plaintext;				
				}
				else
					$author = $author->plaintext;

				$current_book->author = mb_convert_encoding($author, 'HTML-ENTITIES', 'UTF-8');	;
			}
					
			// 3. year/date
			if(array_key_exists(TABLE_DATE,$table_index)){
				$date = $book->find('td', $table_index[TABLE_DATE]);
				$span = $date->find("span[style=display:none]", 0);
				if(isset($span)){
					$span->outertext = "";	
					$date = $date->innertext;				
				}
				else
					$date = $date->plaintext;

				$current_book->date = mb_convert_encoding($date, 'HTML-ENTITIES', 'UTF-8');	
			}
			
			// 4. country/origin
			if(array_key_exists(TABLE_ORIGIN,$table_index)){
				$origin = $book->find('td', $table_index[TABLE_ORIGIN])->plaintext;
				$current_book->origin = $origin;
			}
			
			$current_book->toplist = $list;

			$results[] = $current_book;
		}

		return $results;
	}

	/**
	 * Get index ok author, title... in table
	 *
	 * @param 	$list 			name of top 100	
	 *
	 * @return array|null
	 */

	function get_index($list){

		$table_index = array();

		switch ($list) {
			case MOST_INFLUENTIAL_BOOKS_EVER_WRITTEN:
				$table_index = [ TABLE_TITLE => 2
								,TABLE_AUTHOR => 1
								,TABLE_DATE => 3];
				break;
			
			case BOOKS_OF_THE_CENTURY:
				$table_index = [ TABLE_TITLE => 1
								,TABLE_AUTHOR => 2
								,TABLE_DATE => 3
								,TABLE_ORIGIN => 4];
				break;

			case BEST_BOOKS_OF_ALL_TIME:
				$table_index = [ TABLE_TITLE => 0
								,TABLE_AUTHOR => 1
								,TABLE_DATE => 2
								,TABLE_ORIGIN => 3];
				break;

			case ENGLISH_LANGUAGE_BOOKS_OF_FICTION:
				$table_index = [ TABLE_TITLE => 2
								,TABLE_AUTHOR => 3
								,TABLE_DATE => 1];
				break;

			default:
				return null;
		}

		return $table_index;
	}

}

?>