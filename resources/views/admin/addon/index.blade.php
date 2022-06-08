@extends('admin.layouts.master')

@section('main-content')

  <section class="section">
        <div class="section-header">
            <h1>{{ __('addon.addons') }}</h1>
            {{ Breadcrumbs::render('addons') }}
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        @can('addons_create')
                            <div class="card-header">
                                <a href="{{ route('admin.addons.create') }}" class="btn btn-icon icon-left btn-primary"><i class="fas fa-plus"></i> {{ __('addon.add_addon') }}</a>
                            </div>
                        @endcan
                        <div class="card-body">
                            <div class="row">
                                @if(!blank($addons))
                                    @foreach($addons as $addon )
                                        <div class="col-md-3">
                                            <div class="card card-custom">
                                                <img src="{{$addon->image}}" class="card-img-top card-image-height" alt="{{$addon->title}}">
                                                <div class="card-body">
                                                    <h6 class="card-title">{{$addon->version}}</h6>
                                                    <h5 class="card-title">{{ \Illuminate\Support\Str::limit($addon->title ?? '',45,' ...') }}</h5>
                                                    <p class="card-text">{{ \Illuminate\Support\Str::limit($addon->description ?? '',100,' ...') }}</p>
                                                    @can('addons_delete')
                                                        <a href="#" id="DeleteModalClick"  data-attr="{{ route('admin.addons.destroy', $addon->id) }}" data-title="{{$addon->title}}" title="Delete Addon" class="btn btn-block btn-danger">{{ __('levels.remove') }}</a>
                                                    @endcan
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                               @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
  </section>
{{--  delete Model--}}
  <div class="modal fade" id="DeleteModal" tabindex="-1" role="dialog" aria-labelledby="DeleteModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <div>
                      <form id="deleteForm"  method="post">
                          <div class="modal-body">
                              @csrf
                              @method('DELETE')
                              <h5 class="text-center" id="fromTitle"></h5>
                          </div>
                          <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('levels.cancel') }}</button>
                              <button type="submit" class="btn btn-danger">{{ __('addon.delete_addon') }}</button>
                          </div>
                      </form>
                  </div>
              </div>
          </div>
      </div>
  </div>

@endsection
@section('scripts')
    <script src="{{ asset('js/addon/index.js') }}"></script>
@endsection
