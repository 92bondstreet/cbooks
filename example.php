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
 
require_once('cbooks.php');

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
?>