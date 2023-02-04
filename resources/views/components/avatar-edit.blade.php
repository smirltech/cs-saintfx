@props(['model'])
<div
    wire:click="$emit('showModal', 'profile.edit-avatar-modal', '{{ class_basename($model) }}','{{ $model->id }}')"
    class="text-center">
    <img class="profile-user-img img-fluid img-circle"
         src="{{$model->avatar}}" alt="User profile picture">
</div>
