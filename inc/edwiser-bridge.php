<?php
/**
 * Custom taxonomies used by the genU Training website.
 *
 * @package Grindstone Creative
 * @subpackage genU Training
 */

/**
 * Registers custom taxonomies.
 *
 * @return void
 */

use app\wisdmlabs\edwiserBridge\EdwiserBridge;


function gc_eb_update_course_meta($wp_course_id, $course_data, $sync_options)
{
    gc_eb_create_field_group($sync_options);
    gc_eb_update_fields($sync_options);
    gc_eb_update_course_data($wp_course_id, $course_data, $sync_options);
}

add_action('eb_course_updated_wp', 'gc_eb_update_course_meta', 10, 3);
add_action('eb_course_created_wp', 'gc_eb_update_course_meta', 10, 3);

function gc_eb_create_field_group($sync_options)
{
    if (!acf_get_field_group('group_moodle_course_data')) {
        $field_group = array (
            'key' => 'group_moodle_course_data',
            'title' => 'Moodle Sync Fields',
            'location' => array (
                array (
                    array (
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'eb_course',
                    ),
                ),
            ),
        );
        acf_import_field_group($field_group);
    }
}

function gc_eb_update_fields($sync_options)
{   
    $field_group = acf_get_field_group('group_moodle_course_data');
    $fields = acf_get_fields($field_group);

    foreach ( $fields as $field ) {
        acf_remove_local_field( $field['key'] );
        acf_get_local_store( 'fields' )->remove( $field['key'] );
    }

    acf_remove_local_field_group( $field_group['key'] );
    acf_get_store( 'field-groups' )->remove( $field_group['key'] );

    foreach ($sync_options as $key => $value) {
        if (strpos($key, 'eb_update_course_fields_') !== false) {
            if ($value) {
                $id = substr($key, 24);
                if (is_array($fields) && $fields) {
                    $exists = false;
                    foreach ($fields as $field) {
                        if ($field['key'] == 'field_course_' . $id) {
                            $exists = true;
                        }
                    }
                    if (!$exists) {
                        array_push(
                            $fields,
                            array(
                                'key' => 'field_course_' . $id,
                                'label' => 'Moodle Field ' . $id,
                                'name' => 'course_' . $id,
                                'type' => 'text',
                                'wrapper' => array(
                                    'width' => '80',
                                    'class' => '',
                                    'id' => '',
                                ),
                            )
                        );
                        array_push(
                            $fields,
                            array(
                                'key' => 'field_course_' . $id . 'stauts',
                                'label' => 'Enable Field',
                                'name' => 'course_' . $id . '_status',
                                'type' => 'true_false',
                                'wrapper' => array(
                                    'width' => '20',
                                    'class' => '',
                                    'id' => '',
                                ),
                                'default_value' => 1,
                            )
                        );
                    }
                } else {
                    array_push(
                        $fields,
                        array(
                            'key' => 'field_course_' . $id,
                            'label' => 'Moodle Field ' . $id,
                            'name' => 'course_' . $id,
                            'type' => 'text',
                            'wrapper' => array(
                                'width' => '80',
                                'class' => '',
                                'id' => '',
                            ),
                        )
                    );
                    array_push(
                        $fields,
                        array(
                            'key' => 'field_course_' . $id . 'stauts',
                            'label' => 'Enable Field',
                            'name' => 'course_' . $id . '_status',
                            'type' => 'true_false',
                            'wrapper' => array(
                                'width' => '20',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => 1,
                        )
                    );
                }
            }
        }
    }
// Search database for existing field group.
    $post = acf_get_field_group_post( $field_group['key'] );
    if ($post) {
        $field_group['ID'] = $post->ID;
    }
    $field_group['fields'] = $fields;
    acf_import_field_group($field_group);
}

function gc_eb_update_course_data($wp_course_id, $course_data, $sync_options)
{
    // data for the field
    foreach ($sync_options as $key => $value) {
        if (strpos($key, 'eb_update_course_fields_') !== false) {
            if ($value) {
                $method = substr($key, 24);
                $selector = 'field_course_' . $method;
                update_field($selector, $course_data->$method, $wp_course_id);
            }
        }
    }
}
