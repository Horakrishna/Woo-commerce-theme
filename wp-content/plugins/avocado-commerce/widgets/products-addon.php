<?php
/**
 * Elementor avocado widget.
 *
 * Elementor widget.
 *
 * @since 1.0.0
 */


if (class_exists('WooCommerce')) {

    function avocado_product_cat_list(){

    $term_id ='product_cat';
    $categories= get_terms($term_id);

    $cat_array['all'] ="All Categories";
    if (!empty($categories)) {
          foreach ($categories as $category) {
           $cat_info =get_term($category, $term_id);
           $cat_array[$cat_info->slug] = $cat_info->name;
          }
    }
    return $cat_array;
  }


  function Avocado_product_list(){
    $args = wp_parse_args(array(
        'post_type'  => 'product',
        'numberposts'=>-1,
        'orderby'    =>'title',
        'order'      =>'ASC',
    ));

    $query_query =get_posts($args);
    $dropdown_array=array();
    if ($query_query) {
      foreach ($query_query as $query) {
       
       $dropdown_array[$query->ID]= $query->post_title;
      }
    }
    return $dropdown_array;
  }
}


class Avocado_products_Widget extends \Elementor\Widget_Base {

    
    public function get_name() {
        return 'avocado-product';
    }

    public function get_title() {
        return __( 'Avocado-Product', 'plugin-name' );
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
            'limit', [
                'label' => __( 'Count', 'plugin-domain' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' =>'4',
            ]
        );

        $this->add_control(
           'columns',
               [
                'label' => __( 'Columns', 'plugin-domain' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '4',
                'options'=>[
                  '1' => __('1 Column','plugin-domain'),
                  '2' => __('2 Columns','plugin-domain'),
                  '3' => __('3 Columns','plugin-domain'),
                  '4' => __('4 Columns','plugin-domain'),
                ]
            ]
        );

       
        $this->add_control(
                'category',
                [
                    'label' => __( 'Select Category', 'plugin-domain' ),
                    'type' => \Elementor\Controls_Manager::SELECT2,
                    'multiple' => true,
                    'options' =>avocado_product_cat_list(),
                    'default' =>['all'],
               ]
          );
        $this->add_control(
              'carousel',
                      [
                        'label' => __( 'Enable Carousel?', 'plugin-domain' ),
                        'type' => \Elementor\Controls_Manager::SWITCHER,
                        'label_on' => __( 'Yes', 'your-plugin' ),
                        'label_off' => __( 'No', 'your-plugin' ),
                        'return_value' => 'yes',
                        'default' => 'no',
                      ]
                );
 

         $this->end_controls_section();

        
 }

    protected function render() {

        $settings = $this->get_settings_for_display();

        if (empty($settings['category']) OR $settings['category'] =='all')  {
          
          $cats = '';
        }else{
            $cats = implode(',', $settings['category']);
        }

          if ($settings['carousel'] == 'yes') {

            
              $dynamic_id = rand(888788,885785578);

               
           echo '<script>
                  jQuery(window).load(function(){

                    jQuery("#product-carousel-'.$dynamic_id.' .products").slick({
                          slidesToShow: '.$settings['columns'].',
                          arrows   :'.$arrows.',
                          prevArrow:"<i class=\'fa fa-angle-left\'></i>",
                          nextArrow:"<i class=\'fa fa-angle-right\'></i>",
                          dots     :'.$dots.',
                          fade     :'.$fade.',
                          autoplay :'.$autoplay.',
                          loop     : '.$loop.',
                      });
                    });
                </script><div id="product-carousel-'.$dynamic_id.'">';
           }
        echo do_shortcode('[products category="'.$cats.'" limit="'.$settings['limit'].'" columns="'.$settings['columns'].'"]');

        if ($settings['carousel'] == 'yes') { echo '</div>'; }

  }         

}

 /*End Product Addons */

 /*Selling Product Addons Start*/         
class Avocado_selling_products_Widget extends \Elementor\Widget_Base {

    
    public function get_name() {
        return 'avocado-selling-product';
    }

    public function get_title() {
        return __( 'Avocado-Selling-Product', 'plugin-name' );
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
            'from',

            [
                'label' => __( 'Product From', 'plugin-name' ),
                'tab' => \Elementor\Controls_Manager::SELECT,
                'options'=>[
                    'select'  =>__('Select Products','plugin-domain'),
                    'category'=>__('Select Categories','plugin-domain')
                ],
                'default' =>'select',
            ]
        );

        $this->add_control(
                'p_ids',
                [
                    'label' => __( 'And/or Select Products', 'plugin-domain' ),
                    'type' => \Elementor\Controls_Manager::SELECT2,
                    'multiple' => true,
                    'options' =>Avocado_product_list(),
                    'condition' =>[
                        'from' =>'select',
                    ],
               ]
          );

        $this->add_control(
                'cat_ids',
                [
                    'label' => __( 'And/or Select Product Categories', 'plugin-domain' ),
                    'type' => \Elementor\Controls_Manager::SELECT2,
                    'multiple' => true,
                    'options' =>avocado_product_cat_list(),
                    'condition' =>[
                        'from' =>'category',
                    ],
               ]
          );

        $this->add_control(
                'nav',
                [
                    'label' => __( 'Enable Navigation ?', 'plugin-domain' ),
                    'type' => \Elementor\Controls_Manager::SWITCHER,
                    'default' =>'yes',
               ]
          );
        $this->add_control(
                'dots',
                [
                    'label' => __( 'Enable Dots ?', 'plugin-domain' ),
                    'type' => \Elementor\Controls_Manager::SWITCHER,
                    'default' =>'yes',
               ]
          );
        $this->add_control(
                'autoplay',
                [
                    'label' => __( 'Enable Autoplay ?', 'plugin-domain' ),
                    'type' => \Elementor\Controls_Manager::SWITCHER,
                    'default' =>'5000',
               ]
          );
         $this->end_controls_section();

        
 }

    protected function render() {

        $settings = $this->get_settings_for_display();
       
        if($settings['from'] =='category'){
            $q = new WP_Query(array(
                'posts_per_page' =>10,
                'post_type'      =>'product',
                'tax_query'      => array(
                        array(
                            'taxonomy' => 'product_cat',
                            'field'    => 'term_id',
                            'terms'    => $settings['cat_ids'],
                        )
                    ),
            ));
        }else{
            $q = new WP_Query(array(
                'posts_per_page' =>10,
                'post_type'      =>'product',
                'post__in'       =>$settings['p_ids'],
            ));
        }
        
        $rand   =rand(88788878,889777887);

        $html ='<div class="product-carousel" id="product-carousel-'.$rand.'">';
        while($q->have_posts()): $q->the_post(); 

          $html .='<div class="single-c-product">
                
                <h2>'.get_the_title().'</h2>

                </div>';
          
        endwhile;
       wp_reset_query();

       $html .='</div>';
        if($settings['from']=='category' && empty($settings['cat_ids'])){
            $html ='<div class="alert alert-warning"><p>Please Select Your Product Category</p></div>';
        }
       echo $html;

  }         

}

/*Selling Product Addons End*/         

