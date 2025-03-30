<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student CGPA Calculator</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"],
        input[type="number"],
        input[type="date"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .button-group {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        button {
            padding: 10px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #45a049;
        }
        #savePdf {
            background-color: #2196F3;
        }
        #savePdf:hover {
            background-color: #0b7dda;
        }
        #result {
            margin-top: 20px;
            padding: 15px;
            background-color: #e8f5e9;
            border-radius: 4px;
            display: none;
        }
        .subject-row {
            background-color: #f9f9f9;
        }
        .full-marks {
            font-size: 0.9em;
            color: #666;
        }
        .server-response {
            margin-top: 10px;
            padding: 10px;
            border-radius: 4px;
            display: none;
        }
        .success {
            background-color: #dff0d8;
            color: #3c763d;
        }
        .error {
            background-color: #f2dede;
            color: #a94442;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Student CGPA Calculator</h1>
        
        <div class="form-group">
            <label for="studentName">Student's Name:</label>
            <input type="text" id="studentName" required>
        </div>
        
        <div class="form-group">
            <label for="symbolNo">Symbol No.:</label>
            <input type="text" id="symbolNo" required>
        </div>
        
        <div class="form-group">
            <label for="dob">Date of Birth:</label>
            <input type="date" id="dob" required>
        </div>
        
        <h2>Enter Marks</h2>
        
        <table>
            <thead>
                <tr>
                    <th>Subject</th>
                    <th>Type</th>
                    <th>Credit Hours</th>
                    <th>Full Marks</th>
                    <th>Obtained Marks</th>
                    <th>GPA</th>
                </tr>
            </thead>
            <tbody id="subjectsTable">
                <!-- Subjects will be added here by JavaScript -->
            </tbody>
        </table>
        
        <div class="button-group">
            <button id="calculateBtn">Calculate CGPA</button>
            <button id="savePdf">Save as PDF</button>
        </div>
        
        <div id="serverResponse" class="server-response"></div>
        
        <div id="result">
            <h3>CGPA Result</h3>
            <p><strong>Student Name:</strong> <span id="resultName"></span></p>
            <p><strong>Symbol No.:</strong> <span id="resultSymbol"></span></p>
            <p><strong>Date of Birth:</strong> <span id="resultDob"></span></p>
            <p><strong>Your CGPA is:</strong> <span id="cgpaValue" style="font-size: 24px; font-weight: bold;"></span></p>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>
    
    <script>
        // Initialize subjects data
        const subjects = [
            { name: "English", type: "Theory", creditHours: 3.75, fullMarks: 75 },
            { name: "English", type: "Practical", creditHours: 1.25, fullMarks: 25 },
            { name: "Nepali", type: "Theory", creditHours: 3.75, fullMarks: 75 },
            { name: "Nepali", type: "Practical", creditHours: 1.25, fullMarks: 25 },
            { name: "Compulsory Mathematics", type: "Theory", creditHours: 3.75, fullMarks: 75 },
            { name: "Compulsory Mathematics", type: "Practical", creditHours: 1.25, fullMarks: 25 },
            { name: "Compulsory Science", type: "Theory", creditHours: 3.75, fullMarks: 75 },
            { name: "Compulsory Science", type: "Practical", creditHours: 1.25, fullMarks: 25 },
            { name: "Social Studies", type: "Theory", creditHours: 3.00, fullMarks: 75 },
            { name: "Social Studies", type: "Practical", creditHours: 1.00, fullMarks: 25 },
            { name: "Optional Mathematics", type: "Theory", creditHours: 3.00, fullMarks: 75 },
            { name: "Optional Mathematics", type: "Practical", creditHours: 1.00, fullMarks: 25 },
            { name: "Optional Computer Science", type: "Theory", creditHours: 3.00, fullMarks: 50 },
            { name: "Optional Computer Science", type: "Practical", creditHours: 1.00, fullMarks: 50 }
        ];

        // Populate subjects table
        const tableBody = document.getElementById('subjectsTable');
        
        subjects.forEach((subject, index) => {
            const row = document.createElement('tr');
            row.className = 'subject-row';
            
            row.innerHTML = `
                <td>${subject.name}</td>
                <td>${subject.type}</td>
                <td>${subject.creditHours}</td>
                <td>${subject.fullMarks}</td>
                <td><input type="number" id="marks${index}" min="0" max="${subject.fullMarks}" step="0.01" required></td>
                <td id="gpa${index}">-</td>
            `;
            
            tableBody.appendChild(row);
        });

        // Calculate GPA for a subject based on marks
        function calculateGPA(marks, fullMarks) {
            // For subjects with full marks 25 or 50, we need to scale them to equivalent of 75
            let percentage;
            if (fullMarks === 25) {
                percentage = (marks / 25) * 100;
            } else if (fullMarks === 50) {
                percentage = (marks / 50) * 100;
            } else {
                percentage = (marks / 75) * 100;
            }
            
            if (percentage > 90) return 4.0;
            if (percentage > 80) return 3.6;
            if (percentage > 70) return 3.2;
            if (percentage > 60) return 2.8;
            if (percentage > 50) return 2.4;
            if (percentage > 40) return 2.0;
            if (percentage > 35) return 1.6;
            return 0.0;
        }

        // Calculate CGPA
        document.getElementById('calculateBtn').addEventListener('click', function() {
            let totalCreditPoints = 0;
            let totalCreditHours = 0;
            let allValid = true;
            
            subjects.forEach((subject, index) => {
                const marksInput = document.getElementById(`marks${index}`);
                const marks = parseFloat(marksInput.value);
                
                if (isNaN(marks) {
                    marksInput.style.border = '1px solid red';
                    allValid = false;
                } else if (marks < 0 || marks > subject.fullMarks) {
                    marksInput.style.border = '1px solid red';
                    allValid = false;
                } else {
                    marksInput.style.border = '1px solid #ddd';
                    const gpa = calculateGPA(marks, subject.fullMarks);
                    document.getElementById(`gpa${index}`).textContent = gpa.toFixed(2);
                    totalCreditPoints += gpa * subject.creditHours;
                    totalCreditHours += subject.creditHours;
                }
            });
            
            if (!allValid) {
                alert('Please enter valid marks for all subjects (0 to full marks).');
                return;
            }
            
            const cgpa = totalCreditPoints / 32; // Total credit hours is 32 as per formula
            
            // Display result
            document.getElementById('resultName').textContent = document.getElementById('studentName').value;
            document.getElementById('resultSymbol').textContent = document.getElementById('symbolNo').value;
            document.getElementById('resultDob').textContent = document.getElementById('dob').value;
            document.getElementById('cgpaValue').textContent = cgpa.toFixed(2);
            document.getElementById('result').style.display = 'block';
            
            // Save data to server
            saveDataToServer(cgpa);
        });

        // Save data to server
        function saveDataToServer(cgpa) {
            const studentData = {
                name: document.getElementById('studentName').value,
                symbolNo: document.getElementById('symbolNo').value,
                dob: document.getElementById('dob').value,
                marks: [],
                cgpa: cgpa.toFixed(2),
                timestamp: new Date().toISOString()
            };
            
            subjects.forEach((subject, index) => {
                studentData.marks.push({
                    subject: subject.name,
                    type: subject.type,
                    marks: document.getElementById(`marks${index}`).value || '0'
                });
            });
            
            // Create a FormData object to send to PHP
            const formData = new FormData();
            formData.append('data', JSON.stringify(studentData));
            
            // Send data to server using fetch API
            fetch('#', {  // Using '#' to submit to same page
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                const responseDiv = document.getElementById('serverResponse');
                responseDiv.style.display = 'block';
                
                if (data.includes('successfully')) {
                    responseDiv.className = 'server-response success';
                } else {
                    responseDiv.className = 'server-response error';
                }
                responseDiv.textContent = data;
                
                // Hide the message after 5 seconds
                setTimeout(() => {
                    responseDiv.style.display = 'none';
                }, 5000);
            })
            .catch((error) => {
                const responseDiv = document.getElementById('serverResponse');
                responseDiv.style.display = 'block';
                responseDiv.className = 'server-response error';
                responseDiv.textContent = 'Error saving data: ' + error;
                
                setTimeout(() => {
                    responseDiv.style.display = 'none';
                }, 5000);
            });
        }

        // Save as PDF
        document.getElementById('savePdf').addEventListener('click', function() {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();
            
            // Student info
            doc.setFontSize(18);
            doc.text('CGPA Result', 105, 15, { align: 'center' });
            
            doc.setFontSize(12);
            doc.text(`Student Name: ${document.getElementById('studentName').value}`, 14, 25);
            doc.text(`Symbol No.: ${document.getElementById('symbolNo').value}`, 14, 35);
            doc.text(`Date of Birth: ${document.getElementById('dob').value}`, 14, 45);
            
            // CGPA
            doc.setFontSize(16);
            const cgpaValue = document.getElementById('cgpaValue').textContent || '0.00';
            const cgpaText = `Your CGPA is: ${cgpaValue}`;
            doc.text(cgpaText, 105, 60, { align: 'center' });
            
            // Subjects table
            const headers = [["Subject", "Type", "Credit Hours", "Full Marks", "Obtained Marks", "GPA"]];
            const data = [];
            
            subjects.forEach((subject, index) => {
                data.push([
                    subject.name,
                    subject.type,
                    subject.creditHours.toString(),
                    subject.fullMarks.toString(),
                    document.getElementById(`marks${index}`).value || '0',
                    document.getElementById(`gpa${index}`).textContent
                ]);
            });
            
            doc.autoTable({
                startY: 70,
                head: headers,
                body: data,
                theme: 'grid',
                headStyles: {
                    fillColor: [242, 242, 242],
                    textColor: 0
                }
            });
            
            // Save the PDF
            doc.save(`${document.getElementById('studentName').value}_CGPA_Result.pdf`);
        });
    </script>

    <?php
    // PHP code to handle data saving
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['data'])) {
        $data = json_decode($_POST['data'], true);
        
        if ($data) {
            // Ensure the directory exists
            if (!file_exists('student_data')) {
                mkdir('student_data', 0777, true);
            }
            
            // Create a filename with timestamp and student name
            $filename = 'student_data/' . date('Y-m-d_His') . '_' . 
                        preg_replace('/[^a-zA-Z0-9]/', '_', $data['name']) . '.json';
            
            // Save the data
            if (file_put_contents($filename, json_encode($data, JSON_PRETTY_PRINT))) {
                echo "Data saved successfully.";
            } else {
                echo "Error saving data.";
            }
            exit;
        }
        
        echo "Invalid data received.";
        exit;
    }
    ?>
</body>
</html>