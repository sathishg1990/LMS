<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Tables\Users;
use Illuminate\Http\Request;
use App\Forms\CreateUserForm;
use App\Rules\CheckRoleForUser;
use Illuminate\Validation\Rule;
use Illuminate\Support\Collection;
use ProtoneMedia\Splade\SpladeTable;
use Spatie\QueryBuilder\QueryBuilder;
use ProtoneMedia\Splade\Facades\Toast;
use Spatie\QueryBuilder\AllowedFilter;
use App\Http\Requests\CreateUserFormRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.users.index', [
            'users' => Users::class
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view(
            'admin.users.create',
            ['form' => CreateUserForm::class]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateUserForm $form, CreateUserFormRequest $request)
    {
        $createUser = $form->validate($request);
        User::create($createUser);
        Toast::message('User Created')
            ->success()
            ->rightTop()
            ->autoDismiss(3);
        return redirect()->route('admin.users');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = User::select('role')->groupBy('role')->get()->toArray();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(User $user, Request $request)
    {
        
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => ['required', Rule::unique('users')->ignore($user->id)],
            'password' => 'required',
            'role' => [
                'required',
                new CheckRoleForUser
            ]
        ]);

        $user->update($validatedData);
        Toast::message('User Updated')
            ->success()
            ->rightTop()
            ->autoDismiss(3);
        return redirect()->route('admin.users');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        Toast::message('User Deleted')
            ->success()
            ->rightTop()
            ->autoDismiss(3);
        return redirect()->route('admin.users');

    }

    public function showstudentslist()
    {

        $studentsList = User::where('role', 'STUDENT');


        $globalSearch = AllowedFilter::callback('global', function ($query, $value) {
            $query->where(function ($query) use ($value) {
                Collection::wrap($value)->each(function ($value) use ($query) {
                    $query
                        ->orWhere('name', 'LIKE', "%{$value}%")
                        ->orWhere('email', 'LIKE', "%{$value}%");
                });
            });
        });


        $students = QueryBuilder::for($studentsList)
            ->defaultSort('name')
            ->allowedSorts(['name', 'email'])
            ->allowedFilters(['name', 'email', $globalSearch]);


        return view('admin.users.students', [
            'students' => SpladeTable::for($students)
                ->withGlobalSearch('Search through the data...', ['id', 'name'])
                ->column('name')
                ->column('email')
                ->column(key: 'grades.name', label: 'Grade')
                ->paginate(15),
        ]);
    }

    public function showTeacherlist()
    {
        $teachersList = User::where('role', 'TEACHER');


        $globalSearch = AllowedFilter::callback('global', function ($query, $value) {
            $query->where(function ($query) use ($value) {
                Collection::wrap($value)->each(function ($value) use ($query) {
                    $query
                        ->orWhere('name', 'LIKE', "%{$value}%")
                        ->orWhere('email', 'LIKE', "%{$value}%");
                });
            });
        });


        $teachers = QueryBuilder::for($teachersList)
            ->defaultSort('name')
            ->allowedSorts(['name', 'email'])
            ->allowedFilters(['name', 'email', $globalSearch]);


        return view('admin.users.teachers', [
            'teachers' => SpladeTable::for($teachers)
                ->withGlobalSearch('Search through the data...', ['id', 'name'])
                ->column('name')
                ->column('email')
                ->column(key: 'grades.name', label: 'Grade')
                ->paginate(15),
        ]);
    }
}