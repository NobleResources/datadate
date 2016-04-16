<?php

namespace DataDate\Views;

use DataDate\Database\Models\Model;

class HtmlHelper
{
    /**
     * @var Model
     */
    private $model;
    /**
     * @var array
     */
    private $errors = [];
    /**
     * @var array
     */
    private $old = [];

    /**
     * @param $name
     *
     * @return string
     */
    public function firstError($name)
    {
        if (isset($this->errors[$name])) {
            return array_first($this->errors[$name]);
        }

        return '';
    }

    /**
     * @return string
     */
    public function csrfField()
    {
        $ci =& get_instance();

        $name = $ci->security->get_csrf_token_name();
        $value = $ci->security->get_csrf_hash();

        return "<input type='hidden' name='$name' value='$value'>";
    }

    public function display($name)
    {
        return $this->formRow($this->formatLabel($name), sprintf('<div>%s</div>', $this->getModelValue($name)));
    }

    /**
     * @param string $name
     * @param string $type
     * @param bool   $rememberOld
     * @param array  $attributes
     *
     * @return mixed
     */
    public function input($name, $type, $rememberOld = true, $attributes = [])
    {
        $attributes = $this->maybeAddError($name, $attributes);
        $attributes = $this->attributeList($attributes);

        $value = $this->getValue($name, $rememberOld);

        $input = sprintf('<input name="%s" type="%s" value="%s" %s>', $name, $type, $value, $attributes);

        return $this->formRow($this->formatLabel($name), $input);
    }

    /**
     * @param string $name
     * @param bool   $rememberOld
     *
     * @return string
     */
    public function textArea($name, $rememberOld = true)
    {
        $value = $this->getValue($name, $rememberOld);

        $textArea = sprintf('<textarea name="%s">%s</textarea>', $name, $value);

        return $this->formRow($this->formatLabel($name), $textArea);
    }

    /**
     * @param string $name
     * @param array  $options
     * @param array  $attributes
     *
     * @return mixed
     */
    public function select($name, $options, $attributes = [])
    {
        $attributes = $this->maybeAddError($name, $attributes);
        $attributes = $this->attributeList($attributes);

        $options = $this->options($options, $this->getOld($name, null));

        $select = sprintf('<select name="%s" %s >%s</select>', $name, $attributes, $options);

        return $this->formRow($this->formatLabel($name), $select);
    }

    /**
     * @param array       $options
     *
     * @param string|null $selected
     *
     * @return string
     */
    public function options($options, $selected = null)
    {
        foreach ($options as $value => $label) {
            $options[$value] = $this->option($value, $label, $selected === $value ? ['selected'] : []);
        }

        array_prepend($options, $this->option('', '', isset($selected) ? ['disabled'] : ['disabled', 'selected']));

        return implode('', $options);
    }

    /**
     * @param       $value
     * @param       $label
     *
     * @param array $attributes
     *
     * @return mixed
     */
    private function option($value, $label, $attributes = [])
    {
        return sprintf('<option value="%s" %s>%s</option>', $value, $this->attributeList($attributes), $label);
    }

    /**
     * @param $label
     *
     * @return mixed
     */
    public function submit($label)
    {
        return $this->formRow('', sprintf('<button type="submit">%s</button>', $label));
    }

    /**
     * @return mixed
     */
    public function errorList()
    {
        return sprintf('<ul class="error-list">%s</ul>', implode('', array_map([$this, 'errorListItem'], $this->errors)));
    }

    /**
     * @param $value
     *
     * @return string
     */
    private function errorListItem($value)
    {
        return sprintf('<li>%s</li>', array_first($value));
    }

    /**
     * @param $name
     *
     * @return mixed
     */
    private function formatLabel($name)
    {
        return ucfirst(str_replace('_', ' ', $name));
    }

    /**
     * @param $label
     * @param $input
     *
     * @return mixed
     */
    private function formRow($label, $input)
    {
        return sprintf('<div class="row"><label>%s</label>%s</div>', $label, $input);
    }

    /**
     * @param $attributes
     *
     * @return string
     */
    private function attributeList($attributes)
    {
        if (empty($attributes)) {
            return '';
        }

        foreach ($attributes as $name => $value) {
            $attributes[$name] = $this->attribute($name, $value);
        }

        return implode(' ', $attributes);
    }

    /**
     * @param $name
     * @param $value
     *
     * @return string
     */
    private function attribute($name, $value)
    {
        if (is_int($name)) {
            return $value;
        }

        return sprintf('%s="%s"', $name, $value);
    }

    /**
     * @param $name
     * @param $rememberOld
     *
     * @return string
     */
    private function getValue($name, $rememberOld)
    {
        return $rememberOld ? $this->getOld($name, $this->getModelValue($name)) : '';
    }

    /**
     * @param $name
     *
     * @return string
     */
    private function getModelValue($name)
    {
        if (isset($this->model->$name)) {
            return $this->model->$name;
        }

        return '';
    }

    /**
     * @param string $field
     *
     * @param string $default
     *
     * @return string
     */
    private function getOld($field, $default = '')
    {
        if (isset($this->old[$field])) {
            return $this->old[$field];
        }

        return $default;
    }


    /**
     * @param $old
     */
    public function setOld($old)
    {
        $this->old = $old;
    }

    /**
     * @return array
     */
    private function getErrors()
    {
        return isset($this->errors) ? $this->errors : [];
    }

    /**
     * @param $errors
     */
    public function setErrors($errors)
    {
        $this->errors = $errors;
    }

    /**
     * @param $name
     *
     * @return bool
     */
    private function hasError($name)
    {
        return isset($this->errors[$name]);
    }

    /**
     * @param Model|null $model
     */
    public function setModel($model)
    {
        $this->model = $model;
    }

    /**
     * @param $name
     * @param $attributes
     *
     * @return mixed
     */
    private function maybeAddError($name, $attributes)
    {
        if ($this->hasError($name)) {
            $attributes['class'] = 'error-input';
            return $attributes;
        }
        return $attributes;
    }
}