<?php

namespace App\Forms;

use App\Models\User;
use ProtoneMedia\Splade\SpladeForm;
use ProtoneMedia\Splade\AbstractForm;
use ProtoneMedia\Splade\FormBuilder\Text;
use ProtoneMedia\Splade\FormBuilder\Email;
use ProtoneMedia\Splade\FormBuilder\Select;
use ProtoneMedia\Splade\FormBuilder\Submit;
use ProtoneMedia\Splade\FormBuilder\Password;

class CreateUserForm extends AbstractForm
{
    public function configure(SpladeForm $form)
    {
        $form
            ->action(route('admin.users.store'))
            ->method('POST')
            ->class('space-y-4')
            ->fill([
                //
            ]);
    }

    public function fields(): array
    {
        $option = User::select('role')->groupBy('role')->get()->toArray();

        return [
            Text::make('name')
                ->label(__('Name')),
            Email::make('email')
                ->label('Email address'),
            Password::make('password')
                ->label('Password'),
            Select::make('role')
                ->label('Select the Role')
                ->options($option)
                ->optionLabel('role')
                ->optionValue('role'),
            Submit::make()
                ->label(__('Create'))
        ];
    }
}