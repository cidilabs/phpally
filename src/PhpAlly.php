<?php

namespace CidiLabs\PhpAlly;

use DOMDocument;

class PhpAlly {
    public function __construct()
    {

    }

    public function checkOne($content, $ruleId, $options = [])
    {
        return $this->checkMany($content, [$ruleId], $options);
    }

    public function checkMany($content, $ruleIds = [], $options = [])
    {
        $report = new PhpAllyReport();
        $document = $this->getDomDocument($content);

        foreach ($ruleIds as $ruleId) {
            try {
                $className = 'CidiLabs\\PhpAlly\\Rule\\' . $ruleId;
                if (!class_exists($className)) {
                    $report->setError('Rule does not exist.');
                    continue;
                }           

                $rule = new $className($document, $options);
                $rule->check();                

                $report->setIssues($rule->getIssues());
                $report->setErrors($rule->getErrors());
            } catch (\Exception $e) {
                $report->setError($e->getMessage());
            }
        }

        return $report;
    }

    public function getDomDocument($content)
    {
        $dom = new DOMDocument('1.0', 'utf-8');
        $dom->loadHTML('<?xml encoding="utf-8" ?>' . $content, LIBXML_HTML_NODEFDTD | LIBXML_HTML_NOIMPLIED);

        return $dom;
    }

    public function getRuleIds()
    {
        $path = __DIR__ . '/rules.json';
        $json = file_get_contents($path);

        return \json_decode($json, true);
    }
}