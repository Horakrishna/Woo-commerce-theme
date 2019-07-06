<?php
/**
 * Elementor avocado widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */
class Avocado_slider_Widget extends \Elementor\Widget_Base {

    
    public function get_name() {
        return 'avocado-slider';
    }

    public function get_title() {
        return __( 'Avocado-slider', 'plugin-name' );
    }

    public function get_icon() {
        return 'fa fa-code';
    }

    public function get_categories() {
        return [ 'general' ];
    }

    
    protected function _register_controls() {

        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Content', 'plugin-name' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'url',
            [
                'label' => __( 'URL to embed', 'plugin-name' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'input_type' => 'url',
                'placeholder' => __( 'https://your-link.com', 'plugin-name' ),
            ]
        );

        $this->add_control(
            'link',
            [
                'label' => __( 'Link to embed', 'plugin-name' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'input_type' => 'link',
                'placeholder' => __( 'https://google.com', 'plugin-name' ),
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'slide_title', [
                'label' => __( 'Title', 'plugin-domain' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __( 'Slide Title' , 'plugin-domain' ),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'slide_content', [
                'label' => __( 'Content', 'plugin-domain' ),
                'type' => \Elementor\Controls_Manager::WYSIWYG,
                'default' => __( 'Slide Content' , 'plugin-domain' ),
                'show_label' => true,
            ]
        );

        $repeater->add_control(
            'slide_desc',
            [
                'label' => __( 'Slide Description', 'plugin-domain' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __( 'Slide Description' , 'plugin-domain' ),
                'show_label' => true,
            ]
        );
        $repeater->add_control(
            'slide_img',
            [
                'label' => __( 'Slide Image', 'plugin-domain' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => __( 'Slide Image' , 'plugin-domain' ),
                'show_label' => true,
            ]
        );

        $this->add_control(
            'slides',
            [
                'label' => __( 'slides', 'plugin-domain' ),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'list_title' => __( 'Slide #1', 'plugin-domain' ),
                        'list_content' => __( 'Slide content', 'plugin-domain' ),
                    ]
                ],
            ]
        );


        $this->end_controls_section();

    }

    protected function render() {

        $settings = $this->get_settings_for_display();

        if ($settings['slides']) {

            $dynamic_id =rand(777888,88775877);

            if (count($settings['slides']) >1 ) {
                
                echo '<script>
                    jQuery(document).ready(function($){
                        $("#slides-'.$dynamic_id.'").slick();

                        });
                </script>';
            }

            echo '<div id="slides-'.$dynamic_id.'" class="slides">';

            foreach ($settings['slides'] as $slides) {

                 //echo var_dump($slides['slide_img']);  
                echo '<div class="single-slide-item" style="background-image:url('.wp_get_attachment_image_url($slides['slide_img']['id'],'large').')">
                    <div class="row">
                        <div class="col my-auto">
                          '.wpautop($slides['slide_content']).'
                        </div>
                    </div>   
                        <div class="slide-info">
                            <h3>'.$slides['slide_title'].'</h3>
                            '.$slides['slide_desc'].'
                        </div>
                    
                </div>';
            }
     echo '</div>';
        }

    }

}
