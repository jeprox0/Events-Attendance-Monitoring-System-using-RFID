<?php

if (!function_exists('generateAcronym')) {
    function generateAcronym($phrase)
    {
        // Define words to exclude from the acronym
        $excludeWords = ['of', 'and', 'the', 'in', 'for', 'a', 'to', 'with', 'on', 'by'];

        // Split the phrase into words
        $words = explode(' ', $phrase);
        
        // Generate acronym excluding specified words
        $acronym = '';
        foreach ($words as $word) {
            // Remove any punctuation and check if the word is not in the exclude list
            $cleanWord = preg_replace('/[^a-zA-Z]/', '', $word); // Remove punctuation
            if (!in_array(strtolower($cleanWord), $excludeWords) && !empty($cleanWord)) {
                $acronym .= strtoupper($cleanWord[0]); // Add the first letter of the word
            }
        }
        
        return $acronym;
    }
}

