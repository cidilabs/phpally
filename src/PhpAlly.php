<?php

namespace CidiLabs\PhpAlly;

use DOMDocument;

class PhpAlly {
    protected $report;

    public function __construct()
    {
        $this->report = new PhpAllyReport();
    }

    public function checkOne($html, $ruleId, $options = [])
    {
        $className = 'CidiLabs\\PhpAlly\\Rule\\' . $ruleId;
        if (!class_exists($className)) {
            $this->report->setError('Rule does not exist.');
        }

        $document = $this->getDomDocument($html);

        if (!$document) {
            $this->report->setError('Failed to load HTML document.');
        }
        else {
            $rule = new $className($document, $options);
            $rule->check();

            $this->report->setIssues($rule->getIssues());
            $this->report->setErrors($rule->getErrors());
        }

        return $this->report;
    }

    public function checkMany($content, $ruleIds = [], $options = [])
    {
        $document = $this->getDomDocument($content);

        foreach ($ruleIds as $ruleId) {
            $className = 'CidiLabs\\PhpAlly\\Rule\\' . $ruleId;
            if (!class_exists($className)) {
                $this->report->setError('Rule does not exist.');
            }           

            $rule = new $className($document, $options);
            $rule->check();

            $this->report->setIssues($rule->getIssues());
            $this->report->setErrors($rule->getErrors());
        }

        return $this->report;
    }

    public function getReport($options = [])
    {
        return $this->report;
    }

    public function getDomDocument($content)
    {
        $dom = new DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($content);

        return $dom;
    }
}