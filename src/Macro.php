<?php

namespace Org_Heigl\HtmlToPdflib;

class Macro {

    private $tagName;

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
}
