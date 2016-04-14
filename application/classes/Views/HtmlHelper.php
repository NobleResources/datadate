<?php

namespace DataDate\Views;

use DataDate\Database\Model;

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
     * @param $field
     *
     * @return string
     */
    public function getFirstError($field)
    {
        if (isset($this->errors[$field])) {
            return array_first($this->errors[$field]);
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

    public function textArea($name)
    {
        $textArea = sprintf('<textarea name="%s">%s</textarea>', $name, $this->getOld($name));

        return $this->formRow($this->getLabel($name), $textArea);
    }

    /**
     * @param string $name
     * @param string $type
     *
     * @param bool   $rememberOld
     *
     * @return string
     */
    public function formInput($name, $type, $rememberOld = true)
    {
        $value = $this->getValue($name, $rememberOld);

        return $this->formRow($this->getLabel($name), $this->input($name, $type, $value));
    }

    /**
     * @param      $name
     * @param      $options
     * @param bool $rememberOld
     *
     * @return mixed
     */
    public function formSelect($name, $options, $rememberOld = true)
    {
        return $this->formRow($this->getLabel($name), $this->select($name, $options));
    }

    /**
     * @param $label
     *
     * @return mixed
     */
    public function formSubmit($label)
    {
        return $this->formRow('', sprintf('<button type="submit">%s</button>', $label));
    }

    /**
     * @param $label
     * @param $input
     *
     * @return mixed
     */
    private function formRow($label, $input)
    {
        return sprintf('<div class="form-row"><label>%s</label>%s</div>', $label, $input);
    }

    /**
     * @param string $name
     * @param string $type
     * @param string $value
     *
     * @return mixed
     */
    public function input($name, $type, $value)
    {
        if ($type === 'select') {
            return $this->select($name, $value);
        }

        return sprintf('<input name="%s" type="%s" value="%s" %s>', $name, $type, $value, $this->getInputClass($name));
    }

    /**
     * @param string $name
     * @param array  $options
     *
     * @return mixed
     */
    public function select($name, $options)
    {
        $class = $this->getInputClass($name);

        $options = $this->options($options, $this->getOld($name, null));

        return sprintf('<select name="%s" %s >%s</select>', $name, $class, $options);
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
     * @param $name
     *
     * @return mixed
     */
    private function getLabel($name)
    {
        return ucfirst(str_replace('_', ' ', $name));
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
    public function getModelValue($name)
    {
        if (isset($this->model) && isset($this->model->$name)) {
            $this->model->$name;
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
    public function getOld($field, $default = '')
    {
        if (isset($this->old[$field])) {
            return $this->old[$field];
        }

        return $default;
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
     * @return array
     */
    private function getErrors()
    {
        return isset($this->errors) ? $this->errors : [];
    }

    /**
     * @param $name
     *
     * @return string
     */
    private function getInputClass($name)
    {
        $errors = $this->getErrors();
        if (isset($errors[$name])) {
            return 'class="error-input"';
        }

        return '';
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
     * @param $errors
     */
    public function setErrors($errors)
    {
        $this->errors = $errors;
    }

    /**
     * @param $old
     */
    public function setOld($old)
    {
        $this->old = $old;
    }
}