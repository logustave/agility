<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Http\Requests\EmployeeRequest\StoreEmployeeRequest;
use App\Http\Requests\EmployeeRequest\UpdateEmployeeRequest;
use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Spatie\Permission\Models\Role;

class EmployeeController extends Controller
{
    private User $user;
    private Employee $employee;

    public function __construct(User $user, Employee $employee, private readonly Role $role)
    {
        $this->user = $user;
        $this->employee = $employee;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $employees = EmployeeResource::collection(
            $this->employee::query()->paginate(config('app.default_pagination_size'))
        );
        return view('pages.pages.employee.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('employees.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEmployeeRequest $request): RedirectResponse
    {
        $role = $this->role::query()->where('name', UserRole::EMPLOYEE->value)->first();

        $userAttributes = $request->userAttributes();
        $user = $this->user::create($userAttributes);
        $user->assignRole($role);

        $this->employee::create($request->employeeAttributes($user->id));

        return redirect()->route('employees.index')->with('success', 'opération éffectuée');
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee): \Illuminate\Contracts\Foundation\Application|Factory|View|Application
    {
        $employee = new EmployeeResource($employee);
        return view('employees.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $employee = new EmployeeResource($employee);
        return view('employees.edit', compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmployeeRequest $request, Employee $employee): RedirectResponse
    {
        $employee->user()->update($request->userAttributes());
        return redirect()->route('employees.index')->with('success', 'opération éffectuée');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee): RedirectResponse
    {
        $employee->delete();
        $employee->user()->delete();
        return redirect()->route('employees.index')->with('success', 'opération éffectuée');
    }
}
