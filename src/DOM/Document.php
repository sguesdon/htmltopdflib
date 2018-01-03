<?php

namespace Org_Heigl\HtmlToPdflib\DOM;

use DOMDocument;

class Document extends DOMDocument {

    public function __construct($version = '1.0', $charset = 'UTF-8') {
        parent::__construct(...func_get_args());
    }

    public function getPdfLibString() {

        $content = '';

        foreach ($this->childNodes as $child) {
            switch($child->nodeType) {
                case XML_TEXT_NODE:
                    $content .= $child->textContent;
                    break;
                case XML_ELEMENT_NODE:
                    $content .= $child->getPdfLibString();
                    break;
            }
        }

        return $content;
    }

    public function loadHtml($html, $options = NULL) {
        parent::loadHtml('<?xml encoding="UTF-8">' . $html);
    }
}
