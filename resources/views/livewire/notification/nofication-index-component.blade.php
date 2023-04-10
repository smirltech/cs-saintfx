<div>
    <div class="content mt-3">
        <div class="container-fluid">
            <div class="box-body">
                @foreach($notifications as $notification)
                    <div class="alert {{$notification->unread()?'alert-warning':'alert-info'}} alert-dismissible"
                         wire:click="openNotification('{{$notification->id}}')">
                        <button wire:click="deleteNotification('{{$notification->id}}')" type="button"
                                class="close" data-dismiss="alert" aria-hidden="true">×
                        </button>
                        <h4><i class="fa {{$notification->read()?'fa-envelope-open':'fa-envelope'}}"></i>
                            {{$notification->data['title']??''}}
                        </h4>
                        <p>{{$notification->data['message']??''}}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
