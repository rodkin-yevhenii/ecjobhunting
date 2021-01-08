<?php


namespace EcJobHunting\Front;

use \EcJobHunting\Interfaces\AjaxResponse;

class EcResponse implements AjaxResponse
{
    protected ?int $status = 0;
    protected ?int $paged = 1;
    protected ?bool $isEnd = false;
    protected ?string $body = '';
    protected ?string $order = '';
    protected ?string $s = '';
    protected ?int $total = 0;

    public function setStatus(int $status)
    {
        $this->status = $status;
        return $this;
    }

    public function setPaged(int $paged)
    {
        $this->paged = $paged;
        return $this;
    }

    public function setIsEnd(bool $isEnd)
    {
        $this->isEnd = $isEnd;
        return $this;
    }

    public function setResponseBody(string $html)
    {
        $this->body = $html;
        return $this;
    }

    public function setOrder(string $order)
    {
        $this->order = $order;
        return $this;
    }

    public function setSearchKeyword(string $s)
    {
        $this->s = $s;
        return $this;
    }

    public function setTotal(?int $total)
    {
        $this->total = $total;
        return $this;
    }

    public function send(): string
    {
        $response = [
            'status' => $this->status,
            'paged' => $this->paged,
            'isEnd' => $this->isEnd,
            'html' => $this->body,
            'orderby' => $this->order,
            's' => $this->s,
            'total' => $this->total,
        ];
        echo json_encode($response);
        wp_die();
    }
}