@props(['model','edit'=>true])
<div
    @if($edit)
        wire:click="$emit('showModal', 'profile.edit-avatar-modal', '{{ class_basename($model) }}','{{ $model->id }}')"
    @endif
    class="img text-center">
    @if($edit)
        <span class="badge badge-primary p-2">
        <i class="fa fa-camera-alt"></i>
   </span>
    @endif
    <img class="profile-user-img img-fluid img-circle"
         src="{{$model->avatar}}"
         alt="User profile picture">
</div>
<style>
    .img {
        position: relative;
    }

    .img span {
        top: 50%;
        left: 50%;
        position: absolute;
        transform: translate(-50%, -50%);
        color: white;
    }
</style>
