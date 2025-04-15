# School Management System

A web-based application built with Laravel to manage school operations, including user authentication, role-based dashboards, homework assignments, marks management, and administrative tasks.

---

## 🚀 Features

- **Authentication**: Secure login using JWT tokens (Admin, Teacher, Student).
- **Role-Based Dashboards**:
  - **Admin**: Manage users (create, update, delete).
  - **Teacher**: Manage students, assign homework, record marks.
  - **Student**: View assigned homework and track performance.
- **Homework Management**: Teachers assign, students submit.
- **Marks Management**: Teachers assign, students view grades.
- **Reports**: Generate student performance reports (PDF).
- **Batch Import**: Import student data via Excel/CSV.
- **API-Driven**: Secure APIs for all features via JWT.

---

## 🛠 Tech Stack

| Layer      | Tech Used                                 |
|------------|--------------------------------------------|
| Backend    | Laravel 11, PHP 8.2                         |
| Frontend   | Bootstrap 5.3, JavaScript, Axios            |
| Database   | MySQL                                       |
| Auth       | Tymon JWT-Auth                              |
| Roles      | Spatie Laravel Permission                   |
| PDF        | Barryvdh Laravel DomPDF                     |
| Import     | Maatwebsite Laravel Excel                   |
| Others     | Composer, npm                               |

---

## 📁 Folder Structure

```plaintext
school-management-system/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AdminController.php        # Admin user management
│   │   │   ├── AuthController.php         # JWT authentication (login, logout, refresh)
│   │   │   ├── HomeworkController.php     # Homework assignment and viewing
│   │   │   ├── MarksController.php        # Marks assignment
│   │   │   ├── ReportController.php       # Student report generation
│   │   │   ├── StudentController.php      # Student performance viewing
│   │   │   └── TeacherController.php      # Teacher student management
│   │   └── Middleware/
│   │       └── VerifyCsrfToken.php        # CSRF protection (excludes API routes)
│   ├── Imports/
│   │   └── StudentsImport.php             # Batch student import logic
│   └── Models/
│       ├── Homework.php                   # Homework model
│       ├── Marks.php                      # Marks model
│       ├── Student.php                    # Student model
│       ├── Teacher.php                    # Teacher model
│       └── User.php                       # User model with roles
├── bootstrap/
│   └── app.php                            # Application bootstrap
├── config/
│   ├── app.php                            # General app configuration
│   ├── auth.php                           # Authentication guards (web, api)
│   ├── cors.php                           # CORS settings for API
│   └── permission.php                     # Spatie Permission settings
├── database/
│   ├── migrations/
│   │   ├── 2023_10_01_000000_create_users_table.php
│   │   ├── 2025_04_15_001957_create_students_table.php
│   │   ├── 2025_04_15_002105_create_teachers_table.php
│   │   ├── 2025_04_15_002129_create_homework_table.php
│   │   ├── 2025_04_15_002153_create_marks_table.php
│   │   └── 2025_04_15_002736_create_permission_tables.php
│   └── seeders/
│       ├── DatabaseSeeder.php
│       ├── RoleSeeder.php              # Seeds roles (admin, teacher, student)
│       └── UserSeeder.php             # Seeds sample users
├── public/
│   ├── css/                               # Compiled CSS (if any)
│   └── js/                                # Compiled JavaScript (if any)
├── resources/
│   └── views/
│       ├── auth/
│       │   └── login.blade.php            # Login page
│       ├── admin/
│       │   └── dashboard.blade.php        # Admin dashboard
│       ├── teacher/
│       │   └── dashboard.blade.php        # Teacher dashboard
│       ├── student/
│       │   └── dashboard.blade.php        # Student dashboard
│       ├── layouts/
│       │   └── app.blade.php              # Main layout template
│       └── reports/
│           └── performance.blade.php      # PDF report template
├── routes/
│   ├── api.php                            # API routes (JWT-protected)
│   └── web.php                            # Web routes (login, dashboards)
├── .env.example                           # Environment configuration template
├── composer.json                          # PHP dependencies
├── package.json                           # Node.js dependencies
└── README.md                              # Project documentation


---

## ⚙️ Installation

### 🔧 Prerequisites

- PHP >= 8.2
- Composer
- Node.js & npm
- MySQL
- Git

## 🧱 Setup Steps

Follow these steps to set up the project locally:

1. **Clone the repository**:

    ```bash
    git clone https://github.com/ixmsanto/laravel-school-management.git
    cd school-management-system
    ```

2. **Install PHP dependencies**:

    ```bash
    composer install
    ```

3. **Install JavaScript dependencies**:

    ```bash
    npm install
    ```

4. **Configure `.env` file**:

    - Copy the environment configuration file:

      ```bash
      cp .env.example .env
      ```

    - Update `.env` with your database and JWT settings:

      ```env
      DB_CONNECTION=mysql
      DB_HOST=127.0.0.1
      DB_PORT=3306
      DB_DATABASE=stud-manage
      DB_USERNAME=root
      DB_PASSWORD=

      JWT_SECRET=your_jwt_secret
      ```

5. **Generate application key**:

    ```bash
    php artisan key:generate
    ```

6. **Run database migrations**:

    ```bash
    php artisan migrate
    ```

7. **Seed the database (optional)**:

    ```bash
    php artisan db:seed
    ```

8. **Generate JWT secret**:

    ```bash
    php artisan jwt:secret
    ```

9. **Compile frontend assets**:

    ```bash
    npm run dev
    ```

10. **Start the development server**:

    ```bash
    php artisan serve
    ```

---

### Running Tests

To run tests, use the following command:

```bash
npm run test

