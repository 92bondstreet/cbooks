CBooks
=========

CBooks (100 Books) is 100 Top books (from wikipedia) PHP API.

Get list of top literay books from wikipedia list.


Requirements
------------
* PHP 5.2.0 or newer
* <a href="https://github.com/92bondstreet/swisscode" target="_blank">SwissCode</a>


What comes in the package?
--------------------------
1. `cbooks.php` - The CBooks class functions to get results
2. `example.php` - All CBooks functions call


Example.php
-----------

	// Init constructor with false value: no dump log file
	$top100Books = new CBooks();

	// The 100 Most Influential Books Ever Written
	$top100 = $top100Books->get_top_100(MOST_INFLUENTIAL_BOOKS_EVER_WRITTEN);
	print_r($top100);

	// Le Monde's 100 Books of the Century
	$top100 = $top100Books->get_top_100(BOOKS_OF_THE_CENTURY);
	print_r($top100);

	// The 100 Best Books of All Time
	$top100 = $top100Books->get_top_100(BEST_BOOKS_OF_ALL_TIME);
	print_r($top100);

	//20th Century's Greatest Hits: 100 English-Language Books of Fiction
	$top100 = $top100Books->get_top_100(ENGLISH_LANGUAGE_BOOKS_OF_FICTION);
	print_r($top100);

To start the demo
-----------------
1. Upload this package to your webserver.
4. Open `example.php` in your web browser and check screen output. 
5. Enjoy !


Project status
--------------
CBooks is currently maintained by Yassine Azzout.


Authors and contributors
------------------------
### Current
* [Yassine Azzout][] (Creator, Building keeper)

[Yassine Azzout]: http://www.92bondstreet.com


License
-------
[MIT license](http://www.opensource.org/licenses/Mit)

