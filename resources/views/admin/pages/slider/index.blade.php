@extends('admin.master', ['menu' => 'slider'])
@section('title', isset($title) ? $title : '')
@section('content')


    <div id="table-url" data-url="{{ route('admin.slider') }}"></div>
    <div class="row">
        <div class="col-md-12">
            <div class="breadcrumb__content">
                <div class="breadcrumb__content__left">
                    <div class="breadcrumb__title">
                        <h2>{{__('Slider')}}</h2>
                    </div>
                </div>
                <div class="breadcrumb__content__right">
                    <nav aria-label="breadcrumb">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('Home')}}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{__('Slider')}}</li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="customers__area bg-style mb-30">
                <div class="item-title">
                    <div class="col-xs-6">
                        <a href="{{route('admin.slider.create')}}" class="btn btn-md btn-info">{{ __('Add Slider')}}</a>

                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            Priority
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form action="{{route('admin.slider.priority')}}"  method="GET">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Priority</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">

                                        <div class="row">

                                                @csrf
                                                @php
                                                    $slides = App\Models\Admin\Slider::get();
                                                    $count = App\Models\Admin\Slider::count();
                                                @endphp

                                                @foreach ($slides as $slide)
                                                    <div class="col-md-4">
                                                        <div class="input__group mb-25">
                                                            <label for="priority" class="mb-1">{{ $slide->en_Title }}</label>
                                                            <select class="form-control form-select-sm" id="priority" name="{{$slide->id}}">
                                                                <option>{{__('---Select item---')}}</option>
                                                                @for ($i=1; $i<=$count; $i++)
                                                                    <option value="{{$i}}" {{$slide->priority == $i ? 'selected' : ''}}> {{$i}} </option>
                                                                @endfor
                                                            </select>
                                                        </div>
                                                    </div>
                                                    @endforeach


                                        </div>

                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-sm btn-primary">Save changes</button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="customers__table">
                    <table id="SliderTable" class="row-border data-table-filter table-style">
                        <thead>
                        <tr>
                            <th>{{ __('Background Image')}}</th>
                            <th>{{ __('Thumbnail')}}</th>
                            <th>{{ __('Title')}}</th>
                            <th>{{ __('Sub Title')}}</th>
                            <th>{{ __('Description')}}</th>
                            <th>{{ __('Button_Text')}}</th>
                            <th>{{ __('Action')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!--Row-->
    @push('post_scripts')
        <script src="{{asset('backend/js/admin/datatables/slider.js')}}"></script>
        <!-- Page level custom scripts -->
    @endpush
@endsection
