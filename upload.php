<?php
// Aditya Rao - 23f3000019@es.study.iitm.ac.in
// TechFest CA Program WebApp Submission

function readCSV($filename) {
    $rows = [];
    if (($handle = fopen($filename, "r")) !== false) {
        while (($data = fgetcsv($handle, 1000, ",")) !== false) {
            $rows[] = $data;
        }
        fclose($handle);
    }
    return $rows;
}

// Function to write CSV file
function writeCSV($data, $filename) {
    $fp = fopen($filename, 'w');
    foreach ($data as $fields) {
        fputcsv($fp, $fields);
    }
    fclose($fp);
}

// Function to allocate rooms based on criteria
function allocateRooms($groups, $hostels) {
    $allocations = [];

    // Sort groups by number of members (descending order)
    usort($groups, function($a, $b) {
        return $b[1] - $a[1];
    });

    // Initialize room capacities
    $roomCapacities = [];

    foreach ($hostels as $hostel) {
        $roomCapacities[$hostel[1]] = $hostel[2];
    }

    // Allocate rooms
    foreach ($groups as $group) {
        $groupID = $group[0];
        $members = $group[1];
        $gender = strtolower($group[2]);

        foreach ($hostels as $hostel) {
            $hostelName = strtolower($hostel[0]);
            $roomNumber = $hostel[1];
            $capacity = $hostel[2];
            $hostelGender = strtolower($hostel[3]);

            // Check if room matches gender and has capacity
            if (($hostelGender === 'mixed' || $hostelGender === $gender) &&
                $roomCapacities[$roomNumber] >= $members) {

                // Allocate group to this room
                $allocations[] = [
                    'Group ID' => $groupID,
                    'Hostel Name' => $hostelName,
                    'Room Number' => $roomNumber,
                    'Members Allocated' => $members
                ];

                // Update room capacity
                $roomCapacities[$roomNumber] -= $members;
                break; // Allocate to one room per group
            }
        }
    }

    return $allocations;
}

// Main script
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle file uploads
    if ($_FILES["file1"]["error"] == UPLOAD_ERR_OK && $_FILES["file2"]["error"] == UPLOAD_ERR_OK) {
        $file1 = $_FILES["file1"]["tmp_name"];
        $file2 = $_FILES["file2"]["tmp_name"];

        // Read CSV files
        $groups = readCSV($file1);
        $hostels = readCSV($file2);

        // Remove header rows
        if (!empty($groups)) {
            array_shift($groups); // Remove header row
        }
        if (!empty($hostels)) {
            array_shift($hostels); // Remove header row
        }

        // Allocate rooms
        $allocations = allocateRooms($groups, $hostels);

        // Prepare CSV output
        $output = [
            ['Group ID', 'Hostel Name', 'Room Number', 'Members Allocated']
        ];

        foreach ($allocations as $allocation) {
            $output[] = [
                $allocation['Group ID'],
                $allocation['Hostel Name'],
                $allocation['Room Number'],
                $allocation['Members Allocated']
            ];
        }

        // Write CSV file for output
        $outputFileName = 'room_allocations.csv';
        writeCSV($output, $outputFileName);

        // Provide download link to the user
        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename=' . $outputFileName);
        readfile($outputFileName);
        exit;
    } else {
        echo "Error uploading files.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>TechFest-24 Room Allocation</title>
</head>
<body>
    <h2>TechFest-24 Room Allocation</h2>
    <form method="post" enctype="multipart/form-data">
        <label for="file1">Upload File 1 (Group Information CSV):</label>
        <input type="file" name="file1" id="file1" accept=".csv"><br><br>
        <label for="file2">Upload File 2 (Hostel Information CSV):</label>
        <input type="file" name="file2" id="file2" accept=".csv"><br><br>
        <input type="submit" value="Allocate Rooms">
    </form>
</body>
</html>
