<style>
    .limited-text {
        display: -webkit-box;
        -webkit-box-orient: vertical;
        overflow: hidden;
        -webkit-line-clamp: 2;
    }
</style>

<li class="nav-item dropdown">
    <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="far fa-comments"></i>
        <span class="badge badge-danger navbar-badge">{{ $count }}</span>
    </a>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        @if($listNoti->isEmpty())
            <span class="dropdown-item dropdown-header">Không có thông báo mới</span>
        @else
            @foreach($listNoti as $noti)
                <a href="{{route('noti.detail', $noti->id)}} " class="dropdown-item">
                    <div class="media">
                        <img src="{{$noti->user->avatar}}" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">{{$noti->user->full_name}}</h3>
                            <p class="text-sm limited-text">{{$noti->message}}</p>
                            <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> {{ \Carbon\Carbon::parse($noti->created_at)->format('d/m/Y') }}</p>
                        </div>
                    </div>
                </a>
                <div class="dropdown-divider"></div>
            @endforeach
        @endif
        <a href="{{route('noti.index')}}" class="dropdown-item dropdown-footer">Xem tất cả thông báo</a>
    </div>
</li>
