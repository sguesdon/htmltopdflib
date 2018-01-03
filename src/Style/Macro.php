<?php

namespace Org_Heigl\HtmlToPdflib\Style;

class Macro {

    private $tagName;
    private $hash;
    private $nodes = [];

    /**
     * Sets the value of tagName
     *
     * @param mixed $tagName
     * @return self
     */
    public function setTagName($tagName) {
         $this->tagName = $tagName;
         return $this;
    }

    /**
     * Gets the value of tagName
     * @return mixed
     */
    public function getTagName() {
        return $this->tagName;
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
}
