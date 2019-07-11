<?php
/**
 * Elementor avocado widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */
class Avocado_content_block_Widget extends \Elementor\Widget_Base {

    
    public function get_name() {
        return 'avocado-content-block';
    }

    public function get_title() {
        return __( 'Avocado-content-block', 'plugin-name' );
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
            'title', [
                'label' => __( 'Title', 'plugin-domain' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default'=>'Girl Lookbook 2015',

            ]
           
        );

        $this->add_control(
            'content', [
                'label' => __( 'Content', 'plugin-domain' ),
                'type' => \Elementor\Controls_Manager::WYSIWYG,
                'default' => __( 'Block Content' , 'plugin-domain' ),
                'show_label' => true,
            ]
        );

        $this->add_control(
           'icon',
               [
                'label' => __( 'Select icon', 'plugin-domain' ),
                'type' => \Elementor\Controls_Manager::ICON,
                'default' => 'fa fa-angle-double-right',
            ]
        );
        $this->add_control(
           'url',
              [
                'label' => __( 'Url', 'elementor' ),
                'type' => \Elementor\Controls_Manager::URL,
              ]
        );

        $this->add_control(
            'content_img',
            [
                'label' => __( 'Content Image', 'plugin-domain' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
            ]
        );


          $this->add_control(
            'theme',
            [
              'label' => __( 'Box Theme', 'plugin-domain' ),
              'type' => \Elementor\Controls_Manager::SELECT,
              'default' => '1',
              'options' => [
                '1'  => __( 'Theme 1', 'plugin-domain' ),
                '2' => __( 'Theme 2', 'plugin-domain' ),
              ],
            ]
          );
       
        
         $this->end_controls_section();
 }

    protected function render() {

        $settings = $this->get_settings_for_display();

          if ($settings['link']['is_external']==true) {
            $target ='_blank';
          }else{
            $target='_self';

          }

        echo '<div class="content-box content-box-theme-'.$settings['theme'].'">
                <div class="content-box-bg" style="background-image:url('.wp_get_attachment_image_url($settings['content_img']['id'],'large').')"></div>
                <div class="content-box-content">
                  '.wpautop($settings['content']).'
                  <h5>'.$settings['title'].'</h5>
                  <a href="'.$settings['link']['url'].'" target="'.$target.'"><i class="'.$settings['icon'].'"></i></a>
                </div>
             </div>';

    }
}