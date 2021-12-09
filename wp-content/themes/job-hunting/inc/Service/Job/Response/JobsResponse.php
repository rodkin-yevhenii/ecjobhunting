<?php

namespace EcJobHunting\Service\Job\Response;

use EcJobHunting\Front\EcResponse;

/**
 * Class JobsResponse
 *
 * @package EcJobHunting\Service\Job\Response
 */
class JobsResponse extends EcResponse
{
    protected bool $isAdded = false;

    /**
     * @param bool $isAdded
     *
     * @return JobsResponse
     */
    public function setIsAdded(bool $isAdded): JobsResponse
    {
        $this->isAdded = $isAdded;
        return $this;
    }

    public function send(): string
    {
        $response = [
            'status' => $this->status,
            'paged' => $this->paged,
            'isEnd' => $this->isEnd,
            'isAdded' => $this->isAdded,
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
