<?php


namespace App\Models;


class ApiResponse
{

    private $message;
    private $success;
    private $data;

    public function __construct($message, $success, $data = null)
    {
        $this->message = $message;
        $this->success = $success;
        $this->data = $data;
    }

    public function response($message, $success, $data = null)
    {
        $this->message = $message;
        $this->success = $success;
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return mixed
     */
    public function getSuccess()
    {
        return $this->success;
    }

    /**
     * @param mixed $success
     */
    public function setSuccess($success)
    {
        $this->success = $success;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }



}
