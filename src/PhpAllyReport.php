<?php

namespace CidiLabs\PhpAlly;

class PhpAllyReport {
    protected $issues = [];
    protected $errors = [];

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