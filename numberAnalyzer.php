<?php

function getNumbersFromInput($input) {
    $input = trim($input);
    $parts = explode(" ", $input);
    $numbers = [];
    $invalids = [];

    foreach ($parts as $part) {
        if ($part === '') continue; // skip empty values (e.g., double spaces)
        if (!is_numeric($part)) {
            $invalids[] = $part;
        } else {
            $numbers[] = floatval($part);
        }
    }

    if (!empty($invalids)) {
        return [
            "error" => true,
            "invalids" => $invalids
        ];
    }

    return [
        "error" => false,
        "numbers" => $numbers
    ];
}

function displayResults($numbers) {
    $max = max($numbers);
    $min = min($numbers);
    $sum = array_sum($numbers);
    $avg = $sum / count($numbers);

    echo "\n=== Results ===\n";
    echo "Maximum: " . $max . "\n";
    echo "Minimum: " . $min . "\n";
    echo "Sum: " . $sum . "\n";
    echo "Average: " . number_format($avg, 2) . "\n\n";
}

// Main loop
while (true) {
    echo "Enter a list of numbers separated by spaces (or type 'exit' to quit): ";
    $input = trim(fgets(STDIN));

    if (strtolower($input) === "exit") {
        echo "Exiting program. Goodbye!\n";
        break;
    }

    $result = getNumbersFromInput($input);

    if ($result["error"]) {
        $invalidList = implode(", ", $result["invalids"]);
        echo "Invalid input: The following value(s) are not valid numbers: $invalidList\n\n";
        continue;
    }

    $numbers = $result["numbers"];

    if (count($numbers) === 0) {
        echo "No valid numbers entered. Please try again.\n\n";
        continue;
    }

    displayResults($numbers);
}