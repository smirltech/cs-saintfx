<div class="modal-dialog">
    <form wire:submit.prevent="submit">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-md-12">
                        <x-form::input-file-image :avatar="$avatar" multiple wire:model="avatar" label="Avatar"/>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <x-button type="submit" class="btn btn-primary">Soumettre</x-button>
            </div>
        </div>
    </form>
</div>
