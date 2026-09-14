<?php

namespace App\Http\Controllers\Admin;

use App\Enums\IssueSeverity;
use App\Enums\IssueStatus;
use App\Http\Controllers\Controller;
use App\Models\Bus;
use App\Models\BusIssue;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BusIssueController extends Controller
{
    public function index(Bus $bus): View
    {
        return view('admin.buses.issues.index', [
            'bus' => $bus,
            'issues' => $bus->issues()->orderByDesc('created_at')->paginate(15),
        ]);
    }

    public function create(Bus $bus): View
    {
        return view('admin.buses.issues.create', [
            'bus' => $bus,
            'severities' => IssueSeverity::cases(),
        ]);
    }

    public function store(Request $request, Bus $bus): RedirectResponse
    {
        $validated = $request->validate([
            'category' => ['required', 'string', 'max:100'],
            'description' => ['required', 'string', 'max:1000'],
            'severity' => ['required', \Illuminate\Validation\Rule::enum(IssueSeverity::class)],
        ]);

        $validated['bus_id'] = $bus->id;
        $validated['status'] = IssueStatus::OPEN;

        BusIssue::create($validated);

        return redirect()->route('admin.buses.issues.index', $bus)
            ->with('status', 'Laporan masalah berhasil dibuat.');
    }

    public function updateStatus(Request $request, Bus $bus, BusIssue $issue): RedirectResponse
    {
        $request->validate([
            'status' => ['required', \Illuminate\Validation\Rule::enum(IssueStatus::class)],
        ]);

        $issue->update(['status' => IssueStatus::from($request->input('status'))]);

        return redirect()->route('admin.buses.issues.index', $bus)
            ->with('status', 'Status masalah diperbarui ke '.$issue->status->label().'.');
    }
}