## 📡 API Reference

All protected routes require `Authorization: Bearer <token>`.

### Authentication

| Method | Endpoint            | Description                  | Role     |
|--------|---------------------|------------------------------|----------|
| POST   | `/api/login`         | Authenticate user            | All      |
| POST   | `/api/logout`        | Logout user                  | All      |
| POST   | `/api/refresh`       | Refresh JWT token            | All      |

---

### User Management (Admin)

| Method | Endpoint            | Description                  | Role     |
|--------|---------------------|------------------------------|----------|
| GET    | `/api/users`         | List all users               | Admin    |
| POST   | `/api/users`         | Create a user                | Admin    |
| GET    | `/api/users/{id}`    | Get a user                   | Admin    |
| PUT    | `/api/users/{id}`    | Update a user                | Admin    |
| DELETE | `/api/users/{id}`    | Delete a user                | Admin    |

---

### Students (Teacher)

| Method | Endpoint            | Description                  | Role     |
|--------|---------------------|------------------------------|----------|
| GET    | `/api/students`      | List all students            | Teacher  |
| POST   | `/api/students`      | Create a student             | Teacher  |
| GET    | `/api/students/{id}` | Get a student                | Teacher  |
| PUT    | `/api/students/{id}` | Update a student             | Teacher  |
| POST   | `/api/students/import` | Import students (Excel/CSV)  | Teacher  |

---

### Homework (Teacher/Student)

| Method | Endpoint            | Description                  | Role     |
|--------|---------------------|------------------------------|----------|
| POST   | `/api/homework`      | Assign homework              | Teacher  |
| GET    | `/api/homework`      | View assigned homework       | Student  |
| PUT    | `/api/homework/{id}` | Update homework status       | Student  |

---

### Marks (Teacher)

| Method | Endpoint            | Description                  | Role     |
|--------|---------------------|------------------------------|----------|
| POST   | `/api/marks`         | Assign marks                 | Teacher  |

---

### Performance (Student)

| Method | Endpoint            | Description                  | Role     |
|--------|---------------------|------------------------------|----------|
| GET    | `/api/performance`   | View student performance     | Student  |

---

### Reports

| Method | Endpoint                    | Description                  | Role     |
|--------|-----------------------------|------------------------------|----------|
| GET    | `/api/reports/student/{id}`  | Generate student report (PDF)| All      |

---

### Notes

- **Authorization**: All protected API routes require `Authorization: Bearer <token>`.
- **JWT**: Use `/api/login` to authenticate and receive a JWT token for accessing protected routes.
- **Swagger Documentation**: For a detailed, interactive API reference, visit `/api/documentation` (if Swagger is configured).
