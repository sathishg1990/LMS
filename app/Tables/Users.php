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
use Maatwebsite\Excel\Excel;


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

        return QueryBuilder::for(User::class)
            ->defaultSort('id')
            ->allowedSorts(['id', 'name', 'email', 'role', 'is_admin'])
            ->allowedFilters(['id', 'name', 'email', 'role', 'is_admin', $globalSearch]);
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
            ->withGlobalSearch('Search through the data...', ['id', 'name'])
            ->column('id', sortable: true)
            ->column('name', sortable: true)
            ->column('email', sortable: true)
            ->column(key: 'role', as: fn($role) => ucfirst(strtolower($role)), sortable: true)
            ->column('is_admin', sortable: true, alignment: "center")
            ->rowModal(fn (User $user) => route('admin.users.edit', ['id' => $user->id]))
            ->paginate(15)
            ->export(label: 'CSV export', filename: 'User.csv', type: Excel::CSV);

        // ->searchInput()
        // ->selectFilter()
        // ->withGlobalSearch()

        // -
        // ->export()
    }
}