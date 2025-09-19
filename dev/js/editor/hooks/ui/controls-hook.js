export default class ControlsHook extends $e.modules.hookUI.After {
	getCommand() {
		// Command to listen.
		return 'document/elements/settings';
	}

	getId() {
		// Unique id for the hook.
		return 'hello-elementor-editor-controls-handler';
	}

	/**
	 * Get Hello Elementor Theme Controls
	 *
	 * Returns an object in which the keys are control IDs, and the values are the selectors of the elements that need
	 * to be targeted in the apply() method.
	 *
	 * Example return value:
	 *   {
	 *      hello_elementor_show_logo: '.site-header .site-header-logo',
	 *      hello_elementor_show_menu: '.site-header .site-header-menu',
	 *   }
	 */
	getHelloThemeControls() {
		return {
			hello_header_logo_display: {
				selector: '.site-header .site-logo, .site-header .site-title',
				callback: ( $element, args ) => {
					this.toggleShowHideClass( $element, args.settings.hello_header_logo_display );
				},
			},
			hello_header_menu_display: {
				selector: '.site-header .site-navigation, .site-header .site-navigation-toggle-holder',
				callback: ( $element, args ) => {
					this.toggleShowHideClass( $element, args.settings.hello_header_menu_display );
				},
			},
			hello_header_tagline_display: {
				selector: '.site-header .site-description',
				callback: ( $element, args ) => {
					this.toggleShowHideClass( $element, args.settings.hello_header_tagline_display );
				},
			},
			hello_header_logo_type: {
				selector: '.site-header .site-branding',
				callback: ( $element, args ) => {
					const classPrefix = 'show-',
						inputOptions = args.container.controls.hello_header_logo_type.options,
						inputValue = args.settings.hello_header_logo_type;

					this.toggleLayoutClass( $element, classPrefix, inputOptions, inputValue );
				},
			},
			hello_header_layout: {
				selector: '.site-header',
				callback: ( $element, args ) => {
					const classPrefix = 'header-',
						inputOptions = args.container.controls.hello_header_layout.options,
						inputValue = args.settings.hello_header_layout;

					this.toggleLayoutClass( $element, classPrefix, inputOptions, inputValue );
				},
			},
			hello_header_width: {
				selector: '.site-header',
				callback: ( $element, args ) => {
					const classPrefix = 'header-',
						inputOptions = args.container.controls.hello_header_width.options,
						inputValue = args.settings.hello_header_width;

					this.toggleLayoutClass( $element, classPrefix, inputOptions, inputValue );
				},
			},
			hello_header_menu_layout: {
				selector: '.site-header',
				callback: ( $element, args ) => {
					const classPrefix = 'menu-layout-',
						inputOptions = args.container.controls.hello_header_menu_layout.options,
						inputValue = args.settings.hello_header_menu_layout;

					// No matter what, close the mobile menu
					$element.find( '.site-navigation-toggle-holder' ).removeClass( 'elementor-active' );
					$element.find( '.site-navigation-dropdown' ).removeClass( 'show' );

					this.toggleLayoutClass( $element, classPrefix, inputOptions, inputValue );
				},
			},
			hello_header_menu_dropdown: {
				selector: '.site-header',
				callback: ( $element, args ) => {
					const classPrefix = 'menu-dropdown-',
						inputOptions = args.container.controls.hello_header_menu_dropdown.options,
						inputValue = args.settings.hello_header_menu_dropdown;

					this.toggleLayoutClass( $element, classPrefix, inputOptions, inputValue );
				},
			},
			hello_footer_logo_display: {
				selector: '.site-footer .site-logo, .site-footer .site-title',
				callback: ( $element, args ) => {
					this.toggleShowHideClass( $element, args.settings.hello_footer_logo_display );
				},
			},
			hello_footer_tagline_display: {
				selector: '.site-footer .site-description',
				callback: ( $element, args ) => {
					this.toggleShowHideClass( $element, args.settings.hello_footer_tagline_display );
				},
			},
			hello_footer_menu_display: {
				selector: '.site-footer .site-navigation',
				callback: ( $element, args ) => {
					this.toggleShowHideClass( $element, args.settings.hello_footer_menu_display );
				},
			},
			hello_footer_copyright_display: {
				selector: '.site-footer .copyright',
				callback: ( $element, args ) => {
					const $footerContainer = $element.closest( '#site-footer' ),
						inputValue = args.settings.hello_footer_copyright_display;

					this.toggleShowHideClass( $element, inputValue );

					$footerContainer.toggleClass( 'footer-has-copyright', 'yes' === inputValue );
				},
			},
			hello_footer_logo_type: {
				selector: '.site-footer .site-branding',
				callback: ( $element, args ) => {
					const classPrefix = 'show-',
						inputOptions = args.container.controls.hello_footer_logo_type.options,
						inputValue = args.settings.hello_footer_logo_type;

					this.toggleLayoutClass( $element, classPrefix, inputOptions, inputValue );
				},
			},
			hello_footer_layout: {
				selector: '.site-footer',
				callback: ( $element, args ) => {
					const classPrefix = 'footer-',
						inputOptions = args.container.controls.hello_footer_layout.options,
						inputValue = args.settings.hello_footer_layout;

					this.toggleLayoutClass( $element, classPrefix, inputOptions, inputValue );
				},
			},
			hello_footer_width: {
				selector: '.site-footer',
				callback: ( $element, args ) => {
					const classPrefix = 'footer-',
						inputOptions = args.container.controls.hello_footer_width.options,
						inputValue = args.settings.hello_footer_width;

					this.toggleLayoutClass( $element, classPrefix, inputOptions, inputValue );
				},
			},
			hello_footer_copyright_text: {
				selector: '.site-footer .copyright',
				callback: ( $element, args ) => {
					const inputValue = args.settings.hello_footer_copyright_text;

					$element.find( 'p' ).text( inputValue );
				},
			},
			hello_grid_lines_enable: {
				selector: 'body',
				callback: ( $element, args ) => {
					const inputValue = args.settings.hello_grid_lines_enable;
					const gridOverlay = elementor.$previewContents.find( '.hello-grid-lines-overlay' );

					if ( 'yes' === inputValue ) {
						if ( ! gridOverlay.length ) {
							this.createGridLinesOverlay();
						} else {
							gridOverlay.show();
						}
					} else {
						gridOverlay.hide();
					}
				},
			},
			hello_grid_lines_line_color: {
				selector: '.hello-grid-lines-overlay',
				callback: () => {
					this.updateGridLinesStyles();
				},
			},
			hello_grid_lines_column_color: {
				selector: '.hello-grid-lines-overlay',
				callback: () => {
					this.updateGridLinesStyles();
				},
			},
			hello_grid_lines_columns: {
				selector: '.hello-grid-lines-overlay',
				callback: () => {
					this.updateGridLinesColumns();
				},
			},
			hello_grid_lines_outline: {
				selector: '.hello-grid-lines-overlay',
				callback: () => {
					this.updateGridLinesStyles();
				},
			},
			hello_grid_lines_max_width: {
				selector: '.hello-grid-lines-overlay',
				callback: () => {
					this.updateGridLinesStyles();
				},
			},
			hello_grid_lines_width: {
				selector: '.hello-grid-lines-overlay',
				callback: () => {
					this.updateGridLinesStyles();
				},
			},
			hello_grid_lines_line_width: {
				selector: '.hello-grid-lines-overlay',
				callback: () => {
					this.updateGridLinesStyles();
				},
			},
			hello_grid_lines_direction: {
				selector: '.hello-grid-lines-overlay',
				callback: () => {
					this.updateGridLinesStyles();
				},
			},
			hello_grid_lines_z_index: {
				selector: '.hello-grid-lines-overlay',
				callback: () => {
					this.updateGridLinesStyles();
				},
			},
		};
	}

	/**
	 * Toggle show and hide classes on containers
	 *
	 * This will remove the .show and .hide clases from the element, then apply the new class
	 *
	 * @param {jQuery} element
	 * @param {string} inputValue
	 */
	toggleShowHideClass( element, inputValue ) {
		element.removeClass( 'hide' ).removeClass( 'show' ).addClass( inputValue ? 'show' : 'hide' );
	}

	/**
	 * Toggle layout classes on containers
	 *
	 * This will cleanly set classes onto which ever container we want to target, removing the old classes and adding the new one
	 *
	 * @param {jQuery} element
	 * @param {string} classPrefix
	 * @param {Object} inputOptions
	 * @param {string} inputValue
	 */
	toggleLayoutClass( element, classPrefix, inputOptions, inputValue ) {
		// Loop through the possible classes and remove the one that's not in use
		Object.entries( inputOptions ).forEach( ( [ key ] ) => {
			element.removeClass( classPrefix + key );
		} );

		// Append the class which we want to use onto the element
		if ( '' !== inputValue ) {
			element.addClass( classPrefix + inputValue );
		}
	}

	/**
	 * Create grid lines overlay in the editor preview
	 */
	createGridLinesOverlay() {
		const $previewDocument = elementor.$previewContents;
		const gridOverlay = $previewDocument.find( '.hello-grid-lines-overlay' );

		if ( gridOverlay.length ) {
			return;
		}

		const overlayHtml = '<div class="hello-grid-lines-overlay"><div class="hello-grid-lines-columns"></div></div>';
		$previewDocument.find( 'body' ).append( overlayHtml );

		this.updateGridLinesColumns();
		this.updateGridLinesStyles();
	}

	/**
	 * Update grid lines columns
	 */
	updateGridLinesColumns() {
		const $previewDocument = elementor.$previewContents;
		const $columnsContainer = $previewDocument.find( '.hello-grid-lines-columns' );

		if ( ! $columnsContainer.length ) {
			return;
		}

		const settings = elementor.settings.page.model.attributes;
		const columns = settings.hello_grid_lines_columns?.size || 12;

		$columnsContainer.empty();

		for ( let i = 0; i < columns; i++ ) {
			$columnsContainer.append( '<div class="hello-grid-lines-column"></div>' );
		}
	}

	/**
	 * Update grid lines styles
	 */
	updateGridLinesStyles() {
		const $previewDocument = elementor.$previewContents;
		const $existingStyle = $previewDocument.find( '#hello-grid-lines-editor-css' );

		if ( $existingStyle.length ) {
			$existingStyle.remove();
		}

		const settings = elementor.settings.page.model.attributes;
		const lineColor = settings.hello_grid_lines_line_color || '#e1e1e1';
		const columnColor = settings.hello_grid_lines_column_color || '#f0f0f0';
		const outline = settings.hello_grid_lines_outline || 'yes';
		const maxWidth = settings.hello_grid_lines_max_width?.size || 1200;
		const width = settings.hello_grid_lines_width?.size || 100;
		const lineWidth = settings.hello_grid_lines_line_width?.size || 1;
		const direction = settings.hello_grid_lines_direction?.size || 0;
		const zIndex = settings.hello_grid_lines_z_index || -1;

		let css = '<style id="hello-grid-lines-editor-css">';
		css += '.hello-grid-lines-overlay {';
		css += 'position: fixed;';
		css += 'top: 0;';
		css += 'left: 50%;';
		css += 'transform: translateX(-50%);';
		css += 'height: 100vh;';
		css += 'pointer-events: none;';
		css += 'z-index: ' + zIndex + ';';
		css += 'max-width: ' + maxWidth + 'px;';
		css += 'width: ' + width + '%;';

		if ( 'yes' === outline ) {
			css += 'border-left: ' + lineWidth + 'px solid ' + lineColor + ';';
			css += 'border-right: ' + lineWidth + 'px solid ' + lineColor + ';';
		}

		css += '}';
		css += '.hello-grid-lines-columns {';
		css += 'display: flex;';
		css += 'height: 100%;';
		css += 'transform: rotate(' + direction + 'deg);';
		css += '}';
		css += '.hello-grid-lines-column {';
		css += 'flex: 1;';
		css += 'background-color: ' + columnColor + ';';
		css += 'border-right: ' + lineWidth + 'px solid ' + lineColor + ';';
		css += '}';
		css += '.hello-grid-lines-column:last-child {';
		css += 'border-right: none;';
		css += '}';
		css += '</style>';

		$previewDocument.find( 'head' ).append( css );
	}

	/**
	 * Set the conditions under which the hook will run.
	 *
	 * @param {Object} args
	 */
	getConditions( args ) {
		const isKit = 'kit' === elementor.documents.getCurrent().config.type,
			changedControls = Object.keys( args.settings ),
			isSingleSetting = 1 === changedControls.length;

		// If the document is not a kit, or there are no changed settings, or there is more than one single changed
		// setting, don't run the hook.
		if ( ! isKit || ! args.settings || ! isSingleSetting ) {
			return false;
		}

		// If the changed control is in the list of theme controls, return true to run the hook.
		// Otherwise, return false so the hook doesn't run.
		return !! Object.keys( this.getHelloThemeControls() ).includes( changedControls[ 0 ] );
	}

	/**
	 * The hook logic.
	 *
	 * @param {Object} args
	 */
	apply( args ) {
		const allThemeControls = this.getHelloThemeControls(),
			// Extract the control ID from the passed args
			controlId = Object.keys( args.settings )[ 0 ],
			controlConfig = allThemeControls[ controlId ],
			// Find the element that needs to be targeted by the control.
			$element = elementor.$previewContents.find( controlConfig.selector );

		controlConfig.callback( $element, args );
	}
}
