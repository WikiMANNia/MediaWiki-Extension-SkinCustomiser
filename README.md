# SkinCustomiser
Die Pflege der MediaWiki-Erweiterung [SkinCustomiser](https://www.mediawiki.org/wiki/Extension:SkinCustomiser) wird von WikiMANNia verwaltet.

The maintenance of the MediaWiki extension [SkinCustomiser](https://www.mediawiki.org/wiki/Extension:SkinCustomiser) is managed by WikiMANNia.

El mantenimiento de la extensión de MediaWiki [SkinCustomiser](https://www.mediawiki.org/wiki/Extension:SkinCustomiser) está gestionado por WikiMANNia.

## Description

Customises existing MediaWiki skins. Add scripts and meta data in the header area. Add translated labels to the sidebar.

Installation instructions can be found at [MediaWiki](http://www.mediawiki.org/wiki/Extension:SkinCustomiser).

## Configuration

### Add head data

* $wgSkinCustomiserHeadItems = [
		[ "key1", "content1" ],
		[ "key2", "content2" ]
	];

### Add meta data

* $wgSkinCustomiserMetaItems = [
		[ "name1", "content1" ]
		[ "name2", "content2" ],
	];

### Add bottom data

* $wgSkinCustomiserDisplayBottom = "&lt;p>Something at the bottom of every page.&lt;/p>";

### Add scripts

* $wgSkinCustomiserScripts = '&lt;script type="text/javascript">Some script code here!&lt;/script>';

### Configure logo

$wgLogos   = [ '1x' => "$wgResourceBasePath/extensions/SkinCustomiser/resources/images/logo.png" ];

$wgFavicon = "$wgResourceBasePath/extensions/SkinCustomiser/resources/images/favicon.ico";

#### Skin `vector-2022`

$wgLogos = [

'1x' => "$wgResourceBasePath/extensions/SkinCustomiser/resources/images/logo.png",

'icon' => "$wgResourceBasePath/extensions/SkinCustomiser/resources/images/logo-icon.svg",

'wordmark' => [

"src" => "$wgResourceBasePath/extensions/SkinCustomiser/resources/images/logo-wordmark.svg",

"width" => 160, "height" => 24 ],

'tagline' => [

"src" => "$wgResourceBasePath/extensions/SkinCustomiser/resources/images/logo-tagline.svg",

"width" => 160, "height" => 14 ]

];

$wgFavicon = "$wgResourceBasePath/extensions/SkinCustomiser/resources/images/favicon.ico";

## Version history

1.0.0

* First public release

1.1.0

* Add Support for MediaWiki:Mobile.css

1.2.0

* Add Support for `fallback`, `minerva`, `timeless`, `vector-2022`

2.0.0

* Refactoring
* Adding features from extension [PCR GUI Inserts](https://www.mediawiki.org/wiki/Extension:PCR_GUI_Inserts)

2.0.1

* Support added for Skin [Monaco](https://www.mediawiki.org/wiki/Skin:Monaco).
