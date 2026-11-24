<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Assessment;
use App\Models\StudentAssessment;

class AssessmentController extends Controller
{
    public function index()
    {
        $assessments = Assessment::with('trainor')
            ->withCount(['questions', 'studentAssessments'])
            ->get();
        return view('admin.assessment.index', compact('assessments'));
    }

    public function show($id)
    {
        $assessment = Assessment::with(['trainor', 'questions'])->findOrFail($id);
        return view('admin.assessment.show', compact('assessment'));
    }

    public function submissions()
    {
        $submissions = StudentAssessment::with(['student', 'assessment.trainor', 'evaluation'])
            ->whereIn('status', ['submitted', 'evaluated'])
            ->latest('submitted_at')
            ->get();
        return view('admin.assessment.submissions', compact('submissions'));
    }

    public function submissionDetail($id)
    {
        $submission = StudentAssessment::with([
            'student', 'assessment.trainor', 'assessment.questions',
            'answers.question', 'evaluation.trainor'
        ])->findOrFail($id);
        return view('admin.assessment.submission_detail', compact('submission'));
    }
}
