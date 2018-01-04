<?php

namespace Org_Heigl\HtmlToPdflib\Style;

use Symfony\Component\CssSelector\CssSelectorConverter;

use DOMAttr;
use DOMXpath;

class Provider {

    private $document;
    private $finder;
    private $cssToXPath;
    private $defaultProperties = [];
    private $macros = [];

    public function __construct(&$document) {
        $this->setDocument($document);
        $this->setFinder(new DOMXpath($document));
        $this->setCssToXPath(new CssSelectorConverter());
    }

    public function applyRule($cssPath, $styleProperties, $preStr = '', $postStr = '') {

        $xpath = $this->getCssToXPath()->toXPath($cssPath);
        $entries = $this->getFinder()->query($xpath);
        $macro = $this->buildMacro(array_replace($this->getDefaultProperties(), $styleProperties));
        
        foreach($entries as $entrie) {
            $entrie->setAttribute('strprefix', $preStr);
            $entrie->setAttribute('strpostfix', $postStr);
            $entrie->setAttribute('macro', $macro->getName());
        }
    }

    private function buildMacro($properties) {
        
        $macros = $this->getMacros();
        $hash = md5(json_encode($properties));
        $macro = current(array_filter($macros, function($macro) use ($hash) {
            return ($macro->getHash() === $hash);
        }));

        if(!$macro) {
            $macro = new Macro();
            $macro->setName('macro_' . $hash);
            $macro->setHash($hash);
            $macro->setProperties($properties);
            $macros[] = $macro;
            $this->setMacros($macros);
        }

        return $macro;
    }

    public function getPdflibMacros() {
        
        $macros = '';
        
        foreach($this->getMacros() as $macro) {
            $attrs = [];
            foreach($macro->getProperties() as $name => $value) {
                $attrs[] = "$name=$value";
            }
            $macros .= "\n\t" . $macro->getName() . ' { ' . implode(' ', $attrs) . ' } ';
        }

        return "<macro { "  . $macros . "\n}>";
    }

    /**
     * Gets the value of document
     * @return mixed
     */
    public function &getDocument() {
        return $this->document;
    }
    
    /**
     * Sets the value of document
     *
     * @param mixed $document
     * @return self
     */
    public function setDocument(&$document) {
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

    /**
     * Gets the value of cssToXPath
     * @return mixed
     */
    public function getCssToXPath() {
        return $this->cssToXPath;
    }
    
    /**
     * Sets the value of cssToXPath
     *
     * @param mixed $cssToXPath
     * @return self
     */
    public function setCssToXPath($cssToXPath) {
         $this->cssToXPath = $cssToXPath;
         return $this;
    }

    /**
     * Gets the value of defaultProperties
     * @return mixed
     */
    public function getDefaultProperties() {
        return $this->defaultProperties;
    }
    
    /**
     * Sets the value of defaultProperties
     *
     * @param mixed $defaultProperties
     * @return self
     */
    public function setDefaultProperties($defaultProperties) {
        $this->defaultProperties = $defaultProperties;
        return $this;
    }
}
