<div class="card-body">
    @include('partials.fields', [
        'fields' => [
            [
                'ftype' => 'input',
                'name' => 'Name',
                'id' => 'custom[client_name]',
                'placeholder' => 'Your Name',
                'required' => true,
                'value' => isset($authUser) ? $authUser->name : '',
            ],
        ],
    ])
    {{-- Brij Negi Update --}}
    @if ($forceLogin === 'yes' && session()->has('UserViewer'))
        @include('partials.fields', [
            'fields' => [
                [
                    'ftype' => 'input',
                    'name' => 'Logged in user id',
                    'id' => 'custom[logged_client_id]',
                    'placeholder' => 'ID',
                    'class'=> 'hidden',
                    'required' => true,
                    'value' => isset($authUser) ? $authUser->id : '',
                ],
            ],
        ])
    @endif
</div>
