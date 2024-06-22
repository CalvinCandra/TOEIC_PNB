<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Test Result Notification</title>
    <style>
        /* Import Poppins font */
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap");

        /* Reset some default browser styling */
        body {
            font-family: "Poppins", sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }

        h2 {
            font-size: 20px;
            font-weight: 800;
        }

        /* Container styles */
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            /* Prevents background color bleed outside container */
        }

        /* Header styles */
        .header {
            background-color: #219ebc;
            /* Warna latar belakang header */
            color: #ffffff;
            text-align: center;
            padding: 10px 0;
            border-radius: 8px 8px 0 0;
            font-size: 12px;
        }

        /* Content styles */
        .content {
            padding-left: 20px;
            padding-right: 20px;
            padding-top: 5px;
            /* Reduce top padding to move content closer to header */
        }

        .desk p {
            font-size: 14px;
            color: #333;
        }

        /* Table styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .parameter {
            margin-bottom: 1%;
        }

        th,
        td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
            text-align: center;
            font-size: 14px;
        }

        th {
            background-color: #219ebc;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .personal-data,
        .result {
            margin-bottom: 30px;
        }

        .personal-data p,
        .result p {
            margin: 2px 0;
        }

        .label {
            font-size: 14px;
            display: inline-block;
            width: 130px;
            /* Adjust based on your requirement */
        }

        .value {
            font-size: 14px;
            display: inline-block;
            word-wrap: break-word;
            /* Allows long words to wrap to the next line */
            font-weight: bold;
        }

        .end {
            margin-top: 6%;
            font-size: 14px;
            font-weight: 500;
            color: #333;
        }

        .footer {
            font-size: 12px;
            margin-top: auto;
            text-align: center;
        }

        /* Media queries for responsiveness */
        @media (max-width: 600px) {
            .header h1 {
                font-size: 16px;
            }

            .content h2 {
                font-size: 18px;
            }

            .content p {
                font-size: 13px;
            }

            .label,
            .value {
                font-size: 12px;
            }

            .label {
                margin-bottom: 5px;
                width: 100px;
            }

            .personal-data p,
            .result p {
                font-size: 14px;
            }

            table,
            th,
            td {
                font-size: 12px;
                text-align: center;
            }

            .footer {
                font-size: 1px;
                margin-top: auto;
                text-align: center;
            }

            .end {
                margin-top: 30px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>SIMULATION TEST RESULT FOR TOEIC</h1>
        </div>

        <div class="content">
            <h2>Hello, {{ $nama_peserta }}</h2>
            <div class="desk">
                <p>
                    Congratulations on successfully completing the TOEIC simulation test
                    at TOEIC SIMULATION PNB. Your accomplishment marks an important step
                    forward in your preparation for the actual TOEIC exam.
                </p>
                <p>
                    Next, discover your simulation test results by reviewing the
                    detailed information provided below!
                </p>
            </div>

            <div class="personal-data">
                <p style="font-weight: bold">Your Personal Data :</p>
                <p>
                    <span class="label">Username</span>
                    <span class="value">: {{ $nama_peserta }}</span>
                </p>
                <p>
                    <span class="label">Email</span>
                    <span class="value">: <a href="mailto:{{ $email }}">{{ $email }}</a></span>
                </p>
                <p>
                    <span class="label">NIM</span>
                    <span class="value">: {{ $nim }}</span>
                </p>
                <p>
                    <span class="label">Major</span>
                    <span class="value">: {{ $jurusan }}</span>
                </p>
            </div>

            <div class="result">
                <p style="font-weight: bold">Your Result :</p>
                <p>
                    <span class="label">Category</span>
                    <span class="value">: {{ $kategori }}</span>
                </p>
                <p>
                    <span class="label">Reading Score</span>
                    <span class="value">: {{ $skorReading }}</span>
                </p>
                <p>
                    <span class="label">Listening Score</span>
                    <span class="value">: {{ $skorListening }}</span>
                </p>
                <p>
                    <span class="label">Total Score</span>
                    <span class="value">: {{ $totalSkor }}</span>
                </p>
            </div>

            <p class="parameter" style="font-weight: bold">Parameter Score</p>
            <table>
                <tr>
                    <th>Score Range</th>
                    <th>Category</th>
                </tr>
                <tr>
                    <td>10-180</td>
                    <td>No Useful Proficiency</td>
                </tr>
                <tr>
                    <td>185 -250</td>
                    <td>Memorised Proficiency</td>
                </tr>
                <tr>
                    <td>255 - 400</td>
                    <td>Elementary Proficiency</td>
                </tr>
                <tr>
                    <td>405 - 600</td>
                    <td>Elementary Proficiency Plus</td>
                </tr>
                <tr>
                    <td>605 - 780</td>
                    <td>Limited Working Proficiency</td>
                </tr>
                <tr>
                    <td>785 - 900</td>
                    <td>Working Proficiency Plus</td>
                </tr>
                <tr>
                    <td>905 - 990</td>
                    <td>International Proficiency</td>
                </tr>
            </table>
            <div class="desk">
                <p>
                    After completing this TOEIC simulation test, ensure you maintain
                    consistent learning habits to effectively prepare for the actual
                    TOEIC exam and achieve mastery.
                </p>
                <p>
                    If you have any further questions, please contact us via email at
                    simulationtoeic@gmail.com.
                </p>
            </div>
            <div class="end">
                <p>Thank you and warm regards,<br />TOEIC Simulation Team</p>
                <hr />
            </div>
            <p class="footer" style="color: #6b6b6b">
                copyright 2024 | TOEIC SIMULATION PNB
            </p>
        </div>
    </div>
</body>

</html>
