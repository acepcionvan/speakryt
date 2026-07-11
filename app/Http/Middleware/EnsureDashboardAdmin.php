<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureDashboardAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->session()->has('user_role')) {
            return redirect()
                ->route('login')
                ->withErrors(['email' => 'Please log in as an Admin to view the CEO dashboard.']);
        }

        if ($request->session()->get('user_role') !== 'admin') {
            return redirect()
                ->route($this->fallbackRoute($request->session()->get('user_role')))
                ->withErrors(['email' => 'Only Admin users can view the CEO dashboard.']);
        }

        return $next($request);
    }

    private function fallbackRoute(?string $role): string
    {
        return match ($role) {
            'teacher' => 'schedule.index',
            'student' => 'student.dashboard',
            'staff' => 'staff.index',
            'manager' => 'schedule.index',
            default => 'login',
        };
    }
}
