{{-- Delete Item --}}
<div wire:ignore.self class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true" data-bs-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Delete Item</h5>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger" role="alert">
                    <p>Are you sure you? This action is irreversible.</p>
                    <input type="hidden" wire:model="row_id">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" wire:click.prevent="cancel()" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" wire:click.prevent="destroy_item()" class="btn btn-danger close-modal">Delete</button>
            </div>
        </div>
    </div>
</div>
