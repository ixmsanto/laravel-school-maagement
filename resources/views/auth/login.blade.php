 {{-- path: resources/views/auth/login.blade.php --}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - School Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jwt-decode@3.1.2/build/jwt-decode.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h2>Login</h2>
        <form id="loginForm">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
        <div id="error" class="text-danger mt-3"></div>
    </div>
    <script>
        document.getElementById('loginForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            try {
                const response = await axios.post('/api/login', { email, password });
                const { access_token } = response.data;
                localStorage.setItem('token', access_token);
                const decoded = jwtDecode(access_token);
                const role = decoded.role; // Assumes role is added to JWT claims
                window.location.href = `/${role}/dashboard`;
            } catch (error) {
                document.getElementById('error').textContent = error.response?.data?.error || 'Login failed';
            }
        });
    </script>
</body>
</html>
