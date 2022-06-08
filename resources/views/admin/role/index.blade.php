@extends('admin.layouts.master')
    
@section('main-content')
  
  <section class="section">
        <div class="section-header">
        <h1>{{ __('menu.roles') }}</h1>
            {{ Breadcrumbs::render('roles') }}
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        
                        @can('role_create')
                            <div class="card-header">
                                <a href="{{ route('admin.role.create') }}" class="btn btn-icon icon-left btn-primary"><i class="fas fa-plus"></i> {{ __('levels.add_role') }}</a>
                            </div>
                        @endcan

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>{{ __('levels.id') }}</th>
                                            <th>{{ __('levels.name') }}</th>
                                            @if (auth()->user()->can('role_show') || auth()->user()->can('role_edit') || auth()->user()->can('role_delete'))
                                                <th>{{ __('levels.actions') }}</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(!blank($roles))
                                            @foreach($roles as $role)
                                                <tr>
                                                    <td>{{ $loop->index+1}}</td>
                                                    <td>{{ $role->name}}</td>
                                                    
                                                    @if (auth()->user()->can('role_show') || auth()->user()->can('role_edit') || auth()->user()->can('role_delete'))
                                                        <td>
                                                            @if (auth()->user()->can('role_show'))
                                                                <a href="{{ route('admin.role.show', $role) }}" class="btn btn-sm btn-icon float-left btn-success" data-toggle="tooltip" data-placement="top" title="Permission"><i class="fas fa-plus"></i></a>
                                                            @endif

                                                            @if (auth()->user()->can('role_edit'))
                                                                <a href="{{ route('admin.role.edit', $role) }}" class="btn btn-sm btn-icon float-left btn-primary ml-2" data-toggle="tooltip" data-placement="top" title="Edit"><i class="far fa-edit"></i></a>
                                                            @endif

                                                            @if (!in_array($role->id, $notDeleteArray) && auth()->user()->can('role_delete'))
                                                                <form class="float-left pl-2" action="{{ route('admin.role.destroy', $role) }}" method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button class="btn btn-sm btn-icon btn-danger" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></button>
                                                                </form>
                                                            @endif
                                                        </td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection