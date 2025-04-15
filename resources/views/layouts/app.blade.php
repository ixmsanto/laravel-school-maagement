<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>School Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">School System</a>
        <button class="btn btn-link ms-auto" onclick="logout()">Logout</button>
    </nav>
    <main class="py-4">
        @yield('content')
    </main>
    <script>
        axios.interceptors.request.use(config => {
            config.headers.Authorization = `Bearer ${localStorage.getItem('token')}`;
            return config;
        });
        axios.interceptors.response.use(response => response, async error => {
            if (error.response.status === 401) {
                const newToken = await axios.post('/api/refresh');
                localStorage.setItem('token', newToken.data.access_token);
                return axios(error.config);
            }
            return Promise.reject(error);
        });
        function logout() {
            axios.post('/api/logout').then(() => {
                localStorage.removeItem('token');
                window.location.href = '/login';
            });
        }
    </script>
</body>
</html>
