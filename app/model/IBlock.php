<?php
/**
 * Created by PhpStorm.
 * User: jakub
 * Date: 17/03/2018
 * Time: 16:31
 */

namespace App\Model;


interface IBlock
{
    public function initialize();

    public function databaseInput();

    public function getFormProperties();

    public function getColorProperties();

    public function toString();

    public function setId($id);

    public function deleteImage();
}