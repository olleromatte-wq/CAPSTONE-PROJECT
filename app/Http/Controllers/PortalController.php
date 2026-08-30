<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PortalController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function authenticate(Request $request)
    {
        $request->validate(['access_type' => ['required', 'in:student,staff']]);

        if ($request->input('access_type') === 'student') {
            $id = trim((string) $request->input('student_id'));
            if (! preg_match('/^[0-9]{4}-?[0-9]{4}$/', $id)) {
                return back()->withErrors(['login' => 'Enter a valid Student ID Number, such as 2026-0001.'])->withInput();
            }
            $request->session()->regenerate();
            $request->session()->put('user', ['role' => 'student', 'id' => $id]);
            return redirect()->route('student.dashboard');
        }

        $accounts = [
            'admin' => ['password' => 'admin123', 'role' => 'administrator'],
            'admin@ncbii.edu' => ['password' => 'Admin@2026', 'role' => 'administrator'],
            'faculty' => ['password' => 'faculty123', 'role' => 'faculty', 'faculty_id' => 'FAC-001'],
            'faculty@ncbii.edu' => ['password' => 'Faculty@2026', 'role' => 'faculty', 'faculty_id' => 'FAC-001'],
            'faculty1' => ['password' => 'faculty123', 'role' => 'faculty', 'faculty_id' => 'FAC-001'],
            'faculty2' => ['password' => 'faculty123', 'role' => 'faculty', 'faculty_id' => 'FAC-002'],
            'faculty3' => ['password' => 'faculty123', 'role' => 'faculty', 'faculty_id' => 'FAC-003'],
            'pedro' => ['password' => 'pedro123', 'role' => 'faculty', 'faculty_id' => 'FAC-002'],
        ];

        $username = strtolower(trim((string) $request->input('staff_email')));
        $account = $accounts[$username] ?? null;
        if (! $account || ! hash_equals($account['password'], (string) $request->input('staff_password'))) {
            return back()->withErrors(['login' => 'The username or password is incorrect.'])->withInput();
        }

        $request->session()->regenerate();
        $request->session()->put('user', ['role' => $account['role'], 'email' => $username, 'faculty_id' => $account['faculty_id'] ?? null]);
        return redirect()->route($account['role'] === 'administrator' ? 'admin.dashboard' : 'faculty.dashboard');
    }

    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    public function home()
    {
        return view('home');
    }

    public function studentDashboard(Request $request)
    {
        return view('dashboard', ['student' => $request->session()->get('user')]);
    }

    public function facultyDashboard()
    {
        return view('faculty-dashboard');
    }

    public function adminDashboard()
    {
        return view('admin-dashboard');
    }
}
