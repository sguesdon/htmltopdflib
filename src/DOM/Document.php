<?php

namespace Org_Heigl\HtmlToPdflib\DOM;

use DOMDocument;

class Document extends DOMDocument {

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
}
