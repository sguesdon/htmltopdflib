<?php

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
