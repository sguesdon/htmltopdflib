<?php

namespace Org_Heigl\HtmlToPdflib\Style;

class Provider {

    private $document;
    private $finder;
    private $macros = [];

    public function __construct($document) {
        $this->setDocument($document);
        $this->setFinder(new DOMXpath($document));
    }

    public function applyRule($xpath, $preffix, $suffix, $styleProperties) {
        //$this->getFinder()->query()
    }

    /**
     * Gets the value of document
     * @return mixed
     */
    public function getDocument() {
        return $this->document;
    }
    
    /**
     * Sets the value of document
     *
     * @param mixed $document
     * @return self
     */
    public function setDocument($document) {
         $this->document = $document;
         return $this;
    }

    /**
     * Gets the value of macros
     * @return mixed
     */
    public function getMacros() {
        return $this->macros;
    }
    
    /**
     * Sets the value of macros
     *
     * @param mixed $macros
     * @return self
     */
    public function setMacros($macros) {
         $this->macros = $macros;
         return $this;
    }

    /**
     * Gets the value of finder
     * @return mixed
     */
    public function getFinder() {
        return $this->finder;
    }
    
    /**
     * Sets the value of finder
     *
     * @param mixed $finder
     * @return self
     */
    public function setFinder($finder) {
         $this->finder = $finder;
         return $this;
    }
}
