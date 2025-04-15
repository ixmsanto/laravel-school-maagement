<?php

namespace App\Http\Controllers;

// path: app/Http/Controllers/ReportController.php

use App\Models\Student;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function generateReport($id)
    {
        $student = Student::with(['marks', 'homework'])->findOrFail($id);
        $pdf = Pdf::loadView('reports.performance', compact('student'));
        return $pdf->download('performance_report_' . $student->id . '.pdf');
    }
}
