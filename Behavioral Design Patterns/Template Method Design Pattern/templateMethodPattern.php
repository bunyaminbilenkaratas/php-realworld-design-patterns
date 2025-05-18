<?php

abstract class ReportGenerator
{
    public final function generateReport()
    {
        $data = $this->loadData();
        $processedData = $this->processData($data);
        $report = $this->formatReport($processedData);
        $this->saveReport($report);
    }

    abstract protected function loadData();
    abstract protected function processData($data);

    protected function formatReport($processedData)
    {
        // Default formatting logic
        return json_encode($processedData, JSON_PRETTY_PRINT);
    }

    protected function saveReport($report)
    {
        // Default save logic
        file_put_contents('report.json', $report);
    }
}

class CSVReportGenerator extends ReportGenerator
{
    protected function loadData()
    {
        // Load data from a CSV file
        // return array_map('str_getcsv', file('data.csv'));
        // Simulating CSV data for demonstration
        return [
            ['name' => 'John Doe','age' => 30, 'city'  =>  'New York'],
            ['name' => 'Jane Smith','age' => 25, 'city'  =>  'Los Angeles'],
            ['name' => 'Sam Brown','age' => 22, 'city'  =>  'Chicago'],
        ];
    }

    protected function processData($data)
    {
        // Process the CSV data
        $totalAge = 0;
        foreach ($data as $row) {
            $totalAge += $row['age'];
        }
        $averageAge = $totalAge / count($data);
        return ['average_age' => $averageAge];
    }

}

class JsonReportGenerator extends ReportGenerator
{
    protected function loadData()
    {
        // Load data from a JSON file
        // return json_decode(file_get_contents('data.json'), true);
        // Simulating JSON data for demonstration
        return [
            ['Name' => 'John Doe', 'Age' => 30, 'City' => 'New York'],
            ['Name' => 'Jane Smith', 'Age' => 25, 'City' => 'Los Angeles'],
        ];
    }

    protected function processData($data)
    {
        // Process the JSON data
        $totalAge = 0;
        foreach ($data as $row) {
            $totalAge += $row['Age'];
        }
        $averageAge = $totalAge / count($data);
        return ['average_age' => $averageAge];
    }
}

// Usage
$csvReportGenerator = new CSVReportGenerator();
$csvReportGenerator->generateReport();

$jsonReportGenerator = new JsonReportGenerator();
$jsonReportGenerator->generateReport();
