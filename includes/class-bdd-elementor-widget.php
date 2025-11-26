<?php
if (!defined('ABSPATH')) exit;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class BDD_Elementor_Widget extends Widget_Base {

    public function get_name() {
        return 'bdd_downloads';
    }

    public function get_title() {
        return 'Bootstrap Document Downloads';
    }

    public function get_icon() {
        return 'eicon-file-download';
    }

    public function get_categories() {
        return ['general'];
    }

    protected function register_controls() {
        $this->start_controls_section('content_section', [
            'label' => __('Settings', 'bdd'),
            'tab'   => Controls_Manager::TAB_CONTENT,
        ]);

        $categories = get_terms([
            'taxonomy'   => 'download_cat',
            'hide_empty' => false,
        ]);

        $options = [];
        if (!empty($categories) && !is_wp_error($categories)) {
            foreach ($categories as $cat) {
                $options[$cat->slug] = $cat->name;
            }
        }

        $this->add_control('category', [
            'label'       => __('Category', 'bdd'),
            'type'        => Controls_Manager::SELECT2,
            'options'     => $options,
            'multiple'    => true,
            'description' => 'Select download categories.',
        ]);

        $this->add_control('columns', [
            'label'   => __('Columns per Row', 'bdd'),
            'type'    => Controls_Manager::NUMBER,
            'min'     => 1,
            'max'     => 6,
            'default' => 3,
        ]);

        $this->add_control('limit', [
            'label'   => __('Total Items Limit', 'bdd'),
            'type'    => Controls_Manager::NUMBER,
            'min'     => 1,
            'max'     => 50,
            'default' => 9,
        ]);

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        $category = '';
        if (!empty($settings['category'])) {
            $category = is_array($settings['category'])
                ? implode(',', $settings['category'])
                : $settings['category'];
        }

        echo bdd_render_grid(
            $category,
            $settings['columns'],
            $settings['limit']
        );
    }
}