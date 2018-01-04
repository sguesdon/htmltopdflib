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

namespace Org_Heigl\HtmlToPdflib\Style;

class Macro {

    private $name;
    private $hash;
    private $properties = [];
    private $nodes = [];

    /**
     * Sets the value of name
     *
     * @param mixed $name
     * @return self
     */
    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    /**
     * Gets the value of name
     * @return mixed
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Gets the value of nodes
     * @return mixed
     */
    public function &getNodes() {
        return $this->nodes;
    }
    
    /**
     * Sets the value of nodes
     *
     * @param mixed $nodes
     * @return self
     */
    public function setNodes(&$nodes) {
         $this->nodes = $nodes;
         return $this;
    }

    /**
     * Gets the value of hash
     * @return mixed
     */
    public function getHash() {
        return $this->hash;
    }
    
    /**
     * Sets the value of hash
     *
     * @param mixed $hash
     * @return self
     */
    public function setHash($hash) {
         $this->hash = $hash;
         return $this;
    }

    /**
     * Gets the value of properties
     * @return mixed
     */
    public function getProperties() {
        return $this->properties;
    }
    
    /**
     * Sets the value of properties
     *
     * @param mixed $properties
     * @return self
     */
    public function setProperties($properties) {
        $this->properties = $properties;
        return $this;
    }
}
