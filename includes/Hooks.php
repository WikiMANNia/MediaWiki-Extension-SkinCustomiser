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
class SkinCustomiserHooks extends Hooks {

	/**
	 * https://www.mediawiki.org/wiki/Manual:Hooks/BeforePageDisplay
	 *
	 * @param OutputPage $out
	 * @param Skin $skin
	 * @return void This hook must not abort, it must return no value
	 */
	public static function onBeforePageDisplay( OutputPage &$out, Skin &$skin ) {

		// 1. Add head data
		global $wgSkinCustomiserHeadItems;

		if ( is_array( $wgSkinCustomiserHeadItems ) && ( count( $wgSkinCustomiserHeadItems ) > 0 ) ) {

			foreach ( $wgSkinCustomiserHeadItems as $value ) {
				$out->addHeadItem( $value[0], $value[1] );
			}
		}


		// 2. Add meta data
		global $wgSkinCustomiserMetaItems;

		if ( is_array( $wgSkinCustomiserMetaItems ) && ( count( $wgSkinCustomiserMetaItems ) > 0 ) ) {

			foreach ( $wgSkinCustomiserMetaItems as $value ) {
				$out->addMeta( $value[0], $value[1] );
			}
		}


		// 3. Add scripts
		global $wgSkinCustomiserDisplayBottom;

		if ( !empty( $wgSkinCustomiserDisplayBottom ) ) {
			$out->addHTML( $wgSkinCustomiserDisplayBottom );
		}


		// 4. Customize skins
		$skinname = $skin->getSkinName();
		$out->addModuleStyles( 'ext.skincustomiser.common' );
		$out->addModuleStyles( 'ext.skincustomiser.mobile' );
		if ( self::isSupported( $skinname ) ) {
			$out->addModuleStyles( 'ext.skincustomiser.' . $skinname );
		} else if ( $skinname !== 'fallback' ) {
			wfLogWarning( 'Skin ' . $skinname . ' not supported by SkinCustomiser.' . "\n" );
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
	public static function onSkinAfterBottomScripts( $skin, &$text ) {

		global $wgSkinCustomiserScripts;

		if ( !empty( $wgSkinCustomiserScripts ) ) {
			$text .= $wgSkinCustomiserScripts;
		}
	}

	private static function isSupported( $skinname ) {

		// 4. Add another supported skin here:
		$mySkin = 'anotherskin';
		return in_array( $skinname, [ 'cologneblue', 'minerva', 'modern', 'monobook', 'timeless', 'vector', 'vector-2022', $mySkin ] );
	}
}
