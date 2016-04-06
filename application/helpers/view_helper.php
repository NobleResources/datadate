<?php

function csrf_field()
{
    $ci =& get_instance();

    $name = $ci->security->get_csrf_token_name();
    $value = $ci->security->get_csrf_hash();

    return "<input type='hidden' name='$name' value='$value'>";
}

function form_field($name, $type, $value = '', $error = '')
{
    $label = ucfirst(str_replace('_', ' ', $name));

    return sprintf(
        '<div class="form-field"><label> %s: <input name="%s" type="%s" value="%s"></label><span class="error">%s</span></div>',
        $label, $name, $type, $value, $error
    );
}