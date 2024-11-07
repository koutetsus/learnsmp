<!DOCTYPE html>
<html>
<head>
    <title>Student Scores</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>
    <h1>Student Scores</h1>

    @if($studentScores && $studentScores->isNotEmpty())
        @foreach ($studentScores as $subject => $quizzes)
            <h2>{{ $subject }}</h2>
            <table>
                <thead>
                    <tr>
                        <th>User Name</th>
                        <th>Quiz Title</th>
                        <th>Score</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($quizzes as $quizTitle => $scores)
                        @foreach ($scores as $score)
                            <tr>
                                <td>{{ $score->user_name }}</td>
                                <td>{{ $quizTitle }}</td>
                                <td>{{ $score->score }}</td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        @endforeach
    @else
        <p>No scores available.</p>
    @endif
</body>
</html>
