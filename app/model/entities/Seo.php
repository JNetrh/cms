<?php
/**
 * Created by PhpStorm.
 * User: Kuba
 * Date: 10.4.2018
 * Time: 13:12
 */

namespace App\Model\Entities;



use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\Entities\Attributes\Identifier;

/**
 * Doctrine entita
 * @package App\Model\Entities
 * @ORM\Entity
 * @ORM\Table(name="seo")
 */
class Seo {

	use Identifier;



	/**
	 * right name column
	 * @ORM\Column(type="string")
	 */
	protected $keywords;


	/**
	 * right name column
	 * @ORM\Column(type="string")
	 */
	protected $description;


	/**
	 * right name column
	 * @ORM\Column(type="string")
	 */
	protected $favicon;



	/**
	 * @return array of form properties
	 */
	public function getFormProperties(){

		return [
			'id' => $this->getId(),
			'keywords' => $this->getKeywords(),
			'description' => $this->getDescription(),
			'favicon' => $this->getFavicon()
		];
	}



	public function deleteFavicon(){
		$this->setFavicon(null);
	}

	/**
	 * @return int
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @param int $id
	 */
	public function setId( $id ) {
		$this->id = $id;
	}

	/**
	 * @return mixed
	 */
	public function getKeywords() {
		return $this->keywords;
	}

	/**
	 * @param mixed $keywords
	 */
	public function setKeywords( $keywords ) {
		$this->keywords = $keywords;
	}

	/**
	 * @return mixed
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * @param mixed $description
	 */
	public function setDescription( $description ) {
		$this->description = $description;
	}

	/**
	 * @return mixed
	 */
	public function getFavicon() {
		return $this->favicon;
	}

	/**
	 * @param string $favicon
	 */
	public function setFavicon($favicon)
	{
		if(file_exists($this->getFavicon())){
			unlink($this->getFavicon());
		}
		$this->favicon = $favicon;
	}

	/**
	 * @return string
	 */
	public function toString(){
		return 'seo';
	}




}