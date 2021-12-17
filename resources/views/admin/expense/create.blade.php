@extends('layouts.admin-layout')
@section('title', 'Expenses')
@section('content')
    <div class="content p-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12">
                    <div class="card card-outline shadow-3">
                        <div class="card-header admin-cart-header">
                            <h3 class="card-title col-md-10">{{ __('all.expenses') }}</h3>
                        </div>
                        <div class="card-body">
                            <form
                                action="{{ isset($expense) ? url('admin/expenses/update/' . $expense->id) : url('admin/expenses/create') }}"
                                method="post" id="MyExpenseForm">
                                {{ @csrf_field() }}
                                <div class="row">
                                    <div class="col-sm-3 col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('all.date') }}:<span
                                                    class="text-red">*</span></label>
                                            <input type="date" class="form-control" placeholder="Date" name="date" id="date"
                                                value="{{ isset($expense) ? $expense->date : \Carbon\Carbon::today()->format('Y-m-d') }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('all.customer') }}</label>
                                            @php
                                                $customers = App\Customer::latest()->get();
                                            @endphp
                                            <select class="form-control select2"
                                                data-placeholder="Choose one (with searchbox)" name="customer_id"
                                                id="customer_id">
                                                <option value="">--{{ __('all.choose_customer') }}--</option>
                                                @foreach ($customers as $row)
                                                    <option value="{{ $row->id }}"
                                                        {{ isset($expense) && $expense->customer_id == $row->id ? 'selected' : '' }}>
                                                        {{ $row->display_name }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('all.amount') }}:<span
                                                    class="text-red">*</span></label>
                                            <input type="text" class="form-control" placeholder="Amount" name="amount"
                                                id="amount" value="{{ isset($expense) ? $expense->amount : '' }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('all.expense_category') }}</label>
                                            @php
                                                $expenseCategories = App\ExpenseCategory::latest()->get();
                                            @endphp
                                            <select class="form-control select2" name="expense_category_id"
                                                id="expense_category_id">
                                                <option value="">--{{ __('all.choose_expense_category') }}--</option>
                                                @foreach ($expenseCategories as $row)
                                                    <option value="{{ $row->id }}"
                                                        {{ isset($expense) && $expense->expense_category_id == $row->id ? 'selected' : '' }}>
                                                        {{ $row->name }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('all.notes') }}:<span
                                                    class="text-red">*</span></label>
                                            <textarea class="form-control mb-4" placeholder="Notes" rows="6" name="note"
                                                id="note">{{ isset($expense) ? $expense->note : '' }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-12">
                                        <div class="form-footer mt-2">
                                            <button class="btn admin-submit-btn-grad">{{ __('all.save') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection