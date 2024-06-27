<!DOCTYPE html>
<html lang="en" style="margin: 0px; padding:0px;">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Test Result Notification</title>
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap");

        body {
            font-family: "Poppins", Arial, sans-serif;
            line-height: 1.6;
            background-color: #f0f0f0;
        }

        .container {
            /* width: 100%; */
            max-width: 210mm;
            /* A4 width */
            /* height: 297mm; */
            /* A4 height */
            margin: 0;
            background-color: #ffffff;
            overflow: hidden;
            /* padding: 0px 20px 0px; */
            box-sizing: border-box;
        }

        .header {
            background-color: #023047;
            color: #ffffff;
            text-align: center;
            padding: 10px 0;
            font-size: 12px;
            margin: 0 -20px 0;
        }

        .content {
            padding: 0 20px 0;
            margin: 0 20px;
        }

        h2 {
            font-size: 20px;
            font-weight: 800;
        }

        .personal-data {
            margin-bottom: 20px;
        }

        .data-row {
            display: table;
            width: 100%;
            margin-bottom: 10px;
        }

        .label,
        .value {
            display: table-cell;
            vertical-align: top;
        }

        .label {
            width: 130px;
            font-size: 14px;
            font-weight: bold;
        }

        .value {
            font-size: 14px;
        }

        .score-tables {
            position: relative;
            width: 100%;
            /* justify-content: space-around; */
            margin-bottom: 10px;
        }

        /* .score-tables table {
        display: table-cell;
        vertical-align: top;
        background-color: green;
      } */

        .table-kategori {
            position: absolute;
            top: 0;
            left: 0;
        }

        .table-reading {
            position: absolute;
            top: 0;
            right: 0;
        }

        .score-tables td {
            font-size: 13px;
        }

        table {
            width: 48%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
            font-size: 14px;
        }

        th {
            background-color: #023047;
            color: white;
            text-align: center;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .total-score {
            color: white;
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 8px;
            background-color: #023047;
            padding: 8px;
        }

        .parameter td {
            text-align: center;
        }

        .footer {
            font-size: 12px;
            margin-top: auto;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>SIMULATION TEST RESULT FOR TOEIC</h1>
        </div>

        <div class="content">
            <div class="personal-data">
                <p style="font-weight: bold">Your Personal Data:</p>
                <div class="data-row">
                    <div class="label">Username</div>
                    <div class="value">: {{ $nama_peserta }}</div>
                </div>
                <div class="data-row">
                    <div class="label">Email</div>
                    <div class="value">
                        : <a href="mailto:{{ $email }}">{{ $email }}</a>
                    </div>
                </div>
                <div class="data-row">
                    <div class="label">NIM</div>
                    <div class="value">: {{ $nim }}</div>
                </div>
                <div class="data-row">
                    <div class="label">Major</div>
                    <div class="value">: {{ $jurusan }}</div>
                </div>
            </div>

            <div class="result">
                <div class="total-score">Total Score: {{ $totalSkor }}</div>
                <div class="score-tables">
                    <table class="table-listening">
                        <tr>
                            <th colspan="2">Listening</th>
                        </tr>
                        <tr>
                            <td>Correct Answers</td>
                            <td>{{ $benarListening }}</td>
                        </tr>
                        <tr>
                            <td>Incorrect Answers</td>
                            <td>{{ $salahListening }}</td>
                        </tr>
                        <tr>
                            <td>Score</td>
                            <td>{{ $skorListening }}</td>
                        </tr>
                    </table>

                    <table class="table-reading">
                        <tr>
                            <th colspan="2">Reading</th>
                        </tr>
                        <tr>
                            <td>Correct Answers</td>
                            <td>{{ $benarReading }}</td>
                        </tr>
                        <tr>
                            <td>Incorrect Answers</td>
                            <td>{{ $salahReading }}</td>
                        </tr>
                        <tr>
                            <td>Score</td>
                            <td>{{ $skorReading }}</td>
                        </tr>
                    </table>
                </div>
                <table style="width: 100%">
                    <tr>
                        <th>
                            {{ $kategori }} <br />
                            TOEIC score range {{ $rangeSkor }}
                        </th>
                    </tr>
                    <tr>
                        <td style="font-size: 12px">{{ $detail }}</td>
                    </tr>
                </table>
            </div>

            <p style="font-weight: bold">All Parameter Score</p>
            <table class="parameter" style="width: 100%">
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
            <p class="footer" style="color: #6b6b6b">
                copyright 2024 | TOEIC ASSESSMENT PNB
            </p>
        </div>
    </div>
</body>

</html>
