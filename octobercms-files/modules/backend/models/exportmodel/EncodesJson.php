<?php namespace Backend\Models\ExportModel;

/**
 * EncodesJson format for import
 */
trait EncodesJson
{
    /**
     * encodeArrayValueForJson
     */
    protected function encodeArrayValueForJson(array $data)
    {
        return $data;
    }

    /**
     * processExportDataAsJson returns the export data as a JSON string
     */
    protected function processExportDataAsJson($columns, $results, $options)
    {
        // Parse options
        $options = array_merge([
            'useOutput' => false,
        ], $options);

        $result = [];

        // Add records
        foreach ($results as $data) {
            $row = [];
            foreach ($columns as $column => $label) {
                $row[$column] = array_get($data, $column);
            }

            $result[] = $row;
        }

        // Output
        if ($options['useOutput']) {
            echo json_encode($result, JSON_PRETTY_PRINT);
            return;
        }

        return json_encode($result, JSON_PRETTY_PRINT);
    }
}
