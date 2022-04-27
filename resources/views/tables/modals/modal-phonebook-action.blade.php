@if($row->id != 0)
    <div class="d-flex justify-content-start">
        <li class="list-inline-item">
            <a class='btn btn-sm btn-success rounded-0' role='button' href='#updateModal' data-bs-toggle='modal' wire:click="show_item({{ $row->id }})">
            Edit
            </a></li>

        <a class='btn btn-sm btn-danger rounded-0' role='button' href='#deleteModal' data-bs-toggle='modal' wire:click="show_item({{ $row->id }})">
            Delete
        </a>
        {{-- you can add more button to what action you need --}}
    </div>
@endif

{{-- Import Data --}}
<div wire:ignore.self class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Import Data</h4>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label>Title<span style='color: red;'>*</span></label>
                        <select wire:model="select_title">
                            <option>--Select--</option>
                            <option value="0">Title</option>
                            <option value="1">Firstname</option>
                            <option value="2">Lastname</option>
                            <option value="3">Mobile Num</option>
                            <option value="4">Company Name</option>
                        </select>
                        @error('select_title')<p style='color: red;'>{{ $message }}</p>@enderror
                    </div>
                    <div class="form-group">
                        <label>Firstname<span style='color: red;'>*</span></label><select wire:model="select_firstname">
                            <option>--Select--</option>
                            <option value="0">Title</option>
                            <option value="1">Firstname</option>
                            <option value="2">Lastname</option>
                            <option value="3">Mobile Num</option>
                            <option value="4">Company Name</option>
                        </select>
                        @error('select_firstname')<p style='color: red;'>{{ $message }}</p>@enderror
                    </div>
                    <div class="form-group">
                        <label>Lastname<span style='color: red;'>*</span></label>
                        <select wire:model="select_lastname">
                            <option>--Select--</option>
                            <option value="0">Title</option>
                            <option value="1">Firstname</option>
                            <option value="2">Lastname</option>
                            <option value="3">Mobile Num</option>
                            <option value="4">Company Name</option>
                        </select>
                        @error('select_lastname')<p style='color: red;'>{{ $message }}</p>@enderror
                    </div>
                    <div class="form-group">
                        <label>Mobile Number<span style='color: red;'>*</span></label>
                        <select wire:model="select_mobilenum">
                            <option>--Select--</option>
                            <option value="0">Title</option>
                            <option value="1">Firstname</option>
                            <option value="2">Lastname</option>
                            <option value="3">Mobile Num</option>
                            <option value="4">Company Name</option>
                        </select>
                        @error('select_mobilenum')<p style='color: red;'>{{ $message }}</p>@enderror
                    </div>
                    <div class="form-group">
                        <label>Company Name<span style='color: red;'>*</span></label>
                        <select wire:model="select_companyname">
                            <option>--Select--</option>
                            <option value="0">Title</option>
                            <option value="1">Firstname</option>
                            <option value="2">Lastname</option>
                            <option value="3">Mobile Num</option>
                            <option value="4">Company Name</option>
                        </select>
                        @error('select_companyname')<p style='color: red;'>{{ $message }}</p>@enderror
                    </div>
                    <input wire:model="uploadFile" type="file">
                    @error('uploadFile')<p style='color: red;'>{{ $message }}</p>@enderror
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-light border rounded" type="button" data-bs-dismiss="modal">Close</button>
                <button type="button" wire:click.prevent="import()" class="btn btn-succes close-modal">Save</button>
            </div>
        </div>
    </div>
</div>
{{--<div wire:ignore.self class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true" data-bs-backdrop="static" data-keyboard="false">--}}
{{--    <div class="modal-dialog" role="document">--}}
{{--        <div class="modal-content">--}}
{{--            <div class="modal-header">--}}
{{--                <h5 class="modal-title" id="addModalLabel">Add Item</h5>--}}
{{--            </div>--}}
{{--            <form>--}}
{{--                <div class="modal-body">--}}
{{--                    <div class="form-group">--}}
{{--                        <label>Category<span style='color: red;'>*</span></label>--}}
{{--                        <input type='text' class="form-control" wire:model="category_item" placeholder="Add Item" required maxlength="15">--}}
{{--                        @if($errors->has('category_item'))--}}
{{--                            <span>{{ $errors->first('category_item') }}</span>--}}
{{--                        @endif--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="modal-footer">--}}
{{--                    <button type="button" wire:click.prevent="cancel()" class="btn btn-secondary">Close</button>--}}
{{--                    <button type="button" wire:click.prevent="store_item()" class="btn btn-success close-modal">Save changes</button>--}}
{{--                </div>--}}
{{--            </form>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}

{{-- Update Item --}}
<div wire:ignore.self class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true" data-bs-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Update Item</h5>
            </div>
            <form>
                <div class="modal-body">
                    <input wire:model="row_id" type="hidden">
                    <div class="form-group">
                        <label>Title<span style='color: red;'>*</span></label>
                        <input type='text' class="form-control" wire:model="title" placeholder="Add Item" required maxlength="15">
                        @error('title')<p style='color: red;'>{{ $message }}</p>@enderror
                    </div>
                    <div class="form-group">
                        <label>Firstname<span style='color: red;'>*</span></label>
                        <input type='text' class="form-control" wire:model="firstname" placeholder="Add Item" required maxlength="15">
                        @error('firstname')<p style='color: red;'>{{ $message }}</p>@enderror
                    </div>
                    <div class="form-group">
                        <label>Lastname<span style='color: red;'>*</span></label>
                        <input type='text' class="form-control" wire:model="lastname" placeholder="Add Item" required maxlength="15">
                        @error('lastname')<p style='color: red;'>{{ $message }}</p>@enderror
                    </div>
                    <div class="form-group">
                        <label>Mobile Number<span style='color: red;'>*</span></label>
                        <input type='text' class="form-control" wire:model="mobilenum" placeholder="Add Item" required maxlength="15">
                        @error('mobilenum')<p style='color: red;'>{{ $message }}</p>@enderror
                    </div>
                    <div class="form-group">
                        <label>Company Name<span style='color: red;'>*</span></label>
                        <input type='text' class="form-control" wire:model="companyname" placeholder="Add Item" required maxlength="15">
                        @error('companyname')<p style='color: red;'>{{ $message }}</p>@enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" wire:click.prevent="cancel()" class="btn btn-secondary">Close</button>
                    <button type="button" wire:click.prevent="update_item()" class="btn btn-success close-modal">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

@include('tables.modals.modal-delete-action')
