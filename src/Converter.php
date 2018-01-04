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

namespace Org_Heigl\HtmlToPdflib;

use Org_Heigl\HtmlToPdflib\DOM\Document as Document;
use Org_Heigl\HtmlToPdflib\Style\Provider as StyleProvider;
use DOMXpath;

class Converter
{
    private $domDoc;
    private $allowedTags = [];
    private $styleProvider;

    public function __construct() {
        $this->domDoc = new Document('1.0', 'UTF-8');
        $this->domDoc->registerNodeClass('DOMNode' , 'Org_Heigl\HtmlToPdflib\DOM\Node');
        $this->domDoc->registerNodeClass('DOMElement' , 'Org_Heigl\HtmlToPdflib\DOM\Element');
    }

    public function build($text) {

        if(count($this->allowedTags) > 0) {
            $text = strip_tags($text, implode($this->allowedTags));
        }
        
        $this->domDoc->loadHTML('<?xml encoding="UTF-8">' . $text);
        $this->styleProvider = new StyleProvider($this->domDoc);
    }

    public function convert() {
        $this->styleProvider->buildMacros();
        return $this->styleProvider->getPdflibMacros() . $this->domDoc->getPdflibString();
    }

    /**
     * Gets the value of allowedTags
     * @return mixed
     */
    public function getAllowedTags() {
        return $this->allowedTags;
    }
    
    /**
     * Sets the value of allowedTags
     *
     * @param mixed $allowedTags
     * @return self
     */
    public function setAllowedTags($allowedTags) {
         $this->allowedTags = $allowedTags;
         return $this;
    }

    /**
     * Gets the value of styleProvider
     * @return mixed
     */
    public function getStyleProvider() {
        return $this->styleProvider;
    }
    
    /**
     * Sets the value of styleProvider
     *
     * @param mixed $styleProvider
     * @return self
     */
    public function setStyleProvider($styleProvider) {
         $this->styleProvider = $styleProvider;
         return $this;
    }
} 
