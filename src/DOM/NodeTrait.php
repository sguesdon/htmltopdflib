<?php

namespace Org_Heigl\HtmlToPdflib\DOM;

use DOMAttr;
use Org_Heigl\HtmlToPdflib\Style\Macro;

trait NodeTrait {

    /**
     * [getPdfLibString description]
     * @return [type] [description]
     */
    public function getPdfLibString() {

        $content = '';

        $strPrefix = $this->getAttribute('strprefix');
        $strPostfix = $this->getAttribute('strpostfix');
        
        $macroTag = '';
        if($this->getAttribute('macro')) {
            $macroTag = '<&' . $this->getAttribute('macro') . '>';
        }
        
        $prevMacroTag = '';
        $prevMacroName = $this->getParentMacro();

        if($prevMacroName) {
            $prevMacroTag = '<&' . $prevMacroName . '>';
        }
        
        foreach ($this->childNodes as $child) {
            if(XML_TEXT_NODE === $child->nodeType) {
                $content .= $child->textContent;
            } else {
                $content .= $child->getPdfLibString();
            }
        }

        return $macroTag
             . $strPrefix
             . $content
             . $strPostfix
             . $prevMacroTag;
    }

    private function getParentMacro($node = false) {
        
        $macro = false;
        
        if($node === false) {
            $node = $this->parentNode;
        }

        if($node->nodeType !== XML_HTML_DOCUMENT_NODE) {
            $macro = $node->getAttribute('macro');
            if(!$macro) {
                if(isset($node->parentNode)) {
                    $macro = $this->getParentMacro($node->parentNode);
                }
            }
        }

        return $macro;
    }
}
