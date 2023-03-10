@props(['model','edit'=>true])
<div
    @if($edit)
        wire:click="$emit('showModal', 'profile.edit-avatar-modal', '{{ class_basename($model) }}','{{ $model->id }}')"
    @endif
    class="text-center">
    <img class="profile-user-img img-fluid img-circle"
         src="{{$model->avatar}}"
         alt="User profile picture">
</div>
