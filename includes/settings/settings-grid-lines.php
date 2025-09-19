<?php

namespace HelloElementor\Includes\Settings;

use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Tab_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Settings_Grid_Lines extends Tab_Base {

	public function get_id() {
		return 'hello-settings-grid-lines';
	}

	public function get_title() {
		return esc_html__( 'Hello Theme Grid Lines', 'hello-elementor' );
	}

	public function get_icon() {
		return 'eicon-grid';
	}

	public function get_help_url() {
		return '';
	}

	public function get_group() {
		return 'theme-style';
	}

	protected function register_tab_controls() {
		$this->start_controls_section(
			'hello_grid_lines_section',
			[
				'tab' => 'hello-settings-grid-lines',
				'label' => esc_html__( 'Grid Lines', 'hello-elementor' ),
			]
		);

		$this->add_control(
			'hello_grid_lines_enable',
			[
				'type' => Controls_Manager::SWITCHER,
				'label' => esc_html__( 'Enable Grid Lines', 'hello-elementor' ),
				'default' => '',
				'label_on' => esc_html__( 'Show', 'hello-elementor' ),
				'label_off' => esc_html__( 'Hide', 'hello-elementor' ),
			]
		);

		$this->add_control(
			'hello_grid_lines_line_color',
			[
				'label' => esc_html__( 'Line Color', 'hello-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#e1e1e1',
				'condition' => [
					'hello_grid_lines_enable' => 'yes',
				],
			]
		);

		$this->add_control(
			'hello_grid_lines_column_color',
			[
				'label' => esc_html__( 'Column Color', 'hello-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#f0f0f0',
				'condition' => [
					'hello_grid_lines_enable' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'hello_grid_lines_columns',
			[
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__( 'Columns', 'hello-elementor' ),
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 24,
						'step' => 1,
					],
				],
				'default' => [
					'size' => 12,
				],
				'tablet_default' => [
					'size' => 8,
				],
				'mobile_default' => [
					'size' => 4,
				],
				'condition' => [
					'hello_grid_lines_enable' => 'yes',
				],
			]
		);

		$this->add_control(
			'hello_grid_lines_outline',
			[
				'type' => Controls_Manager::SWITCHER,
				'label' => esc_html__( 'Show Outline', 'hello-elementor' ),
				'default' => 'yes',
				'label_on' => esc_html__( 'Show', 'hello-elementor' ),
				'label_off' => esc_html__( 'Hide', 'hello-elementor' ),
				'condition' => [
					'hello_grid_lines_enable' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'hello_grid_lines_max_width',
			[
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__( 'Max Width (px)', 'hello-elementor' ),
				'range' => [
					'px' => [
						'min' => 300,
						'max' => 2000,
						'step' => 10,
					],
				],
				'default' => [
					'size' => 1200,
				],
				'tablet_default' => [
					'size' => 768,
				],
				'mobile_default' => [
					'size' => 480,
				],
				'condition' => [
					'hello_grid_lines_enable' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'hello_grid_lines_width',
			[
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__( 'Width (%)', 'hello-elementor' ),
				'range' => [
					'px' => [
						'min' => 50,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'size' => 100,
				],
				'condition' => [
					'hello_grid_lines_enable' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'hello_grid_lines_line_width',
			[
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__( 'Line Width (px)', 'hello-elementor' ),
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 10,
						'step' => 1,
					],
				],
				'default' => [
					'size' => 1,
				],
				'condition' => [
					'hello_grid_lines_enable' => 'yes',
				],
			]
		);

		$this->add_control(
			'hello_grid_lines_direction',
			[
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__( 'Line Direction (degrees)', 'hello-elementor' ),
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 360,
						'step' => 1,
					],
				],
				'default' => [
					'size' => 0,
				],
				'condition' => [
					'hello_grid_lines_enable' => 'yes',
				],
			]
		);

		$this->add_control(
			'hello_grid_lines_z_index',
			[
				'type' => Controls_Manager::NUMBER,
				'label' => esc_html__( 'Z-index', 'hello-elementor' ),
				'default' => -1,
				'min' => -999,
				'max' => 999,
				'step' => 1,
				'condition' => [
					'hello_grid_lines_enable' => 'yes',
				],
			]
		);

		$this->end_controls_section();
	}

	public function get_additional_tab_content() {
		$content_template = '
			<div class="hello-elementor elementor-nerd-box">
				<img src="%1$s" class="elementor-nerd-box-icon" alt="%2$s">
				<p class="elementor-nerd-box-title">%3$s</p>
				<p class="elementor-nerd-box-message">%4$s</p>
			</div>';

		return sprintf(
			$content_template,
			get_template_directory_uri() . '/assets/images/go-pro.svg',
			esc_attr__( 'Grid Lines', 'hello-elementor' ),
			esc_html__( 'Visual Grid Helper', 'hello-elementor' ),
			esc_html__( 'Use grid lines to help align your content during design and development.', 'hello-elementor' )
		);
	}
}