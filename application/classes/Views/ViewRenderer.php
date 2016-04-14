<?php

namespace DataDate\Views;

class ViewRenderer
{
    /**
     * @var HtmlHelper
     */
    private $htmlHelper;

    /**
     * ViewRenderer constructor.
     *
     * @param HtmlHelper $htmlHelper
     */
    public function __construct(HtmlHelper $htmlHelper)
    {
        $this->htmlHelper = $htmlHelper;
    }

    /**
     * @param View $view
     *
     * @return mixed
     */
    public function render(View $view)
    {
        $this->htmlHelper->setErrors($view->getErrors());
        $this->htmlHelper->setOld($view->getOld());

        ob_start();
        extract($view->getData(), EXTR_OVERWRITE);
        include $view->getPath();
        $content = ob_get_clean();

        ob_start();
        include VIEWPATH . 'layouts/main.php';

        return ob_get_clean();
    }

    /**
     * @param $name
     * @param $arguments
     *
     * @return mixed
     */
    function __call($name, $arguments)
    {
        return call_user_func_array([$this->htmlHelper, $name], $arguments);
    }
}