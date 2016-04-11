<?php
/**
 * Created by PhpStorm.
 * User: Yohan
 * Date: 20/03/2016
 * Time: 14:03
 */

namespace Yohan;


class Publications
{
    private $id;

    private $content;

    private $pdf;

    /**
     * @return mixed
     */
    public function getPdf()
    {
        return $this->pdf;
    }

    /**
     * @param mixed $pdf
     */
    public function setPdf($pdf)
    {
        $this->pdf = $pdf;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }


    public function __contruct(){

    }
}