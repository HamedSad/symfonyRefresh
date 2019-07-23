<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class ProjectSearch {

    /**
     * @var int | null
     */
    private $maxArea;

    /**
     * @var int | null
     */
    private $minSurface;

    
    /**
     * Get | null
     *
     * @return  int
     */ 
    public function getMaxArea()
    {
        return $this->maxArea;
    }

    /**
     * Set | null
     *
     * @param  int  $maxArea  | null
     *
     * @return  self
     */ 
    public function setMaxArea(int $maxArea)
    {
        $this->maxArea = $maxArea;

        return $this;
    }

    /**
     * Get | null
     *
     * @return  int
     */ 
    public function getMinSurface()
    {
        return $this->minSurface;
    }

    /**
     * Set | null
     *
     * @param  int  $minSurface  | null
     *
     * @return  self
     */ 
    public function setMinSurface(int $minSurface)
    {
        $this->minSurface = $minSurface;

        return $this;
    }
}