@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Student Dashboard</h2>
    <h3>Assigned Homework</h3>
    <table class="table" id="homeworkTable">
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Due Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>

    <h3>Performance</h3>
    <div id="performance"></div>
</div>

<script>
    async function loadHomework() {
        const response = await axios.get('/api/homework');
        const homework = response.data;
        const tbody = document.querySelector('#homeworkTable tbody');
        tbody.innerHTML = homework.map(hw => `
            <tr>
                <td>${hw.title}</td>
                <td>${hw.description}</td>
                <td>${hw.due_date}</td>
                <td>${hw.status}</td>
                <td>
                    ${hw.status === 'assigned' ? `<button class="btn btn-primary" onclick="submitHomework(${hw.id})">Submit</button>` : ''}
                </td>
            </tr>
        `).join('');
    }

    async function loadPerformance() {
        const response = await axios.get('/api/performance');
        const performance = response.data;
        const performanceDiv = document.getElementById('performance');
        performanceDiv.innerHTML = `
            <p>Marks: ${performance.marks.map(m => `${m.subject}: ${m.marks}`).join(', ')}</p>
            <p>Homework Completed: ${performance.homework_completion}</p>
        `;
    }

    async function submitHomework(id) {
        await axios.put(`/api/homework/${id}`, { status: 'submitted' });
        alert('Homework submitted');
        loadHomework();
    }

    window.onload = () => {
        loadHomework();
        loadPerformance();
    };
</script>
@endsection
