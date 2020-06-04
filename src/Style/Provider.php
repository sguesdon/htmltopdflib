<?php
/**
 * Copyright (c)2014-2014 heiglandreas
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIBILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @category
 * @author    Andreas Heigl<andreas@heigl.org>
 * @copyright ©2018-2018 NR-Communication
 * @license   http://www.opesource.org/licenses/mit-license.php MIT-License
 * @version   0.1
 * @since     04.01.2018
 * @link      https://github.com/NRCommunication/htmltopdflib
 */

namespace NRCommunication\HtmlToPdflib\Style;

use Symfony\Component\CssSelector\CssSelectorConverter;

use DOMAttr;
use DOMXpath;

class Provider {

    private $document;
    private $finder;
    private $cssToXPath;
    private $macros = [];

    public function __construct(&$document) {
        $this->setDocument($document);
        $this->setFinder(new DOMXpath($document));
        $this->setCssToXPath(new CssSelectorConverter());
    }

    public function applyRule($cssPath, $styleProperties, $preStr = '', $postStr = '') {

        $xpath = $this->getCssToXPath()->toXPath($cssPath);
        $entries = $this->getFinder()->query($xpath);

        foreach($entries as $entrie) {

            $properties = $styleProperties;
            $prevMacroAttrs = $entrie->getAttribute('macroAttrs');
            if($prevMacroAttrs) {
                $properties = array_replace(
                    (array)json_decode($prevMacroAttrs),
                    $properties
                );
            }

            if($entrie->hasAttribute('style')) {
                $styleProps = explode(';', $entrie->getAttribute('style'));
                foreach($styleProps as $prop) {
                    if(preg_match('#^.+?:.+?$#', $prop)) {
                        [$propName, $propValue] = array_map('trim', explode(':', $prop));
                        switch(trim($propName)) {
                            case 'text-align':
                                switch(trim($propValue)) {
                                    case 'center':
                                        $properties['alignment'] = 'center';
                                        break;
                                    case 'left':
                                        $properties['alignment'] = 'left';
                                        break;
                                    case 'right':
                                        $properties['alignment'] = 'right';
                                        break;
                                    case 'justify':
                                        $properties['alignment'] = 'justify';
                                        break;
                                }
                                break;
                        }
                    }
                }
            }

            $entrie->setAttribute('strprefix', $preStr);
            $entrie->setAttribute('strpostfix', $postStr);
            $entrie->setAttribute('macroAttrs', json_encode($properties));
        }

        return $this;
    }

    public function buildMacros($initialAttributes = [], $node = false, $level = 0) {

        if($node === false) {
            $node = $this->getDocument();
        }

        if($node->hasChildNodes()) {
            foreach($node->childNodes as $childNode) {

                $finalAttributes = $initialAttributes;

                if($childNode->hasAttributes()) {

                    // getting macro attributes
                    $macroAttrs = $childNode->getAttribute('macroAttrs');

                    if($macroAttrs) {

                        // mixin prev attributes and macro attributes
                        $finalAttributes = array_replace(
                            $initialAttributes,
                            (array)json_decode($macroAttrs)
                        );

                        // building macro and setting macro name in node
                        $macro = $this->buildMacro($finalAttributes);
                        $childNode->setAttribute('macro', $macro->getName());
                    }
                }

                // with children nodes reinjecing extended attributes
                $this->buildMacros($finalAttributes, $childNode, $level+1);
            }
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
            $macro->setName('m' . count($macros));
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
}
