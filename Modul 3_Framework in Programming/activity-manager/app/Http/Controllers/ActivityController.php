<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreActivityRequest;
use App\Http\Requests\UpdateActivityRequest;
use App\Models\Activity;
use App\Models\Category;
use App\Services\ActivityService;
use DomainException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;

class ActivityController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $categoryId = $request->query('category_id');
        $status = $request->query('status');
        $sort = $request->query('sort', 'latest');

        $activities = Activity::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhere('code', 'like', "%{$search}%");
                });
            })
            ->when(
                $categoryId,
                fn ($query, $categoryId) => $query->where('category_id', $categoryId)
            )
            ->when(
                in_array($status, Activity::STATUSES, true),
                fn ($query) => $query->where('status', $status)
            )
            ->orderBy(
                'start_at',
                $sort === 'oldest' ? 'asc' : 'desc'
            )
            ->paginate(10)
            ->withQueryString();

        $categories = Category::orderBy('name')->get();

        return view('activities.index', compact(
            'activities',
            'categories',
            'search',
            'categoryId',
            'status',
            'sort'
        ));
    }

    public function show(Activity $activity): View
    {
        return view('activities.show', compact('activity'));
    }

    public function create(): View
    {
        $categories = Category::orderBy('name')->get();

        return view('activities.create', compact('categories'));
    }

    public function store(
        StoreActivityRequest $request,
        ActivityService $service
    ): RedirectResponse {
        $activity = $service->create($request->validated());

        return to_route('activities.show', $activity)
            ->with('success', 'Kegiatan berhasil dibuat.');
    }

    public function edit(Activity $activity): View
    {
        $categories = Category::orderBy('name')->get();

        return view('activities.edit', compact('activity', 'categories'));
    }

    public function update(
        UpdateActivityRequest $request,
        Activity $activity,
        ActivityService $service
    ): RedirectResponse {
        try {
            $service->update(
                $activity,
                $request->validated(),
                $request->input('status')
            );
        } catch (DomainException $exception) {
            return back()
                ->withErrors(['status' => $exception->getMessage()])
                ->withInput();
        }

        return to_route('activities.show', $activity)
            ->with('success', 'Kegiatan berhasil diperbarui.');
    }

    public function destroy(Activity $activity): RedirectResponse
    {
        $activity->delete();

        return to_route('activities.index')
            ->with('success', 'Kegiatan berhasil dihapus.');
    }

    public function trash(): View
    {
        $activities = Activity::onlyTrashed()->latest()->get();

        return view('activities.trash', compact('activities'));
    }

    public function restore(int $id): RedirectResponse
    {
        $activity = Activity::withTrashed()->findOrFail($id);
        $activity->restore();

        return redirect()
            ->route('activities.trash')
            ->with('success', 'Kegiatan berhasil dipulihkan.');
    }

    public function publish(Activity $activity): RedirectResponse
    {
        try {
            $this->activityService->publish($activity);

            return back()->with('success', 'Kegiatan berhasil dipublikasikan.');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors());
        }
    }

    public function complete(Activity $activity): RedirectResponse
    {
        try {
            $this->activityService->complete($activity);

            return back()->with(
                'success',
                'Kegiatan berhasil diselesaikan.'
            );
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors());
        }
    }

    private ActivityService $activityService;

    public function __construct(ActivityService $activityService)
    {
        $this->activityService = $activityService;
    }
}
