<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Tables\Users;
use Illuminate\Http\Request;
use App\Forms\CreateUserForm;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
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
    public function edit(Request $request)
    {
        $userId = $request->id;
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
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
                ->column('name')
                ->column('email')
                ->column(key: 'grades.name', label: 'Grade')
                ->paginate(15),
        ]);
    }

    public function showTeacherlist()
    {

    }
}