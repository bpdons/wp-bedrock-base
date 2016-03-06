<?php
add_filter('gform_validation', 'custom_validation_message_callback');
function custom_validation_message_callback($validation_result)
{
    $message = '<p>The following errors need to be fixed:</p><ul>';

    foreach ($validation_result['form']['fields'] as $field) {
        if ($field->failed_validation == 1 && strlen($field->errorMessage) > 0) {
            $message .= '<li>' . $field->errorMessage . '</li>';
        }
    }

    $message .= '</ul>';

    $validation_result['form']['overall_message'] = $message;

    return $validation_result;
}

add_filter('gform_validation_message', 'custom_validation_overall_message_callback', 10, 2);
function custom_validation_overall_message_callback($message, $form)
{
    if (isset($form['overall_message'])) {
        $message = '<div class="validation_error">';
        $message .= '<div class="columns large-10 medium-12 small-12 large-offset-1 end">';
        $message .= '<div class="validation-overall-message">';
        $message .= $form['overall_message'];
        $message .= '</div>';
        $message .= '</div>';
        $message .= '</div>';
    }

    return $message;
}

function custom_ajax_loading_gif_callback($image_src, $form)
{
    return get_bloginfo( 'template_directory' ) . '/assets/images/ajax-loader.gif';
}
add_filter('gform_ajax_spinner_url', 'custom_ajax_loading_gif_callback', 10, 2);