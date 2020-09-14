<?php

namespace CidiLabs\PhpAlly;

class PhpAllyReport implements \JsonSerializable {
    protected $issues = [];
    protected $errors = [];
    protected $html = '';

    public function __construct()
    {
    }

    public function toArray()
    {
        return [
            'issues' => $this->getIssues(),
            'errors' => $this->getErrors(),
        ];
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }

    public function __toString()
    {
        return \json_encode($this->toArray());        
    }

    public function getIssues()
    {
        return $this->issues;
    }

    public function setIssue($issue)
    {
        $this->issues[] = $issue;
    }

    public function setIssues($issues)
    {
        $this->issues = array_merge($this->issues, $issues);
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function setError($error)
    {
        $this->errors[] = $error;
    }

    public function setErrors($errors)
    {
        $this->errors = array_merge($this->errors, $errors);
    }

}