@extends('layouts.app')
@section('content')
    <div class="container">
        <h2>Admin Dashboard</h2>
        <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addUserModal">Add User</button>
        <table class="table" id="usersTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
    <script>
        async function loadUsers() {
            const response = await axios.get('/api/users', { headers: { Authorization: `Bearer ${localStorage.getItem('token')}` } });
            const tbody = document.querySelector('#usersTable tbody');
            tbody.innerHTML = response.data.map(user => `
                <tr>
                    <td>${user.id}</td>
                    <td>${user.name}</td>
                    <td>${user.email}</td>
                    <td>${user.role}</td>
                    <td>
                        <button class="btn btn-warning" onclick="editUser(${user.id})">Edit</button>
                        <button class="btn btn-danger" onclick="deleteUser(${user.id})">Delete</button>
                    </td>
                </tr>
            `).join('');
        }
        window.onload = loadUsers;
    </script>
@endsection
