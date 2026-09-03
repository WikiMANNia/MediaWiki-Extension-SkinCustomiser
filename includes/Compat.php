<?php

namespace MediaWiki\Extension\SkinCustomiser;

class Compat {

    public static function init(): void {
        self::aliasCoreClasses();
    }

    private static function aliasCoreClasses(): void {

		// Class aliases for multi-version compatibility.
		// These need to be in global scope so phan can pick up on them,
		// and before any use statements that make use of the namespaced names.
		if ( version_compare( MW_VERSION, '1.41', '<' ) ) {
			class_exists( 'MediaWiki\Config\Config' ) or class_alias( '\Config', '\MediaWiki\Config\Config' );
			class_exists( 'MediaWiki\Output\OutputPage' ) or class_alias( '\OutputPage', '\MediaWiki\Output\OutputPage' );
		}

		if ( version_compare( MW_VERSION, '1.44', '<' ) ) {
			class_exists( 'MediaWiki\Skin\Skin' ) or class_alias( '\Skin', '\MediaWiki\Skin\Skin' );
		}
    }
}