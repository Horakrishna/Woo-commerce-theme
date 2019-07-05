<?php 





class Avocaro_Slider_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'slider';
    }
    
	public function get_title() {
		return __( 'Slider', 'ppm-quickstart' );
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
				'label' => __( 'Slides', 'plugin-name' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
        );
        
        $repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'title', [
				'label' => __( 'Title', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Slide Title' , 'plugin-domain' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'content', [
				'label' => __( 'Content', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'default' => __( 'Slide Content' , 'plugin-domain' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'slide_btn_text', [
				'label' => __( 'Button text', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Read More' , 'plugin-domain' ),
			]
		);

		$repeater->add_control(
			'slide_link', [
				'label' => __( 'Button link', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::TEXT,
			]
		);

		$repeater->add_control(
			'slide_bg', [
				'label' => __( 'Slide Background', 'plugin-domain' ),
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
						'title' => __( 'Slide Title', 'plugin-domain' ),
						'slide_btn_text' => __( 'Read More', 'plugin-domain' ),
					]
				],
				'title_field' => '{{{ title }}}',
			]
		);

		$this->end_controls_section();

	}

	protected function render() {

		$settings = $this->get_settings_for_display();

        if(!empty($settings['slides'])) {
            $html = '';
            $random = rand(8977,897987);
            if(count($settings['slides']) > 1) {
                $html .= '<script>
                    jQuery(document).ready(function($) {
                        $("#slide-'.$random.'").slick({

                        });
                    });
                </script>';
            }
            $html .= '<div class="slider-wrapper"><div id="slide-'.$random.'" class="slides">';
                foreach($settings['slides'] as $slide) {
                    $html .= '<div style="background-image:url('.wp_get_attachment_image_url($slide['slide_bg']['id'], 'large').')" class="single-slide-item">
                        <div class="container">
                            <div class="row justify-content-center text-center">
                                <div class="col my-auto">
                                    <div class="slide-text">
										<h2>'.$slide['title'].'</h2>
										'.wpautop(do_shortcode($slide['content'])).'
                                        <a href="'.$slide['slide_link'].'" class="boxed-btn">'.$slide['slide_btn_text'].'</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>';
                }
            $html .= '</div><img class="slider-shape" src="'.get_template_directory_uri().'/assets/img/slider-bottom.png" alt=""/></div>';
        } else {
            $html = '<div class="alert alert-warning">Please add slides.</div>';
        }
        


        echo $html;

	}

}

if ( class_exists( 'WooCommerce' ) ) {


    function avocado_product_cat_list( ) {
        $elements = get_terms( 'product_cat', array('hide_empty' => false) );
        $product_cat_array = array();

        if ( !empty($elements) ) {
            foreach ( $elements as $element ) {
                $info = get_term($element, 'product_cat');
                $product_cat_array[ $info->term_id ] = $info->name;
            }
        }
    
        return $product_cat_array;
    }


    class Avocado_Categories_Widget extends \Elementor\Widget_Base {

        public function get_name() {
            return 'avocado-categories';
        }
        
        public function get_title() {
            return __( 'Avocado Cagegories', 'ppm-quickstart' );
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
                    'label' => __( 'Configuration', 'plugin-name' ),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
            );


            $this->add_control(
                'cat_ids',
                [
                    'label' => __( 'Select Categories', 'plugin-domain' ),
                    'type' => \Elementor\Controls_Manager::SELECT2,
                    'multiple' => true,
                    'options' => avocado_product_cat_list()
                ]
            );

            $this->add_control(
                'columns',
                [
                    'label' => __( 'Columns', 'plugin-domain' ),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'default' => '4',
                    'options' => [
                        '4'  => __( '4 Columns', 'plugin-domain' ),
                        '3'  => __( '3 Columns', 'plugin-domain' ),
                        '2'  => __( '2 Columns', 'plugin-domain' ),
                        '1'  => __( '1 Columns', 'plugin-domain' ),
                    ],
                ]
            );

            $this->add_control(
                'bg',
                [
                    'label' => __( 'Image as background?', 'plugin-domain' ),
                    'type' => \Elementor\Controls_Manager::SWITCHER,
                    'default' => 'no'
                ]
            );

            $this->end_controls_section();

        }

        protected function render() {

            $settings = $this->get_settings_for_display();

            if($settings['columns'] == '4') {
                $columns_markup = 'col-lg-3';
            } else if($settings['columns'] == '3') {
                $columns_markup = 'col-lg-4';
            } else if($settings['columns'] == '2') {
                $columns_markup = 'col-lg-6';
            } else {
                $columns_markup = 'col';
            }

            if(!empty($settings['cat_ids'])) {
                $html = '<div class="row">';
                foreach($settings['cat_ids'] as $cat) {
                    $thumb_id = get_woocommerce_term_meta( $cat, 'thumbnail_id', true );
                    $term_img = wp_get_attachment_image_url(  $thumb_id, 'medium' );
                    $info = get_term($cat, 'product_cat');
                    $html .= '<div class="'.$columns_markup.' single-category-item">';

                        if(!empty($thumb_id)) {
                            if($settings['bg'] == 'yes') {
                                $html .= '<div class="cat-img cat-img-bg" style="background-image:url('.$term_img.')"></div>';
                            } else {
                                $html .='
                                <div class="row cat-img">
                                    <div class="col text-center">
                                        <img src="'.$term_img.'" alt=""/>
                                    </div>
                                </div>';
                            }
                            
                        } else {
                            $html .= '<div class="cat-no-thumb"><p>No thumbnail</p></div>';
                        }
                        

                        $html .='

                        <h3>'.$info->name.'</h3>
                        '.$info->description.'
                    </div>';
                }
                $html .= '</div>';
            } else {
                $html = '<div class="alert alert-warning"><p>Please select categories.</p></div>';
            }

            echo $html;

        }

    }

}