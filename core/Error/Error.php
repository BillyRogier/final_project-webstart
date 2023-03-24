<?php

namespace Core\Error;

class Error
{
    private $error;

    public function danger($message)
    {
        $this->error .= "<li class='danger'>$message</li>";
        return $this;
    }

    public function alert($message)
    {
        $this->error .= "<li class='alert'>$message</li>";
        return $this;
    }

    public function success($message, $name)
    {
        $this->error .= "\"$name\": \"<li class='success'>$message</li>\",";
        return $this;
    }

    public function toJson($array)
    {
        foreach ($array as $name => $propertie) {
            $this->error .= "\"$name\": {";
            foreach ($propertie as $cle => $value) {
                $this->error .= "\"$cle\": \"$value\",";
            }
            $this->error = substr($this->error, 0, -1) . "},";
        }
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
