<?php
/**
 * The template for displaying meta box in page/post
 *
 * This adds Layout Options, Select Sidebar, Header Freatured Image Options, Single Page/Post Image Layout
 * This is only for the design purpose and not used to save any content
 *
 * @package Fotografie Blog Pro
 */


/**
 * Class to Add, Render and save metabox options
 *
 * @since Fotografie Blog Pro 1.0
 */
class Fotografie_Blog_Metabox {
    private $meta_box;

    /**
     * Constructor
     *
     * @since Fotografie Blog Pro 1.0
     *
     * @access public
     *
     */
    public function __construct( $meta_box_id, $meta_box_title, $post_type ) {

        $this->meta_box = array(
            'id'        => $meta_box_id,
            'title'     => $meta_box_title,
            'post_type' => $post_type,
        );

        // Add metaboxes.
        add_action( 'add_meta_boxes', array( $this, 'add' ) );

        add_action( 'save_post', array( $this, 'save' ) );
    }

    /**
     * Add Meta Box for multiple post types.
     *
     * @param [string] $post_type Post Type.
     */
    public function add( $post_type ) {
        if ( in_array( $post_type, $this->meta_box['post_type'] ) ) {
            add_meta_box( $this->meta_box['id'], $this->meta_box['title'], array( $this, 'show' ), $post_type,'side');
        }
    }

    /**
     * Renders metabox
     */
    public function show() {
        global $post;
        $header_image = array(
            'default' => array(
                'id'    => 'fotografie-blog-header-image',
                'value' => 'default',
                'label' => esc_html__( 'Default', 'fotografie-blog' ),
            ),
            'enable' => array(
                'id'    => 'fotografie-blog-header-image',
                'value' => 'enable',
                'label' => esc_html__( 'Enable', 'fotografie-blog' ),
            ),
            'disable' => array(
                'id'    => 'fotografie-blog-header-image',
                'value' => 'disable',
                'label' => esc_html__( 'Disable', 'fotografie-blog' ),
            ),
        );

        // Use nonce for verification.
        wp_nonce_field( basename( __FILE__ ), 'fotografie_blog_custom_meta_box_nonce' );

        // Begin the field table and loop.
        ?>
        <p class="post-attributes-label-wrapper"><label class="post-attributes-label" for="fotografie-blog-header-image"><?php esc_html_e( 'Header Featured Image Options', 'fotografie-blog' ); ?></label></p>
        <select class="widefat" name="fotografie-blog-header-image" id="fotografie-blog-header-image">
             <?php
                $meta_value = get_post_meta( $post->ID, 'fotografie-blog-header-image', true );
                
                if ( empty( $meta_value ) ){
                    $meta_value='default';
                }
                
                foreach ($header_image as $field =>$label ) {   
                ?>
                <option value="<?php echo esc_attr( $label['value'] ); ?>" <?php selected( $meta_value, $label['value'] ); ?>><?php echo esc_html( $label['label'] ); ?></option>
                    
                <?php
                } // end foreach
            ?>
        </select>
    <?php
    }

    /**
     * Save custom metabox data
     *
     * @action save_post
     *
     * @since Fotografie Blog Pro 1.0
     *
     * @access public
     */
    public function save( $post_id ) {
        global $post_type;

        $post_type_object = get_post_type_object( $post_type );

        if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )                      // Check Autosave
        || ( ! isset( $_POST['post_ID'] ) || $post_id != $_POST['post_ID'] )        // Check Revision
        || ( ! in_array( $post_type, $this->meta_box['post_type'] ) )                  // Check if current post type is supported.
        || ( ! check_admin_referer( basename( __FILE__ ), 'fotografie_blog_custom_meta_box_nonce') )    // Check nonce - Security
        || ( ! current_user_can( $post_type_object->cap->edit_post, $post_id ) ) )  // Check permission
        {
          return $post_id;
        }

        $value = $_POST['fotografie-blog-header-image'];

        if ( '' === $value || is_array( $value ) ) {
            return;
        } else {
            delete_post_meta( $post_id, 'fotografie-blog-header-image' );

            if ( ! update_post_meta( $post_id, 'fotografie-blog-header-image', sanitize_key( $value ) ) ) {
                add_post_meta( $post_id, 'fotografie-blog-header-image', sanitize_key( $value ), true );
            }
        }
    }
  }

$clean_fotografie_metabox = new Fotografie_Blog_Metabox(
    'fotografie-blog-options',                   //metabox id
    esc_html__( 'Fotografie Blog Options', 'fotografie-blog' ), //metabox title
    array( 'page', 'post' )             //metabox post types
);
