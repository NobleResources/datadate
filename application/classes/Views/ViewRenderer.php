<?php

namespace DataDate\Views;

use DataDate\Services\UrlGenerator;

class ViewRenderer
{
    /**
     * @var HtmlHelper
     */
    private $html;
    /**
     * @var UrlGenerator
     */
    private $url;

    /**
     * ViewRenderer constructor.
     *
     * @param HtmlHelper   $htmlHelper
     * @param UrlGenerator $urlGenerator
     */
    public function __construct(HtmlHelper $htmlHelper, UrlGenerator $urlGenerator)
    {
        $this->html = $htmlHelper;
        $this->url = $urlGenerator;
    }

    /**
     * @param View $view
     *
     * @return mixed
     */
    public function render(View $view)
    {
        $this->html->setErrors($view->getErrors());
        $this->html->setOld($view->getOld());
        $this->html->setModel($view->getModel());

        ob_start();
        extract($view->getData(), EXTR_OVERWRITE);
        include $view->getPath();
        $content = ob_get_clean();

        ob_start();
        include VIEWPATH . 'layouts/main.php';

        return ob_get_clean();
    }
}