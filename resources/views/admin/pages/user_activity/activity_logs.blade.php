@extends('admin.master', ['menu' => 'activity', 'submenu' => 'user-activity'])
@section('title', isset($title) ? $title : '')
@section('content')

    <div id="table-url" data-url=""></div>
    <div class="row">
        <div class="col-md-12">
            <div class="breadcrumb__content">
                <div class="breadcrumb__content__left">
                    <div class="breadcrumb__title">
                        <h5 class=" text-light">Session : {{$user->name}}</h5>
                        <span class="text-light">Email: {{$user->email}}</span>
                    </div>
                </div>

                <div class="breadcrumb__content__right">
                    <nav aria-label="breadcrumb">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('Home')}}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">User Activity</li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="customers__area bg-style mb-30">
                <div class="customers__table">

                    <table id="AdvertiseTable" class="row-border data-table-filter table-style">
                        <thead>
                        <tr>
                            <th>Activity</th>
                            <th>Description</th>
                            <th>Time</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php $i = 1; @endphp
                        @foreach ($activityLogs as $log)
                            <tr>
                                <td>{{$log->log_name}}</td>
                                <td>{{$log->description}}</td>
                                <td>{{$log->created_at->isoFormat('dddd, D MMMM YYYY h:mm A')}}</td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @push('post_scripts')
        <!-- Page level custom scripts -->


        <script>

            $(document).ready(function() {
                var table = $('#AdvertiseTable').DataTable({
                    "order": [[3, "desc"]]
                });
            });

        </script>
    @endpush
@endsection
