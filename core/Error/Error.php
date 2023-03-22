<?php

namespace Core\Error;

class Error
{
    private $error;

    public function danger($message, $name)
    {
        $this->error .= "\"$name\": \"$message\",";
        return $this;
    }

    public function alert($message, $name)
    {
        $this->error .= "\"$name\": \"$message\",";
        return $this;
    }

    public function success($message, $name)
    {
        $this->error .= "\"$name\": \"<li class='success'>$message</li>\",";
        return $this;
    }

    public function getErrorMessage()
    {
        return $this->error;
    }

    public function setError($error)
    {
        $this->error = "";
        return $this->error;
    }

    public function getView()
    {
        return "{" . substr($this->error, 0, -1) . "}";
    }
}
