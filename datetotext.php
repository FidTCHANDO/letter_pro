<?php 
    function datetotext ($date) {
        // Set the locale to French
        $locale = 'fr_FR';

        // Original date string
        $dateString = "2024-12-26";

        // Create a DateTime object from the string
        $date = DateTime::createFromFormat('Y-m-d', $date);

        // Create an IntlDateFormatter
        $formatter = new IntlDateFormatter(
            $locale,
            IntlDateFormatter::FULL,
            IntlDateFormatter::NONE,
            'Europe/Paris',
            IntlDateFormatter::GREGORIAN,
            'EEEE d MMMM y'
        );

        // Format the date
        $formattedDate = $formatter->format($date);

        // Ensure the first letter is capitalized (if necessary)
        // $formattedDate = ucfirst($formattedDate);

        return $formattedDate;
    }
 ?>