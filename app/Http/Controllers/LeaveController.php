<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\LeaveRequest;
use App\Models\LeaveType;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class LeaveController extends Controller
{
    public function requestLeave(Request $request)
    {
        $employee = Employee::findOrFail($request->employee_id);
        $leaveType = LeaveType::findOrFail($request->leave_type_id);

        $start = Carbon::parse($request->start_date);
        $end = Carbon::parse($request->end_date);
        $daysRequested = $start->diffInDays($end) + 1;

        // Validate leave rules
        if ($leaveType->name === 'Annual') {
            $approvedDays = LeaveRequest::where('employee_id', $employee->id)
                ->where('leave_type_id', $leaveType->id)
                ->where('status', 'Approved')
                ->whereYear('start_date', now()->year)
                ->get()
                ->sum(fn($leave) => $leave->days_count);

            $availableDays = $employee->total_annual_leave_days - $approvedDays;

            if ($daysRequested > $availableDays) {
                return response()->json(['error' => 'Annual leave limit exceeded'], 400);
            }
        }

        if ($leaveType->name === 'Monthly') {
            // Check if request is exactly 1 day
            if ($daysRequested !== 1) {
                return response()->json(['error' => 'Monthly leave can only be 1 day per request'], 400);
            }

            // Only one monthly leave allowed per calendar month
            $monthlyCount = LeaveRequest::where('employee_id', $employee->id)
                ->where('leave_type_id', $leaveType->id)
                ->where('status', 'Approved')
                ->whereMonth('start_date', $start->month)
                ->whereYear('start_date', $start->year)
                ->count();

            if ($monthlyCount >= 1) {
                return response()->json(['error' => 'You already took monthly leave this month'], 400);
            }

            // Check yearly total not over 10 days
            $yearlyTotal = LeaveRequest::where('employee_id', $employee->id)
                ->where('leave_type_id', $leaveType->id)
                ->where('status', 'Approved')
                ->whereYear('start_date', $start->year)
                ->count(); // 1 day per request, so count is enough

            if ($yearlyTotal >= 10) {
                return response()->json(['error' => 'You reached the maximum monthly leave for the year'], 400);
            }
        }

        $leave = LeaveRequest::create($request->only(['employee_id', 'leave_type_id', 'start_date', 'end_date']));

        return response()->json(['message' => 'Leave requested successfully', 'data' => $leave]);
    }

    public function approveLeave(Request $request, $id)
    {
        $request->validate([
            'comment' => 'nullable|string|max:255'
        ]);

        $leave = LeaveRequest::findOrFail($id);

        if ($leave->status !== 'Pending') {
            return response()->json(['error' => 'This leave has already been processed'], 400);
        }

        $leave->status = 'Approved';
        $leave->review_comment = $request->comment ?? 'Approved';
        $leave->save();

        return response()->json(['message' => 'Leave approved successfully']);
    }
    public function rejectLeave(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required|string|max:255'
        ]);

        $leave = LeaveRequest::findOrFail($id);

        if ($leave->status !== 'Pending') {
            return response()->json(['error' => 'This leave has already been processed'], 400);
        }

        $leave->status = 'Rejected';
        $leave->review_comment = $request->comment;
        $leave->save();

        return response()->json(['message' => 'Leave rejected successfully']);
    }

    public function getLeaveBalance($employeeId)
    {
        $employee = Employee::findOrFail($employeeId);
        $annualLeave = $employee->total_annual_leave_days;

        $usedAnnual = LeaveRequest::where('employee_id', $employeeId)
            ->whereHas('leaveType', fn($q) => $q->where('name', 'Annual'))
            ->where('status', 'Approved')
            ->whereYear('start_date', now()->year)
            ->get()
            ->sum(fn($l) => $l->days_count);

        $usedMonthly = LeaveRequest::where('employee_id', $employeeId)
            ->whereHas('leaveType', fn($q) => $q->where('name', 'Monthly'))
            ->where('status', 'Approved')
            ->whereYear('start_date', now()->year)
            ->count();

        return response()->json([
            'annual_total' => $annualLeave,
            'annual_used' => $usedAnnual,
            'annual_remaining' => $annualLeave - $usedAnnual,
            'monthly_used' => $usedMonthly,
            'monthly_remaining' => 10 - $usedMonthly
        ]);
    }
}

