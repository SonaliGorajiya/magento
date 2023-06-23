<?php

class Ccc_Practice_Adminhtml_CsvDirectController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $categoryCsvFilePath = "C:\Users\User\Downloads\Csv _file\CATEGORY.csv";
        $attributeOptionCsvFilePath = "C:\Users\User\Downloads\Csv _file\ATTRIBUTE-OPTIONS.csv";
        echo "<pre>";print_r($categoryCsvFile);die();
        $finalCsvFilePath = 'category-attribute-option.csv';

        
        // Open the final CSV file for writing
        $finalCsvFile = fopen($finalCsvFilePath, 'w');

        // Write the CSV header
        $header = ['Category ID', 'Category Name', 'Attribute ID', 'Option'];
        fputcsv($finalCsvFile, $header);

        // Load the category data from the category.csv file and remove duplicate categories
        $categoryCsvData = array_map('str_getcsv', file($categoryCsvFilePath));
        $categoryData = array_unique(array_column($categoryCsvData, 1)); // Get unique category names
        $categoryData = array_values($categoryData); // Reindex the array
        $categoryHeaders = array_shift($categoryData); // Remove the header row

        // Load the attribute-option data from the attribute-option.csv file and remove duplicates
        $attributeOptionData = array_map('str_getcsv', file($attributeOptionCsvFilePath));
        $attributeOptionData = array_unique($attributeOptionData, SORT_REGULAR);
        $attributeOptionHeaders = array_shift($attributeOptionData); // Remove the header row

        // Iterate through each category
        foreach ($categoryData as $categoryName) {
            // Find the category ID based on the category name
            $categoryId = null;
            foreach ($categoryCsvData as $categoryRow) {
                if ($categoryRow[1] === $categoryName) {
                    $categoryId = $categoryRow[0];
                    break;
                }
            }

            // Keep track of written attribute-option combinations
            $writtenCombinations = [];

            // Iterate through each attribute-option mapping
            foreach ($attributeOptionData as $attributeOptionRow) {
                $attributeId = $attributeOptionRow[0];
                $option = $attributeOptionRow[1];

                // Generate a unique key for the attribute-option combination
                $combinationKey = $attributeId . '_' . $option;

                // Check if the combination has been written
                if (!isset($writtenCombinations[$combinationKey])) {
                    // Write the category, attribute, and option to the final CSV file
                    $row = [$categoryId, $categoryName, $attributeId, $option];
                    fputcsv($finalCsvFile, $row);

                    // Mark the combination as written
                    $writtenCombinations[$combinationKey] = true;
                }
            }
        }

        // Close the final CSV file
        fclose($finalCsvFile);

        // Set the file download headers
        $this->_prepareDownloadResponse('category-attribute-option.csv', file_get_contents($finalCsvFilePath));

    }

    public function twoAction()
    {
        $csvMergeObj = Mage::getModel('practice/csvmerge');
        
        $csvMergeObj->setCategoryFile('C:\Users\User\Downloads\Csv _file\CATEGORY.csv');
        $csvMergeObj->setOptionFile('C:\Users\User\Downloads\Csv _file\ATTRIBUTE-OPTIONS.csv');
        $csvMergeObj->setFinalFile('C:\Users\User\Downloads\Csv _file\category-attribute-option.csv');

        $file = $csvMergeObj->run();
        
        $this->_prepareDownloadResponse('category-attribute-option.csv', file_get_contents($file));
    }
}
