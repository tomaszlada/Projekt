<?php

namespace AppBundle\Entity;

/**
 *
 * @author Tomek
 *        
 */
class PageInfo {
	
	private $title;
	private $description;
	
	
	public function PageInfo($title, $description){
		$this->title = $title;
		$this->description = $description;
	}

	public function getTitle() {
		return $this->title;
	}
	public function setTitle($title) {
		$this->title = $title;
		return $this;
	}
	public function getDescription() {
		return $this->description;
	}
	public function setDescription($description) {
		$this->description = $description;
		return $this;
	}
}