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
    protected ?int $id = null;
    protected ?string $permalink = null;
    protected ?string $message = null;
    protected ?int $count = 0;

    /**
     * @param int|null $count
     *
     * @return EcResponse
     */
    public function setCount(?int $count)
    {
        $this->count = $count;
        return $this;
    }
    /**
     * @param int|null $id
     *
     * @return $this
     */
    public function setId(?int $id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param string $permalink
     *
     * @return $this
     */
    public function setPermalink(string $permalink)
    {
        $this->permalink = $permalink;
        return $this;
    }

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

    /**
     * @param string|null $message
     *
     * @return EcResponse
     */
    public function setMessage(?string $message)
    {
        $this->message = $message;
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
            'id' => $this->id,
            'permalink' => $this->permalink,
            'message' => $this->message,
            'itemsCount' => $this->count,
        ];
        echo json_encode($response);
        wp_die();
    }
}