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
            'slide_btn_text',
            [
                'label' => __( 'Slide botton Text', 'plugin-domain' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __( 'Read More' , 'plugin-domain' ),
            ]
        );
        $repeater->add_control(
            'slide_link',
            [
                'label' => __( 'Slide link', 'plugin-domain' ),
                'type' => \Elementor\Controls_Manager::TEXT,
            ]
        );
        $repeater->add_control(
            'slide_img',
            [
                'label' => __( 'Slide Image', 'plugin-domain' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
            ]
        );

        $this->add_control(
            'slides',
            [
                'label' => __( 'Slides', 'plugin-domain' ),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'list_title' => __( 'Slide Title', 'plugin-domain' ),
                        'slide_btn_text' => __( 'Read More', 'plugin-domain' ),
                    ]
                ],
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'Slide_setting',
            [
                'label' => __( 'Slide Setting', 'plugin-name' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
           'fade',
           [
            'label'       =>__('Fade Effect?','plugin-domain'),
            'type'        =>\Elementor\Controls_Manager::SWITCHER,
            'label_on'    =>__('Yes','your-plugin'),
            'label_off'   =>__('No','your-plugin'),
            'return_value'=>'yes',
            'default'     =>'on'
           ]
        );
        $this->add_control(
           'loop',
           [
            'label'       =>__('Loop?','plugin-domain'),
            'type'        =>\Elementor\Controls_Manager::SWITCHER,
            'label_on'    =>__('Yes','your-plugin'),
            'label_off'   =>__('No','your-plugin'),
            'return_value'=>'yes',
            'default'     =>'on'
           ]
        );
        $this->add_control(
           'arrows',
           [
            'label'       =>__('show arrows?','plugin-domain'),
            'type'        =>\Elementor\Controls_Manager::SWITCHER,
            'label_on'    =>__('Show','your-plugin'),
            'label_off'   =>__('Hide','your-plugin'),
            'return_value'=>'yes',
            'default'     =>'yes'
           ]
        );
        $this->add_control(
           'dots',
           [
            'label'       =>__('show dots?','plugin-domain'),
            'type'        =>\Elementor\Controls_Manager::SWITCHER,
            'label_on'    =>__('Show','your-plugin'),
            'label_off'   =>__('Hide','your-plugin'),
            'return_value'=>'yes',
            'default'     =>'yes'
           ]
        );
          $this->add_control(
           'autoplay',
           [
            'label'       =>__('Autoplay?','plugin-domain'),
            'type'        =>\Elementor\Controls_Manager::SWITCHER,
            'label_on'    =>__('yes','your-plugin'),
            'label_off'   =>__('no','your-plugin'),
            'return_value'=>'yes',
            'default'     =>'yes'
           ]
        );

         $this->add_control(
           'autoplay_time',
           [
            'label'       =>__('Autoplay Time?','plugin-domain'),
            'type'        =>\Elementor\Controls_Manager::TEXT,
            'default'     =>'5000',
            'condition'   =>[
                'autoplay' =>'yes'
            ],

          ]
        );
         $this->end_controls_section();
 }

    protected function render() {

        $settings = $this->get_settings_for_display();

        if (!empty($settings['slides'])) {
            $html ='';
            $dynamic_id =rand(777888,88775877);

            if (count($settings['slides']) >1 ) {
                if ($settings['fade']== 'yes') {
                     $fade ='true';
                 } else{
                    $fade='false';
                 }
                 if ($settings['loop']== 'yes') {
                     $loop ='true';
                 } else{
                    $loop='false';
                 }
                 if ($settings['arrows']== 'yes') {
                     $arrows ='true';
                 } else{
                    $arrows='false';
                 }
                 if ($settings['dots']== 'yes') {
                     $dots ='true';
                 } else{
                    $dots='false';
                 }
                 if ($settings['autoplay']== 'yes') {
                     $autoplay ='true';
                 } else{
                    $autoplay='false';
                 }

                $html.='<script>
                    jQuery(document).ready(function($){
                        $("#slides-'.$dynamic_id.'").slick({
                          arrows   :'.$arrows.',
                          prevArrow:"<i class=\'fa fa-angle-left\'></i>",
                          nextArrow:"<i class=\'fa fa-angle-right\'></i>",
                          dots     :'.$dots.',
                          fade     :'.$fade.',
                          autoplay :'.$autoplay.',
                          loop     : '.$loop.',
                        });
                            
                   });
                </script>';
            }

             $html.='<div class="slider-wrapper">
                <div id="slides-'.$dynamic_id.'" class="slides">';
                 foreach ($settings['slides'] as $slides) {

                 //echo var_dump($slides['slide_img']);  
                $html.='<div class="single-slide-item" style="background-image:url('.wp_get_attachment_image_url($slides['slide_img']['id'],'large').')">
                    <div class="container">
                        <div class="row justify-content-center text-center">
                            <div class="col my-auto">
                               <div class="slide-text">
                               <h2>'.$slides['slide_title'].'</h2>  
                              '.wpautop($slides['slide_content']).'
                              <a href="'.$slides['slide_link'].'" class="box-btn">'.$slides['slide_btn_text'].'</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>';
            }
         $html.='</div><img class="slider-shape" src="'.get_template_directory_uri().'/assets/img/slider-botton.png" alt=""></div>';
        }else{
            $html ='<div class="alert alert-warning">Please Add slides.</div>';
        }

        echo $html;

    }
}