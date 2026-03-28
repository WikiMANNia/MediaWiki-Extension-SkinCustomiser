<?php
/**
 * Hooks for SkinCustomiser extension
 *
 * @author WikiMANNia
 *
 * @license GPL-2.0-or-later
 *
 * @file
 * @ingroup Extensions
 */

namespace MediaWiki\Extension\SkinCustomiser;

use MediaWiki\Hook\BeforePageDisplayHook;
use MediaWiki\Hook\SkinAfterBottomScriptsHook;

use MediaWiki\Config\Config;
use MediaWiki\Output\OutputPage;
use MediaWiki\Skin\Skin;

// Class aliases for multi-version compatibility.
// These need to be in global scope so phan can pick up on them,
// and before any use statements that make use of the namespaced names.
if ( version_compare( MW_VERSION, '1.41', '<' ) ) {
	if ( !class_exists('MediaWiki\Config\Config') )  class_alias( '\Config', '\MediaWiki\Config\Config' );
	if ( !class_exists('MediaWiki\Output\OutputPage') )  class_alias( '\OutputPage', '\MediaWiki\Output\OutputPage' );
}

if ( version_compare( MW_VERSION, '1.44', '<' ) ) {
	if ( !class_exists('MediaWiki\Skin\Skin') )  class_alias( '\Skin', '\MediaWiki\Skin\Skin' );
}

/**
 * PHPMD will warn us about these things here but since they're hooks,
 * we really don't have much choice.
 *
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 *
 * @phpcs:disable MediaWiki.NamingConventions.LowerCamelFunctionsName.FunctionName
 */
class Hooks implements
	BeforePageDisplayHook,
	SkinAfterBottomScriptsHook
{

	private Config $config;

	/**
	 * @param GlobalVarConfig $config
	 */
	public function __construct(
		Config $config
	) {
		$this->config = $config;
	}

	/**
	 * https://www.mediawiki.org/wiki/Manual:Hooks/BeforePageDisplay
	 *
	 * @param OutputPage $out
	 * @param Skin $skin
	 * @return void This hook must not abort, it must return no value
	 */
	public function onBeforePageDisplay( $out, $skin ): void {

		$_array = $this->config->get( "SkinCustomiserHeadItems" );
		if ( is_array( $_array ) && ( count( $_array ) > 0 ) ) {

			foreach ( $_array as $value ) {
				$out->addHeadItem( $value[0], $value[1] );
			}
		}

		$_array = $this->config->get( "SkinCustomiserMetaItems" );
		if ( is_array( $_array ) && ( count( $_array ) > 0 ) ) {

			foreach ( $_array as $value ) {
				$out->addMeta( $value[0], $value[1] );
			}
		}

		$_string = $this->config->get( "SkinCustomiserDisplayBottom" );
		if ( !empty( $_string ) ) {
			$out->addHTML( $_string );
		}

		$skinName = $skin->getSkinName();
		$out->addModuleStyles( 'ext.skincustomiser.common' );
		$out->addModuleStyles( 'ext.skincustomiser.mobile' );
		if ( self::isSupported( $skinName ) ) {
			if ( $skinName !== 'monaco' ) {
				$out->addModuleStyles( 'ext.skincustomiser.' . $skinName );
			}
		} else if ( ( $skinName !== 'apioutput' ) AND ( $skinName !== 'fallback' ) ) {
			wfLogWarning( "Skin $skinName not supported by SkinCustomiser.\n" );
		}
	}

	/**
	 * https://www.mediawiki.org/wiki/Manual:Hooks/SkinAfterBottomScripts
	 *
	 * @param Skin $skin
	 * @param string &$text BottomScripts text. Append to $text to add additional text/scripts after
	 *   the stock bottom scripts.
	 * @return bool|void True or no return value to continue or false to abort
	 */
	public function onSkinAfterBottomScripts( $skin, &$text ) {

		$_string = $this->config->get( "SkinCustomiserScripts" );
		if ( !empty( $_string ) ) {
			$text .= $_string;
		}
	}

	private static function isSupported( string $skinName ): bool {

		$mySkin = 'anotherskin';
		return in_array( $skinName, [ 'citizen', 'cologneblue', 'minerva', 'modern', 'monaco', 'monobook', 'timeless', 'vector', 'vector-2022', $mySkin ] );
	}
}
