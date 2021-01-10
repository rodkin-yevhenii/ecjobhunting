<?php


namespace EcJobHunting\Interfaces;


interface AjaxResponse
{
    public function setStatus(int $status);

    public function setPaged(int $spaged);

    public function setIsEnd(bool $isEnd);

    public function setResponseBody(string $html);

    public function setOrder(string $order);

    public function setSearchKeyword(string $s);

    public function setTotal(?int $total);

    public function send();
}