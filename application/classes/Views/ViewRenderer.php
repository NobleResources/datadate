<?php

namespace DataDate\Views;

class ViewRenderer
{
    /**
     * @var View
     */
    private $view;

    /**
     * @param View $view
     *
     * @return mixed
     */
    public function render(View $view)
    {
        $this->view = $view;

        ob_start();
        extract($view->data, EXTR_OVERWRITE);
        include $view->path;

        return ob_get_clean();
    }

    /**
     * @param $field
     *
     * @return string
     */
    public function getFirstError($field)
    {
        if (isset($this->view->data['errors'][$field])) {
            return array_first($this->view->data['errors'][$field]);
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
        return sprintf('<div class="form-row"><button type="submit">%s</button></div>', $label);
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
        return sprintf('<select name="%s" %s >%s</select>', $name, $this->getInputClass($name), $this->options($options));
    }

    /**
     * @param array $options
     *
     * @return string
     */
    public function options($options)
    {
        foreach ($options as $value => $label) {
            $options[$value] = $this->option($value, $label);
        }

        array_prepend($options, $this->option('', '', ['selected', 'disabled']));

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

    public function getModelValue($name)
    {
        $model = $this->getModel();
        if ($model === null) {
            return '';
        }

        $value = $model->$name;

        return $value === null ? '' : $value;
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
        if (isset($this->view->data['old'][$field])) {
            return $this->view->data['old'][$field];
        }

        return $default;
    }

    /**
     * @return mixed
     */
    private function getModel()
    {
        return isset($this->view->data['model']) ? $this->view->data['model'] : null;
    }


    public function errorList()
    {
        return sprintf('<ul class="error-list">%s</ul>', implode('', array_map([$this, 'errorListItem'], $this->getErrors())));
    }

    /**
     * @param $value
     *
     * @return string
     */
    private function errorListItem($value) {
        return sprintf('<li>%s</li>', array_first($value));
    }

    /**
     * @return array
     */
    private function getErrors()
    {
        return isset($this->view->data['errors']) ? $this->view->data['errors'] : [];
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
}