{{-- path: resources/views/reports/performance.blade.php --}}

<!DOCTYPE html>
<html>
<head>
    <title>Performance Report</title>
</head>
<body>
    <h1>Performance Report for {{ $student->first_name }} {{ $student->last_name }}</h1>
    <h2>Marks</h2>
    <table border="1">
        <tr>
            <th>Subject</th>
            <th>Marks</th>
            <th>Period</th>
        </tr>
        @foreach($student->marks as $mark)
            <tr>
                <td>{{ $mark->subject }}</td>
                <td>{{ $mark->marks }}</td>
                <td>{{ $mark->period }}</td>
            </tr>
        @endforeach
    </table>
    <h2>Homework Completion</h2>
    <p>Completed: {{ $student->homework->where('status', 'submitted')->count() }}</p>
</body>
</html>
