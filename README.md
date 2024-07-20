# TechFest'24 - IIT Bombay Hostel Allocation WebApp

A WebApp and Algorithm to manage the TechFest'24 Hostel Allocation process

Room Allocation Web Application
Overview
This web application facilitates the digitalization of the hospitality process for group accommodation. It allows users to upload two CSV files containing group information and hostel room details, respectively. The application then allocates rooms based on specified criteria and generates an output CSV file with allocation details.

Instructions
Requirements

Web server with PHP support (PHP 5.6+ recommended).
Modern web browser.
Installation

Download or clone the repository to your local environment or web server directory.
File Structure

Ensure the following files are present:
index.php: PHP script for room allocation.
readme.txt: Instructions for users.
index.html (optional): Form for file uploads (can be integrated into index.php).
Usage

Access the application through your web browser using the appropriate URL (e.g., http://localhost/room-allocation/index.html,upload.php).
Upload Files

Click on the "Choose File" buttons to upload the following CSV files:
File 1 (Group Information): Contains details about groups with a common ID, number of members, and gender.
File 2 (Hostel Information): Provides information about hostels, including room numbers, capacities, and gender accommodations.
Room Allocation

After uploading both CSV files, click on the "Allocate Rooms" button.
The application will process the data and allocate rooms based on the following criteria:
Members of the same group (same ID) stay together in the same room.
Boys and girls stay in their respective hostels.
Room capacities are respected (capacity not exceeded).
Output

Once processing is complete, the application generates an output CSV file (room_allocations.csv) containing the following details:
Group ID
Hostel Name
Room Number
Number of Members Allocated
Download Results

The output CSV file will automatically download or prompt for download depending on your browser settings.
Check your browser's download location for the file (room_allocations.csv).
Notes

Ensure your CSV files are correctly formatted as per the provided examples (file1.csv and file2.csv).
Verify that your CSV files do not contain headers or extra rows that could interfere with the processing.
Support

