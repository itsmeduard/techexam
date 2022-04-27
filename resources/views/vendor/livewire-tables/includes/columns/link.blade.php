{{--<a href="{{ $path }}" {!! count($attributes) ? $column->arrayToAttributes($attributes) : '' !!} --}}{{--wire:click="show({{ $row->id }})"--}}{{-->{{ $title }}</a>--}} {{--This code is the old one that I modified based on my needs--}}
<a class='btn btn-{{ $title }} btn-icon-split' role='button' href='{{ $path }}' {!! count($attributes) ? $column->arrayToAttributes($attributes) : '' !!} data-bs-toggle='modal' wire:click="show_item({{ $id }})" style='background: rgba(255,255,255,0);border-radius: 0px;border-width: 0px;border-style: none;'>
    @if($title == 'success') <i class='fas fa-pencil-alt' style='color: rgb(58,196,125);'></i> @else <i class='fas fa-trash-alt' style='color: #d92550;'></i> @endif
</a>

{{--Call Modal Add and Edit--}}
@if(request()->routeIs('user.category*'))
    @include('tables.modals.modal-category')

@elseif(request()->routeIs('user.expenses*'))
    @php
        $category_item = \App\Models\ModelCategory::where('user_id',auth()->user()->id)->orderBy('category','asc')->get();
    @endphp

    {{-- Add Item --}}
    <div wire:ignore.self class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Add Item</h5>
                </div>
                <form>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Item<span style='color: red;'>*</span></label>
                            <input type='text' class="form-control" wire:model.lazy="item" placeholder="Item Name" required maxlength="30">
                        </div>
                        <div class="form-group">
                            <label>Amount<span style='color: red;'>*</span></label>
                            <input type='text' class="form-control" wire:model.lazy="amount" placeholder="Amount" required maxlength="5">
                        </div>
                        <div class="form-group">
                            <label>Quantity<span style='color: red;'>*</span></label>
                            <input type='text' class="form-control" wire:model.lazy="quantity" placeholder="Quantity" required maxlength="3">
                        </div>
                        <div class="form-group">
                            <label>Category<span style='color: red;'>*</span></label>
                            <select wire:model.lazy='category_id' class='form control' required>
                                <option selected value="">--Select--</option>
                                @forelse($category_item as $c)
                                    <option value='{{$c->id}}'>{{$c->category}}</option>
                                @empty
                                    <option selected value="">--Select--</option>
                                @endforelse
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Date&Time Purchase<span style='color: red;'>*</span></label>
                            <input type='text' name='datepicker' class="form-control" wire:model.lazy="datetime_added" placeholder="Date&Time Purchase" required maxlength="10">
                        </div>
                        <div class="form-group">
                            <label>Need/Want<span style='color: red;'>*</span></label>
                            <select wire:model.lazy='item_status' class='form control' required>
                                <option selected value="">--Select--</option>
                                <option value='Want'>Want</option>
                                <option value='Need'>Need</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Remarks<span style='color: red;'>*</span></label>
                            <input type='text' class="form-control" wire:model.lazy="description" placeholder="Remarks" required maxlength="35">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" wire:click.prevent="cancel()" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" wire:click.prevent="store_item()"  class="btn btn-success close-modal">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Update Item --}}
    <div wire:ignore.self class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel">Update Item</h5>
                </div>
                <form>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Item<span style='color: red;'>*</span></label>
                            <input type='text' class="form-control" wire:model="item" placeholder="Item Name" required maxlength="30">
                        </div>
                        <div class="form-group">
                            <label>Amount<span style='color: red;'>*</span></label>
                            <input type='text' class="form-control" wire:model="amount" placeholder="Amount" required maxlength="5">
                        </div>
                        <div class="form-group">
                            <label>Quantity<span style='color: red;'>*</span></label>
                            <input type='text' class="form-control" wire:model="quantity" placeholder="Quantity" required maxlength="3">
                        </div>
                        <div class="form-group">
                            <label>Category<span style='color: red;'>*</span></label>
                            <select wire:model='category_id' class='form control' required>
                                <option selected value="">--Select--</option>
                                @forelse($category_item as $c)
                                    <option value='{{$c->id}}'>{{$c->category}}</option>
                                @empty
                                    <option selected value="">--Select--</option>
                                @endforelse
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Date&Time Purchase<span style='color: red;'>*</span></label>
                            <input type='text' name="datepicker" class="form-control" wire:model="datetime_added" placeholder="Date&Time Purchase" required maxlength="10">
                        </div>
                        <div class="form-group">
                            <label>Need/Want<span style='color: red;'>*</span></label>
                            <select wire:model='item_status' class='form control' required>
                                <option selected value="">--Select--</option>
                                <option value='Want'>Want</option>
                                <option value='Need'>Need</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Remarks<span style='color: red;'>*</span></label>
                            <input type='text' class="form-control" wire:model="description" placeholder="Remarks"  required maxlength="35">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" wire:click.prevent="cancel()" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" wire:click.prevent="update_item()" class="btn btn-success close-modal">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif

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

