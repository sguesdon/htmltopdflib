<?php

namespace Org_Heigl\HtmlToPdflib\DOM;

use Org_Heigl\HtmlToPdflib\Style\Macro;


trait NodeTrait {

    private $macro;
    private $prefix = '';
    private $postfix = '';

    public function getPdfLibString() {

        $content = '';
        $tagName = $this->getMacro()->getTagName();
        $previousTagName = $this->getPreviousMacro()->getTagName();
        
        foreach ($this->childNodes as $child) {
            if(XML_TEXT_NODE === $child->nodeType) {
                $content .= $child->textContent;
            } else {
                $content .= $child->getPdfLibString();
            }
        }

        return $tagName
             . $this->prefix
             . $content
             . $this->postfix
             . $previousTagName;
    }

    /**
     * Get previous macro
     * @return Object 
     */
    public function getPreviousMacro() {

        if(!$this->parentNode) {
            return new Macro();
        }

        if($this->parentNode->nodeType === XML_HTML_DOCUMENT_NODE) {
            return new Macro();    
        }

        return $this->parentNode->getMacro();
    }

    /**
     * Set style properties
     * @param Array $styleProperties Style properties pdflib
     */
    public function setStyleProperties($styleProperties) {
        $styleProperties = array_replace(...func_get_args());
        $macro = StyleProvider::lookupMacro($styleProperties, $this->getMacro());
        $this->setMacro($macro);
    }

    /**
     * Gets the value of macro
     * @return mixed
     */
    public function getMacro() {
        if(!$this->macro) {
            $this->macro = new Macro();
        }
        return $this->macro;
    }
    
    /**
     * Sets the value of macro
     *
     * @param mixed $macro
     * @return self
     */
    public function setMacro($macro) {
         $this->macro = $macro;
         return $this;
    }

    /**
     * Gets the value of prefix
     * @return mixed
     */
    public function getPrefix() {
        return $this->prefix;
    }
    
    /**
     * Sets the value of prefix
     *
     * @param mixed $prefix
     * @return self
     */
    public function setPrefix($prefix) {
         $this->prefix = $prefix;
         return $this;
    }

    /**
     * Gets the value of postfix
     * @return mixed
     */
    public function getPostfix() {
        return $this->postfix;
    }
    
    /**
     * Sets the value of postfix
     *
     * @param mixed $postfix
     * @return self
     */
    public function setPostfix($postfix) {
         $this->postfix = $postfix;
         return $this;
    }
}
