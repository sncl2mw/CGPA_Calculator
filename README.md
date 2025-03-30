Features Implemented:
Student Information Section:

Name, Symbol No., and Date of Birth fields

Marks Input Section:

All 14 subjects with their respective types, credit hours, and full marks

Input validation to ensure marks don't exceed full marks

GPA Calculation:

Implements the provided GPA calculation formula

Handles different full marks (25, 50, 75) appropriately

CGPA Calculation:

Uses the provided formula to calculate overall CGPA

Displays the result in a formatted section

Save Buttons:

"Calculate CGPA" button that also saves data to server

"Save as PDF" button that generates a downloadable PDF report

Backend Integration:

PHP script to save student data as JSON files in a "student_data" directory


Update 1:
Key Features of This Combined Solution:
All-in-One File: Contains both frontend (HTML/CSS/JS) and backend (PHP) code in a single file.

Data Saving:

When the "Calculate CGPA" button is clicked, data is sent to the PHP backend

PHP saves the data as JSON files in a "student_data" directory

Shows success/error messages to the user

PDF Generation:

Uses jsPDF library to create downloadable PDF reports

Includes all student information and results

Responsive Design:

Clean, modern interface that works on different screen sizes

Clear visual feedback for input validation

Complete CGPA Calculation:

Implements all the specified GPA and CGPA formulas

Handles different subject types and full marks appropriately


Update 2:
Key Changes Made:
Added Creator Information:

Added "Coded by Niraj Shrestha" centered below the main header

Added "sncl2mw@gmail.com" below the name

Enhanced PDF Footer:

Added automatic timestamp generation in the PDF footer

Added copyright notice "(c) sncl2mw@gmail.com" to each page of the PDF

The footer appears at the bottom of every page in the generated PDF

Styling Improvements:

Added specific styling for the creator information section

Maintained consistent styling throughout the document

The code now meets all your requirements while maintaining all the original functionality of the CGPA calculator. The PDF generation now includes:

A timestamp showing when the PDF was generated

Your copyright notice on every page

All the original student data and calculation results

Update 3:
Key Changes Made:
Added Grade Column:

Added a "Grade" column to the input table

Added corresponding grade display cells in each row

Implemented Grade Calculation:

Created a gradeMap object to map GPA values to letter grades

Added a getGrade() function to convert GPA to letter grade

Updated the calculation function to display grades

Updated PDF Output:

Added the Grade column to the PDF output table

Included grade information in the generated PDF

Data Saving:

Updated the data saving functionality to include grade information in the saved JSON

The grade mapping follows this scale:

A+ (4.0)

A (3.6)

B+ (3.2)

B (2.8)

C+ (2.4)

C (2.0)

D+ (1.6)

NG (0.0)
