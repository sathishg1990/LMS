<?php

namespace App\Tables;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use ProtoneMedia\Splade\SpladeTable;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Query\Builder;
use ProtoneMedia\Splade\AbstractTable;
use Spatie\QueryBuilder\AllowedFilter;

class Users extends AbstractTable
{
    /**
     * Create a new instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the user is authorized to perform bulk actions and exports.
     *
     * @return bool
     */
    public function authorize(Request $request)
    {
        return true;
    }

    /**
     * The resource or query builder.
     *
     * @return mixed
     */
    public function for ()
    {
        $globalSearch = AllowedFilter::callback('global', function ($query, $value) {
            $query->where(function ($query) use ($value) {
                Collection::wrap($value)->each(function ($value) use ($query) {
                    $query
                        ->orWhere('name', 'LIKE', "%{$value}%")
                        ->orWhere('email', 'LIKE', "%{$value}%");
                });
            });
        });

        $users = User::select("*")->selectRaw("CONCAT_WS(', ',IF(is_admin, 'Admin', NULL),IF(is_teacher, 'Teacher', NULL),IF(is_student, 'Student', NULL)) AS user_type");

        return QueryBuilder::for($users)
            ->defaultSort('id')
            ->allowedSorts(['id','name', 'email', 'user_type'])
            ->allowedFilters(['id', 'name', 'email', $globalSearch]);
    }

    /**
     * Configure the given SpladeTable.
     *
     * @param \ProtoneMedia\Splade\SpladeTable $table
     * @return void
     */
    public function configure(SpladeTable $table)
    {
        $table
            ->withGlobalSearch(columns: ['id'])
            ->column('id', sortable: true)
            ->column('name', sortable: true)
            ->column('email', sortable: true)
            ->column('user_type',  sortable: true)
            ->paginate(15);

        // ->searchInput()
        // ->selectFilter()
        // ->withGlobalSearch()

        // -
        // ->export()
    }
}