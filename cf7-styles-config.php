<?php
    if ( ! class_exists( 'Redux_Framework_CF7_config' ) ) {

        class Redux_Framework_CF7_config {

            public $args = array();
            public $sections = array();
            public $theme;
            public $ReduxFramework;

            public function __construct() {

                if ( ! class_exists( 'ReduxFramework' ) ) {
                    return;
                }

                // This is needed. Bah WordPress bugs.  ;)
                if ( true == Redux_Helpers::isTheme( __FILE__ ) ) {
                    $this->initSettings();
                } else {
                    add_action( 'plugins_loaded', array( $this, 'initSettings' ), 10 );
                }

            }

            public function initSettings() {

                $this->setArguments();
                $this->setSections();

                if ( ! isset( $this->args['opt_name'] ) ) { // No errors please
                    return;
                }

                $this->ReduxFramework = new ReduxFramework( $this->sections, $this->args );
            }



            // Remove the demo link and the notice of integrated demo from the redux-framework plugin
            function remove_demo() {

                // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
                if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
                    remove_filter( 'plugin_row_meta', array(
                        ReduxFrameworkPlugin::instance(),
                        'plugin_metalinks'
                    ), null, 2 );

                    // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
                    remove_action( 'admin_notices', array( ReduxFrameworkPlugin::instance(), 'admin_notices' ) );
                }
            }

            public function setSections() {

                ob_start();

                $ct          = wp_get_theme();
                $this->theme = $ct;
                $item_name   = $this->theme->get( 'Name' );
                $tags        = $this->theme->Tags;
                $screenshot  = $this->theme->get_screenshot();
                $class       = $screenshot ? 'has-screenshot' : '';

                $customize_title = sprintf( __( 'Customize &#8220;%s&#8221;', 'redux-framework-demo' ), $this->theme->display( 'Name' ) );

                ?>
                <div id="current-theme" class="<?php echo esc_attr( $class ); ?>">
                    <?php if ( $screenshot ) : ?>
                        <?php if ( current_user_can( 'edit_theme_options' ) ) : ?>
                            <a href="<?php echo wp_customize_url(); ?>" class="load-customize hide-if-no-customize"
                               title="<?php echo esc_attr( $customize_title ); ?>">
                                <img src="<?php echo esc_url( $screenshot ); ?>"
                                     alt="<?php esc_attr_e( 'Current theme preview', 'redux-framework-demo' ); ?>"/>
                            </a>
                        <?php endif; ?>
                        <img class="hide-if-customize" src="<?php echo esc_url( $screenshot ); ?>"
                             alt="<?php esc_attr_e( 'Current theme preview', 'redux-framework-demo' ); ?>"/>
                    <?php endif; ?>

                    <h4><?php echo $this->theme->display( 'Name' ); ?></h4>

                    <div>
                        <ul class="theme-info">
                            <li><?php printf( __( 'By %s', 'redux-framework-demo' ), $this->theme->display( 'Author' ) ); ?></li>
                            <li><?php printf( __( 'Version %s', 'redux-framework-demo' ), $this->theme->display( 'Version' ) ); ?></li>
                            <li><?php echo '<strong>' . __( 'Tags', 'redux-framework-demo' ) . ':</strong> '; ?><?php printf( $this->theme->display( 'Tags' ) ); ?></li>
                        </ul>
                        <p class="theme-description"><?php echo $this->theme->display( 'Description' ); ?></p>
                        <?php
                            if ( $this->theme->parent() ) {
                                printf( ' <p class="howto">' . __( 'This <a href="%1$s">child theme</a> requires its parent theme, %2$s.', 'redux-framework-demo' ) . '</p>', __( 'http://codex.wordpress.org/Child_Themes', 'redux-framework-demo' ), $this->theme->parent()->display( 'Name' ) );
                            }
                        ?>

                    </div>
                </div>

                <?php
                $item_info = ob_get_contents();

                ob_end_clean();

                // ACTUAL DECLARATION OF SECTIONS
                // General CF7 Styles
                $this->sections[] = array(
                    'title'  => __( 'General Styles', 'redux-framework-demo' ),
                    'desc'   => __( 'Also known as the traditional input field, this section allows for the quick styling of text fields for Contact Form 7', 'redux-framework-demo' ),
                    'icon'   => 'el-icon-wrench',
                    'fields' => array(

                        // Background Section
                        array(
                            'id'        => 'cf7_general_backgrounds',
                            'type'      => 'section',
                            'title'     => __('General Backgrounds', 'redux-framework-demo'),
                            'subtitle'  => __('This section adds general background options for Contact Form 7.', 'redux-framework-demo'),
                            'indent'    => true,
                        ),

                            array(
                                'id'       => 'cf7_general_form_background',
                                'type'     => 'background',
                                'output'   => array('#cf7-styles .wpcf7 .wpcf7-form', '.wpcf7 .wpcf7-form'),
                                'title'    => __( 'Form Background', 'redux-framework-demo' ),
                                'subtitle' => __( 'Set the background of the entire form area.', 'redux-framework-demo' ),
                                'preview'  => false,
                            ),

                            array(
                                'id'       => 'cf7_general_section_background',
                                'type'     => 'background',
                                'output'   => array('#cf7-styles .wpcf7 .wpcf7-form p', '.wpcf7 .wpcf7-form p'),
                                'title'    => __( 'Section Background', 'redux-framework-demo' ),
                                'subtitle' => __( 'Set the background for all the different field section. Please make sure all sections are wrapped with the paragraph tag as in the demo form that comes with Contact Form 7.', 'redux-framework-demo' ),
                                'preview'  => false,
                            ),

                            array(
                                'id'       => 'cf7_general_section_hover_background',
                                'type'     => 'background',
                                'output'   => array('#cf7-styles .wpcf7 .wpcf7-form p:hover', '.wpcf7 .wpcf7-form p:hover'),
                                'title'    => __( 'Section Background: Hover', 'redux-framework-demo' ),
                                'subtitle' => __( 'Set the background for all the different field section when hovering over them. Please make sure all sections are wrapped with the paragraph tag as in the demo form that comes with Contact Form 7.', 'redux-framework-demo' ),
                                'preview'  => false,
                            ),

                            array(
                                'id'       => 'cf7_general_button_background',
                                'type'     => 'background',
                                'output'   => array('#cf7-styles .wpcf7 .wpcf7-form .wpcf7-submit', '.wpcf7 .wpcf7-form .wpcf7-submit'),
                                'title'    => __( 'Submit Button Background', 'redux-framework-demo' ),
                                'subtitle' => __( 'Set the background for the form submit button.', 'redux-framework-demo' ),
                                'preview'  => false,
                            ),

                            array(
                                'id'       => 'cf7_general_buttonhover_background',
                                'type'     => 'background',
                                'output'   => array('#cf7-styles .wpcf7 .wpcf7-form .wpcf7-submit:hover', '.wpcf7 .wpcf7-form .wpcf7-submit:hover'),
                                'title'    => __( 'Submit Button Background Hover', 'redux-framework-demo' ),
                                'subtitle' => __( 'Set the background for the form submit button on hover.', 'redux-framework-demo' ),
                                'preview'  => false,
                            ),

                        // Borders Section
                        array(
                            'id'        => 'cf7_general_borders',
                            'type'      => 'section',
                            'title'     => __('Borders', 'redux-framework-demo'),
                            'subtitle'  => __('This section adds border styles for the input field section.', 'redux-framework-demo'),
                            'indent'    => true 
                        ),

                            array(
                                'id'       => 'cf7_general_form_border',
                                'type'     => 'border',
                                'output'   => array('#cf7-styles .wpcf7 .wpcf7-form', '.wpcf7 .wpcf7-form'),
                                'title'    => __( 'Form Border', 'redux-framework-demo' ),
                                'subtitle' => __( 'Set the border of the entire form.', 'redux-framework-demo' ),
                                'all'      => false,
                                'top'      => true,
                                'right'    => true,
                                'left'     => true,
                                'bottom'   => true,
                            ),

                            array(
                                'id'       => 'cf7_general_section_border',
                                'type'     => 'border',
                                'output'   => array('#cf7-styles .wpcf7 .wpcf7-form p', '.wpcf7 .wpcf7-form p'),
                                'title'    => __( 'Field Section Border', 'redux-framework-demo' ),
                                'subtitle' => __( 'Set the border around each field section. Please make sure all sections are wrapped with the paragraph tag as in the demo form that comes with Contact Form 7.', 'redux-framework-demo' ),
                                'all'      => false,
                                'top'      => true,
                                'right'    => true,
                                'left'     => true,
                                'bottom'   => true,
                            ),

                            array(
                                'id'       => 'cf7_general_button_border',
                                'type'     => 'border',
                                'output'   => array('#cf7-styles .wpcf7 .wpcf7-form .wpcf7-submit', '.wpcf7 .wpcf7-form .wpcf7-submit'),
                                'title'    => __( 'Submit Button Border', 'redux-framework-demo' ),
                                'subtitle' => __( 'Set the border for the form submit button.', 'redux-framework-demo' ),
                                'all'      => false,
                                'top'      => true,
                                'right'    => true,
                                'left'     => true,
                                'bottom'   => true,
                            ),

                        // Padding & Margin
                        array(
                            'id'        => 'cf7__general_spacing',
                            'type'      => 'section',
                            'title'     => __('Padding / Margin', 'redux-framework-demo'),
                            'subtitle'  => __('This section adds padding / margin options for the entire form.', 'redux-framework-demo'),
                            'indent'    => true 
                        ),

                            array(
                                'id'                => 'cf7_general_form_padding',
                                'type'              => 'spacing',
                                'output'            => array('#cf7-styles .wpcf7 .wpcf7-form', '.wpcf7 .wpcf7-form'), 
                                'mode'              => 'padding', 
                                'units'             => array('em', 'px', '%'),
                                'units_extended'    => false,
                                'display_units'     => true, 
                                'title'             => __('Form Padding', 'redux-framework-demo'),
                                'subtitle'          => __('Specifies the padding used for the entire form.', 'redux-framework-demo'),
                            ),

                            array(
                                'id'                => 'cf7_general_form_margin',
                                'type'              => 'spacing',
                                'output'            => array('#cf7-styles .wpcf7 .wpcf7-form', '.wpcf7 .wpcf7-form'), 
                                'mode'              => 'margin', 
                                'units'             => array('em', 'px', '%'),
                                'units_extended'    => false,
                                'display_units'     => true, 
                                'title'             => __('Form Margin', 'redux-framework-demo'),
                                'subtitle'          => __('Specifies the margin used for the entire form.', 'redux-framework-demo'),
                            ),

                            array(
                                'id'                => 'cf7_general_section_padding',
                                'type'              => 'spacing',
                                'output'            => array('#cf7-styles .wpcf7 .wpcf7-form p', '.wpcf7 .wpcf7-form p'), 
                                'mode'              => 'padding', 
                                'units'             => array('em', 'px', '%'),
                                'units_extended'    => false,
                                'display_units'     => true, 
                                'title'             => __('Section Padding', 'redux-framework-demo'),
                                'subtitle'          => __('Specifies the padding used for each form field section. Please make sure all sections are wrapped with the paragraph tag as in the demo form that comes with Contact Form 7.', 'redux-framework-demo'),
                            ),

                            array(
                                'id'                => 'cf7_general_section_margin',
                                'type'              => 'spacing',
                                'output'            => array('#cf7-styles .wpcf7 .wpcf7-form p', '.wpcf7 .wpcf7-form p'), 
                                'mode'              => 'margin', 
                                'units'             => array('em', 'px', '%'),
                                'units_extended'    => false,
                                'display_units'     => true, 
                                'title'             => __('Section Margin', 'redux-framework-demo'),
                                'subtitle'          => __('Specifies the margin used for each form field section. Please make sure all sections are wrapped with the paragraph tag as in the demo form that comes with Contact Form 7.', 'redux-framework-demo'),
                            ),

                             array(
                                'id'                => 'cf7_general_button_padding',
                                'type'              => 'spacing',
                                'output'            => array('#cf7-styles .wpcf7 .wpcf7-form .wpcf7-submit', '.wpcf7 .wpcf7-form .wpcf7-submit'), 
                                'mode'              => 'padding', 
                                'units'             => array('em', 'px', '%'),
                                'units_extended'    => false,
                                'display_units'     => true, 
                                'title'             => __('Submit Button Padding', 'redux-framework-demo'),
                                'subtitle'          => __('Specifies the padding used for the form submit button.', 'redux-framework-demo'),
                            ),

                            array(
                                'id'                => 'cf7_general_button_margin',
                                'type'              => 'spacing',
                                'output'            => array('#cf7-styles .wpcf7 .wpcf7-form .wpcf7-submit', '.wpcf7 .wpcf7-form .wpcf7-submit'), 
                                'mode'              => 'margin', 
                                'units'             => array('em', 'px', '%'),
                                'units_extended'    => false,
                                'display_units'     => true, 
                                'title'             => __('Submit Button Margin', 'redux-framework-demo'),
                                'subtitle'          => __('Specifies the margin used for the form submit button.', 'redux-framework-demo'),
                            ),

                        // Fonts
                        array(
                            'id'        => 'cf7_general_fonts',
                            'type'      => 'section',
                            'title'     => __('Fonts', 'redux-framework-demo'),
                            'subtitle'  => __('This section sets font rules for the entire form.', 'redux-framework-demo'),
                            'indent'    => true 
                        ),

                            array(
                                'id'                => 'cf7_general_form_font',
                                'type'              => 'typography',
                                'title'             => __('Form Fonts', 'redux-framework-demo'),
                                'google'            => true, 
                                'font-backup'       => true, 
                                'font-style'        => true,
                                'subsets'           => true,
                                'font-size'         => true,
                                'line-height'       => true,
                                'color'             => true,
                                'preview'           => true, 
                                'all_styles'        => true,
                                'text-transform'    => true,
                                'output'            => array('#cf7-styles .wpcf7 .wpcf7-form', '#cf7-styles .wpcf7 .wpcf7-form p', '.wpcf7 .wpcf7-form', '.wpcf7 .wpcf7-form p'),
                                'units'             => 'px',
                                'subtitle'          => __('Set the fonts for the entire form.', 'redux-framework-demo'),
                            ),

                            array(
                                'id'                => 'cf7_general_button_font',
                                'type'              => 'typography',
                                'title'             => __('Submit Button Font', 'redux-framework-demo'),
                                'google'            => true, 
                                'font-backup'       => true, 
                                'font-style'        => true,
                                'subsets'           => true,
                                'font-size'         => true,
                                'line-height'       => true,
                                'color'             => true,
                                'preview'           => true, 
                                'all_styles'        => true,
                                'text-transform'    => true,
                                'output'            => array('#cf7-styles .wpcf7-submit', '.wpcf7 .wpcf7-form .wpcf7-submit'),
                                'units'             => 'px',
                                'subtitle'          => __('Set the font to be used for the form submit button.', 'redux-framework-demo'),
                            ),

                        // Dimensions
                        array(
                            'id'        => 'cf7_general_dimensions',
                            'type'      => 'section',
                            'title'     => __('Dimensions', 'redux-framework-demo'),
                            'subtitle'  => __('This section sets dimension rules for the entire form.', 'redux-framework-demo'),
                            'indent'    => true 
                        ),

                            array(
                                'id'             => 'cf7_general_form_dimension',
                                'type'           => 'dimensions',
                                'units'          => array('em','px','%'),
                                'units_extended' => 'true', 
                                'output'         => array('#cf7-styles .wpcf7 .wpcf7-form', '.wpcf7 .wpcf7-form'), 
                                'title'          => __( 'Form Width', 'redux-framework-demo' ),
                                'subtitle'       => __( 'Allow your users to set the overall width of the form', 'redux-framework-demo' ),
                                'width'          => true,
                                'height'         => false,
                            ), 

                            array(
                                'id'             => 'cf7_general_button_dimension',
                                'type'           => 'dimensions',
                                'units'          => array('em','px','%'),
                                'units_extended' => 'true', 
                                'output'         => array('#cf7-styles .wpcf7-submit', '.wpcf7 .wpcf7-form .wpcf7-submit'), 
                                'title'          => __( 'Submit Button Width', 'redux-framework-demo' ),
                                'subtitle'       => __( 'Allow your users to set the width / height of the form submit button', 'redux-framework-demo' ),
                                'width'          => true,
                                'height'         => true,
                            ), 
                    ),
                );
                


                // Input Field Styles
                $this->sections[] = array( 
                    'title'  => __( 'Text Field', 'redux-framework-demo' ),
                    'desc'   => __( 'Also known as the traditional input fields, this section allows for the quick styling of text, email, URL and contact numbers fields for Contact Form 7.', 'redux-framework-demo' ),
                    'icon'   => 'el-icon-minus',
                    'fields' => array(

                        // Background Section
                        array(
                            'id' => 'cf7_input_section_backgrounds',
                            'type' => 'section',
                            'title' => __('Backgrounds', 'redux-framework-demo'),
                            'subtitle' => __('This section adds background styles for the input field section.', 'redux-framework-demo'),
                            'indent' => true 
                        ),

                            array(
                                'id'       => 'cf7_input_field_background',
                                'type'     => 'background',
                                'output'   => array('#cf7-styles .wpcf7 .wpcf7-form input.wpcf7-text', '.wpcf7 .wpcf7-form input.wpcf7-text'),
                                'title'    => __( 'Input Field Background', 'redux-framework-demo' ),
                                'subtitle' => __( 'Set the background of the text text element (input field)', 'redux-framework-demo' ),
                                'preview'  => false,
                            ),

                        // Borders Section
                        array(
                            'id'        => 'cf7_input_section_borders',
                            'type'      => 'section',
                            'title'     => __('Borders', 'redux-framework-demo'),
                            'subtitle'  => __('This section adds border styles for the input field section.', 'redux-framework-demo'),
                            'indent'    => true 
                        ),

                            array(
                                'id'       => 'cf7_input_field_border',
                                'type'     => 'border',
                                'output'   => array('#cf7-styles .wpcf7 .wpcf7-form input.wpcf7-text', '.wpcf7 .wpcf7-form input.wpcf7-text'),
                                'title'    => __( 'Input Field Border', 'redux-framework-demo' ),
                                'subtitle' => __( 'Set the border of each text text element (input field)', 'redux-framework-demo' ),
                                'all'      => false,
                                'top'      => true,
                                'right'    => true,
                                'left'     => true,
                                'bottom'   => true,
                            ),

                        // Padding & Margin
                        array(
                            'id'        => 'cf7_input_section_spacing',
                            'type'      => 'section',
                            'title'     => __('Padding / Margin', 'redux-framework-demo'),
                            'subtitle'  => __('This section adds padding and margin for the input field section.', 'redux-framework-demo'),
                            'indent'    => true,
                        ),

                            array(
                                'id'                => 'cf7_input_field_padding',
                                'type'              => 'spacing',
                                'output'            => array('#cf7-styles .wpcf7 .wpcf7-form input.wpcf7-text', '.wpcf7 .wpcf7-form input.wpcf7-text'), 
                                'mode'              => 'padding', 
                                'units'             => array('em', 'px', '%'),
                                'units_extended'    => false,
                                'display_units'     => true, 
                                'title'             => __('Input Field Padding', 'redux-framework-demo'),
                                'subtitle'          => __('Specifies the padding used for the text text (input) field.', 'redux-framework-demo'),
                            ),

                            array(
                                'id'                => 'cf7_input_field_margin',
                                'type'              => 'spacing',
                                'output'            => array('#cf7-styles .wpcf7 .wpcf7-form input.wpcf7-text', '.wpcf7 .wpcf7-form input.wpcf7-text'), 
                                'mode'              => 'margin', 
                                'units'             => array('em', 'px', '%'),
                                'units_extended'    => false,
                                'display_units'     => true, 
                                'title'             => __('Input Field Margin', 'redux-framework-demo'),
                                'subtitle'          => __('Specifies the margin used for the text text (input) field.', 'redux-framework-demo'),
                            ),

                        // Fonts
                        array(
                            'id'        => 'cf7_input_section_fonts',
                            'type'      => 'section',
                            'title'     => __('Fonts', 'redux-framework-demo'),
                            'subtitle'  => __('This section sets font rules for the text text (input) field.', 'redux-framework-demo'),
                            'indent'    => true 
                        ),

                            array(
                                'id'                => 'cf7_input_field_font',
                                'type'              => 'typography',
                                'title'             => __('Input Field', 'redux-framework-demo'),
                                'google'            => true, 
                                'font-backup'       => true, 
                                'font-style'        => true,
                                'subsets'           => true,
                                'font-size'         => true,
                                'line-height'       => true,
                                'color'             => true,
                                'preview'           => true, 
                                'all_styles'        => true,
                                'text-transform'    => true,
                                'output'            => array('#cf7-styles .wpcf7 .wpcf7-form input.wpcf7-text', '.wpcf7 .wpcf7-form input.wpcf7-text'),
                                'units'             => 'px',
                                'subtitle'          => __('Applies to all input fields generated by Contact Form 7.', 'redux-framework-demo'),
                            ),

                        // Dimensions
                        array(
                            'id'        => 'cf7_input_section_dimensions',
                            'type'      => 'section',
                            'title'     => __('Dimensions', 'redux-framework-demo'),
                            'subtitle'  => __('This section adds dimension options for the text text (input) field.', 'redux-framework-demo'),
                            'indent'    => true 
                        ),

                            array(
                                'id'             => 'cf7_input_field_dimension',
                                'type'           => 'dimensions',
                                'units'          => array('em','px','%'),
                                'units_extended' => 'true', 
                                'output'         => array('#cf7-styles .wpcf7 .wpcf7-form input.wpcf7-text', '.wpcf7 .wpcf7-form input.wpcf7-text'), 
                                'title'          => __( 'Width / Height', 'redux-framework-demo' ),
                                'subtitle'       => __( 'Allow your users to set the width / height of Contact Form 7 input fields.', 'redux-framework-demo' ),
                            ), 
                    ),
                );



                 // Textarea Field Styles
                $this->sections[] = array( 
                    'title'  => __( 'Textarea', 'redux-framework-demo' ),
                    'desc'   => __( 'This section allows for the quick styling of textarea fields for Contact Form 7', 'redux-framework-demo' ),
                    'icon'   => 'el-icon-stop',
                    'fields' => array(

                         // Background Section
                        array(
                            'id' => 'cf7_textarea_section_backgrounds',
                            'type' => 'section',
                            'title' => __('Backgrounds', 'redux-framework-demo'),
                            'subtitle' => __('This section adds background styles for the textarea field section.', 'redux-framework-demo'),
                            'indent' => true 
                        ),

                            array(
                                'id'       => 'cf7_textarea_field_background',
                                'type'     => 'background',
                                'output'   => array('#cf7-styles .wpcf7 .wpcf7-form textarea.wpcf7-textarea', '.wpcf7 .wpcf7-form textarea.wpcf7-textarea'),
                                'title'    => __( 'Textarea Field Background', 'redux-framework-demo' ),
                                'subtitle' => __( 'Set the background of the textarea field.', 'redux-framework-demo' ),
                                'preview'  => false,
                            ),

                        // Borders Section
                        array(
                            'id'        => 'cf7_textarea_section_borders',
                            'type'      => 'section',
                            'title'     => __('Borders', 'redux-framework-demo'),
                            'subtitle'  => __('This section adds border styles for the textarea section.', 'redux-framework-demo'),
                            'indent'    => true 
                        ),

                            array(
                                'id'       => 'cf7_textarea_field_border',
                                'type'     => 'border',
                                'output'   => array('#cf7-styles .wpcf7 .wpcf7-form textarea.wpcf7-textarea', '.wpcf7 .wpcf7-form textarea.wpcf7-textarea'),
                                'title'    => __( 'Textarea Field Border', 'redux-framework-demo' ),
                                'subtitle' => __( 'Set the border of each textarea field.', 'redux-framework-demo' ),
                                'all'      => false,
                                'top'      => true,
                                'right'    => true,
                                'left'     => true,
                                'bottom'   => true,
                            ),

                        // Padding & Margin
                        array(
                            'id'        => 'cf7_textarea_section_spacing',
                            'type'      => 'section',
                            'title'     => __('Padding / Margin', 'redux-framework-demo'),
                            'subtitle'  => __('This section adds padding and margin for the textarea section.', 'redux-framework-demo'),
                            'indent'    => true,
                        ),

                            array(
                                'id'                => 'cf7_textarea_field_padding',
                                'type'              => 'spacing',
                                'output'            => array('#cf7-styles .wpcf7 .wpcf7-form textarea.wpcf7-textarea', '.wpcf7 .wpcf7-form textarea.wpcf7-textarea'), 
                                'mode'              => 'padding', 
                                'units'             => array('em', 'px', '%'),
                                'units_extended'    => false,
                                'display_units'     => true, 
                                'title'             => __('Textarea Field Padding', 'redux-framework-demo'),
                                'subtitle'          => __('Specifies the padding used for the textarea field.', 'redux-framework-demo'),
                            ),

                            array(
                                'id'                => 'cf7_textarea_field_margin',
                                'type'              => 'spacing',
                                'output'            => array('#cf7-styles .wpcf7 .wpcf7-form textarea.wpcf7-textarea', '.wpcf7 .wpcf7-form textarea.wpcf7-textarea'), 
                                'mode'              => 'margin', 
                                'units'             => array('em', 'px', '%'),
                                'units_extended'    => false,
                                'display_units'     => true, 
                                'title'             => __('Textarea Field Margin', 'redux-framework-demo'),
                                'subtitle'          => __('Specifies the margin used for the textarea field.', 'redux-framework-demo'),
                            ),

                        // Fonts
                        array(
                            'id'        => 'cf7_textarea_section_fonts',
                            'type'      => 'section',
                            'title'     => __('Fonts', 'redux-framework-demo'),
                            'subtitle'  => __('This section sets font rules for the textarea field.', 'redux-framework-demo'),
                            'indent'    => true 
                        ),

                            array(
                                'id'                => 'cf7_textarea_field_font',
                                'type'              => 'typography',
                                'title'             => __('Textarea Field', 'redux-framework-demo'),
                                'google'            => true, 
                                'font-backup'       => true, 
                                'font-style'        => true,
                                'subsets'           => true,
                                'font-size'         => true,
                                'line-height'       => true,
                                'color'             => true,
                                'preview'           => true, 
                                'all_styles'        => true,
                                'text-transform'    => true,
                                'output'            => array('#cf7-styles .wpcf7 .wpcf7-form textarea.wpcf7-textarea', '.wpcf7 .wpcf7-form textarea.wpcf7-textarea'),
                                'units'             => 'px',
                                'subtitle'          => __('Applies to all textarea generated by Contact Form 7.', 'redux-framework-demo'),
                            ),

                        // Dimensions
                        array(
                            'id'        => 'cf7_textarea_section_dimensions',
                            'type'      => 'section',
                            'title'     => __('Dimensions', 'redux-framework-demo'),
                            'subtitle'  => __('This section adds dimension options for the textarea field.', 'redux-framework-demo'),
                            'indent'    => true 
                        ),

                            array(
                                'id'             => 'cf7_textarea_field_dimension',
                                'type'           => 'dimensions',
                                'units'          => array('em','px','%'),
                                'units_extended' => 'true', 
                                'output'         => array('#cf7-styles .wpcf7 .wpcf7-form textarea.wpcf7-textarea', '.wpcf7 .wpcf7-form textarea.wpcf7-textarea'), 
                                'title'          => __( 'Width / Height', 'redux-framework-demo' ),
                                'subtitle'       => __( 'Allow your users to set the width / height of Contact Form 7 textarea fields.', 'redux-framework-demo' ),
                            ), 
                    ),
                );

                
                // Spinbox Number Field Styles
                $this->sections[] = array( 
                    'title'  => __( 'Numbers - Spinbox', 'redux-framework-demo' ),
                    'icon'   => 'el-icon-braille',
                    'fields' => array(

                        // Pro Warning
                        array(
                            'id'     => 'opt-notice-critical',
                            'type'   => 'info',
                            'notice' => true,
                            'style'  => 'critical',
                            'title'  => __( 'Pro Feature', 'redux-framework-demo' ), 
                            'desc'   => __( 'This feature is reserved for the Pro version of Contact Form 7 Designer. Values saved here will not take effect on the front end. <br />Please visit <a href="http://tinygiantstudios.co.uk/product/contact-form-7-designer-pro/" target="_blank">Tiny Giant Studios</a> for more information.', 'redux-framework-demo' )
                        ),

                        // Background Section
                        array(
                            'id' => 'cf7_spinbox_section_backgrounds',
                            'type' => 'section',
                            'title' => __('Backgrounds', 'redux-framework-demo'),
                            'subtitle' => __('This section adds background styles for the spinbox number field sections.', 'redux-framework-demo'),
                            'indent' => true 
                        ),

                            array(
                                'id'       => 'cf7_spinbox_field_background',
                                'type'     => 'background',
                                'title'    => __( 'Spinbox Number Field Background', 'redux-framework-demo' ),
                                'subtitle' => __( 'Set the background of the spinbox number element.', 'redux-framework-demo' ),
                                'preview'  => false,
                            ),

                        // Borders Section
                        array(
                            'id'        => 'cf7_spinbox_section_borders',
                            'type'      => 'section',
                            'title'     => __('Borders', 'redux-framework-demo'),
                            'subtitle'  => __('This section adds border styles for the spinbox number section.', 'redux-framework-demo'),
                            'indent'    => true 
                        ),

                            array(
                                'id'       => 'cf7_spinbox_field_border',
                                'type'     => 'border',
                                'title'    => __( 'Spinbox Number Field Border', 'redux-framework-demo' ),
                                'subtitle' => __( 'Set the border of each spinbox number element.', 'redux-framework-demo' ),
                                'all'      => false,
                                'top'      => true,
                                'right'    => true,
                                'left'     => true,
                                'bottom'   => true,
                            ),

                        // Padding & Margin
                        array(
                            'id'        => 'cf7_spinbox_section_spacing',
                            'type'      => 'section',
                            'title'     => __('Padding / Margin', 'redux-framework-demo'),
                            'subtitle'  => __('This section adds padding and margin for the spinbox number element.', 'redux-framework-demo'),
                            'indent'    => true,
                        ),

                            array(
                                'id'                => 'cf7_spinbox_field_padding',
                                'type'              => 'spacing',
                                'mode'              => 'padding', 
                                'units'             => array('em', 'px', '%'),
                                'units_extended'    => false,
                                'display_units'     => true, 
                                'title'             => __('Spinbox Number Field Padding', 'redux-framework-demo'),
                                'subtitle'          => __('Specifies the padding used for the spinbox number element.', 'redux-framework-demo'),
                            ),

                            array(
                                'id'                => 'cf7_spinbox_field_margin',
                                'type'              => 'spacing',
                                'mode'              => 'margin', 
                                'units'             => array('em', 'px', '%'),
                                'units_extended'    => false,
                                'display_units'     => true, 
                                'title'             => __('Spinbox Number Field Margin', 'redux-framework-demo'),
                                'subtitle'          => __('Specifies the margin used for the spinbox number element.', 'redux-framework-demo'),
                            ),

                        // Fonts
                        array(
                            'id'        => 'cf7_spinbox_section_fonts',
                            'type'      => 'section',
                            'title'     => __('Fonts', 'redux-framework-demo'),
                            'subtitle'  => __('This section sets font rules for the spinbox number element.', 'redux-framework-demo'),
                            'indent'    => true 
                        ),

                            array(
                                'id'                => 'cf7_spinbox_field_font',
                                'type'              => 'typography',
                                'title'             => __('Spinbox Input Field', 'redux-framework-demo'),
                                'google'            => true, 
                                'font-backup'       => true, 
                                'font-style'        => true,
                                'subsets'           => true,
                                'font-size'         => true,
                                'line-height'       => true,
                                'color'             => true,
                                'preview'           => true, 
                                'all_styles'        => true,
                                'text-transform'    => true,
                                'units'             => 'px',
                                'subtitle'          => __('Applies to all spinbox number elements generated by Contact Form 7.', 'redux-framework-demo'),
                            ),

                        // Dimensions
                        array(
                            'id'        => 'cf7_spinbox_section_dimensions',
                            'type'      => 'section',
                            'title'     => __('Dimensions', 'redux-framework-demo'),
                            'subtitle'  => __('This section adds dimension options for thespinbox number element.', 'redux-framework-demo'),
                            'indent'    => true 
                        ),

                            array(
                                'id'             => 'cf7_spinbox_field_dimension',
                                'type'           => 'dimensions',
                                'units'          => array('em','px','%'),
                                'units_extended' => 'true', 
                                'title'          => __( 'Width / Height', 'redux-framework-demo' ),
                                'subtitle'       => __( 'Allow your users to set the width / height of Contact Form 7 spinbox number element.', 'redux-framework-demo' ),
                            ), 
                    ),
                );



                // Slider Number Field Styles - Currently canned while we wait for CSS specs to catch up 
                /*
                $this->sections[] = array( 
                    'title'  => __( 'Numbers: Slider', 'redux-framework-demo' ),
                    'icon'   => 'el-icon-minus',
                    'fields' => array(

                        // Pro Warning
                        array(
                            'id'     => 'opt-notice-critical',
                            'type'   => 'info',
                            'notice' => true,
                            'style'  => 'critical',
                            'title'  => __( 'Pro Feature', 'redux-framework-demo' ),
                            'desc'   => __( 'This feature is reserved for the Pro version of Contact Form 7 Designer. Values saved here will not take effect on the front end. <br />Please visit <a href="http://tinygiantstudios.co.uk/product/contact-form-7-designer-pro/" target="_blank">Tiny Giant Studios</a> for more information.', 'redux-framework-demo' )
                        ),

                        // Background Section
                        array(
                            'id' => 'cf7_slider_section_backgrounds',
                            'type' => 'section',
                            'title' => __('Backgrounds', 'redux-framework-demo'),
                            'subtitle' => __('This section adds background styles for the slider number field sections.', 'redux-framework-demo'),
                            'indent' => true 
                        ),

                            array(
                                'id'       => 'cf7_slider_track_background',
                                'type'     => 'background',
                                'title'    => __( 'Slider Track Background', 'redux-framework-demo' ),
                                'subtitle' => __( 'Set the background of the slider number track.', 'redux-framework-demo' ),
                                'preview'  => false,
                            ),

                            array(
                                'id'       => 'cf7_slider_thumb_background',
                                'type'     => 'background',
                                'title'    => __( 'Slider Thumb Background', 'redux-framework-demo' ),
                                'subtitle' => __( 'Set the background of the slider number thumb.', 'redux-framework-demo' ),
                                'preview'  => false,
                            ),

                        // Borders Section
                        array(
                            'id'        => 'cf7_slider_section_borders',
                            'type'      => 'section',
                            'title'     => __('Borders', 'redux-framework-demo'),
                            'subtitle'  => __('This section adds border styles for the slider number section.', 'redux-framework-demo'),
                            'indent'    => true 
                        ),

                            array(
                                'id'       => 'cf7_slider_track_border',
                                'type'     => 'border',
                                'title'    => __( 'Slider Track Border', 'redux-framework-demo' ),
                                'subtitle' => __( 'Set the border for each slider track.', 'redux-framework-demo' ),
                                'all'      => true,
                            ),

                            array(
                                'id'       => 'cf7_slider_thumb_border',
                                'type'     => 'border',
                                'title'    => __( 'Slider Thumb Border', 'redux-framework-demo' ),
                                'subtitle' => __( 'Set the border for each slider thumb.', 'redux-framework-demo' ),
                                'all'      => true,
                            ),

                        // Padding & Margin
                        array(
                            'id'        => 'cf7_slider_section_spacing',
                            'type'      => 'section',
                            'title'     => __('Padding / Margin', 'redux-framework-demo'),
                            'subtitle'  => __('This section adds padding and margin for the slider number element.', 'redux-framework-demo'),
                            'indent'    => true,
                        ),

                            array(
                                'id'                => 'cf7_slider_field_padding',
                                'type'              => 'spacing',
                                'mode'              => 'padding', 
                                'units'             => array('em', 'px', '%'),
                                'units_extended'    => false,
                                'display_units'     => true, 
                                'title'             => __('Input Field Padding', 'redux-framework-demo'),
                                'subtitle'          => __('Specifies the padding used for the slider number element.', 'redux-framework-demo'),
                            ),

                            array(
                                'id'                => 'cf7_slider_field_margin',
                                'type'              => 'spacing',
                                'mode'              => 'margin', 
                                'units'             => array('em', 'px', '%'),
                                'units_extended'    => false,
                                'display_units'     => true, 
                                'title'             => __('Input Field Margin', 'redux-framework-demo'),
                                'subtitle'          => __('Specifies the margin used for the slider number element.', 'redux-framework-demo'),
                            ),

                        // Fonts
                        array(
                            'id'        => 'cf7_slider_section_fonts',
                            'type'      => 'section',
                            'title'     => __('Fonts', 'redux-framework-demo'),
                            'subtitle'  => __('This section sets font rules for the slider number element.', 'redux-framework-demo'),
                            'indent'    => true 
                        ),

                            array(
                                'id'                => 'cf7_slider_field_font',
                                'type'              => 'typography',
                                'title'             => __('Slider Label', 'redux-framework-demo'),
                                'google'            => true, 
                                'font-backup'       => true, 
                                'font-style'        => true,
                                'subsets'           => true,
                                'font-size'         => true,
                                'line-height'       => true,
                                'color'             => true,
                                'preview'           => true, 
                                'all_styles'        => true,
                                'text-transform'    => true,
                                'units'             => 'px',
                                'subtitle'          => __('Applies to all slider number elements generated by Contact Form 7.', 'redux-framework-demo'),
                            ),

                        // Dimensions
                        array(
                            'id'        => 'cf7_slider_section_dimensions',
                            'type'      => 'section',
                            'title'     => __('Dimensions', 'redux-framework-demo'),
                            'subtitle'  => __('This section adds dimension options for the slider number element.', 'redux-framework-demo'),
                            'indent'    => true 
                        ),

                            array(
                                'id'             => 'cf7_slider_track_dimension',
                                'type'           => 'dimensions',
                                'units'          => array('em','px','%'),
                                'units_extended' => 'true', 
                                'title'          => __( 'Width / Height', 'redux-framework-demo' ),
                                'subtitle'       => __( 'Allow your users to set the width / height of Contact Form 7 number slider track.', 'redux-framework-demo' ),
                            ), 

                            array(
                                'id'             => 'cf7_slider_thumb_dimension',
                                'type'           => 'dimensions',
                                'units'          => array('em','px','%'),
                                'units_extended' => 'true', 
                                'title'          => __( 'Width / Height', 'redux-framework-demo' ),
                                'subtitle'       => __( 'Allow your users to set the width / height of Contact Form 7 number slider thumb.', 'redux-framework-demo' ),
                            ), 
                    ),
                );
                */
                


                // Date Styles
                $this->sections[] = array( 
                    'title'  => __( 'Date', 'redux-framework-demo' ),
                    'icon'   => 'el-icon-calendar',
                    'fields' => array(

                        // Pro Warning
                        array(
                            'id'     => 'opt-notice-critical',
                            'type'   => 'info',
                            'notice' => true,
                            'style'  => 'critical',
                            'title'  => __( 'Pro Feature', 'redux-framework-demo' ),
                            'desc'   => __( 'This feature is reserved for the Pro version of Contact Form 7 Designer. Values saved here will not take effect on the front end. <br />Please visit <a href="http://tinygiantstudios.co.uk/product/contact-form-7-designer-pro/" target="_blank">Tiny Giant Studios</a> for more information.', 'redux-framework-demo' )
                        ),

                        // Background Section
                        array(
                            'id' => 'cf7date_section_backgrounds',
                            'type' => 'section',
                            'title' => __('Backgrounds', 'redux-framework-demo'),
                            'subtitle' => __('This section adds background styles for the date fields.', 'redux-framework-demo'),
                            'indent' => true 
                        ),

                            array(
                                'id'       => 'cf7_date_field_background',
                                'type'     => 'background',
                                'title'    => __( 'Date Dropdown Background', 'redux-framework-demo' ),
                                'subtitle' => __( 'Set the background of the date input fields.', 'redux-framework-demo' ),
                                'preview'  => false,
                            ),

                        // Borders Section
                        array(
                            'id'        => 'cf7_date_section_borders',
                            'type'      => 'section',
                            'title'     => __('Borders', 'redux-framework-demo'),
                            'subtitle'  => __('This section adds border styles for the date fields.', 'redux-framework-demo'),
                            'indent'    => true 
                        ),

                            array(
                                'id'       => 'cf7_date_field_border',
                                'type'     => 'border',
                                'title'    => __( 'Date Dropdown Border', 'redux-framework-demo' ),
                                'subtitle' => __( 'Set the border of each date field.', 'redux-framework-demo' ),
                                'all'      => false,
                                'top'      => true,
                                'right'    => true,
                                'left'     => true,
                                'bottom'   => true,
                            ),

                        // Padding & Margin
                        array(
                            'id'        => 'cf7_date_section_spacing',
                            'type'      => 'section',
                            'title'     => __('Padding / Margin', 'redux-framework-demo'),
                            'subtitle'  => __('This section adds padding and margin for each of the date dropdown fields.', 'redux-framework-demo'),
                            'indent'    => true,
                        ),

                            array(
                                'id'                => 'cf7_date_field_padding',
                                'type'              => 'spacing',
                                'mode'              => 'padding', 
                                'units'             => array('em', 'px', '%'),
                                'units_extended'    => false,
                                'display_units'     => true, 
                                'title'             => __('Date Dropdown Field Padding', 'redux-framework-demo'),
                                'subtitle'          => __('Specifies the padding used for each of the date dropdown fields.', 'redux-framework-demo'),
                            ),

                            array(
                                'id'                => 'cf7_date_field_margin',
                                'type'              => 'spacing',
                                'mode'              => 'margin', 
                                'units'             => array('em', 'px', '%'),
                                'units_extended'    => false,
                                'display_units'     => true, 
                                'title'             => __('Date Dropdown Field Margin', 'redux-framework-demo'),
                                'subtitle'          => __('Specifies the margin used for each the date dropdown fields.', 'redux-framework-demo'),
                            ),

                        // Fonts
                        array(
                            'id'        => 'cf7_date_section_fonts',
                            'type'      => 'section',
                            'title'     => __('Fonts', 'redux-framework-demo'),
                            'subtitle'  => __('This section sets font rules for the date dropdown fields.', 'redux-framework-demo'),
                            'indent'    => true 
                        ),

                            array(
                                'id'                => 'cf7_date_field_font',
                                'type'              => 'typography',
                                'title'             => __('Date Dropdown Field', 'redux-framework-demo'),
                                'google'            => true, 
                                'font-backup'       => true, 
                                'font-style'        => true,
                                'subsets'           => true,
                                'font-size'         => true,
                                'line-height'       => true,
                                'color'             => true,
                                'preview'           => true, 
                                'all_styles'        => true,
                                'text-transform'    => true,
                                'output'            => array('#cf7-styles .wpcf7 .wpcf7-form input.wpcf7-date', '.wpcf7 .wpcf7-form input.wpcf7-date'),
                                'units'             => 'px',
                                'subtitle'          => __('Applies to all date dropdown fields generated by Contact Form 7.', 'redux-framework-demo'),
                            ),

                        // Dimensions
                        array(
                            'id'        => 'cf7_date_section_dimensions',
                            'type'      => 'section',
                            'title'     => __('Dimensions', 'redux-framework-demo'),
                            'subtitle'  => __('This section adds dimension options for the date dropdown fields.', 'redux-framework-demo'),
                            'indent'    => true 
                        ),

                            array(
                                'id'             => 'cf7_date_field_dimension',
                                'type'           => 'dimensions',
                                'units'          => array('em','px','%'),
                                'units_extended' => 'true', 
                                'title'          => __( 'Width / Height', 'redux-framework-demo' ),
                                'subtitle'       => __( 'Allow your users to set the width / height of Contact Form 7 date dropdown fields.', 'redux-framework-demo' ),
                            ), 
                    ),
                );



                // Dropdown Styles
                $this->sections[] = array( 
                    'title'  => __( 'Dropdown', 'redux-framework-demo' ),
                    'icon'   => 'el-icon-lines',
                    'fields' => array(

                        // Pro Warning
                        array(
                            'id'     => 'opt-notice-critical',
                            'type'   => 'info',
                            'notice' => true,
                            'style'  => 'critical',
                            'title'  => __( 'Pro Feature', 'redux-framework-demo' ),
                            'desc'   => __( 'This feature is reserved for the Pro version of Contact Form 7 Designer. Values saved here will not take effect on the front end. <br />Please visit <a href="http://tinygiantstudios.co.uk/product/contact-form-7-designer-pro/" target="_blank">Tiny Giant Studios</a> for more information.', 'redux-framework-demo' )
                        ),

                        // Background Section
                        array(
                            'id' => 'cf7_select_section_backgrounds',
                            'type' => 'section',
                            'title' => __('Backgrounds', 'redux-framework-demo'),
                            'subtitle' => __('This section adds background styles for the dropdown section.', 'redux-framework-demo'),
                            'indent' => true 
                        ),

                            array(
                                'id'       => 'cf7_select_field_background',
                                'type'     => 'background',
                                'title'    => __( 'Dropdown Background', 'redux-framework-demo' ),
                                'subtitle' => __( 'Set the background of the dropdown section.', 'redux-framework-demo' ),
                                'preview'  => false,
                            ),

                        // Borders Section
                        array(
                            'id'        => 'cf7_select_section_borders',
                            'type'      => 'section',
                            'title'     => __('Borders', 'redux-framework-demo'),
                            'subtitle'  => __('This section adds border styles for the dropdown section.', 'redux-framework-demo'),
                            'indent'    => true 
                        ),

                            array(
                                'id'       => 'cf7_select_field_border',
                                'type'     => 'border',
                                'title'    => __( 'Dropdown Menu Border', 'redux-framework-demo' ),
                                'subtitle' => __( 'Set the border of each dropdown field.', 'redux-framework-demo' ),
                                'all'      => false,
                                'top'      => true,
                                'right'    => true,
                                'left'     => true,
                                'bottom'   => true,
                            ),

                        // Padding & Margin
                        array(
                            'id'        => 'cf7_select_section_spacing',
                            'type'      => 'section',
                            'title'     => __('Padding / Margin', 'redux-framework-demo'),
                            'subtitle'  => __('This section adds padding and margin for the dropdown field section.', 'redux-framework-demo'),
                            'indent'    => true,
                        ),

                            array(
                                'id'                => 'cf7_select_field_padding',
                                'type'              => 'spacing',
                                'mode'              => 'padding', 
                                'units'             => array('em', 'px', '%'),
                                'units_extended'    => false,
                                'display_units'     => true, 
                                'title'             => __('Dropdown Menu Padding', 'redux-framework-demo'),
                                'subtitle'          => __('Specifies the padding used for the dropdown field.', 'redux-framework-demo'),
                            ),

                            array(
                                'id'                => 'cf7_select_field_margin',
                                'type'              => 'spacing',
                                'mode'              => 'margin', 
                                'units'             => array('em', 'px', '%'),
                                'units_extended'    => false,
                                'display_units'     => true, 
                                'title'             => __('Dropdown Menu Margin', 'redux-framework-demo'),
                                'subtitle'          => __('Specifies the margin used for the dropdown field.', 'redux-framework-demo'),
                            ),

                        // Fonts
                        array(
                            'id'        => 'cf7_select_section_fonts',
                            'type'      => 'section',
                            'title'     => __('Fonts', 'redux-framework-demo'),
                            'subtitle'  => __('This section sets font rules for the dropdown (select) field.', 'redux-framework-demo'),
                            'indent'    => true 
                        ),

                            array(
                                'id'                => 'cf7_select_field_font',
                                'type'              => 'typography',
                                'title'             => __('Dropdown Field', 'redux-framework-demo'),
                                'google'            => true, 
                                'font-backup'       => true, 
                                'font-style'        => true,
                                'subsets'           => true,
                                'font-size'         => true,
                                'line-height'       => true,
                                'color'             => true,
                                'preview'           => true, 
                                'all_styles'        => true,
                                'text-transform'    => true,
                                'units'             => 'px',
                                'subtitle'          => __('Applies to all dropdown fields (select) generated by Contact Form 7.', 'redux-framework-demo'),
                            ),

                        // Dimensions
                        array(
                            'id'        => 'cf7_select_section_dimensions',
                            'type'      => 'section',
                            'title'     => __('Dimensions', 'redux-framework-demo'),
                            'subtitle'  => __('This section adds dimension options for the dropdown (select) field.', 'redux-framework-demo'),
                            'indent'    => true 
                        ),

                            array(
                                'id'             => 'cf7_select_field_dimension',
                                'type'           => 'dimensions',
                                'units'          => array('em','px','%'),
                                'units_extended' => 'true', 
                                'title'          => __( 'Width / Height', 'redux-framework-demo' ),
                                'subtitle'       => __( 'Allow your users to set the width / height of Contact Form 7 dropdown (select) fields.', 'redux-framework-demo' ),
                            ), 
                    ),
                );



                // Checkbox Styles
                $this->sections[] = array( 
                    'title'  => __( 'Checkboxes', 'redux-framework-demo' ),
                    'icon'   => 'el-icon-check',
                    'fields' => array(

                        // Pro Warning
                        array(
                            'id'     => 'opt-notice-critical',
                            'type'   => 'info',
                            'notice' => true,
                            'style'  => 'critical',
                            'title'  => __( 'Pro Feature', 'redux-framework-demo' ),
                            'desc'   => __( 'This feature is reserved for the Pro version of Contact Form 7 Designer. Values saved here will not take effect on the front end. <br />Please visit <a href="http://tinygiantstudios.co.uk/product/contact-form-7-designer-pro/" target="_blank">Tiny Giant Studios</a> for more information.', 'redux-framework-demo' )
                        ),

                        // Padding & Margin
                        array(
                            'id'        => 'cf7_checkbox_section_spacing',
                            'type'      => 'section',
                            'title'     => __('Padding / Margin', 'redux-framework-demo'),
                            'subtitle'  => __('This section adds padding and margin for the checkbox field section.', 'redux-framework-demo'),
                            'indent'    => true,
                        ),

                            array(
                                'id'                => 'cf7_checkbox_label_padding',
                                'type'              => 'spacing',
                                'mode'              => 'padding', 
                                'units'             => array('em', 'px', '%'),
                                'units_extended'    => false,
                                'display_units'     => true, 
                                'title'             => __('Checkbox Label Padding', 'redux-framework-demo'),
                                'subtitle'          => __('Specifies the padding used for the checkbox label.', 'redux-framework-demo'),
                            ),

                            array(
                                'id'                => 'cf7_checkbox_label_margin',
                                'type'              => 'spacing',
                                'mode'              => 'margin', 
                                'units'             => array('em', 'px', '%'),
                                'units_extended'    => false,
                                'display_units'     => true, 
                                'title'             => __('Checkbox Label Margin', 'redux-framework-demo'),
                                'subtitle'          => __('Specifies the margin used for the checkbox label.', 'redux-framework-demo'),
                            ),

                            array(
                                'id'                => 'cf7_checkbox_field_padding',
                                'type'              => 'spacing',
                                'mode'              => 'padding', 
                                'units'             => array('em', 'px', '%'),
                                'units_extended'    => false,
                                'display_units'     => true, 
                                'title'             => __('Checkbox Option Padding', 'redux-framework-demo'),
                                'subtitle'          => __('Specifies the padding used for the checkbox option.', 'redux-framework-demo'),
                            ),

                            array(
                                'id'                => 'cf7_checkbox_field_margin',
                                'type'              => 'spacing',
                                'mode'              => 'margin', 
                                'units'             => array('em', 'px', '%'),
                                'units_extended'    => false,
                                'display_units'     => true, 
                                'title'             => __('Checkbox Option Margin', 'redux-framework-demo'),
                                'subtitle'          => __('Specifies the margin used for the checkbox option.', 'redux-framework-demo'),
                            ),


                            array(
                                'id'                => 'cf7_checkbox_item_padding',
                                'type'              => 'spacing',
                                'mode'              => 'padding', 
                                'units'             => array('em', 'px', '%'),
                                'units_extended'    => false,
                                'display_units'     => true, 
                                'title'             => __('Checkbox List Item Padding', 'redux-framework-demo'),
                                'subtitle'          => __('Specifies the padding used for the entire checkbox list item.', 'redux-framework-demo'),
                            ),

                            array(
                                'id'                => 'cf7_checkbox_item_margin',
                                'type'              => 'spacing',
                                'mode'              => 'margin', 
                                'units'             => array('em', 'px', '%'),
                                'units_extended'    => false,
                                'display_units'     => true, 
                                'title'             => __('Checkbox List Item Margin', 'redux-framework-demo'),
                                'subtitle'          => __('Specifies the margin used for the entire checkbox list item.', 'redux-framework-demo'),
                            ),

                        // Fonts
                        array(
                            'id'        => 'cf7_checkbox_section_fonts',
                            'type'      => 'section',
                            'title'     => __('Fonts', 'redux-framework-demo'),
                            'subtitle'  => __('This section sets font rules for the checkbox field.', 'redux-framework-demo'),
                            'indent'    => true 
                        ),

                            array(
                                'id'                => 'cf7_checkbox_label_font',
                                'type'              => 'typography',
                                'title'             => __('Checkbox Label', 'redux-framework-demo'),
                                'google'            => true, 
                                'font-backup'       => true, 
                                'font-style'        => true,
                                'subsets'           => true,
                                'font-size'         => true,
                                'line-height'       => true,
                                'color'             => true,
                                'preview'           => true, 
                                'all_styles'        => true,
                                'text-transform'    => true,
                                'units'             => 'px',
                                'subtitle'          => __('Applies to all dropdown (select) field labels generated by Contact Form 7.', 'redux-framework-demo'),
                            ),
                    ),
                );



                // Radio Button Styles
                $this->sections[] = array( 
                    'title'  => __( 'Radio Buttons', 'redux-framework-demo' ),
                    'icon'   => 'el-icon-record',
                    'fields' => array(

                        // Pro Warning
                        array(
                            'id'     => 'opt-notice-critical',
                            'type'   => 'info',
                            'notice' => true,
                            'style'  => 'critical',
                            'title'  => __( 'Pro Feature', 'redux-framework-demo' ),
                            'desc'   => __( 'This feature is reserved for the Pro version of Contact Form 7 Designer. Values saved here will not take effect on the front end. <br />Please visit <a href="http://tinygiantstudios.co.uk/product/contact-form-7-designer-pro/" target="_blank">Tiny Giant Studios</a> for more information.', 'redux-framework-demo' )
                        ),

                        // Padding & Margin
                        array(
                            'id'        => 'cf7_radio_section_spacing',
                            'type'      => 'section',
                            'title'     => __('Padding / Margin', 'redux-framework-demo'),
                            'subtitle'  => __('This section adds padding and margin for the radio button field section.', 'redux-framework-demo'),
                            'indent'    => true,
                        ),

                            array(
                                'id'                => 'cf7_radio_label_padding',
                                'type'              => 'spacing',
                                'mode'              => 'padding', 
                                'units'             => array('em', 'px', '%'),
                                'units_extended'    => false,
                                'display_units'     => true, 
                                'title'             => __('Radio Button Label Padding', 'redux-framework-demo'),
                                'subtitle'          => __('Specifies the padding used for the radio button label.', 'redux-framework-demo'),
                            ),

                            array(
                                'id'                => 'cf7_radio_label_margin',
                                'type'              => 'spacing',
                                'mode'              => 'margin', 
                                'units'             => array('em', 'px', '%'),
                                'units_extended'    => false,
                                'display_units'     => true, 
                                'title'             => __('Radio Button Label Margin', 'redux-framework-demo'),
                                'subtitle'          => __('Specifies the margin used for the radio button label.', 'redux-framework-demo'),
                            ),

                            array(
                                'id'                => 'cf7_radio_field_padding',
                                'type'              => 'spacing',
                                'mode'              => 'padding', 
                                'units'             => array('em', 'px', '%'),
                                'units_extended'    => false,
                                'display_units'     => true, 
                                'title'             => __('Radio Button Option Padding', 'redux-framework-demo'),
                                'subtitle'          => __('Specifies the padding used for the radio button option.', 'redux-framework-demo'),
                            ),

                            array(
                                'id'                => 'cf7_radio_field_margin',
                                'type'              => 'spacing',
                                'mode'              => 'margin', 
                                'units'             => array('em', 'px', '%'),
                                'units_extended'    => false,
                                'display_units'     => true, 
                                'title'             => __('Radio Button Option Margin', 'redux-framework-demo'),
                                'subtitle'          => __('Specifies the margin used for the radio button option.', 'redux-framework-demo'),
                            ),


                            array(
                                'id'                => 'cf7_radio_item_padding',
                                'type'              => 'spacing',                                
                                'mode'              => 'padding', 
                                'units'             => array('em', 'px', '%'),
                                'units_extended'    => false,
                                'display_units'     => true, 
                                'title'             => __('Radio Button List Item Padding', 'redux-framework-demo'),
                                'subtitle'          => __('Specifies the padding used for the entire radio button list item.', 'redux-framework-demo'),
                            ),

                            array(
                                'id'                => 'cf7_radio_item_margin',
                                'type'              => 'spacing',
                                'mode'              => 'margin', 
                                'units'             => array('em', 'px', '%'),
                                'units_extended'    => false,
                                'display_units'     => true, 
                                'title'             => __('Radio Button List Item Margin', 'redux-framework-demo'),
                                'subtitle'          => __('Specifies the margin used for the entire radio button list item.', 'redux-framework-demo'),
                            ),

                        // Fonts
                        array(
                            'id'        => 'cf7_radio_section_fonts',
                            'type'      => 'section',
                            'title'     => __('Fonts', 'redux-framework-demo'),
                            'subtitle'  => __('This section sets font rules for the checkbox field.', 'redux-framework-demo'),
                            'indent'    => true 
                        ),

                            array(
                                'id'                => 'cf7_radio_label_font',
                                'type'              => 'typography',
                                'title'             => __('Radio Button Label', 'redux-framework-demo'),
                                'google'            => true, 
                                'font-backup'       => true, 
                                'font-style'        => true,
                                'subsets'           => true,
                                'font-size'         => true,
                                'line-height'       => true,
                                'color'             => true,
                                'preview'           => true, 
                                'all_styles'        => true,
                                'text-transform'    => true,
                                'units'             => 'px',
                                'subtitle'          => __('Applies to all radio button labels generated by Contact Form 7.', 'redux-framework-demo'),
                            ),
                    ),
                );



                // Quiz Field Styles
                $this->sections[] = array( 
                    'title'  => __( 'Quiz', 'redux-framework-demo' ),
                    'icon'   => 'el-icon-ok',
                    'fields' => array(

                        // Pro Warning
                        array(
                            'id'     => 'opt-notice-critical',
                            'type'   => 'info',
                            'notice' => true,
                            'style'  => 'critical',
                            'title'  => __( 'Pro Feature', 'redux-framework-demo' ),
                            'desc'   => __( 'This feature is reserved for the Pro version of Contact Form 7 Designer. Values saved here will not take effect on the front end. <br />Please visit <a href="http://tinygiantstudios.co.uk/product/contact-form-7-designer-pro/" target="_blank">Tiny Giant Studios</a> for more information.', 'redux-framework-demo' )
                        ),

                        // Background Section
                        array(
                            'id' => 'cf7_quiz_section_backgrounds',
                            'type' => 'section',
                            'title' => __('Backgrounds', 'redux-framework-demo'),
                            'subtitle' => __('This section adds background styles for the input field section.', 'redux-framework-demo'),
                            'indent' => true 
                        ),

                            array(
                                'id'       => 'cf7_quiz_field_background',
                                'type'     => 'background',
                                'title'    => __( 'Quiz Field Background', 'redux-framework-demo' ),
                                'subtitle' => __( 'Set the background of the quiz element', 'redux-framework-demo' ),
                                'preview'  => false,
                            ),

                        // Borders Section
                        array(
                            'id'        => 'cf7_quiz_section_borders',
                            'type'      => 'section',
                            'title'     => __('Borders', 'redux-framework-demo'),
                            'subtitle'  => __('This section adds border styles for the input field section.', 'redux-framework-demo'),
                            'indent'    => true 
                        ),

                            array(
                                'id'       => 'cf7_quiz_field_border',
                                'type'     => 'border',
                                'title'    => __( 'Quiz Field Border', 'redux-framework-demo' ),
                                'subtitle' => __( 'Set the border of each quiz element.', 'redux-framework-demo' ),
                                'all'      => false,
                                'top'      => true,
                                'right'    => true,
                                'left'     => true,
                                'bottom'   => true,
                            ),

                        // Padding & Margin
                        array(
                            'id'        => 'cf7_quiz_section_spacing',
                            'type'      => 'section',
                            'title'     => __('Padding / Margin', 'redux-framework-demo'),
                            'subtitle'  => __('This section adds padding and margin for the quiz field section.', 'redux-framework-demo'),
                            'indent'    => true,
                        ),

                            array(
                                'id'                => 'cf7_quiz_field_padding',
                                'type'              => 'spacing',
                                'mode'              => 'padding', 
                                'units'             => array('em', 'px', '%'),
                                'units_extended'    => false,
                                'display_units'     => true, 
                                'title'             => __('Quiz Field Padding', 'redux-framework-demo'),
                                'subtitle'          => __('Specifies the padding used for the text text (input) field.', 'redux-framework-demo'),
                            ),

                            array(
                                'id'                => 'cf7_quiz_field_margin',
                                'type'              => 'spacing',
                                'mode'              => 'margin', 
                                'units'             => array('em', 'px', '%'),
                                'units_extended'    => false,
                                'display_units'     => true, 
                                'title'             => __('Quiz Field Margin', 'redux-framework-demo'),
                                'subtitle'          => __('Specifies the margin used for the quiz field.', 'redux-framework-demo'),
                            ),

                             array(
                                'id'                => 'cf7_quiz_label_padding',
                                'type'              => 'spacing',
                                'mode'              => 'padding', 
                                'units'             => array('em', 'px', '%'),
                                'units_extended'    => false,
                                'display_units'     => true, 
                                'title'             => __('Quiz Label Padding', 'redux-framework-demo'),
                                'subtitle'          => __('Specifies the padding used for the text text (input) field.', 'redux-framework-demo'),
                            ),

                            array(
                                'id'                => 'cf7_quiz_label_margin',
                                'type'              => 'spacing',
                                'mode'              => 'margin', 
                                'units'             => array('em', 'px', '%'),
                                'units_extended'    => false,
                                'display_units'     => true, 
                                'title'             => __('Quiz Label Margin', 'redux-framework-demo'),
                                'subtitle'          => __('Specifies the margin used for the quiz field.', 'redux-framework-demo'),
                            ),

                        // Fonts
                        array(
                            'id'        => 'cf7_quiz_section_fonts',
                            'type'      => 'section',
                            'title'     => __('Fonts', 'redux-framework-demo'),
                            'subtitle'  => __('This section sets font rules for the quiz field.', 'redux-framework-demo'),
                            'indent'    => true 
                        ),

                            array(
                                'id'                => 'cf7_quiz_field_font',
                                'type'              => 'typography',
                                'title'             => __('Quiz Field', 'redux-framework-demo'),
                                'google'            => true, 
                                'font-backup'       => true, 
                                'font-style'        => true,
                                'subsets'           => true,
                                'font-size'         => true,
                                'line-height'       => true,
                                'color'             => true,
                                'preview'           => true, 
                                'all_styles'        => true,
                                'text-transform'    => true,
                                'units'             => 'px',
                                'subtitle'          => __('Applies to all quiz fields generated by Contact Form 7.', 'redux-framework-demo'),
                            ),

                        // Dimensions
                        array(
                            'id'        => 'cf7_quiz_section_dimensions',
                            'type'      => 'section',
                            'title'     => __('Dimensions', 'redux-framework-demo'),
                            'subtitle'  => __('This section adds dimension options for the quiz field.', 'redux-framework-demo'),
                            'indent'    => true 
                        ),

                            array(
                                'id'             => 'cf7_quiz_field_dimension',
                                'type'           => 'dimensions',
                                'units'          => array('em','px','%'),
                                'units_extended' => 'true', 
                                'title'          => __( 'Width / Height', 'redux-framework-demo' ),
                                'subtitle'       => __( 'Allow your users to set the width / height of Contact Form 7 quiz fields.', 'redux-framework-demo' ),
                            ), 
                    ),
                );



                // Captcha Styles
                $this->sections[] = array( 
                    'title'  => __( 'Captcha', 'redux-framework-demo' ),
                    'icon'   => 'el-icon-barcode',
                    'fields' => array(

                        // Pro Warning
                        array(
                            'id'     => 'opt-notice-critical',
                            'type'   => 'info',
                            'notice' => true,
                            'style'  => 'critical',
                            'title'  => __( 'Pro Feature', 'redux-framework-demo' ),
                            'desc'   => __( 'This feature is reserved for the Pro version of Contact Form 7 Designer. Values saved here will not take effect on the front end. <br />Please visit <a href="http://tinygiantstudios.co.uk/product/contact-form-7-designer-pro/" target="_blank">Tiny Giant Studios</a> for more information.', 'redux-framework-demo' )
                        ),

                        // Background Section
                        array(
                            'id' => 'cf7_captcha_section_backgrounds',
                            'type' => 'section',
                            'title' => __('Backgrounds', 'redux-framework-demo'),
                            'subtitle' => __('This section adds background styles for the Captcha field section.', 'redux-framework-demo'),
                            'indent' => true 
                        ),

                            array(
                                'id'       => 'cf7_captcha_field_background',
                                'type'     => 'background',
                                'title'    => __( 'Captcha Field Background', 'redux-framework-demo' ),
                                'subtitle' => __( 'Set the background of the Captcha element (input field)', 'redux-framework-demo' ),
                                'preview'  => false,
                            ),

                        // Borders Section
                        array(
                            'id'        => 'cf7_captcha_section_borders',
                            'type'      => 'section',
                            'title'     => __('Borders', 'redux-framework-demo'),
                            'subtitle'  => __('This section adds border styles for the Captcha field section.', 'redux-framework-demo'),
                            'indent'    => true 
                        ),

                            array(
                                'id'       => 'cf7_captcha_field_border',
                                'type'     => 'border',
                                'title'    => __( 'Captcha Field Border', 'redux-framework-demo' ),
                                'subtitle' => __( 'Set the border of each Captcha element.', 'redux-framework-demo' ),
                                'all'      => false,
                                'top'      => true,
                                'right'    => true,
                                'left'     => true,
                                'bottom'   => true,
                            ),

                            array(
                                'id'       => 'cf7_captcha_image_border',
                                'type'     => 'border',
                                'title'    => __( 'Captcha Field Border', 'redux-framework-demo' ),
                                'subtitle' => __( 'Set the border of each Captcha image .', 'redux-framework-demo' ),
                                'all'      => false,
                                'top'      => true,
                                'right'    => true,
                                'left'     => true,
                                'bottom'   => true,
                            ),

                        // Padding & Margin
                        array(
                            'id'        => 'cf7_captcha_section_spacing',
                            'type'      => 'section',
                            'title'     => __('Padding / Margin', 'redux-framework-demo'),
                            'subtitle'  => __('This section adds padding and margin for the Captcha field section.', 'redux-framework-demo'),
                            'indent'    => true,
                        ),

                            array(
                                'id'                => 'cf7_captcha_field_padding',
                                'type'              => 'spacing',
                                'mode'              => 'padding', 
                                'units'             => array('em', 'px', '%'),
                                'units_extended'    => false,
                                'display_units'     => true, 
                                'title'             => __('Captcha Field Padding', 'redux-framework-demo'),
                                'subtitle'          => __('Specifies the padding used for the Captcha field.', 'redux-framework-demo'),
                            ),

                            array(
                                'id'                => 'cf7_captcha_field_margin',
                                'type'              => 'spacing',
                                'mode'              => 'margin', 
                                'units'             => array('em', 'px', '%'),
                                'units_extended'    => false,
                                'display_units'     => true, 
                                'title'             => __('Captcha Field Margin', 'redux-framework-demo'),
                                'subtitle'          => __('Specifies the margin used for the Captcha field.', 'redux-framework-demo'),
                            ),

                            array(
                                'id'                => 'cf7_captcha_image_padding',
                                'type'              => 'spacing',
                                'mode'              => 'padding', 
                                'units'             => array('em', 'px', '%'),
                                'units_extended'    => false,
                                'display_units'     => true, 
                                'title'             => __('Captcha Image Padding', 'redux-framework-demo'),
                                'subtitle'          => __('Specifies the padding used for the Captcha image.', 'redux-framework-demo'),
                            ),

                            array(
                                'id'                => 'cf7_captcha_image_margin',
                                'type'              => 'spacing',
                                'mode'              => 'margin', 
                                'units'             => array('em', 'px', '%'),
                                'units_extended'    => false,
                                'display_units'     => true, 
                                'title'             => __('Captcha Image Margin', 'redux-framework-demo'),
                                'subtitle'          => __('Specifies the margin used for the Captcha image.', 'redux-framework-demo'),
                            ),

                        // Fonts
                        array(
                            'id'        => 'cf7_captcha_section_fonts',
                            'type'      => 'section',
                            'title'     => __('Fonts', 'redux-framework-demo'),
                            'subtitle'  => __('This section sets font rules for the Captcha field.', 'redux-framework-demo'),
                            'indent'    => true 
                        ),

                            array(
                                'id'                => 'cf7_captcha_field_font',
                                'type'              => 'typography',
                                'title'             => __('Captcha Field', 'redux-framework-demo'),
                                'google'            => true, 
                                'font-backup'       => true, 
                                'font-style'        => true,
                                'subsets'           => true,
                                'font-size'         => true,
                                'line-height'       => true,
                                'color'             => true,
                                'preview'           => true, 
                                'all_styles'        => true,
                                'text-transform'    => true,
                                'units'             => 'px',
                                'subtitle'          => __('Applies to all Captcha fields generated by Contact Form 7.', 'redux-framework-demo'),
                            ),

                        // Dimensions
                        array(
                            'id'        => 'cf7_captcha_section_dimensions',
                            'type'      => 'section',
                            'title'     => __('Dimensions', 'redux-framework-demo'),
                            'subtitle'  => __('This section adds dimension options for the Captcha field.', 'redux-framework-demo'),
                            'indent'    => true 
                        ),

                            array(
                                'id'             => 'cf7_captcha_field_dimension',
                                'type'           => 'dimensions',
                                'units'          => array('em','px','%'),
                                'units_extended' => 'true', 
                                'title'          => __( 'Width / Height', 'redux-framework-demo' ),
                                'subtitle'       => __( 'Allow your users to set the width / height of Contact Form 7 Captcha fields.', 'redux-framework-demo' ),
                            ), 
                    ),
                );



                // File Upload Styles
                $this->sections[] = array( 
                    'title'  => __( 'File Upload', 'redux-framework-demo' ),
                    'icon'   => 'el-icon-stackoverflow',
                    'fields' => array(

                        // Pro Warning
                        array(
                            'id'     => 'opt-notice-critical',
                            'type'   => 'info',
                            'notice' => true,
                            'style'  => 'critical',
                            'title'  => __( 'Pro Feature', 'redux-framework-demo' ),
                            'desc'   => __( 'This feature is reserved for the Pro version of Contact Form 7 Designer. Values saved here will not take effect on the front end. <br />Please visit <a href="http://tinygiantstudios.co.uk/product/contact-form-7-designer-pro/" target="_blank">Tiny Giant Studios</a> for more information.', 'redux-framework-demo' )
                        ),

                        // Padding & Margin
                        array(
                            'id'        => 'cf7_upload_section_spacing',
                            'type'      => 'section',
                            'title'     => __('Padding / Margin', 'redux-framework-demo'),
                            'subtitle'  => __('This section adds padding and margin for the upload file element.', 'redux-framework-demo'),
                            'indent'    => true,
                        ),

                            array(
                                'id'                => 'cf7_upload_field_padding',
                                'type'              => 'spacing',
                                'mode'              => 'padding', 
                                'units'             => array('em', 'px', '%'),
                                'units_extended'    => false,
                                'display_units'     => true, 
                                'title'             => __('Upload File Padding', 'redux-framework-demo'),
                                'subtitle'          => __('Specifies the padding used for the uploaded file element.', 'redux-framework-demo'),
                            ),

                            array(
                                'id'                => 'cf7_upload_field_margin',
                                'type'              => 'spacing',
                                'mode'              => 'margin', 
                                'units'             => array('em', 'px', '%'),
                                'units_extended'    => false,
                                'display_units'     => true, 
                                'title'             => __('Upload File Margin', 'redux-framework-demo'),
                                'subtitle'          => __('Specifies the margin used for the uploaded file element.', 'redux-framework-demo'),
                            ),

                        // Fonts
                        array(
                            'id'        => 'cf7_upload_section_fonts',
                            'type'      => 'section',
                            'title'     => __('Fonts', 'redux-framework-demo'),
                            'subtitle'  => __('This section sets font rules for the file upload field.', 'redux-framework-demo'),
                            'indent'    => true 
                        ),

                            array(
                                'id'                => 'cf7_upload_field_font',
                                'type'              => 'typography',
                                'title'             => __('Uploaded File Field', 'redux-framework-demo'),
                                'google'            => true, 
                                'font-backup'       => true, 
                                'font-style'        => true,
                                'subsets'           => true,
                                'font-size'         => true,
                                'line-height'       => true,
                                'color'             => true,
                                'preview'           => true, 
                                'all_styles'        => true,
                                'text-transform'    => true,
                                'units'             => 'px',
                                'subtitle'          => __('Applies to all upload file fields generated by Contact Form 7.', 'redux-framework-demo'),
                            ),

                        // Dimensions
                        array(
                            'id'        => 'cf7_upload_section_dimensions',
                            'type'      => 'section',
                            'title'     => __('Dimensions', 'redux-framework-demo'),
                            'subtitle'  => __('This section adds dimension options for the file upload field.', 'redux-framework-demo'),
                            'indent'    => true 
                        ),

                            array(
                                'id'             => 'cf7_upload_field_dimension',
                                'type'           => 'dimensions',
                                'units'          => array('em','px','%'),
                                'units_extended' => 'true', 
                                'title'          => __( 'Width / Height', 'redux-framework-demo' ),
                                'subtitle'       => __( 'Allow your users to set the width / height of Contact Form 7 file upload fields.', 'redux-framework-demo' ),
                            ), 

                    ),
                );


                $this->sections[] = array(
                    'type' => 'divide',
                );
            }


            /**
             * All the possible arguments for Contact Form 7.
             * 
             * */
            public function setArguments() {

                $theme = wp_get_theme(); // For use with some settings. Not necessary.

                $this->args = array(
                    'opt_name'             => 'cf7_styles',
                    'display_name'         => 'Contact Form 7 Designer',
                    'display_version'      => '1.0',
                    'menu_type'            => 'menu',
                    'allow_sub_menu'       => true,
                    'menu_title'           => __( 'Form Styles', 'redux-framework-demo' ),
                    'page_title'           => __( 'Contact Form 7 Designer', 'redux-framework-demo' ),
                    'google_api_key'       => 'AIzaSyDFR99UaB0zb_zauMKo27xpitQTpbzOY-4',
                    'google_update_weekly' => false,
                    'async_typography'     => true,
                    'admin_bar'            => true,
                    'admin_bar_icon'       => 'dashicons-portfolio',
                    'admin_bar_priority'   => 50,
                    'global_variable'      => '',
                    'dev_mode'             => false,
                    'update_notice'        => false,
                    'customizer'           => false,
                    'page_priority'        => null,
                    'page_parent'          => 'themes.php',
                    'page_permissions'     => 'manage_options',
                    'menu_icon'            => '',
                    'last_tab'             => '',
                    'page_icon'            => 'icon-themes',
                    'page_slug'            => 'cf7-styles_options',
                    'save_defaults'        => true,
                    'default_show'         => false,
                    'default_mark'         => '',
                    'show_import_export'   => false,
                    'transient_time'       => 60 * MINUTE_IN_SECONDS,
                    'output'               => true,
                    'output_tag'           => true,
                    'footer_credit'     => '',
                    'database'             => '',
                    'system_info'          => false,

                    // HINTS
                    'hints'                => array(
                        'icon'          => 'icon-question-sign',
                        'icon_position' => 'right',
                        'icon_color'    => 'lightgray',
                        'icon_size'     => 'normal',
                        'tip_style'     => array(
                            'color'   => 'light',
                            'shadow'  => true,
                            'rounded' => false,
                            'style'   => '',
                        ),
                        'tip_position'  => array(
                            'my' => 'top left',
                            'at' => 'bottom right',
                        ),
                        'tip_effect'    => array(
                            'show' => array(
                                'effect'   => 'slide',
                                'duration' => '500',
                                'event'    => 'mouseover',
                            ),
                            'hide' => array(
                                'effect'   => 'slide',
                                'duration' => '500',
                                'event'    => 'click mouseleave',
                            ),
                        ),
                    )
                );
            }

        }

        global $reduxConfig;
        $reduxConfig = new Redux_Framework_CF7_config();
    } else {
        echo "The class named Redux_Framework_Contact Form 7_config has already been called. <strong>Please contact the plugin author.</strong>";
    }
