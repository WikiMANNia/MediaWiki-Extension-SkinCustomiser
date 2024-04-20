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

use GlobalVarConfig;
use OutputPage;
use Skin;

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

	private GlobalVarConfig $config;

	/**
	 * @param GlobalVarConfig $config
	 */
	public function __construct(
		GlobalVarConfig $config
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

		$skinname = $skin->getSkinName();
		$out->addModuleStyles( 'ext.skincustomiser.common' );
		$out->addModuleStyles( 'ext.skincustomiser.mobile' );
		if ( self::isSupported( $skinname ) ) {
			$out->addModuleStyles( 'ext.skincustomiser.' . $skinname );
		} else if ( $skinname !== 'fallback' ) {
			wfLogWarning( "Skin $skinname not supported by SkinCustomiser.\n" );
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

	private static function isSupported( $skinname ) {

		$mySkin = 'anotherskin';
		return in_array( $skinname, [ 'cologneblue', 'minerva', 'modern', 'monaco', 'monobook', 'timeless', 'vector', 'vector-2022', $mySkin ] );
	}
}
