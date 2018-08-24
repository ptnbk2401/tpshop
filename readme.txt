Install

"require": {
    "sunra/php-simple-html-dom-parser": "1.5.2"
    }

Usage
use Sunra\PhpSimple\HtmlDomParser;

...
$doc = str_get_html('<img data-src="foo">');
echo $doc->find('img', 0)->getAttribute('data-src');


$dom = HtmlDomParser::file_get_html( $file_name );

$elems = $dom->find($elem_name);


Error: file_get_contents(): stream does not support seeking
Sửa file file_html_dom.php -> hàm file_get_html -> $offset = 0