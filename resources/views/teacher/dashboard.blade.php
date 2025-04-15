@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Teacher Dashboard</h2>
    <ul class="nav nav-tabs" id="teacherTabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="students-tab" data-bs-toggle="tab" href="#students" role="tab">Students</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="marks-tab" data-bs-toggle="tab" href="#marks" role="tab">Assign Marks</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="homework-tab" data-bs-toggle="tab" href="#homework" role="tab">Assign Homework</a>
        </li>
    </ul>
    <div class="tab-content" id="teacherTabContent">
        <!-- Students Tab -->
        <div class="tab-pane fade show active" id="students" role="tabpanel">
            <h3>Manage Students</h3>
            <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addStudentModal">Add Student</button>
            <table class="table" id="studentsTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
        <!-- Assign Marks Tab -->
        <div class="tab-pane fade" id="marks" role="tabpanel">
            <h3>Assign Marks</h3>
            <form id="assignMarksForm">
                <div class="mb-3">
                    <label for="student_id_marks" class="form-label">Student</label>
                    <select class="form-control" id="student_id_marks" name="student_id" required></select>
                </div>
                <div class="mb-3">
                    <label for="subject" class="form-label">Subject</label>
                    <input type="text" class="form-control" id="subject" name="subject" required>
                </div>
                <div class="mb-3">
                    <label for="marks" class="form-label">Marks</label>
                    <input type="number" class="form-control" id="marks" name="marks" min="0" max="100" required>
                </div>
                <div class="mb-3">
                    <label for="period" class="form-label">Period</label>
                    <select class="form-control" id="period" name="period" required>
                        <option value="weekly">Weekly</option>
                        <option value="monthly">Monthly</option>
                        <option value="yearly">Yearly</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Assign Marks</button>
            </form>
        </div>
        <!-- Assign Homework Tab -->
        <div class="tab-pane fade" id="homework" role="tabpanel">
            <h3>Assign Homework</h3>
            <form id="assignHomeworkForm">
                <div class="mb-3">
                    <label for="student_id_hw" class="form-label">Student</label>
                    <select class="form-control" id="student_id_hw" name="student_id" required></select>
                </div>
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="due_date" class="form-label">Due Date</label>
                    <input type="date" class="form-control" id="due_date" name="due_date" required>
                </div>
                <button type="submit" class="btn btn-primary">Assign Homework</button>
            </form>
        </div>
    </div>
</div>

<script>
    async function loadStudents() {
        const response = await axios.get('/api/students');
        const students = response.data;
        const tbody = document.querySelector('#studentsTable tbody');
        tbody.innerHTML = students.map(student => `
            <tr>
                <td>${student.id}</td>
                <td>${student.first_name} ${student.last_name}</td>
                <td>${student.user.email}</td>
                <td>
                    <button class="btn btn-warning" onclick="editStudent(${student.id})">Edit</button>
                    <button class="btn btn-danger" onclick="deleteStudent(${student.id})">Delete</button>
                </td>
            </tr>
        `).join('');

        // Populate student dropdowns
        const studentOptions = students.map(student => `<option value="${student.id}">${student.first_name} ${student.last_name}</option>`).join('');
        document.getElementById('student_id_marks').innerHTML = studentOptions;
        document.getElementById('student_id_hw').innerHTML = studentOptions;
    }

    document.getElementById('assignMarksForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(e.target);
        const data = Object.fromEntries(formData.entries());
        await axios.post('/api/marks', data);
        alert('Marks assigned successfully');
    });

    document.getElementById('assignHomeworkForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(e.target);
        const data = Object.fromEntries(formData.entries());
        await axios.post('/api/homework', data);
        alert('Homework assigned successfully');
    });

    window.onload = loadStudents;
</script>
@endsection
